<?php
/**
 * @package    MarkdownGitWiki
 * @subpackage Models
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 14-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

jimport('joomla.application.component.model');

/**
 * MarkdownGitWiki model.
 *
 * @package    MarkdownGitWiki
 * @subpackage Models
 */
class MarkdownGitWikiModelMarkdownGitWiki extends JModel
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Additional work
        $foo = 'Bar';

        parent::__construct();
    }

    public function getContent()
    {
        $content = new stdClass;

        $page = JFactory::getApplication()->input->getVar('page', 'start');

        $page = str_replace('..', '', $page);

        $fullPath = MGW_PATH_DATA.'/'.$page.'.md';

        $path = realpath($fullPath);

//        JPath::clean()Folder::makeSafe()

        if($path && JFile::exists($path))
        {
            //-- Read the content
            $content->text = JFile::read($path);

            return $content;
        }

        $folder = realpath(dirname($fullPath));

        if($folder && JFolder::exists($folder))
        {
            $content->text = '{{pageindex|'.$page.'}}';

            return $content;
        }

        //-- Page not found :(
        if(JFactory::getApplication()->input->getInt('create'))
        {
            //@todo ACL

            $content->text = 'New Page';

            if(false == JFile::write($fullPath, $content->text))
                throw new Exception(sprintf('%s - Can not create the requested page.', __METHOD__));

            JFactory::getApplication()->enqueueMessage('The page has been created');
        }
        else
        {
            if(1) //can create
            {
                $create = '<p><a class="btn btn-success" href="'.JRoute::_('&create=1').'">'
                    .'<i class="icon-plus icon-white"></i>&nbsp;'
                    .'Create the page'
                    .'</a></p>';
            }
            else
            {
                $create = '<p>And you are not allowed to create pages</p>';
            }

            $content->text = sprintf('<p>'.'The page does not exist. %s'.'</p>', $create);
        }

        return $content;
    }
}

