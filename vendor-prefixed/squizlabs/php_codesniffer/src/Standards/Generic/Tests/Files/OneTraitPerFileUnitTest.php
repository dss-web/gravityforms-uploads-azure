<?php

/**
 * Unit test class for the OneTraitPerFile sniff.
 *
 * @author    Alexander Obuhovich <aik.bold@gmail.com>
 * @copyright 2010-2014 Alexander Obuhovich
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Generic\Tests\Files;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;
class OneTraitPerFileUnitTest extends \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getErrorList()
    {
        return [6 => 1, 10 => 1];
    }
    //end getErrorList()
    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getWarningList()
    {
        return [];
    }
    //end getWarningList()
}
//end class
