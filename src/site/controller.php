<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class Sv_Events_LiteController extends JControllerLegacy {

    public function display($cachable = false, $urlparams = false) {
     
        $view = JFactory::getApplication()->input->getCmd('view', 'events');
        
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }

}
