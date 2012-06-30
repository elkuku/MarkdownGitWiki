<?php
/**
 * User: elkuku
 * Date: 14.06.12
 * Time: 21:30
 */

/**
 * Mgw template base class.
 */
abstract class MgwTemplate
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
    abstract public function process($paramString);
}
