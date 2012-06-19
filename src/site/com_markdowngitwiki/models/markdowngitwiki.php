<?php defined('_JEXEC') || die('=;)');
/**
 * @package    MarkdownGitWiki
 * @subpackage Models
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 14-Jun-2012
 * @license    GNU/GPL
 */

jimport('joomla.application.component.model');

/**
 * MarkdownGitWiki model.
 *
 * @package    MarkdownGitWiki
 * @subpackage Models
 */
class MarkdownGitWikiModelMarkdownGitWiki extends JModel
{
    private $createButton = '';

    public function getContent()
    {
        $content = new stdClass;

        $page = JFactory::getApplication()->input->getVar('page', 'start');

        //-- Dumbass check :P
        $page = str_replace('..', '', $page);

        $createPage = JFactory::getApplication()->input->getInt('create') ? true : false;

        $createLink = JRoute::_('&task=createPage&page='.$page);
        //$createLinkStart = JRoute::_('&task=createPage&page='.$page.'/start');

        $createButton = '<a class="btn btn-success" href="'.$createLink.'">'
            .'<i class="icon-plus icon-white"></i>&nbsp;'
            .'Create this page'
            .'</a>';

        $fullPath = MGW_PATH_DATA.'/'.$page.'.md';

        $path = realpath($fullPath);

        if($path && JFile::exists($path))
        {
            //-- Read the content
            $content->text = JFile::read($path);

            return $content;
        }

        $folder = realpath(JFile::stripExt($fullPath));

        if($folder && JFolder::exists($folder))
        {
            $html = array();

            JHtml::script('media/com_markdowngitwiki/site/js/php_file_tree.js');
            JHtml::stylesheet('media/com_markdowngitwiki/site/css/php_file_tree.css');

            $html[] = '<h1>'.$page.'</h1>';

            $html[] = MgwFileTree::drawTree($folder, JRoute::_('&view=&page='.$page.'/[link]'));

//            $html[] = '{{pageindex|'.$page.'}}';

            $this->createButton = $createButton;

            $content->text = implode("\n", $html);

            return $content;
        }

        //-- Page not found :(
        if(false == $createPage)
        {
            $this->createButton = $createButton;

            $content->text = '<p>'.'The page does not exist (yet).'.'</p>';
        }

        return $content;
    }

    public function getCreateButton()
    {
        //@todo: ACL

        if(1) //can create
        {
            return $this->createButton;
        }
    }
}

