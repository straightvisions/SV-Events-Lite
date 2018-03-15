<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

class Sv_Events_LiteModelEvent extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_SV_EVENTS_LITE';


	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Event', $prefix = 'Sv_Events_LiteTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_sv_events_lite.event', 'event', array('control' => 'jform', 'load_data' => $loadData));
  
        
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
            // Check the session for previously entered form data.
            $data = JFactory::getApplication()->getUserState('com_sv_events_lite.edit.event.data', array());

            if (empty($data)) {
                $data = $this->getItem();
            }
            
            if(!empty($data->datetime_start) && $data->datetime_start != '0000-00-00 00:00:00') $data->datetime_start = date('d.m.Y H:i',strtotime($data->datetime_start));
            if(!empty($data->datetime_end) && $data->datetime_end != '0000-00-00 00:00:00')$data->datetime_end = date('d.m.Y H:i',strtotime($data->datetime_end));
            if(!empty($data->datetime_end_application) && $data->datetime_end_application != '0000-00-00 00:00:00')$data->datetime_end_application = date('d.m.Y H:i',strtotime($data->datetime_end_application));

            return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{ 

                    // Do any procesing on fields here if needed
                    $registry = new JRegistry;
                    $registry->loadString($item->categories);
                    $item->categories = $registry->toArray();
                    
		}

		return $item;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	1.6
	 */
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');
                
		if (empty($table->event_id)) {

			// Set ordering to the last item if not set
			if (@$table->ordering === '') {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__sv_events_lite_events');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}

		}
                
                $table->datetime_start = date('Y-m-d H:i:00',strtotime($table->datetime_start));
                $table->datetime_end = date('Y-m-d H:i:00',strtotime($table->datetime_end));
                $table->datetime_end_application = (!empty($table->datetime_end_application)) ? date('Y-m-d H:i:00',strtotime($table->datetime_end_application)) : NULL;
                
                //print_r($table);die;
                
                
	}

}