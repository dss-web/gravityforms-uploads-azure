<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\MagicMethods;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class DisallowMagicGetSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [\T_FUNCTION];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $functionName = $phpcsFile->getDeclarationName($stackPtr);
        if ($functionName === '__get') {
            $error = 'Magic getters are not allowed';
            $phpcsFile->addError($error, $stackPtr, 'MagicGet');
        }
    }
}
