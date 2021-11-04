<?php

/**
 * PHPCompatibility, an external standard for PHP_CodeSniffer.
 *
 * @package   PHPCompatibility
 * @copyright 2012-2019 PHPCompatibility Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCompatibility/PHPCompatibility
 */
namespace Dekode\GravityForms\Vendor\PHPCompatibility\Sniffs\Lists;

use Dekode\GravityForms\Vendor\PHPCompatibility\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer_File as File;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer_Tokens as Tokens;
/**
 * Support for empty `list()` expressions has been removed in PHP 7.0.
 *
 * PHP version 7.0
 *
 * @link https://www.php.net/manual/en/migration70.incompatible.php#migration70.incompatible.variable-handling.list.empty
 * @link https://wiki.php.net/rfc/abstract_syntax_tree#changes_to_list
 * @link https://www.php.net/manual/en/function.list.php
 *
 * @since 7.0.0
 */
class ForbiddenEmptyListAssignmentSniff extends \Dekode\GravityForms\Vendor\PHPCompatibility\Sniff
{
    /**
     * List of tokens to disregard when determining whether the list() is empty.
     *
     * @since 7.0.3
     *
     * @var array
     */
    protected $ignoreTokens = array();
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @since 7.0.0
     *
     * @return array
     */
    public function register()
    {
        // Set up a list of tokens to disregard when determining whether the list() is empty.
        // Only needs to be set up once.
        $this->ignoreTokens = \Dekode\GravityForms\Vendor\PHP_CodeSniffer_Tokens::$emptyTokens;
        $this->ignoreTokens[\Dekode\GravityForms\Vendor\T_COMMA] = \Dekode\GravityForms\Vendor\T_COMMA;
        $this->ignoreTokens[\Dekode\GravityForms\Vendor\T_OPEN_PARENTHESIS] = \Dekode\GravityForms\Vendor\T_OPEN_PARENTHESIS;
        $this->ignoreTokens[\Dekode\GravityForms\Vendor\T_CLOSE_PARENTHESIS] = \Dekode\GravityForms\Vendor\T_CLOSE_PARENTHESIS;
        return array(\T_LIST, \Dekode\GravityForms\Vendor\T_OPEN_SHORT_ARRAY);
    }
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @since 7.0.0
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                   $stackPtr  The position of the current token in the
     *                                         stack passed in $tokens.
     *
     * @return void
     */
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if ($this->supportsAbove('7.0') === \false) {
            return;
        }
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['code'] === \Dekode\GravityForms\Vendor\T_OPEN_SHORT_ARRAY) {
            if ($this->isShortList($phpcsFile, $stackPtr) === \false) {
                return;
            }
            $open = $stackPtr;
            $close = $tokens[$stackPtr]['bracket_closer'];
        } else {
            // T_LIST.
            $open = $phpcsFile->findNext(\Dekode\GravityForms\Vendor\T_OPEN_PARENTHESIS, $stackPtr, null, \false, null, \true);
            if ($open === \false || isset($tokens[$open]['parenthesis_closer']) === \false) {
                return;
            }
            $close = $tokens[$open]['parenthesis_closer'];
        }
        $error = \true;
        if ($close - $open > 1) {
            for ($cnt = $open + 1; $cnt < $close; $cnt++) {
                if (isset($this->ignoreTokens[$tokens[$cnt]['code']]) === \false) {
                    $error = \false;
                    break;
                }
            }
        }
        if ($error === \true) {
            $phpcsFile->addError('Empty list() assignments are not allowed since PHP 7.0', $stackPtr, 'Found');
        }
    }
}
