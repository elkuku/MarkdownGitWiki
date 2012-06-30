<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/19/12
 * Time: 6:57 PM
 * To change this template use File | Settings | File Templates.
 */

class MgwToolbarHelper
{
    protected static $buttonGroups = array();

    public static function addButton(MgwToolbarButton $button, $group = '')
    {
        $group = $group ? : 'default';

        if(false == isset(self::$buttonGroups[$group]))
            self::$buttonGroups[$group] = array();

        self::$buttonGroups[$group][] = $button;
    }

    public static function display($class = '')
    {
        $html = '';

        $html[] = '<div class="btn-toolbar '.$class.'">';

        foreach(self::$buttonGroups as $group => $buttons)
        {
            $html[] = '<div class="btn-group">';

            foreach($buttons as $button)
            {
                $html[] = $button->render();
            }

            $html[] = '</div>';
        }

        $html[] = '</div>';

        return implode("\n", $html);
    }

}
