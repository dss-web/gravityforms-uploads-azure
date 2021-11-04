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
 * Enforces Yoda conditional statements.
 *
 * @link    https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/#yoda-conditions
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.3.0
 * @since   0.12.0 This class now extends the WordPressCS native `Sniff` class.
 * @since   0.13.0 Class name changed: this class is now namespaced.
 */
class YodaConditionsSniff extends \Dekode\GravityForms\Vendor\WordPressCS\WordPress\Sniff
{
    /**
     * The tokens that indicate the start of a condition.
     *
     * @since 0.12.0
     *
     * @var array
     */
    protected $condition_start_tokens;
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        $starters = \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$booleanOperators;
        $starters += \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$assignmentTokens;
        $starters[\T_CASE] = \T_CASE;
        $starters[\T_RETURN] = \T_RETURN;
        $starters[\Dekode\GravityForms\Vendor\T_INLINE_THEN] = \Dekode\GravityForms\Vendor\T_INLINE_THEN;
        $starters[\Dekode\GravityForms\Vendor\T_INLINE_ELSE] = \Dekode\GravityForms\Vendor\T_INLINE_ELSE;
        $starters[\Dekode\GravityForms\Vendor\T_SEMICOLON] = \Dekode\GravityForms\Vendor\T_SEMICOLON;
        $starters[\Dekode\GravityForms\Vendor\T_OPEN_PARENTHESIS] = \Dekode\GravityForms\Vendor\T_OPEN_PARENTHESIS;
        $this->condition_start_tokens = $starters;
        return array(\T_IS_EQUAL, \T_IS_NOT_EQUAL, \T_IS_IDENTICAL, \T_IS_NOT_IDENTICAL);
    }
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param int $stackPtr The position of the current token in the stack.
     *
     * @return void
     */
    public function process_token($stackPtr)
    {
        $start = $this->phpcsFile->findPrevious($this->condition_start_tokens, $stackPtr, null, \false, null, \true);
        $needs_yoda = \false;
        // Note: going backwards!
        for ($i = $stackPtr; $i > $start; $i--) {
            // Ignore whitespace.
            if (isset(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$emptyTokens[$this->tokens[$i]['code']])) {
                continue;
            }
            // If this is a variable or array, we've seen all we need to see.
            if (\T_VARIABLE === $this->tokens[$i]['code'] || \Dekode\GravityForms\Vendor\T_CLOSE_SQUARE_BRACKET === $this->tokens[$i]['code']) {
                $needs_yoda = \true;
                break;
            }
            // If this is a function call or something, we are OK.
            if (\Dekode\GravityForms\Vendor\T_CLOSE_PARENTHESIS === $this->tokens[$i]['code']) {
                return;
            }
        }
        if (!$needs_yoda) {
            return;
        }
        // Check if this is a var to var comparison, e.g.: if ( $var1 == $var2 ).
        $next_non_empty = $this->phpcsFile->findNext(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$emptyTokens, $stackPtr + 1, null, \true);
        if (isset(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$castTokens[$this->tokens[$next_non_empty]['code']])) {
            $next_non_empty = $this->phpcsFile->findNext(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$emptyTokens, $next_non_empty + 1, null, \true);
        }
        if (\in_array($this->tokens[$next_non_empty]['code'], array(\Dekode\GravityForms\Vendor\T_SELF, \Dekode\GravityForms\Vendor\T_PARENT, \T_STATIC), \true)) {
            $next_non_empty = $this->phpcsFile->findNext(\Dekode\GravityForms\Vendor\PHP_CodeSniffer\Util\Tokens::$emptyTokens + array(\T_DOUBLE_COLON => \T_DOUBLE_COLON), $next_non_empty + 1, null, \true);
        }
        if (\T_VARIABLE === $this->tokens[$next_non_empty]['code']) {
            return;
        }
        $this->phpcsFile->addError('Use Yoda Condition checks, you must.', $stackPtr, 'NotYoda');
    }
}
