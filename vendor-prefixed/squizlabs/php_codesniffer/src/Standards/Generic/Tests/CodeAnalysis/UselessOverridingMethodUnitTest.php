<?php

/**
 * Unit test class for the UselessOverridingMethod sniff.
 *
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2014 Manuel Pichler. All rights reserved.
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Generic\Tests\CodeAnalysis;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;
class UselessOverridingMethodUnitTest extends \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest
{
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
        return [4 => 1, 16 => 1];
    }
    //end getWarningList()
}
//end class