<?php
/**
 * @package    MarkdownGitWiki
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 14-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

//-- Import the JView class
jimport('joomla.application.component.view');

/**
 * HTML View class for the MarkdownGitWiki Component.
 *
 * @package MarkdownGitWiki
 */
class MarkdownGitWikiViewMarkdownGitWiki extends JView
{
    protected $content = null;

    protected $page = '';

    /**
     * MarkdownGitWiki view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return mixed|void
     */
    public function display($tpl = null)
    {
        $this->content = $this->get('content');

        $this->page = JFactory::getApplication()->input->getVar('page', 'start');

        if('' == $this->content->text)
        {
            $this->setLayout('edit');

            return;
        }

        //-- Process internal links
        $this->content->text = MgwExtensionHelper::preParse($this->content->text);

        JPluginHelper::importPlugin('content');

        JDispatcher::getInstance()->trigger('onContentPrepare'
            , array('text', &$this->content, &$this->params));

        // $id =($this->content->id_kiss) ?: $this->content->id;

        // $this->translations = $this->getModel()->getTranslations($id);

        $this->setPathway();

        parent::display($tpl);
    }

    /**
     * Set the pathway.
     *
     * @return void
     */
    private function setPathway()
    {
        $title = (isset($this->content->title)) ? $this->content->title : $this->page;

        if(! $title) //-- No path, no -way...
            return;

        $pathway = JFactory::getApplication()->getPathway();

        $items = $pathway->getPathway();

        if($items
            && ! $this->isDefaultView()
        )
            array_pop($items);

        $parts = explode('/', $title);

        $combined = '';

        $baseLink = (isset($items[0]->link)) ? $items[0]->link : '';

        foreach($parts as $part)
        {
            if(! $part
                || 'start' == $part
            )
                continue;

            $combined .= ($combined) ? '/'.$part : $part;

            $p = new stdClass;

            $p->name = $part;
            $p->link = JRoute::_($baseLink.'&page='.$combined);
            $p->class = MgwExtensionHelper::isLink($combined) ? '' : 'internal redlink';

            $items[] = $p;
        }

        $pathway->setPathway($items);

        return;
    }

    protected function isDefaultView()
    {
        $menus = JFactory::getApplication()->getMenu('site');

        //-- Get default from active menu
        $active = $menus->getActive();

        $activeId = ($active) ? $active->id : 1;

        if(! $activeId)
            return false;

        $menus = JFactory::getApplication()->getMenu('site');

        $cId = JComponentHelper::getComponent('com_markdowngitwiki')->id;

        $items = $menus->getItems('component_id', $cId);

        $Itemid = false;

        if($items)
        {
            foreach($items as $item)
            {
                if(isset($item->query['view'])
                    && 'markdowngitwiki' == $item->query['view']
                )
                {
                    $Itemid = $item->id;
                    //-- HEUREKA =;)

                    break;
                }
            }
        }

        if(! $Itemid)
            return false;

        return ($Itemid == $activeId);
    }

}