<?php

/**
 * PHPCompatibility, an external standard for PHP_CodeSniffer.
 *
 * @package   PHPCompatibility
 * @copyright 2012-2019 PHPCompatibility Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCompatibility/PHPCompatibility
 */
namespace Dekode\GravityForms\Vendor\PHPCompatibility\Sniffs\Variables;

use Dekode\GravityForms\Vendor\PHPCompatibility\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer_File as File;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer_Tokens as Tokens;
/**
 * Detect use of `global` with variable variables, support for which has been removed in PHP 7.0.
 *
 * PHP version 7.0
 *
 * @link https://wiki.php.net/rfc/uniform_variable_syntax#global_keyword_takes_only_simple_variables
 *
 * @since 7.0.0
 */
class ForbiddenGlobalVariableVariableSniff extends \Dekode\GravityForms\Vendor\PHPCompatibility\Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @since 7.0.0
     *
     * @return array
     */
    public function register()
    {
        return array(\T_GLOBAL);
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
        $endOfStatement = $phpcsFile->findNext(array(\Dekode\GravityForms\Vendor\T_SEMICOLON, \T_CLOSE_TAG), $stackPtr + 1);
        if ($endOfStatement === \false) {
            // No semi-colon - live coding.
            return;
        }
        for ($ptr = $stackPtr + 1; $ptr <= $endOfStatement; $ptr++) {
            $errorThrown = \false;
            $nextComma = $phpcsFile->findNext(\Dekode\GravityForms\Vendor\T_COMMA, $ptr, $endOfStatement, \false, null, \true);
            $varEnd = $nextComma === \false ? $endOfStatement : $nextComma;
            $variable = $phpcsFile->findNext(\T_VARIABLE, $ptr, $varEnd);
            $varString = \trim($phpcsFile->getTokensAsString($ptr, $varEnd - $ptr));
            $data = array($varString);
            if ($variable !== \false) {
                $prev = $phpcsFile->findPrevious(\Dekode\GravityForms\Vendor\PHP_CodeSniffer_Tokens::$emptyTokens, $variable - 1, $ptr, \true);
                if ($prev !== \false && $tokens[$prev]['type'] === 'T_DOLLAR') {
                    $next = $phpcsFile->findNext(\Dekode\GravityForms\Vendor\PHP_CodeSniffer_Tokens::$emptyTokens, $variable + 1, $varEnd, \true);
                    if ($next !== \false && \in_array($tokens[$next]['code'], array(\Dekode\GravityForms\Vendor\T_OPEN_SQUARE_BRACKET, \T_OBJECT_OPERATOR, \T_DOUBLE_COLON), \true) === \true) {
                        $phpcsFile->addError('Global with variable variables is not allowed since PHP 7.0. Found %s', $variable, 'Found', $data);
                        $errorThrown = \true;
                    } else {
                        $phpcsFile->addWarning('Global with anything other than bare variables is discouraged since PHP 7.0. Found %s', $variable, 'NonBareVariableFound', $data);
                        $errorThrown = \true;
                    }
                }
            }
            if ($errorThrown === \false) {
                $dollar = $phpcsFile->findNext(\Dekode\GravityForms\Vendor\T_DOLLAR, $ptr, $varEnd);
                if ($dollar !== \false) {
                    $next = $phpcsFile->findNext(\Dekode\GravityForms\Vendor\PHP_CodeSniffer_Tokens::$emptyTokens, $dollar + 1, $varEnd, \true);
                    if ($tokens[$next]['code'] === \Dekode\GravityForms\Vendor\T_OPEN_CURLY_BRACKET) {
                        $phpcsFile->addWarning('Global with anything other than bare variables is discouraged since PHP 7.0. Found %s', $dollar, 'NonBareVariableFound', $data);
                    }
                }
            }
            // Move the stack pointer forward to the next variable for multi-variable statements.
            if ($nextComma === \false) {
                break;
            }
            $ptr = $nextComma;
        }
    }
}
