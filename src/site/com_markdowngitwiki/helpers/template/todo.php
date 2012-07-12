<?php
/**
 * User: elkuku
 * Date: 14.06.12
 * Time: 21:15
 */

class MgwTemplateTodo extends MgwTemplate
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
        return '<span class="badge badge-info">@TODO: '.$paramString.'</span>';
    }
}
