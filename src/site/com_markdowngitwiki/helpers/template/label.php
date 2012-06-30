<?php
/**
 * User: elkuku
 * Date: 14.06.12
 * Time: 21:15
 */

class MgwTemplateLabel extends MgwTemplate
{
    /**
     * Process the template.
     *
     * @abstract
     *
     * @param string $paramString
     *
     * @return string
     */
    public function process($paramString)
    {
        $parts = explode('|', $paramString);

        $class = (isset($parts[1])) ? ' label-'.$parts[1] : '';

        return '<span class="label'.$class.'">'.$parts[0].'</span>';
        $path = MGW_PATH_DATA.'/'.$paramString;

        $html = array();

        if(JFolder::exists($path))
        {
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
