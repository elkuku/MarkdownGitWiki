<?php defined('_JEXEC') || die('=;)');
/**
 * @package    MarkdownGitWiki
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 14-Jun-2012
 * @license    GNU/GPL
 */

JHtml::stylesheet('media/com_markdowngitwiki/site/css/markdowngitwiki.css');

echo MgwExtensionHelper::drawToolbar();

echo $this->content->text;
