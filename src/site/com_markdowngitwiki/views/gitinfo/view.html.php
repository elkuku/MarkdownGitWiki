<?php
/**
 * @package    MarkdownGitWiki
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 22-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

jimport('joomla.application.component.view');

/**
 * GitInfo view.
 *
 * @package    MarkdownGitWiki
 * @subpackage Views
 */
class MarkdownGitWikiViewGitInfo extends JView
{
    /**
     * MarkdownGitWikiList view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return void
     */
    public function display($tpl = null)
    {
        $foo = 'Do something here..';

        parent::display($tpl);
    }
    //function
}//class