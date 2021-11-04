<?php
/**
 * Declares addon and handle moving to Azure
 *
 * @package dekode
 */

// phpcs:disable PSR2.Classes.PropertyDeclaration.Underscore
// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

declare( strict_types=1 );

namespace Dekode\GravityForms\Azure;

use Dekode\GravityForms\Azure\Controller;

\GFForms::include_addon_framework();

/**
 * Class declares integration to Gravity Forms core
 *
 * @package Dekode\GravityForms\Azure
 */
class AddOn extends \GFAddOn {
	/**
	 * Version number of the Add-On
	 *
	 * @var string
	 */
	protected $_version = DEKODE_GRAVITYFORMS_AZURE_VERSION;

	/**
	 * Gravity Forms minimum version requirement
	 *
	 * @var string
	 */
	protected $_min_gravityforms_version = '2.5';

	/**
	 * URL-friendly identifier used for form settings, add-on settings, text domain localization.
	 *
	 * @var string
	 */
	protected $_slug = 'gravityforms-uploads-azure';

	/**
	 * Relative path to the plugin from the plugins folder.
	 *
	 * @var string
	 */
	protected $_path = 'gravityforms-uploads-azure/gravityforms-uploads-azure.php';

	/**
	 * Full path the the plugin. Example: __FILE__
	 *
	 * @var string
	 */
	protected $_full_path = __FILE__;

	/**
	 * Title of the plugin to be used on the settings page, form settings and plugins page.
	 *
	 * @var string
	 */
	protected $_title = 'Gravity Forms Uploads Azure Add-On';

	/**
	 * Short version of the plugin title to be used on menus and other places where a less verbose string is useful.
	 *
	 * @var string
	 */
	protected $_short_title = 'Uploads Azure';

	/**
	 * Singleton instance holder.
	 *
	 * @var AddOn
	 */
	private static $_instance = null;

	/**
	 * Azure controller instance.
	 *
	 * @var Controller
	 */
	private $controller = null;

	/**
	 * Get an instance of this class.
	 *
	 * @return \AddOn
	 */
	public static function get_instance(): AddOn {
		if ( null === self::$_instance ) {
			self::$_instance = new AddOn();
		}

		return self::$_instance;
	}

	/**
	 * Handles hooks and loading of language files.
	 *
	 * @return void
	 */
	public function init() {
		parent::init();

		$this->controller = new Controller( $this->get_plugin_settings() );

		add_action( 'gform_after_submission', [ $this, 'after_submission' ], 10, 2 );
	}

	/**
	 * Prepare setting definition to define better description.
	 *
	 * @param array $config Configuration.
	 * @return array
	 */
	public function setting_wrapper( array $config ): array {
		$setting_name = $config['name'];

		if ( $setting_name && defined( $setting_name ) ) {
			if ( ! isset( $config['description'] ) ) {
				$config['description'] = '';
			} else {
				$config['description'] .= '<br/>';
			}

			$config['description'] .= sprintf(
				'<strong>%s</strong>',
				sprintf(
					// translators: %s: constant name.
					__(
						'This value is defined in your websites wp-config.php file with the value `%s`. You may override that value by filling in the field above.',
						'gravityforms-uploads-azure'
					),
					esc_html( constant( $setting_name ) )
				)
			);
		}
		return $config;
	}


	/**
	 * Configures the settings which should be rendered on the add-on settings tab.
	 *
	 * @return array
	 */
	public function plugin_settings_fields(): array {
		return [
			[
				'title'  => \esc_html__( 'Gravity Forms Uploads Azure Add-On Settings', 'simpleaddon' ),
				'fields' => [
					$this->setting_wrapper([
						'name'              => 'MICROSOFT_AZURE_ACCOUNT_NAME',
						'label'             => \esc_html__( 'Account Name', 'gravityforms-uploads-azure' ),
						'type'              => 'text',
						'class'             => 'small',
						'feedback_callback' => [ $this, 'is_valid_setting' ],
					]),
					$this->setting_wrapper([
						'name'              => 'MICROSOFT_AZURE_ACCOUNT_KEY',
						'label'             => \esc_html__( 'Account Key', 'gravityforms-uploads-azure' ),
						'type'              => 'text',
						'class'             => 'small',
						'feedback_callback' => [ $this, 'is_valid_setting' ],
					]),
					$this->setting_wrapper([
						'name'              => 'MICROSOFT_AZURE_CNAME',
						'label'             => \esc_html__( 'Blob Service Endpoint', 'gravityforms-uploads-azure' ),
						'description'       => \esc_html__( 'Service endpoint values in your connection strings must be well-formed URIs, including https:// (recommended) or http://.', 'gravityforms-uploads-azure' ),
						'type'              => 'text',
						'class'             => 'small',
						'feedback_callback' => [ $this, 'is_valid_setting' ],
					]),
				],
			],
		];
	}

	/**
	 * The feedback callback for the 'mytextbox' setting on the plugin settings page and the 'mytext' setting on the form settings page.
	 *
	 * @param mixed $value The setting value.
	 * @param mixed $field Field definition.
	 * @return bool
	 */
	public function is_valid_setting( $value, $field ): bool { // phpcs:ignore NeutronStandard.Functions.TypeHint.NoArgumentType
		// Mark field as valid if the constant is defined.
		if ( defined( $field->name ) && constant( $field->name ) ) {
			return true;
		}
		return $value && strlen( $value ) < 10;
	}

	/**
	 * Processes uploading to Azure and removes files from host.
	 *
	 * @param array $file_info Meta info about file.
	 * @return string
	 */
	public function upload_one( array $file_info ): string {
		try {
			$result = $this->controller->upload_file( $file_info['file_name'], $file_info['file_path'] );
		} catch ( \Exception $e ) {
			$this->log_debug( $e->getMessage() );
			return false;
		}

		if ( false === $result || ! isset( $result['blobName'] ) ) {
			return false;
		}

		$result_url = $this->controller->get_blob_url( $result['blobName'] );

		\WP_Filesystem();
		global $wp_filesystem;
		$wp_filesystem->delete( $file_info['file_path'] );

		return $result_url;
	}

	/**
	 * Performing a custom action at the end of the form submission process.
	 *
	 * @param array $entry The entry currently being processed.
	 * @param array $form The form currently being processed.
	 */
	public function after_submission( array $entry, array $form ) {
		foreach ( $form['fields'] as $field ) {
			$input_type = $field->get_input_type();

			if ( ! in_array( $input_type, [ 'fileupload' ], true ) ) {
				continue;
			}

			$field_value = rgar( $entry, $field->id );

			if ( rgblank( $field_value ) ) {
				continue;
			}

			$upload_dir = \GFFormsModel::get_upload_root();
			$upload_url = \GFFormsModel::get_upload_url_root();

			if ( $field->multipleFiles ) {
				$files = json_decode( $field_value, true );

				foreach ( $files as &$file ) {
					$file_info = [
						'file_name' => basename( $file ),
						'file_path' => str_replace( $upload_url, $upload_dir, $file ),
					];

					$file = $this->upload_one( $file_info );
				}

				$result_url = wp_json_encode( $files );
			} else {
				$file_info = [
					'file_name' => basename( $field_value ),
					'file_path' => str_replace( $upload_url, $upload_dir, $field_value ),
				];

				$result_url = $this->upload_one( $file_info );
			}

			\GFAPI::update_entry_field( $entry['id'], $field->id, $result_url );
		}
	}
}
