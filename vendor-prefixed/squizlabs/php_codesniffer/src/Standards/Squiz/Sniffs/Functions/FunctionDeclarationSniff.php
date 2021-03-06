<?php

/**
 * Checks the function declaration is correct.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\AbstractPatternSniff;
class FunctionDeclarationSniff extends \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\AbstractPatternSniff
{
    /**
     * Returns an array of patterns to check are correct.
     *
     * @return array
     */
    protected function getPatterns()
    {
        return ['function abc(...);', 'function abc(...)', 'abstract function abc(...);'];
    }
    //end getPatterns()
}
//end class
