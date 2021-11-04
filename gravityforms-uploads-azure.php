<?php
/**
 * Plugin Name:     Gravity Forms - File Uploads to Azure
 * Plugin URI:      https://dekode.no
 * Description:     Add support for offloading Gravity Forms Uploads to the Microsoft Azure cloud.
 * Author:          Dekode
 * Author URI:      https://dekode.no
 * Text Domain:     gravityforms-uploads-azure
 * Version:         1.0.0
 *
 * @package Dekode
 */

declare( strict_types=1 );

namespace Dekode\GravityForms\Azure;

define( 'DEKODE_GRAVITYFORMS_AZURE_VERSION', '1.1.0' );
define( 'DEKODE_GRAVITYFORMS_AZURE_DIR_PATH', plugin_dir_path( __FILE__ ) );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

add_action( 'gform_loaded', function() {
	// Check that te GravityForms File Upload plugin is loaded before we try extending it.
	if ( ! method_exists( 'GFForms', 'include_feed_addon_framework' ) ) {
		return;
	}

	require_once 'includes/class-controller.php';
	require_once 'includes/class-addon.php';

	/**
	 * Gravity Forms always replace http to https, but Azure uses their own URL,
	 * administrator should decide which protocol will be used.
	 */
	add_filter( 'gform_secure_file_download_is_https', '__return_false', 200 );

	\GFAddOn::register( __NAMESPACE__ . '\\AddOn' );
}, 10 );
