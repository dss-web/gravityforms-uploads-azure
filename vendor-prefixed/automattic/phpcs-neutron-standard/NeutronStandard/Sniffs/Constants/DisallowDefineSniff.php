<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\Constants;

use Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class DisallowDefineSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [\T_STRING];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $helper = new \Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers();
        if (!$helper->isFunctionCall($phpcsFile, $stackPtr)) {
            return;
        }
        $tokens = $phpcsFile->getTokens();
        $functionName = $tokens[$stackPtr]['content'];
        if ($functionName === 'define') {
            $error = 'Define is not allowed';
            $phpcsFile->addError($error, $stackPtr, 'Define');
        }
    }
}
