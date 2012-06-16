<?php


jimport('joomla.application.component.view');

/**
 * Pages view.
 *
 * @package    MarkdownGitWiki
 * @subpackage Views
 */
class MarkdownGitWikiViewPages extends JView
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
    }//function
}//class
