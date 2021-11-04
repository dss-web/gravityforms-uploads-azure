<?php

/**
 * Verifies that all class constants have their visibility set.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2019 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\PSR12\Sniffs\Properties;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens;
class ConstantVisibilitySniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [\T_CONST];
    }
    //end register()
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        // Make sure this is a class constant.
        if ($phpcsFile->hasCondition($stackPtr, \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$ooScopeTokens) === \false) {
            return;
        }
        $prev = $phpcsFile->findPrevious(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$emptyTokens, $stackPtr - 1, null, \true);
        if (isset(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$scopeModifiers[$tokens[$prev]['code']]) === \true) {
            return;
        }
        $error = 'Visibility must be declared on all constants if your project supports PHP 7.1 or later';
        $phpcsFile->addWarning($error, $stackPtr, 'NotFound');
    }
    //end process()
}
//end class
