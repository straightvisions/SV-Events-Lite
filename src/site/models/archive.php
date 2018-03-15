<?php
/**
 * @version     1.0.2 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class Sv_Events_LiteModelArchive extends JModelList
{

	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'event_id', 'a.event_id',
                                'ordering', 'a.ordering',
                                'state', 'a.state',
                                'date_start', 'a.date_start',
                                'title', 'a.title',
			);
		}
		parent::__construct($config);
	}
        
	protected function populateState($ordering = null, $direction = null)
	{       
                
        $params =  Sv_Events_LiteDefaultFrontendHelper::get_params();

		// Initialise variables.
		$app = JFactory::getApplication();
		// List state information
		/*
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit',$app->get('list_limit'));
		$this->setState('list.limit', $limit);
		$limitstart = $app->input->getInt('limitstart', 0);
		$this->setState('list.start', $limitstart);
		*/
		
		$limit = 0;
		$this->setState('list.limit', $limit);
		$limitstart = 0;
		$this->setState('list.start', $limitstart);

		if ($list = $app->getUserStateFromRequest($this->context . '.list', 'list', array(), 'array'))
		{
			foreach ($list as $name => $value)
			{
				// Extra validations
				switch ($name)
				{
					case 'fullordering':
						$orderingParts = explode(' ', $value);

						if (count($orderingParts) >= 2)
						{
							// Latest part will be considered the direction
							$fullDirection = end($orderingParts);

							if (in_array(strtoupper($fullDirection), array( 'ASC', 'DESC', '' )))
							{
								$this->setState('list.direction', $fullDirection);
							}

							unset($orderingParts[ count($orderingParts) - 1 ]);

							// The rest will be the ordering
							$fullOrdering = implode(' ', $orderingParts);

							if (in_array($fullOrdering, $this->filter_fields))
							{
								$this->setState('list.ordering', $fullOrdering);
							}
						}
						else
						{
							$this->setState('list.ordering', $ordering);
							$this->setState('list.direction', $direction);
						}
						break;

					case 'ordering':
						if (!in_array($value, $this->filter_fields))
						{
							$value = $ordering;
						}
						break;

					case 'direction':
						if (!in_array(strtoupper($value), array( 'ASC', 'DESC', '' )))
						{
							$value = $direction;
						}
						break;

					case 'limit':
						$limit = $value;
						break;

					// Just to keep the default case
					default:
						$value = $value;
						break;
				}

				$this->setState('list.' . $name, $value);
			}
		}

		// Receive & set filters
		if ($filters = $app->getUserStateFromRequest($this->context . '.filter', 'filter', array(), 'array'))
		{
			foreach ($filters as $name => $value)
			{
				$this->setState('filter.' . $name, $value);
			}
		}

		$ordering = $app->input->get('filter_order');
		if (!empty($ordering))
		{
			$list             = $app->getUserState($this->context . '.list');
			$list['ordering'] = $app->input->get('filter_order');
			$app->setUserState($this->context . '.list', $list);
		}

		$orderingDirection = $app->input->get('filter_order_Dir');
		if (!empty($orderingDirection))
		{
			$list              = $app->getUserState($this->context . '.list');
			$list['direction'] = $app->input->get('filter_order_Dir');
			$app->setUserState($this->context . '.list', $list);
		}

		$list = $app->getUserState($this->context . '.list');

		if (empty($list['ordering']))
                {
                        $list['ordering'] = 'ordering';
                }

                if (empty($list['direction']))
                {
                        $list['direction'] = 'asc';
                }

		if (isset($list['ordering']))
		{
			$this->setState('list.ordering', $list['ordering']);
		}
		if (isset($list['direction']))
		{
			$this->setState('list.direction', $list['direction']);
		}

	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return    JDatabaseQuery
	 * @since    1.6
	 */
	protected function getListQuery()
	{
            // get month range
            $params = Sv_Events_LiteDefaultFrontendHelper::get_params();
           // $months = (int)$params->get('calendar_field_months',1);
            $start = date('Y-m-d 23:59:59',time());
            //$end   = date('Y-m-d 23:59:59', strtotime('+ '.$months.' months',strtotime($start)));

            // Create a new query object.
            $db    = $this->getDbo();
            $query = $db->getQuery(true);

            // Select the required fields from the table.
            $query
                    ->select(
                            $this->getState(
                                    'list.select', 'DISTINCT a.*'
                            )
                    );

            $query->from('`#__sv_events_lite_events` AS a');

            // Join over the users for the checked out user.
            $query->select('uc.name AS editor');
            $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

            // Join over the created by field 'created_by'
            $query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');


            if (!JFactory::getUser()->authorise('core.edit.state', 'com_sv_events_lite'))
            {
                    $query->where('a.state = 1');
            }
            
            $query->where('(a.language = '.$db->quote( JFactory::getLanguage()->getTag() ).' OR a.language = '.$db->quote('ALL').')');
            
            // Filter by search in title
            $search = $this->getState('filter.search');


            // get only items within month range
            $query->where('datetime_end < '.$db->quote($start));

            // Add the list ordering clause.
            $orderCol  = $this->state->get('list.ordering','datetime_start');
            $orderDirn = $this->state->get('list.direction','DESC');
            if ($orderCol && $orderDirn)
            {
                    $query->order($db->escape($orderCol . ' ' . $orderDirn));
            }

            return $query;
	}

	public function getItems()
	{
            $items = parent::getItems();
     
            $months = array();
            
            foreach($items as $key => $i){
                
                $month_key = date('Y-m',strtotime($i->datetime_start));
                $event_key = date('Y-m-d-H-i-'.$key,strtotime($i->datetime_start));
                
                if(!isset($months[$month_key])){
                    $months[$month_key] = array();
                }
                
                $i->categories = (is_string($i->categories)) ? (array)json_decode($i->categories) : (array)$i->categories;
                $i->categories = Sv_Events_LiteDefaultFrontendHelper::get_categories($i->categories);
               
                $months[$month_key][$event_key] = $i;
                
            }
            
            foreach($months as &$m){
                
                krsort($m);
                
            }
            
            
            return $months;
	}

	/**
	 * Overrides the default function to check Date fields format, identified by
	 * "_dateformat" suffix, and erases the field if it's not correct.
	 */
	protected function loadFormData()
	{
		$app              = JFactory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;
		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && !$this->isValidDate($value))
			{
				$filters[ $key ]  = '';
				$error_dateformat = true;
			}
		}
		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_SV_EVENTS_LITE_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

	/**
	 * Checks if a given date is valid and in an specified format (YYYY-MM-DD)
	 *
	 * @param string Contains the date to be checked
	 *
	 */
	private function isValidDate($date)
	{
		return preg_match("/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/", $date) && date_create($date);
	}

}
