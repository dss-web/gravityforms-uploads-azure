<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\Extract;

use Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class DisallowExtractSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
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
        if ($functionName === 'extract' && $helper->isFunctionCall($phpcsFile, $stackPtr)) {
            $error = 'Extract is not allowed';
            $phpcsFile->addError($error, $stackPtr, 'Extract');
        }
    }
}
