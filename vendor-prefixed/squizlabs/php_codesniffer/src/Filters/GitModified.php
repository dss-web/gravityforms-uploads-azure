<?php

/**
 * A filter to only include files that have been modified or added in a Git repository.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Filters;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util;
class GitModified extends \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Filters\ExactMatch
{
    /**
     * Get a list of blacklisted file paths.
     *
     * @return array
     */
    protected function getBlacklist()
    {
        return [];
    }
    //end getBlacklist()
    /**
     * Get a list of whitelisted file paths.
     *
     * @return array
     */
    protected function getWhitelist()
    {
        $modified = [];
        $cmd = 'git ls-files -o -m --exclude-standard -- ' . \escapeshellarg($this->basedir);
        $output = [];
        \exec($cmd, $output);
        $basedir = $this->basedir;
        if (\is_dir($basedir) === \false) {
            $basedir = \dirname($basedir);
        }
        foreach ($output as $path) {
            $path = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Common::realpath($path);
            if ($path === \false) {
                continue;
            }
            do {
                $modified[$path] = \true;
                $path = \dirname($path);
            } while ($path !== $basedir);
        }
        return $modified;
    }
    //end getWhitelist()
}
//end class
