<?php

jimport('joomla.application.component.view');

/**
 * Pages view.
 *
 * @package    MarkdownGitWiki
 * @subpackage Views
 */
class MarkdownGitWikiViewPages extends JViewLegacy
{
    /**
     * MarkdownGitWikiList view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return mixed|void
     */
    public function display($tpl = null)
    {
        $pathway = JFactory::getApplication()->getPathway();

        $pathway->addItem('Page List');

        $foo = 'Do something here..';

        parent::display($tpl);
    }
}
