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
        $parts = explode('|', $paramString);

        $icon = (isset($parts[0])) ? $parts[0] : '__unknown__';

        $path = __DIR__.'/icon/icons/%s.png';

        $p = realpath(sprintf($path, $icon));

        $p = ($p) ? : realpath(sprintf(__DIR__.'/icon/icons/%s.ico', $icon));

        $p = ($p) ? : sprintf($path, '__unknown__');

        $data = JFile::read($p);

        $cc = base64_encode($data);

        return '<img src="data:image/png;base64,'.$cc.'" />';
    }
}
