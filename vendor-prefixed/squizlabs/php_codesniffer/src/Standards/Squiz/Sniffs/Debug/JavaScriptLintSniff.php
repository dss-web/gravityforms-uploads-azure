<?php

/**
 * Runs JavaScript Lint on the file.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Squiz\Sniffs\Debug;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Exceptions\RuntimeException;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Common;
class JavaScriptLintSniff implements \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Sniffs\Sniff
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
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If Javascript Lint ran into trouble.
     */
    public function process(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $jslPath = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Config::getExecutablePath('jsl');
        if ($jslPath === null) {
            return;
        }
        $fileName = $phpcsFile->getFilename();
        $cmd = '"' . \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Common::escapeshellcmd($jslPath) . '" -nologo -nofilelisting -nocontext -nosummary -output-format __LINE__:__ERROR__ -process ' . \escapeshellarg($fileName);
        $msg = \exec($cmd, $output, $retval);
        // Variable $exitCode is the last line of $output if no error occurs, on
        // error it is numeric. Try to handle various error conditions and
        // provide useful error reporting.
        if ($retval === 2 || $retval === 4) {
            if (\is_array($output) === \true) {
                $msg = \join('\\n', $output);
            }
            throw new \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Exceptions\RuntimeException("Failed invoking JavaScript Lint, retval was [{$retval}], output was [{$msg}]");
        }
        if (\is_array($output) === \true) {
            foreach ($output as $finding) {
                $split = \strpos($finding, ':');
                $line = \substr($finding, 0, $split);
                $message = \substr($finding, $split + 1);
                $phpcsFile->addWarningOnLine(\trim($message), $line, 'ExternalTool');
            }
        }
        // Ignore the rest of the file.
        return $phpcsFile->numTokens + 1;
    }
    //end process()
}
//end class
