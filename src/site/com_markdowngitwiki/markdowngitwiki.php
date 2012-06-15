<?php
/**
 * @package    MarkdownGitWiki
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 14-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

//include __DIR__.'/helpers/makrdowngitwiki.php';

$params = JComponentHelper::getParams('com_markdowngitwiki');

$dataPath = $params->get('dataPath');

if('' === trim($dataPath))
    $dataPath = JPath::clean(JPATH_COMPONENT_ADMINISTRATOR.'/pages');

if(false == JFolder::exists($dataPath))
{
    $application = JFactory::getApplication();
    $application->enqueueMessage('MarkdownGitWiki: The data path specified in the configuration settings does not exist.', 'error');
    $application->enqueueMessage(sprintf('Please create the folder: %s', $dataPath), 'error');

    return;
}

JLoader::registerPrefix('Mgw', JPATH_COMPONENT_SITE.'/helpers');

define('MGW_PATH_DATA', $dataPath);

//-- Import the class JController
jimport('joomla.application.component.controller');

//-- Get an instance of the controller with the prefix 'MarkdownGitWiki'
$controller = JController::getInstance('MarkdownGitWiki');

//-- Execute the 'task' from the Request
$controller->execute(JFactory::getApplication()->input->get('task'));

//-- Redirect if set by the controller
$controller->redirect();
