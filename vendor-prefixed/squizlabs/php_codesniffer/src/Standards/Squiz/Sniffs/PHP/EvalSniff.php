<?php

/**
 * The use of eval() is discouraged.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
class EvalSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [\T_EVAL];
    }
    //end register()
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in
     *                                               the stack passed in $tokens.
     *
     * @return void
     */
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $error = 'Use of eval() is discouraged';
        $phpcsFile->addWarning($error, $stackPtr, 'Discouraged');
    }
    //end process()
}
//end class
