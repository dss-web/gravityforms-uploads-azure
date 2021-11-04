<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\MagicMethods;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class RiskyMagicMethodSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [\T_FUNCTION];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $functionName = $phpcsFile->getDeclarationName($stackPtr);
        $riskyMagicMethods = ['__invoke', '__call', '__callStatic'];
        if (\in_array($functionName, $riskyMagicMethods)) {
            $error = 'Magic methods are discouraged';
            $phpcsFile->addWarning($error, $stackPtr, 'RiskyMagicMethod');
        }
    }
}
