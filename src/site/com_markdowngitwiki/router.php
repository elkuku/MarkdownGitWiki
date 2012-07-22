<?php defined('_JEXEC') || die('=;)');
/**
 * @package    MarkdownGitWiki
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 22-Jul-2012
 * @license    GNU/GPL
 */

function MarkdowngitwikiBuildRoute(&$query)
{
    $segments = array();

    if(isset($query['page']))
    {
        $segments[] = $query['page'];

        unset($query['page']);
    }

    return $segments;
}

function MarkdowngitwikiParseRoute($segments)
{
    $vars = array();

    if(count($segments))
        $vars['page'] = implode('/', $segments);

    return $vars;
}
