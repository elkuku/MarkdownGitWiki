<?php
/**
 * User: elkuku
 * Date: 14.06.12
 * Time: 21:15
 */

class MgwTemplateImage extends MgwTemplate
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
        $imagePath = '___documentation/___images';

        $parts = explode('|', $paramString);
        $html = array();
        $width = '';
        $height = '';
        $title = '';
        $alt = '';

        $path = $imagePath.'/'.$parts[0];

        if(isset($parts[1]))
        {
            if((int)$parts[1])
            {
                $width = ' width="'.$parts[1].'"';
            }
            else
            {
                $title = ' title="'.$parts[1].'"';
                $alt = ' alt="'.$parts[1].'"';
            }
        }

        if(isset($parts[2]))
        {
            if((int)$parts[2])
            {
                $height = ' height="'.$parts[2].'"';
            }
            else
            {
                $title = ' title="'.$parts[2].'"';
                $alt = ' alt="'.$parts[2].'"';
            }
        }

        if(isset($parts[3]))
        {
            if((int)$parts[3])
            {
                $height = ' height="'.$parts[3].'"';
            }
            else
            {
                $title = ' title="'.$parts[3].'"';
                $alt = ' alt="'.$parts[3].'"';
            }
        }

        $html[] = '<a href="'.$path.'" target="_blank">';
        $html[] = '   <img src="'.$path.'"'.$width.$height.$alt.$title.'/>';
        $html[] = '</a>';

        return implode("\n", $html);
    }
}
