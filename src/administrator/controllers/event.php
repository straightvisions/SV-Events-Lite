<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class Sv_Events_LiteControllerEvent extends JControllerForm
{

    function __construct() {
        $this->view_list = 'events';
        parent::__construct();
    }

}