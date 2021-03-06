<?php

/**
 * Tests for the \PHP_CodeSniffer\Ruleset class.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2019 Juliette Reinders Folmer. All rights reserved.
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Tests\Core\Ruleset;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Ruleset;
use Dekode\GravityForms\Vendor\PHPUnit\Framework\TestCase;
class RuleInclusionTest extends \Dekode\GravityForms\Vendor\PHPUnit\Framework\TestCase
{
    /**
     * The Ruleset object.
     *
     * @var \PHP_CodeSniffer\Ruleset
     */
    protected static $ruleset;
    /**
     * Path to the ruleset file.
     *
     * @var string
     */
    private static $standard = '';
    /**
     * The original content of the ruleset.
     *
     * @var string
     */
    private static $contents = '';
    /**
     * Initialize the test.
     *
     * @return void
     */
    public function setUp()
    {
        if ($GLOBALS['PHP_CODESNIFFER_PEAR'] === \true) {
            // PEAR installs test and sniff files into different locations
            // so these tests will not pass as they directly reference files
            // by relative location.
            $this->markTestSkipped('Test cannot run from a PEAR install');
        }
    }
    //end setUp()
    /**
     * Initialize the config and ruleset objects based on the `RuleInclusionTest.xml` ruleset file.
     *
     * @return void
     */
    public static function setUpBeforeClass()
    {
        if ($GLOBALS['PHP_CODESNIFFER_PEAR'] === \true) {
            // This test will be skipped.
            return;
        }
        $standard = __DIR__ . '/' . \basename(__FILE__, '.php') . '.xml';
        self::$standard = $standard;
        // On-the-fly adjust the ruleset test file to be able to test
        // sniffs included with relative paths.
        $contents = \file_get_contents($standard);
        self::$contents = $contents;
        $repoRootDir = \basename(\dirname(\dirname(\dirname(__DIR__))));
        $newPath = $repoRootDir;
        if (\DIRECTORY_SEPARATOR === '\\') {
            $newPath = \str_replace('\\', '/', $repoRootDir);
        }
        $adjusted = \str_replace('%path_root_dir%', $newPath, $contents);
        if (\file_put_contents($standard, $adjusted) === \false) {
            self::markTestSkipped('On the fly ruleset adjustment failed');
        }
        $config = new \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config(["--standard={$standard}"]);
        self::$ruleset = new \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Ruleset($config);
    }
    //end setUpBeforeClass()
    /**
     * Reset ruleset file.
     *
     * @return void
     */
    public function tearDown()
    {
        \file_put_contents(self::$standard, self::$contents);
    }
    //end tearDown()
    /**
     * Test that sniffs are registered.
     *
     * @return void
     */
    public function testHasSniffCodes()
    {
        $this->assertObjectHasAttribute('sniffCodes', self::$ruleset);
        $this->assertCount(14, self::$ruleset->sniffCodes);
    }
    //end testHasSniffCodes()
    /**
     * Test that sniffs are correctly registered, independently on the syntax used to include the sniff.
     *
     * @param string $key   Expected array key.
     * @param string $value Expected array value.
     *
     * @dataProvider dataRegisteredSniffCodes
     *
     * @return void
     */
    public function testRegisteredSniffCodes($key, $value)
    {
        $this->assertArrayHasKey($key, self::$ruleset->sniffCodes);
        $this->assertSame($value, self::$ruleset->sniffCodes[$key]);
    }
    //end testRegisteredSniffCodes()
    /**
     * Data provider.
     *
     * @see self::testRegisteredSniffCodes()
     *
     * @return array
     */
    public function dataRegisteredSniffCodes()
    {
        return [['PSR1.Classes.ClassDeclaration', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\PSR1\\Sniffs\\Classes\\ClassDeclarationSniff'], ['PSR1.Files.SideEffects', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\PSR1\\Sniffs\\Files\\SideEffectsSniff'], ['PSR1.Methods.CamelCapsMethodName', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\PSR1\\Sniffs\\Methods\\CamelCapsMethodNameSniff'], ['Generic.PHP.DisallowAlternativePHPTags', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\PHP\\DisallowAlternativePHPTagsSniff'], ['Generic.PHP.DisallowShortOpenTag', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\PHP\\DisallowShortOpenTagSniff'], ['Generic.Files.ByteOrderMark', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Files\\ByteOrderMarkSniff'], ['Squiz.Classes.ValidClassName', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Squiz\\Sniffs\\Classes\\ValidClassNameSniff'], ['Generic.NamingConventions.UpperCaseConstantName', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\NamingConventions\\UpperCaseConstantNameSniff'], ['Zend.NamingConventions.ValidVariableName', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Zend\\Sniffs\\NamingConventions\\ValidVariableNameSniff'], ['Generic.Arrays.ArrayIndent', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Arrays\\ArrayIndentSniff'], ['Generic.Metrics.CyclomaticComplexity', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Metrics\\CyclomaticComplexitySniff'], ['Generic.Files.LineLength', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Files\\LineLengthSniff'], ['Generic.NamingConventions.CamelCapsFunctionName', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\NamingConventions\\CamelCapsFunctionNameSniff'], ['Generic.Metrics.NestingLevel', 'Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Metrics\\NestingLevelSniff']];
    }
    //end dataRegisteredSniffCodes()
    /**
     * Test that setting properties for standards, categories, sniffs works for all supported rule
     * inclusion methods.
     *
     * @param string $sniffClass    The name of the sniff class.
     * @param string $propertyName  The name of the changed property.
     * @param mixed  $expectedValue The value expected for the property.
     *
     * @dataProvider dataSettingProperties
     *
     * @return void
     */
    public function testSettingProperties($sniffClass, $propertyName, $expectedValue)
    {
        $this->assertObjectHasAttribute('sniffs', self::$ruleset);
        $this->assertArrayHasKey($sniffClass, self::$ruleset->sniffs);
        $this->assertObjectHasAttribute($propertyName, self::$ruleset->sniffs[$sniffClass]);
        $actualValue = self::$ruleset->sniffs[$sniffClass]->{$propertyName};
        $this->assertSame($expectedValue, $actualValue);
    }
    //end testSettingProperties()
    /**
     * Data provider.
     *
     * @see self::testSettingProperties()
     *
     * @return array
     */
    public function dataSettingProperties()
    {
        return [
            'ClassDeclarationSniff' => ['Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\PSR1\\Sniffs\\Classes\\ClassDeclarationSniff', 'setforallsniffs', \true],
            'SideEffectsSniff' => ['Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\PSR1\\Sniffs\\Files\\SideEffectsSniff', 'setforallsniffs', \true],
            'ValidVariableNameSniff' => ['Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Zend\\Sniffs\\NamingConventions\\ValidVariableNameSniff', 'setforallincategory', \true],
            'ArrayIndentSniff' => ['Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Arrays\\ArrayIndentSniff', 'indent', '2'],
            'LineLengthSniff' => ['Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Files\\LineLengthSniff', 'lineLimit', '10'],
            'CamelCapsFunctionNameSniff' => ['Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\NamingConventions\\CamelCapsFunctionNameSniff', 'strict', \false],
            'NestingLevelSniff-nestingLevel' => ['Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Metrics\\NestingLevelSniff', 'nestingLevel', '2'],
            'NestingLevelSniff-setforsniffsinincludedruleset' => ['Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Metrics\\NestingLevelSniff', 'setforsniffsinincludedruleset', \true],
            // Testing that setting a property at error code level does *not* work.
            'CyclomaticComplexitySniff' => ['Dekode\\GravityForms\\Vendor\\PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Metrics\\CyclomaticComplexitySniff', 'complexity', 10],
        ];
    }
    //end dataSettingProperties()
}
//end class
