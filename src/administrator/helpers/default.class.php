<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;

class DefaultHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        
        JHtmlSidebar::addEntry(
                JText::_('COM_SV_EVENTS_LITE_TITLE_EVENTS'),
                'index.php?option=com_sv_events_lite&view=events',
                $vName == 'events'
        );
        
        JHtmlSidebar::addEntry(
                JText::_('COM_SV_EVENTS_LITE_TITLE_CATEGORIES'),
                'index.php?option=com_sv_events_lite&view=categories',
                $vName == 'categories'
        );

    }

    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_sv_events_lite';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
