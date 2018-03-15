<?php
/**
 * @version     1.0.2 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
session_start();
defined('_JEXEC') or die;

class Sv_Events_LiteDefaultFrontendHelper
{

	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_sv_events_lite/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_sv_events_lite/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'Sv_Events_LiteModel');
		}

		return $model;
	}
        
        public static function get_filterbar($params = NULL){
            
            if(empty($params)){
                $params = new stdClass();
            }
            
            if(empty($params->categories)){
                $params->categories = self::get_categories();
            }
            
            if(empty($params->months)){
               
                
                $params->months = self::get_months();
            }

            // options months ------------------------------------
            $options_month = array();
            $selected_month = JFactory::getApplication()->input->get('month', NULL, 'string');

            foreach($params->months as $key => $data){
                $month_number = date('n',strtotime($key.'-01'));
                $month_year   = date('Y',strtotime($key.'-01'));
                
                $selected     = ($selected_month == $key) ? 'selected':'';
                
                $options_month[]=''
                        . '<option value="'.$key.'" '.$selected.'>'
                        . JText::_('COM_SV_EVENTS_LITE_MONTH_NAME_'.$month_number).' '.$month_year
                        . '</option>';
            }
            
            $options_month = implode('',$options_month);
            // options months  ------------------------------------
            
            // options months ------------------------------------
            $options_category = array();
            $selected_category = JFactory::getApplication()->input->get('category', NULL, 'int');
            foreach($params->categories as $key => $data){
                
                $selected     = ($selected_category == $data->category_id) ? 'selected':'';
                
                $options_category[]=''
                        . '<option value="'.$data->category_id.'" '.$selected.'>'
                        . $data->name
                        . '</option>';
            }
            
            $options_category = implode('',$options_category);
            // options months  ------------------------------------
            
            $html = ''
                    . '<form id="svel-filterbar" name="svel-filterbar" class="form-inline svel-filterbar" method="get">
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
                              <label for="month">'.JText::_('COM_SV_EVENTS_LITE_TIMESPAN').'</label>
                              <select name="month" class="form-control fullwidth" default="">
                              <option value="">'.JText::_('COM_SV_EVENTS_LITE_PLSSELECT').'</option>
                              '.$options_month.'
                              </select>
                            </div>
                            <div class="form-group  col-xs-12 col-sm-6 col-md-4 col-lg-4">
                              <label for="category">'.JText::_('COM_SV_EVENTS_LITE_CATEGORY').'</label>
                              <select name="category" class="form-control fullwidth">
                                <option value="">'.JText::_('COM_SV_EVENTS_LITE_PLSSELECT').'</option>
                                '.$options_category.'
                              </select>
                            </div>
                            <div class="form-group  col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label class="fullwidth">&nbsp;</label>
                            <button type="submit" class="btn btn-default">'.JText::_('COM_SV_EVENTS_LITE_SEARCH').'</button>
                            <button type="button" onclick="SVEL.reset(\'#svel-filterbar\',true);" class="btn btn-default">'.JText::_('COM_SV_EVENTS_LITE_SEARCH_REST').'</button>
                            </div>
                        </div>
                      </form>';
            
            return $html;
        }
        
        public static function get_months(){
            $params = self::get_params();
            $months_array = array();
            
            $months = (int)$params->get('calendar_field_months',1);
            $start = date('Y-m-01 00:00:00',time());
            $end   = date('Y-m-d 23:59:59', strtotime('+ '.$months.' months',strtotime($start)));

            $items = self::get_items(
                        array(
                            'datetime_start'=>$start,
                            'datetime_end'=>$end,
                        ),true
                      );

            $months = array();
            
            foreach($items as $key => $i){
                
                $month_key = date('Y-m',strtotime($i->datetime_start));
                $event_key = date('Y-m-d-h-i-'.$key,strtotime($i->datetime_start));
                
                if(!isset($months[$month_key])){
                    $months[$month_key] = array();
                }
                
                $i->categories = (is_string($i->categories)) ? (array)json_decode($i->categories) : (array)$i->categories;
                $i->categories = Sv_Events_LiteDefaultFrontendHelper::get_categories($i->categories);
               
                $months[$month_key][$event_key] = $i;
                
            }
            
            foreach($months as &$m){
                
                ksort($m);
                
            }
            
            ksort($months);
            
            return $months;
 
        }
        
        public static function get_item($id){
            $db = JFactory::getDBO();
            $q = $db->getQuery(true);
            
            $q->select('*');
            $q->from('#__sv_events_lite_events');
            $q->where('event_id = '.$db->quote((int)$id));
            $db->setQuery($q);
            
            try{
                $item = $db->loadObject();
            } catch (Exception $ex) {
                $item = NULL;
            }
            
            return $item;
        }
        
        public static function get_items($params = array(), $ignore_filter = false){
            $params = (object)$params;
            
            if($ignore_filter===false){
                // we do we need that here? the frontend items are filtered in the model?
                // override params with jinput
                $jinput     = JFactory::getApplication()->input;
                $month      = $jinput->get('month', NULL, 'string');
                $category   = $jinput->get('category', NULL, 'int');

                if(!empty($month)){
                    $params->datetime_start = date('Y-m-01 00:00:00',strtotime($month));
                    $params->datetime_end = date('Y-m-31 23:59:59',strtotime($month));
                }
            
            }
            
            $limit = (isset($params->limit)) ? (int)$params->limit : 0;
            
            $db = JFactory::getDBO();
            $q = $db->getQuery(true);
            
            $q->select('*');
            $q->from('#__sv_events_lite_events');
            $q->where('state = 1','AND');
			
			if(isset($params->featured)){
				 $q->where('featured = '.$db->quote($params->featured),'AND');
			}
			
            if(isset($params->categories)){
                $where = array();
                foreach($params->categories as $cat){
                    if((int)$cat === 0){ // all cats
                        unset($where);break;
                    }
                    $where[] = 'categories LIKE '.$db->quote('%:"'.$cat.'"%');
                }
               
                if(!empty($where))$q->where('('.implode(' OR ',$where).')');
                unset($where);
            }
            
            if(isset($params->datetime_start) && isset($params->datetime_end) ){
                $q->where(
                        '((datetime_start BETWEEN '.$db->quote($params->datetime_start)
                        . ' AND '.$db->quote($params->datetime_end). ') OR ('
                        . 'datetime_end BETWEEN '.$db->quote($params->datetime_start)
                        . ' AND '.$db->quote($params->datetime_end)
                        . '))'
                        );
            }
            
            if(isset($params->order)){
                $q->order($params->order);
            }else{
                $q->order('datetime_start ASC');
            }
            
            $q->setLimit($limit);
            $db->setQuery($q); 
           
            try{
                $list = $db->loadObjectList();
            } catch (Exception $ex) {
                $list = array();
            }
            return $list;
            
        }
        
        public static function get_items_option_list($id = NULL){
            
            $items = self::get_items();
     
            $html = array(
                '<option value="">'.JText::_('COM_SV_EVENTS_LITE_PLSSELECT').'</option>'
            );
            
            foreach($items as $i){
                
                if($i->application_form != 1 || strtotime($i->datetime_end) < time() || strtotime($i->datetime_end_application) < time()){
                    continue; // ignore blocked events
                }
                
                if(date('Y', strtotime($i->datetime_start)) != date('Y', strtotime($i->datetime_end))){
                    $start = date('d.m.Y', strtotime($i->datetime_start));
                    $end = date('d.m.Y', strtotime($i->datetime_end));
                }else{
                    $start = date('d.m.Y', strtotime($i->datetime_start));
                    $end = date('d.m.Y', strtotime($i->datetime_end));
                }

               $date = ($start === $end) ? $start : $start .' - '. $end;
               
               // time -------------------------------------------------------
                $time = '';
               if($i->show_time == 1){
                    $start = date('H:i', strtotime($i->datetime_start));
                    $end = date('H:i', strtotime($i->datetime_end));
                    $time = ($start === $end) ? $start : $start .'&nbsp;- '. $end;
                    $time = ' / '.$time.' Uhr';
               }

               $selected = ((int)$id==$i->event_id) ? 'selected' : '';
               $i->title = htmlentities($i->title);
               $html[] = '<option '.$selected.' value="'.$date.$time.': '.$i->title.'">'.$date.$time.': '.$i->title.'</option>';
                
            }
            
            
            return implode('',$html);
            
        }
        
        public static function get_params(){
            return JComponentHelper::getParams('com_sv_events_lite');
        }
        
        public static function get_categories($ids = array()){
            
            if(!is_array($ids))return '';

            $db = JFactory::getDBO();
            
            $q = $db->getQuery(true);
            $q->select('*');
            $q->from('#__sv_events_lite_categories');
            
            foreach($ids as $id){
                //$q->where('categories LIKE '.$db->quote('%:"'.$id.'"%'),'OR');
                $q->where('category_id = '.$db->quote($id),'OR');
            }
            
            $db->setQuery($q);
      
            return $db->loadObjectList();
            
        }
        
        
        public static function send_application(){
            
            $params = self::get_params();
          
         
            // prepare email to client
            if($params->get('email_client_send') == 1){
                
                $prep_data = self::prepare_email($params->get('email_client_text'));
            
                $M = self::get_email_object();
                $M->sender          = $params->get('email_admin_sender');
                $M->recipient       = (!empty($prep_data->post['email']) ? $prep_data->post['email'] : $params->get('email_admin_recipient'));
                $M->body            = $prep_data->_body;
                $M->subject         = (strpos('COM_SV_EVENTS_LITE',$params->get('email_client_subject'))!==FALSE) ? JText_($params->get('email_client_subject')) : $params->get('email_client_subject');
       
                self::send($M);
              //  $MAIL->send(); 
            }
            
            // prepare email to admin
            $prep_data = self::prepare_email($params->get('email_admin_text'));
            
            $M = self::get_email_object();
            $M->sender          = (!empty($prep_data->post['email'])) ? $prep_data->post['email'] : $params->get('email_admin_sender');
            $M->recipient       = $params->get('email_admin_recipient');
            $M->body            = $prep_data->_body;
            $M->subject         = JText::_('COM_SV_EBENTS_LITE_CUSTOM_MAIL_ADMIN_SUBJECT');
            
            self::send($M);
                   
        }
        
        private static function prepare_email($tpl = ''){
            
            $jinput = JFactory::getApplication()->input;
            $data = new stdClass();
            $application_data = array();
            

            $data->post = $jinput->get('svelform',array(),'array');
            
            if(isset($data->post['application_data'])){
                
                foreach($data->post['application_data'] as $arrKey => $arr){
                    $arrKey = strip_tags($arrKey);
                    $application_data[$arrKey] = '<hr><p>';
                    
                    foreach($arr as $key => $val){
                        $application_data[$arrKey] .= ''
                                . '<br>'.JText::_('COM_SV_EVENTS_LITE_CUSTOM_'.strip_tags($key)).': '.$val;
                    }
                    $application_data[$arrKey] .='</p>';
                }
                
                $data->post['application_data'] =  implode('',$application_data);
                
            }
            
            // mustache
            $m = self::get_mustache_engine();
           
            $data->_body = $m->render($tpl,$data->post);

            return $data;
            
        }

        public static function get_mustache_engine(){
            require_once(__DIR__.'/Mustache/Autoloader.php');
            Mustache_Autoloader::register();
            $m = new Mustache_Engine;
            return $m;
        }
        
        public static function get_email_object(){
            
            $M = new stdClass();
            
            $M->sender = '';
            $M->recipient = '';
            $M->subject = '';
            $M->body = '';
            $M->attachmnets = array();
            
            return $M;
            
        }
        
        public static function send($m){
  
            $mailer = JFactory::getMailer(true); // Joomla 2.x - 3.x
            $config = JFactory::getConfig(); // Joomla 2.x - 3.x
           
            // set settings ------------------------------------
            $mailer->isHTML(true);
            $mailer->Encoding = 'base64';
            
            // apply data ------------------------------------
            $mailer->setSender(     (!empty($m->sender)) ? array($m->sender, $config->get('fromname')): array($config->get('mailfrom'),$config->get('fromname'))); 
            $mailer->addRecipient(  (!empty($m->recipient)) ? $m->recipient : $config->get('mailfrom') );
            $mailer->setSubject(    (!empty($m->subject)) ? $m->subject : 'Email from '.$config->get('fromname') ) ;
            $mailer->setBody(       (!empty($m->body)) ? $m->body : 'ERROR - NO MESSAGE ATTACHED' );
      
            $send = $mailer->Send();
   
            if ( $send !== true ) {
                return 'Error sending email: ' . $send->__toString();
            } else {
                return true;
            }
            
        }
        
        public static function get_captcha($num1 = 1, $num2 = 20){
            // currently we are supporting our math captcha only here
            $num1 = (int)$num1;
            $num2 = (int)$num2;
            $rand_num1 = mt_rand($num1, $num2);
            $rand_num2 = mt_rand($num1, $num2);
            $result = $rand_num1 + $rand_num2;
     
            $_SESSION['SVEL_FORM_CAPTCHA'] = $result;
      
            $html = '<label class="col-md-4 control-label " for="svelform_captcha">'.$rand_num1.' + '.$rand_num2.'?</label>'
                    . '<div class="col-md-5">'
                    . '<input id="captcha" type="text" name="svelform[captcha]" size="2" class="form-control input-md" required="required" anum="'.$rand_num1.'" bnum="'.$rand_num2.'"/>'
                    . '</div>';
            
            return $html;
            
        }
}
