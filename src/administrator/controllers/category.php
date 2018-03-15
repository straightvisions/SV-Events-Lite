<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Employee controller class.
 *
 * @since  1.6
 */
class Sv_Events_LiteControllerCategory extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'categories';
		parent::__construct();
	}
        
        protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
		// Get a handle to the Joomla! application object
	
           
            
            $application = JFactory::getApplication();
		
		
		// handle contact data array
		
                   
		$model->save($data);

	}
}
