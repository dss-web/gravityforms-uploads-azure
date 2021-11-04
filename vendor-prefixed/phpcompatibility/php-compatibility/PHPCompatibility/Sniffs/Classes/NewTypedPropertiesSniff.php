<?php

/**
 * PHPCompatibility, an external standard for PHP_CodeSniffer.
 *
 * @package   PHPCompatibility
 * @copyright 2012-2019 PHPCompatibility Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCompatibility/PHPCompatibility
 */
namespace Dekode\GravityForms\Vendor\PHPCompatibility\Sniffs\Classes;

use Dekode\GravityForms\Vendor\PHPCompatibility\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer_File as File;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer_Tokens as Tokens;
/**
 * Typed class property declarations are available since PHP 7.4.
 *
 * PHP version 7.4
 *
 * @link https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties
 * @link https://wiki.php.net/rfc/typed_properties_v2
 *
 * @since 9.2.0
 */
class NewTypedPropertiesSniff extends \Dekode\GravityForms\Vendor\PHPCompatibility\Sniff
{
    /**
     * Valid property modifier keywords.
     *
     * @since 9.2.0
     *
     * @var array
     */
    private $modifierKeywords = array(\T_PRIVATE => \T_PRIVATE, \T_PROTECTED => \T_PROTECTED, \T_PUBLIC => \T_PUBLIC, \T_STATIC => \T_STATIC, \T_VAR => \T_VAR);
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @since 9.2.0
     *
     * @return array
     */
    public function register()
    {
        return array(\T_VARIABLE);
    }
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @since 9.2.0
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                   $stackPtr  The position of the current token in the
     *                                         stack passed in $tokens.
     *
     * @return int|void Integer stack pointer to skip forward or void to continue
     *                  normal file processing.
     */
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if ($this->isClassProperty($phpcsFile, $stackPtr) === \false) {
            return;
        }
        $find = $this->modifierKeywords;
        $find += array(\Dekode\GravityForms\Vendor\T_SEMICOLON => \Dekode\GravityForms\Vendor\T_SEMICOLON, \Dekode\GravityForms\Vendor\T_OPEN_CURLY_BRACKET => \Dekode\GravityForms\Vendor\T_OPEN_CURLY_BRACKET);
        $tokens = $phpcsFile->getTokens();
        $modifier = $phpcsFile->findPrevious($find, $stackPtr - 1);
        if ($modifier === \false || $tokens[$modifier]['code'] === \Dekode\GravityForms\Vendor\T_SEMICOLON || $tokens[$modifier]['code'] === \Dekode\GravityForms\Vendor\T_OPEN_CURLY_BRACKET) {
            // Parse error. Ignore.
            return;
        }
        $type = $phpcsFile->findNext(\Dekode\GravityForms\Vendor\PHP_CodeSniffer_Tokens::$emptyTokens, $modifier + 1, null, \true);
        if ($tokens[$type]['code'] === \T_VARIABLE) {
            return;
        }
        // Still here ? In that case, this will be a typed property.
        if ($this->supportsBelow('7.3') === \true) {
            $phpcsFile->addError('Typed properties are not supported in PHP 7.3 or earlier', $type, 'Found');
        }
        if ($this->supportsAbove('7.4') === \true) {
            // Examine the type to verify it's valid.
            if ($tokens[$type]['type'] === 'T_NULLABLE' || $tokens[$type]['code'] === \Dekode\GravityForms\Vendor\T_INLINE_THEN) {
                $type = $phpcsFile->findNext(\Dekode\GravityForms\Vendor\PHP_CodeSniffer_Tokens::$emptyTokens, $type + 1, null, \true);
            }
            $content = $tokens[$type]['content'];
            if ($content === 'void' || $content === 'callable') {
                $phpcsFile->addError('%s is not supported as a type declaration for properties', $type, 'InvalidType', array($content));
            }
        }
        $endOfStatement = $phpcsFile->findNext(\Dekode\GravityForms\Vendor\T_SEMICOLON, $stackPtr + 1);
        if ($endOfStatement !== \false) {
            // Don't throw the same error multiple times for multi-property declarations.
            return $endOfStatement + 1;
        }
    }
}
