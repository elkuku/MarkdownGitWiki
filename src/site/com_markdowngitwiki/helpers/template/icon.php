<?php
/**
 * User: elkuku
 * Date: 14.06.12
 * Time: 21:15
 */

class MgwTemplateIcon extends MgwTemplate
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

        $icon = (isset($parts[0])) ? $parts[0] : 'unknown';

        $path = $imagePath.'/icons/'.$icon.'.png';

        return '<img src="'.$path.'" alt="icon '.$icon.'"/>';
    }
}
