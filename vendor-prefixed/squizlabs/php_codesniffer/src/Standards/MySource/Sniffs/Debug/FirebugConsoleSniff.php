<?php

/**
 * Ensures that console is not used for function or var names.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\MySource\Sniffs\Debug;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class FirebugConsoleSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = ['JS'];
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [\T_STRING, T_PROPERTY, T_LABEL, T_OBJECT];
    }
    //end register()
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token
     *                                               in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if (\strtolower($tokens[$stackPtr]['content']) === 'console') {
            $error = 'Variables, functions and labels must not be named "console"; name may conflict with Firebug internal variable';
            $phpcsFile->addError($error, $stackPtr, 'ConflictFound');
        }
    }
    //end process()
}
//end class
