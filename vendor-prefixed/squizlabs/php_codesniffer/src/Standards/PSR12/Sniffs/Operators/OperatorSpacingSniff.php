<?php

/**
 * Verifies that operators have valid spacing surrounding them.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\PSR12\Sniffs\Operators;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\OperatorSpacingSniff as SquizOperatorSpacingSniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens;
class OperatorSpacingSniff extends \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\OperatorSpacingSniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        parent::register();
        $targets = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$comparisonTokens;
        $targets += \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$operators;
        $targets += \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$assignmentTokens;
        $targets += \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$booleanOperators;
        $targets[] = T_INLINE_THEN;
        $targets[] = T_INLINE_ELSE;
        $targets[] = T_STRING_CONCAT;
        $targets[] = \T_INSTANCEOF;
        return $targets;
    }
    //end register()
    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The current file being checked.
     * @param int                         $stackPtr  The position of the current token in
     *                                               the stack passed in $tokens.
     *
     * @return void
     */
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($this->isOperator($phpcsFile, $stackPtr) === \false) {
            return;
        }
        $operator = $tokens[$stackPtr]['content'];
        $checkBefore = \true;
        $checkAfter = \true;
        // Skip short ternary.
        if ($tokens[$stackPtr]['code'] === T_INLINE_ELSE && $tokens[$stackPtr - 1]['code'] === T_INLINE_THEN) {
            $checkBefore = \false;
        }
        // Skip operator with comment on previous line.
        if ($tokens[$stackPtr - 1]['code'] === \T_COMMENT && $tokens[$stackPtr - 1]['line'] < $tokens[$stackPtr]['line']) {
            $checkBefore = \false;
        }
        if (isset($tokens[$stackPtr + 1]) === \true) {
            // Skip short ternary.
            if ($tokens[$stackPtr]['code'] === T_INLINE_THEN && $tokens[$stackPtr + 1]['code'] === T_INLINE_ELSE) {
                $checkAfter = \false;
            }
        } else {
            // Skip partial files.
            $checkAfter = \false;
        }
        if ($checkBefore === \true && $tokens[$stackPtr - 1]['code'] !== \T_WHITESPACE) {
            $error = 'Expected at least 1 space before "%s"; 0 found';
            $data = [$operator];
            $fix = $phpcsFile->addFixableError($error, $stackPtr, 'NoSpaceBefore', $data);
            if ($fix === \true) {
                $phpcsFile->fixer->addContentBefore($stackPtr, ' ');
            }
        }
        if ($checkAfter === \true && $tokens[$stackPtr + 1]['code'] !== \T_WHITESPACE) {
            $error = 'Expected at least 1 space after "%s"; 0 found';
            $data = [$operator];
            $fix = $phpcsFile->addFixableError($error, $stackPtr, 'NoSpaceAfter', $data);
            if ($fix === \true) {
                $phpcsFile->fixer->addContent($stackPtr, ' ');
            }
        }
    }
    //end process()
}
//end class
