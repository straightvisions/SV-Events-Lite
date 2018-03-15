<?php
/**
 * @version     1.0.1 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;

class Sv_Events_LiteTableEvent extends JTable
{

	public function __construct(&$db)
	{
		parent::__construct('#__sv_events_lite_events', 'event_id', $db);
	}

	public function bind($array, $ignore = '')
	{

		$input = JFactory::getApplication()->input;
		$task = $input->getString('task', '');
        
		if ($task == 'save2copy')
		{
			$array['title'] = $array['title'].' (Kopie)';
		}
		
		if(($task == 'save' || $task == 'apply') && (!JFactory::getUser()->authorise('core.edit.state','com_sv_events_lite.event.'.$array['event_id']) && $array['state'] == 1)){
			$array['state'] = 0;
		}
		if($array['event_id'] == 0){
			$array['created_by'] = JFactory::getUser()->id;
		}

		if (isset($array['params']) && is_array($array['params']))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata']))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}
                if (isset($array['rules']) && is_array($array['rules'])) { 
			$rules = new JRules($array['rules']); 
			$this->setRules($rules); 
		}
                /*
		if (!JFactory::getUser()->authorise('core.admin', 'com_sv_events_lite.event.' . $array['event_id']))
		{
			$actions         = JAccess::getActionsFromFile(JPATH_ADMINISTRATOR . '/components/com_sv_events_lite/access.xml',"/access/section[@name='event']/");
			$default_actions = JAccess::getAssetRules('com_sv_events_lite.event.' . $array['event_id'])->getData();
			$array_jaccess   = array();
			foreach ($actions as $action)
			{
				$array_jaccess[ $action->name ] = $default_actions[ $action->name ];
			}
			$array['rules'] = $this->JAccessRulestoArray($array_jaccess);
		}*/
            
		if (isset($array['categories']) && is_array($array['categories'])) {

			$registry = new JRegistry;
			$registry->loadArray($array['categories']);
			$array['categories'] = (string) $registry;

		}

		if (isset($array['rules']) && is_array($array['rules']))
		{
			$this->setRules($array['rules']);
		}

		return parent::bind($array, $ignore);
	}
/*
	private function JAccessRulestoArray($jaccessrules)
	{
		$rules = array();
		foreach ($jaccessrules as $action => $jaccess)
		{
			$actions = array();
			foreach ($jaccess->getData() as $group => $allow)
			{
				$actions[ $group ] = ((bool) $allow);
			}
			$rules[ $action ] = $actions;
		}

		return $rules;
	}*/

	public function check()
	{

		if (property_exists($this, 'ordering') && $this->event_id == 0)
		{
			$this->ordering = self::getNextOrder();
		}

		return parent::check();
	}

	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k)
			{
				$pks = array( $this->$k );
			}
			// Nothing to set publishing state on, return false.
			else
			{
				throw new Exception(500, JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
			}
		}

		// Build the WHERE clause for the primary keys.
		$where = $k . '=' . implode(' OR ' . $k . '=', $pks);

		// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time'))
		{
			$checkin = '';
		}
		else
		{
			$checkin = ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
		}

		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE `' . $this->_tbl . '`' .
			' SET `state` = ' . (int) $state .
			' WHERE (' . $where . ')' .
			$checkin
		);
		$this->_db->execute();

		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
		{
			// Checkin each row.
			foreach ($pks as $pk)
			{
				$this->checkin($pk);
			}
		}

		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks))
		{
			$this->state = $state;
		}

		return true;
	}

	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return 'com_sv_events_lite.event.' . (int) $this->$k;
	}

	protected function _getAssetParentId(JTable $table = null, $id = null)
	{
		// We will retrieve the parent-asset from the Asset-table
		$assetParent = JTable::getInstance('Asset');
		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();
		// The item has the component as asset-parent
		$assetParent->loadByName('com_sv_events_lite');
		// Return the found asset-parent-id
                

		return ($assetParent->id) ? $assetParentId->id : 0;
	}

	public function delete($pk = null)
	{
		$this->load($pk);
		$result = parent::delete($pk);
		if ($result)
		{

			
		}

		return $result;
	}

}
