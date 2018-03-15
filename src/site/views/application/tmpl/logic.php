<?php

/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;
jimport('joomla.application.component.helper');
$params = JComponentHelper::getParams('com_sv_events_lite');
$posted = false;
$message = '';
if(isset($_POST['svelform']) && $_POST['svelform']['SVEL_APPLICATION_FORM_SUBMIT'] == true){
    
    $currenturl = JURI::current();
    JSession::checkToken('post') or jexit(JError::raiseError( 'Woops', 'Something went wrong.<br><br><a href= ' .  $currenturl . '   >Please <span style="text-decoration:underline">click here</span></a> to reload the page you were trying to access and try logging in again!' ));
  
    Sv_Events_LiteDefaultFrontendHelper::send_application();
    
    // here we should add menu item support late for more customization support
    header('Location: '.JRoute::_('index.php?Itemid='.$params->get('application_thank_you_menuitem')));

}
