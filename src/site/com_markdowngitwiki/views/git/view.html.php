<?php defined('_JEXEC') || die('=;)');
/**
 * @package    MarkdownGitWiki
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 19-Jun-2012
 * @license    GNU/GPL
 */

jimport('joomla.application.component.view');

/**
 * Git view.
 *
 * @package    MarkdownGitWiki
 * @subpackage Views
 */
class MarkdownGitWikiViewGit extends JView
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
