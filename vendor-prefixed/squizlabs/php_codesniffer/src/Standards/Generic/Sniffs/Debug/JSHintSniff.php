<?php

/**
 * Runs jshint.js on the file.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Alexander Wei§ <aweisswa@gmx.de>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Generic\Sniffs\Debug;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Common;
class JSHintSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
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
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If jshint.js could not be run
     */
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $rhinoPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config::getExecutablePath('rhino');
        $jshintPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config::getExecutablePath('jshint');
        if ($rhinoPath === null && $jshintPath === null) {
            return;
        }
        $fileName = $phpcsFile->getFilename();
        $jshintPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Common::escapeshellcmd($jshintPath);
        if ($rhinoPath !== null) {
            $rhinoPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Common::escapeshellcmd($rhinoPath);
            $cmd = "{$rhinoPath} \"{$jshintPath}\" " . \escapeshellarg($fileName);
            \exec($cmd, $output, $retval);
            $regex = '`^(?P<error>.+)\\(.+:(?P<line>[0-9]+).*:[0-9]+\\)$`';
        } else {
            $cmd = "{$jshintPath} " . \escapeshellarg($fileName);
            \exec($cmd, $output, $retval);
            $regex = '`^(.+?): line (?P<line>[0-9]+), col [0-9]+, (?P<error>.+)$`';
        }
        if (\is_array($output) === \true) {
            foreach ($output as $finding) {
                $matches = [];
                $numMatches = \preg_match($regex, $finding, $matches);
                if ($numMatches === 0) {
                    continue;
                }
                $line = (int) $matches['line'];
                $message = 'jshint says: ' . \trim($matches['error']);
                $phpcsFile->addWarningOnLine($message, $line, 'ExternalTool');
            }
        }
        // Ignore the rest of the file.
        return $phpcsFile->numTokens + 1;
    }
    //end process()
}
//end class
