<?php
/**
 * @package    MarkdownGitWiki
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 14-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


jimport('joomla.application.component.controller');

/**
 * MarkdownGitWiki Controller.
 *
 * @package    MarkdownGitWiki
 * @subpackage Controllers
 */
class MarkdownGitWikiController extends JController
{
    public function createPage()
    {
        //@todo ACL

        $page = JFactory::getApplication()->input->getVar('page', 'start');

        //-- Dumbass check :P
        $page = str_replace('..', '', $page);

        $c = array();

        $c[] = '# '.$page;
        $c[] = '';
        $c[] = 'New Page...';

        $content = implode("\n", $c);

        $fullPath = MGW_PATH_DATA.'/'.$page.'.md';

      //  $fullPath = realpath(dirname($p));
     //   $fileName = JFile::getName($p);

        if(false == JFile::write($fullPath, $content))
            throw new Exception(sprintf('%s - Can not create the requested page.', __METHOD__));

        JFactory::getApplication()->enqueueMessage('The page has been created');

        $this->setRedirect(JRoute::_('&task=&page='.$page));

    }
}//class
