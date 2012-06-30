<?php
/**
 * User: elkuku
 * Date: 14.06.12
 * Time: 12:21
 */

class MgwExtensionHelper
{
    const NESTED_BRACKETS_REGEX =
        '(?>[^\[\]]+|\[(?>[^\[\]]+|\[(?>[^\[\]]+|\[(?>[^\[\]]+|\[(?>[^\[\]]+|\[(?>[^\[\]]+|\[\])*\])*\])*\])*\])*\])*';

    const NESTED_URL_PARENTHESIS_REGEX =
        '(?>[^()\s]+|\((?>[^()\s]+|\((?>[^()\s]+|\((?>[^()\s]+|\((?>\)))*(?>\)))*(?>\)))*(?>\)))*';

    /**
     * @var string Our page.
     */
    protected static $page = '';

    public static function preParse($text, $baseTitle = '')
    {
        self::$page = JFactory::getApplication()->input->getPath('page');

        //
        // Inline-style internal links: [[link text]](url "optional title")
        // @add KuKu
        //
        $text = preg_replace_callback('{
    	(				# wrap whole match in $1
    			  \[\[
    				('.self::NESTED_BRACKETS_REGEX.')	# link text = $2
    			  \]\]
    			  \(			# literal paren
    				[ ]*
    				(?:
    					<(\S*)>	# href = $3
    				|
    					('.self::NESTED_URL_PARENTHESIS_REGEX.')	# href = $4
    				)
    				[ ]*
    				(			# $5
    				  ([\'"])	# quote char = $6
    				  (.*?)		# Title = $7
    				  \6		# matching quote
    				  [ ]*	# ignore any spaces/tabs between closing quote and )
    				)?			# title is optional
    			  \)
    			)
    			}xs',
            __CLASS__.'::doInternalAnchorsCallback', $text);

        //
        // Next, inline-style internal links: [[link text]]
        // @add KuKu
        //
        $text = preg_replace_callback('{
    		(				# wrap whole match in $1
    			\[\[
    				('.self::NESTED_BRACKETS_REGEX.')	# link text = $2
    			\]\]
    		)
    		}xs',
            __CLASS__.'::doInternalAnchorsCallback', $text);

        $text = self::processFencedCodeBlocks($text);

        $text = self::processTemplates($text);

        return $text;
    }

    private static function processFencedCodeBlocks($text)
    {
        $lines = explode("\n", $text);

        $startfence = false;

        foreach($lines as &$line)
        {
            if(0 === strpos($line, '```'))
            {
                $lang = trim($line, '`');

                if($startfence)
                {
                    $line = '</pre>';

                    $startfence = false;
                }
                else
                {
                    $line = '<pre'.($lang ? ' xml:'.$lang : '').'>';

                    $startfence = true;
                }
            }
        }

        return implode("\n", $lines);

        $pattern = "@\\n```([a-z^\\n]+?)\\n(.*)+@";

        preg_match_all($pattern, $text, $matches);

        return $text;
    }

    private static function processTemplates($text)
    {
        $pattern = "@{{([a-z]+)\|?([A-z0-9\|\.\s]+)}}@";

        preg_match_all($pattern, $text, $matches);

        if(isset($matches[0][0]))
        {
            foreach(array_keys($matches[0]) as $i)
            {
                $className = 'MgwTemplate'.ucfirst($matches[1][$i]);

                if(false == class_exists($className))
                {
                    $red = '<strong style="color: red;">'.$matches[0][$i].'</strong>';
                    $text = str_replace($matches[0][$i], $red, $text);

                    return $text;
                }

                /* @var MgwTemplate $template */
                $template = new $className;

                $text = str_replace($matches[0][$i], $template->process($matches[2][$i]), $text);
            }
        }

        return $text;
    }

    /**
     * Enter description here ...
     *
     * @param array $matches
     *
     * @return string
     */
    protected static function doInternalAnchorsCallback($matches)
    {
        $whole_match = $matches[1];

        $text = trim($matches[2], '/');

        if(count($matches) > 3)
        {
            $url = $matches[3] == '' ? $matches[4] : $matches[3];
            $title =& $matches[7];
        }
        else
        {
            $url = $matches[2];
            $title = '';
        }

        $url = self::encodeAttribute($url);

        $red = (self::isLink($url)) ? '' : ' redlink';

        $attribs = 'class="internal'.$red.'"';

        $url = self::encodeAttribute(self::getLink($url));

        $redAdvise = ($red) ? 'Click to create this page...' : '';

        $attribs .= ((isset($title) && $title) || $redAdvise)
            ? ' title="'.$redAdvise.$title.'"'
            : '';

        return JHtml::link($url, $text, $attribs);
    }

    /**
     * @static
     *
     * @param $text
     *
     * @return mixed
     */
    protected static function encodeAttribute($text)
    {
        //
        // Encode text for a double-quoted HTML attribute. This function
        // is *not* suitable for attributes enclosed in single quotes.
        //
        //         $text = self::encodeAmpsAndAngles($text);
        $text = str_replace('"', '&quot;', $text);

        $text = str_replace('+', '%20', $text);
        $text = str_replace('_', '%5F', $text);
//         $text = str_replace('.','_',$text);
        $text = str_replace('-', ':', $text);

        return $text;
    }

    public static function getLink($text, $add = '', $baseTitle = '')
    {
        static $Itemid;

        if(! $Itemid)
        {
            //-- Hey mom can I have my J! Itemid(tm) plz......

            $menus = JFactory::getApplication()->getMenu('site');

            $cId = JComponentHelper::getComponent('com_markdowngitwiki')->id;

            $items = $menus->getItems('component_id', $cId);

            if($items)
            {
                foreach($items as $item)
                {
                    if(isset($item->query['view'])
                        && 'markdowngitwiki' == $item->query['view']
                    )
                    {
                        //-- HEUREKA =;)
                        $Itemid = $item->id;

                        break;
                    }
                }
            }

            if(! $Itemid)
            {
                //-- Get default from active menu
                $active = $menus->getActive();

                $Itemid = ($active) ? $active->id : 1;
            }
        }

        //-- end get Itemid...

        $raw = $text;

        if(0 === strpos($text, '/'))
        {
            //-- The text starts with a "/" - This is a relative internal link.
            //-- @todo add support for "../" syntax ¿
            $raw = ($baseTitle) ? : self::$page;
            $raw .= $text;
        }

        $parts = explode('/', $raw);

        $results = array();

        foreach($parts as $part)
        {
            $results[] = rawurlencode($part);
        }

        $parsed = implode('/', $results);

        $link = '';
        $link .= 'index.php?option=com_markdowngitwiki';

        $link .= ($Itemid) ? '&Itemid='.$Itemid : '&view=markdowngitwiki';

        $link .= '&page='.$parsed;

        $link .= $add;

        return JRoute::_($link);
    }

    public static function isLink($link)
    {
        $page = JFactory::getApplication()->input->getVar('page');

        if('start' == $page)
            $page = '';

        $path = JPath::clean(MGW_PATH_DATA.(($page) ? '/'.$page : '').'/'.$link.'.md');

        if(true == JFile::exists($path))
            return true;

        $path = JPath::clean(MGW_PATH_DATA.(($page) ? '/'.$page : '').'/'.$link);

        return JFolder::exists($path);
    }

    public static function drawToolbar($class = 'pull-right')
    {
        MgwToolbarHelper::addButton(new MgwToolbarButton(array(
            'href' => JRoute::_('&view=pages'),
            'icon' => 'icon-list-alt',
            'text' => 'Page List'
        )));

        return MgwToolbarHelper::display($class);
    }
}
