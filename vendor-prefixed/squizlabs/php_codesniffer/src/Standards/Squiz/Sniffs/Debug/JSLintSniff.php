<?php

/**
 * Runs jslint.js on the file.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Squiz\Sniffs\Debug;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Common;
class JSLintSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = ['JS'];
    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return int[]
     */
    public function register()
    {
        return [\T_OPEN_TAG];
    }
    //end register()
    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where the token was found.
     * @param int                         $stackPtr  The position in the stack where
     *                                               the token was found.
     *
     * @return void
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If jslint.js could not be run
     */
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $rhinoPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config::getExecutablePath('rhino');
        $jslintPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config::getExecutablePath('jslint');
        if ($rhinoPath === null || $jslintPath === null) {
            return;
        }
        $fileName = $phpcsFile->getFilename();
        $rhinoPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Common::escapeshellcmd($rhinoPath);
        $jslintPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Common::escapeshellcmd($jslintPath);
        $cmd = "{$rhinoPath} \"{$jslintPath}\" " . \escapeshellarg($fileName);
        \exec($cmd, $output, $retval);
        if (\is_array($output) === \true) {
            foreach ($output as $finding) {
                $matches = [];
                $numMatches = \preg_match('/Lint at line ([0-9]+).*:(.*)$/', $finding, $matches);
                if ($numMatches === 0) {
                    continue;
                }
                $line = (int) $matches[1];
                $message = 'jslint says: ' . \trim($matches[2]);
                $phpcsFile->addWarningOnLine($message, $line, 'ExternalTool');
            }
        }
        // Ignore the rest of the file.
        return $phpcsFile->numTokens + 1;
    }
    //end process()
}
//end class
