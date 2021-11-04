<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\Whitespace;

use Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class DisallowMultipleNewlinesSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [\T_WHITESPACE];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['content'] !== "\n") {
            return;
        }
        if ($stackPtr < 3) {
            return;
        }
        if ($tokens[$stackPtr - 1]['content'] !== "\n") {
            return;
        }
        if ($tokens[$stackPtr - 2]['content'] !== "\n") {
            return;
        }
        $error = 'Multiple adjacent blank lines are not allowed';
        $shouldFix = $phpcsFile->addFixableError($error, $stackPtr, 'MultipleNewlines');
        if ($shouldFix) {
            $this->fixTokens($phpcsFile, $stackPtr);
        }
    }
    private function fixTokens(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $phpcsFile->fixer->beginChangeset();
        $phpcsFile->fixer->replaceToken($stackPtr, '');
        $phpcsFile->fixer->endChangeset();
    }
}
