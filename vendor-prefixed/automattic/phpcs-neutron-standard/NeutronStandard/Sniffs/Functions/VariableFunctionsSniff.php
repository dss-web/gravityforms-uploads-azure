<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\Functions;

use Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class VariableFunctionsSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [\T_VARIABLE];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $nextNonWhitespacePtr = $phpcsFile->findNext(\T_WHITESPACE, $stackPtr + 1, null, \true, null, \false);
        if (!$nextNonWhitespacePtr) {
            return;
        }
        if ($tokens[$nextNonWhitespacePtr]['code'] !== T_OPEN_PARENTHESIS) {
            return;
        }
        $message = 'Variable functions are discouraged';
        $phpcsFile->addWarning($message, $stackPtr, 'VariableFunction');
    }
}
