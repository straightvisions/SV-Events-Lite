<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::register('Sv_Events_LiteDefaultFrontendHelper', JPATH_COMPONENT . '/helpers/default.class.php');

$style = file_get_contents(__DIR__.'/assets/css/style.css');
$scripts = file_get_contents(__DIR__.'/assets/js/scripts.js');
$document = JFactory::getDocument();
JHtml::_('jquery.framework');
$document->addStyleDeclaration($style);
$document->addScriptDeclaration($scripts);

// Execute the task.
$controller = JControllerLegacy::getInstance('Sv_Events_Lite');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
