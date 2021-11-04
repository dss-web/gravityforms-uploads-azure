<?php

namespace Dekode\GravityForms\Vendor\Composer;

use Dekode\GravityForms\Vendor\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => NULL, 'name' => 'dekode/ninjaforms-azure'), 'versions' => array('automattic/phpcs-neutron-standard' => array('pretty_version' => 'v1.7.0', 'version' => '1.7.0.0', 'aliases' => array(), 'reference' => '566ad70534296073afa9143858671356444ddead'), 'composer/installers' => array('pretty_version' => 'v1.11.0', 'version' => '1.11.0.0', 'aliases' => array(), 'reference' => 'ae03311f45dfe194412081526be2e003960df74b'), 'dealerdirect/phpcodesniffer-composer-installer' => array('pretty_version' => 'v0.7.1', 'version' => '0.7.1.0', 'aliases' => array(), 'reference' => 'fe390591e0241955f22eb9ba327d137e501c771c'), 'dekode/coding-standards' => array('pretty_version' => '4.0.0', 'version' => '4.0.0.0', 'aliases' => array(), 'reference' => '6e8301311d1c71e70104c9fc6553d3e785413070'), 'dekode/ninjaforms-azure' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => NULL), 'guzzlehttp/guzzle' => array('pretty_version' => '7.3.0', 'version' => '7.3.0.0', 'aliases' => array(), 'reference' => '7008573787b430c1c1f650e3722d9bba59967628'), 'guzzlehttp/promises' => array('pretty_version' => '1.4.1', 'version' => '1.4.1.0', 'aliases' => array(), 'reference' => '8e7d04f1f6450fef59366c399cfad4b9383aa30d'), 'guzzlehttp/psr7' => array('pretty_version' => '1.8.2', 'version' => '1.8.2.0', 'aliases' => array(), 'reference' => 'dc960a912984efb74d0a90222870c72c87f10c91'), 'microsoft/azure-storage-blob' => array('pretty_version' => '1.5.2', 'version' => '1.5.2.0', 'aliases' => array(), 'reference' => '2475330963372d519387cb8135d6a9cfd42272da'), 'microsoft/azure-storage-common' => array('pretty_version' => '1.5.1', 'version' => '1.5.1.0', 'aliases' => array(), 'reference' => 'e5738035891546075bd369954e8af121d65ebd6d'), 'microsoft/azure-storage-file' => array('pretty_version' => '1.2.4', 'version' => '1.2.4.0', 'aliases' => array(), 'reference' => '067a41d588ebb8f2dd3b6657a35c155d7f45c06d'), 'phpcompatibility/php-compatibility' => array('pretty_version' => '9.3.5', 'version' => '9.3.5.0', 'aliases' => array(), 'reference' => '9fb324479acf6f39452e0655d2429cc0d3914243'), 'phpcompatibility/phpcompatibility-paragonie' => array('pretty_version' => '1.3.1', 'version' => '1.3.1.0', 'aliases' => array(), 'reference' => 'ddabec839cc003651f2ce695c938686d1086cf43'), 'phpcompatibility/phpcompatibility-wp' => array('pretty_version' => '2.1.2', 'version' => '2.1.2.0', 'aliases' => array(), 'reference' => 'a792ab623069f0ce971b2417edef8d9632e32f75'), 'psr/http-client' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '2dfb5f6c5eff0e91e20e913f8c5452ed95b86621'), 'psr/http-client-implementation' => array('provided' => array(0 => '1.0')), 'psr/http-message' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => 'f6561bf28d520154e4b0ec72be95418abe6d9363'), 'psr/http-message-implementation' => array('provided' => array(0 => '1.0')), 'ralouphie/getallheaders' => array('pretty_version' => '3.0.3', 'version' => '3.0.3.0', 'aliases' => array(), 'reference' => '120b605dfeb996808c31b6477290a714d356e822'), 'roundcube/plugin-installer' => array('replaced' => array(0 => '*')), 'shama/baton' => array('replaced' => array(0 => '*')), 'squizlabs/php_codesniffer' => array('pretty_version' => '3.6.0', 'version' => '3.6.0.0', 'aliases' => array(), 'reference' => 'ffced0d2c8fa8e6cdc4d695a743271fab6c38625'), 'wp-coding-standards/wpcs' => array('pretty_version' => '2.3.0', 'version' => '2.3.0.0', 'aliases' => array(), 'reference' => '7da1894633f168fe244afc6de00d141f27517b62')));
    public static function getInstalledPackages()
    {
        return \array_keys(self::$installed['versions']);
    }
    public static function isInstalled($packageName)
    {
        return isset(self::$installed['versions'][$packageName]);
    }
    public static function satisfies(\Dekode\GravityForms\Vendor\Composer\Semver\VersionParser $parser, $packageName, $constraint)
    {
        $constraint = $parser->parseConstraints($constraint);
        $provided = $parser->parseConstraints(self::getVersionRanges($packageName));
        return $provided->matches($constraint);
    }
    public static function getVersionRanges($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        $ranges = array();
        if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            $ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
        }
        if (\array_key_exists('aliases', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
        }
        if (\array_key_exists('replaced', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
        }
        if (\array_key_exists('provided', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
        }
        return \implode(' || ', $ranges);
    }
    public static function getVersion($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['version'];
    }
    public static function getPrettyVersion($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['pretty_version'];
    }
    public static function getReference($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['reference'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['reference'];
    }
    public static function getRootPackage()
    {
        return self::$installed['root'];
    }
    public static function getRawData()
    {
        return self::$installed;
    }
    public static function reload($data)
    {
        self::$installed = $data;
    }
}
