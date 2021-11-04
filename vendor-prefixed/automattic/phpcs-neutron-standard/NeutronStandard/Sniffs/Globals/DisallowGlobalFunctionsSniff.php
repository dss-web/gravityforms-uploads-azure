<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\Globals;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class DisallowGlobalFunctionsSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [\T_FUNCTION];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $currentToken = $tokens[$stackPtr];
        $namespaceTokenPtr = $phpcsFile->findPrevious(\T_NAMESPACE, $stackPtr);
        if (!empty($currentToken['conditions'])) {
            return;
        }
        if ($namespaceTokenPtr) {
            return;
        }
        $error = 'Global functions are not allowed';
        $phpcsFile->addError($error, $stackPtr, 'GlobalFunctions');
    }
}
