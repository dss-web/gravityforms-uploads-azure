<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\Arrays;

use Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class DisallowLongformArraySniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [\T_ARRAY];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $functionName = $tokens[$stackPtr]['content'];
        $helper = new \Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers();
        if ($functionName === 'array' && $helper->isFunctionCall($phpcsFile, $stackPtr)) {
            $error = 'Longform array is not allowed';
            $shouldFix = $phpcsFile->addFixableError($error, $stackPtr, 'LongformArray');
            if ($shouldFix) {
                $this->fixTokens($phpcsFile, $stackPtr);
            }
        }
    }
    private function fixTokens(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $openParenPtr = $tokens[$stackPtr]['parenthesis_opener'];
        $closeParenPtr = $tokens[$stackPtr]['parenthesis_closer'];
        $phpcsFile->fixer->beginChangeset();
        $phpcsFile->fixer->replaceToken($stackPtr, '');
        $phpcsFile->fixer->replaceToken($openParenPtr, '[');
        $phpcsFile->fixer->replaceToken($closeParenPtr, ']');
        $phpcsFile->fixer->endChangeset();
    }
}
