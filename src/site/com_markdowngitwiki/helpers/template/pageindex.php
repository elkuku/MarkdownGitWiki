<?php
/**
 * User: elkuku
 * Date: 14.06.12
 * Time: 21:15
 */

class MgwTemplatePageindex extends MgwTemplate
{
    public function process($paramString)
    {
        $path = MGW_PATH_DATA.'/'.$paramString;

        $html = array();

        if(JFolder::exists($path))
        {
            //$html[] = '# '.$paramString;
            $html[] = '<h3 class="mgwPageIndex">Page Index</h3>';
            //$html[] = MGW_PATH_DATA.'/'.$paramString;

            $pages = JFolder::files($path, 'md');

            if(count($pages))
            {
                $html[] = '<ul>';

                foreach($pages as $page)
                {
                    $pName = JFile::stripExt($page);

                    $html[] = '<li>'
                        .'<a href="'.JRoute::_('&page='.$paramString.'/'.$pName).'">'.$pName.'</a>'
                        .'</li>';
                }

                $html[] = '</ul>';
            }

        }

        return implode("\n", $html);
    }
}
