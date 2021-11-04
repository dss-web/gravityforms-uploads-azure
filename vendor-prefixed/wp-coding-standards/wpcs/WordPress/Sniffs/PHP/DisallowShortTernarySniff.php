<?php

/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */
namespace Dekode\GravityForms\Vendor\WordPressCS\WordPress\Sniffs\PHP;

use Dekode\GravityForms\Vendor\WordPressCS\WordPress\Sniff;
use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens;
/**
 * Disallow the use of short ternaries.
 *
 * @link    https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/#ternary-operator
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   2.2.0
 */
class DisallowShortTernarySniff extends \Dekode\GravityForms\Vendor\WordPressCS\WordPress\Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @since 2.2.0
     *
     * @return array
     */
    public function register()
    {
        return array(\Dekode\GravityForms\Vendor\T_INLINE_THEN);
    }
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @since 2.2.0
     *
     * @param int $stackPtr The position of the current token in the stack.
     *
     * @return void
     */
    public function process_token($stackPtr)
    {
        $nextNonEmpty = $this->phpcsFile->findNext(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$emptyTokens, $stackPtr + 1, null, \true);
        if (\false === $nextNonEmpty) {
            // Live coding or parse error.
            return;
        }
        if (\Dekode\GravityForms\Vendor\T_INLINE_ELSE !== $this->tokens[$nextNonEmpty]['code']) {
            return;
        }
        $this->phpcsFile->addError('Using short ternaries is not allowed', $stackPtr, 'Found');
    }
}
