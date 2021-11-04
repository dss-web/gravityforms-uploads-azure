<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\MagicMethods;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class DisallowMagicSerializeSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [\T_FUNCTION];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $functionName = $phpcsFile->getDeclarationName($stackPtr);
        if ($functionName === '__serialize') {
            $error = 'Magic serialize is not allowed';
            $phpcsFile->addError($error, $stackPtr, 'MagicSerialize');
        }
    }
}
