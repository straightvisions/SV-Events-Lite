<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;

JLoader::registerPrefix('Sv_Events_Lite', JPATH_SITE . '/components/com_sv_events_lite/');

class Sv_Events_LiteRouter extends JComponentRouterBase
{

	public function build(&$query)
	{  
		$segments = array();
		$view     = null;

		if (isset($query['task']))
		{
			$taskParts  = explode('.', $query['task']);
			$segments[] = implode('/', $taskParts);
			$view       = $taskParts[0];
			unset($query['task']);
		}
		if (isset($query['view']))
		{
			$segments[] = $query['view'];
			$view       = $query['view'];
			unset($query['view']);
		}
		if (isset($query['id']))
		{
			if ($view !== null)
			{
				$segments[] = $query['id'];
			}
			else
			{
				$segments[] = $query['id'];
			}

			unset($query['id']);
		}

		return $segments;
	}

        public function parse(&$segments)
	{
 
		$vars = array();
		// View is always the first element of the array
		//$vars['view'] = array_shift($segments);
		//$model        = Extavium_bookingHelpersExtavium_booking::getModel($vars['view']);

                $app = JFactory::getApplication();
                $menu = $app->getMenu();
                $item = $menu->getActive();
                $user = JFactory::getUser();
        
		while(!empty($segments))
		{
			$segment = array_pop($segments);

			// If it's the ID, let's put on the request
			if (is_numeric($segment))
			{
				$vars['event_id'] = $segment;
			}
			else
			{
				$vars['task'] = $vars['view'] . '.' . $segment;
			}
		}
                
              
		return $vars;
	}
        
}
