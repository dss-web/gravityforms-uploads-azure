<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\Functions;

use Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class DisallowCallUserFuncSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [\T_STRING];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $functionName = $tokens[$stackPtr]['content'];
        $helper = new \Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers();
        $disallowedFunctions = ['call_user_func', 'call_user_func_array'];
        if (\in_array($functionName, $disallowedFunctions) && $helper->isFunctionCall($phpcsFile, $stackPtr)) {
            $error = 'call_user_func and call_user_func_array are not allowed';
            $phpcsFile->addError($error, $stackPtr, 'CallUserFunc');
        }
    }
}
