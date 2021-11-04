<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\Whitespace;

use Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class RequireParenthesisSpacingSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [T_OPEN_PARENTHESIS, T_CLOSE_PARENTHESIS];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $isBefore = $token['type'] === 'T_OPEN_PARENTHESIS';
        $nextTokenPtr = $isBefore ? $stackPtr + 1 : $stackPtr - 1;
        $nextToken = $tokens[$nextTokenPtr];
        if (!isset($nextToken['type'])) {
            return;
        }
        $allowedTypes = ['T_WHITESPACE'];
        $allowedTypes[] = $isBefore ? 'T_CLOSE_PARENTHESIS' : 'T_OPEN_PARENTHESIS';
        if (\in_array($nextToken['type'], $allowedTypes, \true)) {
            return;
        }
        $error = 'Parenthesis content must be padded by a space';
        $shouldFix = $phpcsFile->addFixableError($error, $stackPtr, 'Missing');
        if ($shouldFix) {
            $this->fixTokens($phpcsFile, $nextTokenPtr, $isBefore);
        }
    }
    private function fixTokens(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr, $isBefore)
    {
        $phpcsFile->fixer->beginChangeset();
        if ($isBefore) {
            $phpcsFile->fixer->addContentBefore($stackPtr, ' ');
        } else {
            $phpcsFile->fixer->addContent($stackPtr, ' ');
        }
        $phpcsFile->fixer->endChangeset();
    }
}
