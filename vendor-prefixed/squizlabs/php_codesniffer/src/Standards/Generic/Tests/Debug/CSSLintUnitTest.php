<?php

/**
 * Unit test class for the CSSLint sniff.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2019 Juliette Reinders Folmer. All rights reserved.
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Generic\Tests\Debug;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config;
class CSSLintUnitTest extends \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest
{
    /**
     * Should this test be skipped for some reason.
     *
     * @return void
     */
    protected function shouldSkipTest()
    {
        $csslintPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config::getExecutablePath('csslint');
        if ($csslintPath === null) {
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
        return [3 => 1, 4 => 1, 5 => 1];
    }
    //end getWarningList()
}
//end class
