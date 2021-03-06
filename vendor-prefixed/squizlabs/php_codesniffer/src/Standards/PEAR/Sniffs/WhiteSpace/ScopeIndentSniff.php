<?php

/**
 * Checks that control structures are structured and indented correctly.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\PEAR\Sniffs\WhiteSpace;

use Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\ScopeIndentSniff as GenericScopeIndentSniff;
class ScopeIndentSniff extends \Dekode\GravityForms\Vendor\PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\ScopeIndentSniff
{
    /**
     * Any scope openers that should not cause an indent.
     *
     * @var int[]
     */
    protected $nonIndentingScopes = [\T_SWITCH];
}
//end class
