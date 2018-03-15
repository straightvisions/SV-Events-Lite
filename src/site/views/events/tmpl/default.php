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
$content_before = $params->get('content_before','');


// filterbar setup
$filterbar = Sv_Events_LiteDefaultFrontendHelper::get_filterbar();

$html = array('months'=>array());

foreach($this->items as $key => $month){
    
   $html['months'][$key] = array();
   $month_number = date('n',strtotime($key.'-01'));
   $month_year   = date('Y',strtotime($key.'-01'));
   
   $appendix_time_am = ''; // later
   $appendix_time_pm = ''; // later
   $appendix_time_x = JText::_('COM_SV_EVENTS_LITE_TIME_APPENDIX_X');
   
   foreach($month as $event){
       // date_state -------------------------------------------------
	   $date_state = (strtotime($event->datetime_end) < time())? 'svel-event-old' : '';
       // date -------------------------------------------------------
       if(date('Y', strtotime($event->datetime_start)) != date('Y', strtotime($event->datetime_end))){
                $start = date('d.m.y', strtotime($event->datetime_start));
                $end = date('d.m.y', strtotime($event->datetime_end));
            }else{
                $start = date('d.m.', strtotime($event->datetime_start));
                $end = date('d.m.', strtotime($event->datetime_end));
        }

       $date = ($start === $end) ? $start : $start .' - '. $end;
       
       if($event->datetime_start_from == 1){
           $date = 'ab '.$date;
       }
       // time -------------------------------------------------------
        $time = '';
       if($event->show_time == 1){
            $start = date('H:i', strtotime($event->datetime_start));
            $end = date('H:i', strtotime($event->datetime_end));
            $time = ($start === $end) ? $start : $start .'&nbsp;- '. $end;
            $time .= $appendix_time_x;
       }
       // title -------------------------------------------------------
       $title = $event->title;
       // category ----------------------------------------------------
       $category = '';
     
       foreach($event->categories as $cat){
           $category .= '<span>'.$cat->name.'</span><br>';
       }
       // category ----------------------------------------------------
       $category_text = (isset($event->text2)) ? $event->text2: '';
       // application ----------------------------------------------------
       $application = '';
   
       if($event->application_form == 1){
           if((empty($event->datetime_end_application) || strtotime($event->datetime_end_application) > time()) && strtotime($event->datetime_end) > time()){
           $application .= '<a href="'
                   . ''.JRoute::_('index.php?option=com_sv_events_lite&Itemid='.$params->get('application_menuitem').'&event='.$event->event_id)
                   . '">'.JText::_('COM_SV_EVENTS_LITE_LINK_APPLICATION_FORM').'</a>';
           }
       }
       
       
       $html['months'][$key][] = ''
               . '<div id="e'.$event->event_id.'" name="e'.$event->event_id.'" class="row svel-event accordion '.$date_state.'">'
               . '<div class="col-xs-12 accordion-trigger">'
                    . '<div class="row">'
                    . '<div class="col-xs-12 col-sm-6 col-md-1 col-lg-1 svel-event-date ">'.$date.'</div>'
                    . '<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2 svel-event-time">'.$time.'</div>'
                    . '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 svel-event-title">'.$title.'</div>'
                    /*. '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 svel-event-category">'.$category.'</div>'*/
                    . '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 svel-event-category">'.$category_text.'</div>'
                    . '<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 svel-event-link accordion-ignore">'.$application.'</div>'
                    . '</div>'
               . '</div>'
               . '<div class="col-xs-12 svel-event-body accordion-body">'.$event->text.'</div>'
               . '</div>';
       
   }
   
   $html['months'][$key] = ''
           . '<div class="row svel-month">'
           . '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 svel-month-title">'
           . JText::_('COM_SV_EVENTS_LITE_MONTH_NAME_'.$month_number).' '.$month_year
           . '</div>'
           . '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 svel-month-body">'
           . implode('',$html['months'][$key])
           . '</div>'
           . '</div>';
    
}

$html = implode('',$html['months']);
if(empty(trim($html))){
    $html = JText::_('COM_SV_EVENTS_LITE_NO_ENTRIES');
}
?>
<div class="page-header-container">
    <div class="explorhino-gradient-better">

        <div class="color1"></div>
        <div class="color2"></div>
        <div class="color3"></div>
        <div class="color4"></div>
        <div class="color5"></div>
        <div class="color6"></div>
        <div class="color7"></div>
        <div class="color8"></div>

    </div>
    <meta itemprop="inLanguage" content="de-DE">

    <div class="page-header">
        <h1 itemprop="headline"><?php echo JText::_('COM_SV_EVENTS_LITE_VIEW_EVENTS_TITLE');?></h1>
    </div>
</div>
<?php echo JHtml::_('content.prepare', $content_before); ?>
<p>&nbsp;</p>
<?php echo $filterbar;?>
<p>&nbsp;</p>
<?php echo $html; ?>
<p>&nbsp;</p>
<?php echo JHtml::_('content.prepare', $content_after); ?>
<p>&nbsp;</p>