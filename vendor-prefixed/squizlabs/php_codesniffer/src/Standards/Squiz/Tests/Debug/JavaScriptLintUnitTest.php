<?php

/**
 * Unit test class for the JavaScriptLint sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Squiz\Tests\Debug;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config;
class JavaScriptLintUnitTest extends \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest
{
    /**
     * Should this test be skipped for some reason.
     *
     * @return void
     */
    protected function shouldSkipTest()
    {
        $jslPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config::getExecutablePath('jsl');
        if ($jslPath === null) {
            return \true;
        }
        return \false;
    }
    //end shouldSkipTest()
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getErrorList()
    {
        return [];
    }
    //end getErrorList()
    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getWarningList()
    {
        return [2 => 1];
    }
    //end getWarningList()
}
//end class
