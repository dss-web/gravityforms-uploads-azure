<?php

namespace Dekode\GravityForms\Vendor\NeutronStandard\Sniffs\StrictTypes;

use Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
class RequireStrictTypesSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    public function register()
    {
        return [\T_OPEN_TAG];
    }
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        if (!$this->isFirstOpenTag($phpcsFile, $stackPtr) || $this->isFileOnlyAnInterface($phpcsFile, $stackPtr)) {
            return;
        }
        $declarePtr = $this->getNextDeclarePtr($phpcsFile, $stackPtr);
        if (!$declarePtr || !$this->isDeclareStrictTypes($phpcsFile, $declarePtr) || !$this->isDeclareTurnedOn($phpcsFile, $declarePtr)) {
            $this->addStrictTypeError($phpcsFile, $stackPtr);
        }
    }
    private function isFirstOpenTag(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr) : bool
    {
        $previousOpenTagPtr = $phpcsFile->findPrevious(\T_OPEN_TAG, $stackPtr);
        return !$previousOpenTagPtr;
    }
    private function isFileOnlyAnInterface(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr) : bool
    {
        $interfacePtr = $phpcsFile->findNext(\T_INTERFACE, $stackPtr);
        if (!$interfacePtr) {
            return \false;
        }
        $tokens = $phpcsFile->getTokens();
        $ignoredTokenTypes = [\T_WHITESPACE, \T_COMMENT];
        $skipExpressionTokenTypes = [\T_USE, \T_NAMESPACE];
        $helper = new \Dekode\GravityForms\Vendor\NeutronStandard\SniffHelpers();
        for ($ptr = $stackPtr + 1; isset($tokens[$ptr]); $ptr++) {
            $token = $tokens[$ptr];
            if ($token['level'] > 0) {
                continue;
            }
            if ($token['code'] === \T_INTERFACE) {
                $ptr = $this->getEndOfBlockPtr($phpcsFile, $ptr);
                continue;
            }
            if (isset($token['comment_closer'])) {
                $ptr = $token['comment_closer'];
                continue;
            }
            if (\in_array($token['code'], $skipExpressionTokenTypes)) {
                $ptr = $helper->getNextSemicolonPtr($phpcsFile, $ptr);
                continue;
            }
            if (!\in_array($token['code'], $ignoredTokenTypes)) {
                return \false;
            }
        }
        return \true;
    }
    private function getEndOfBlockPtr(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        return $tokens[$stackPtr]['scope_closer'];
    }
    private function isDeclareStrictTypes(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $declarePtr) : bool
    {
        $tokens = $phpcsFile->getTokens();
        $declareStringPtr = $phpcsFile->findNext(\T_STRING, $declarePtr, null, \false, null, \true);
        $declareStringToken = $tokens[$declareStringPtr];
        return $declareStringToken && $declareStringToken['content'] === 'strict_types';
    }
    private function isDeclareTurnedOn(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $declarePtr) : bool
    {
        $tokens = $phpcsFile->getTokens();
        $declareNumPtr = $phpcsFile->findNext(\T_LNUMBER, $declarePtr + 1, null, \false, null, \true);
        $declareNumToken = $tokens[$declareNumPtr];
        return $declareNumToken && $declareNumToken['content'] === '1';
    }
    private function addStrictTypeError(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $error = 'File must start with a strict types declaration';
        $phpcsFile->addError($error, $stackPtr, 'StrictTypes');
    }
    private function getNextDeclarePtr(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        return $phpcsFile->findNext(\T_DECLARE, $stackPtr, null, \false, null, \true);
    }
}
