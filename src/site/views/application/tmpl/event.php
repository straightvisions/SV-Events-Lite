<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;
$jinput     = JFactory::getApplication()->input;
$id         = $jinput->get('event', 0, 'int');

$event = Sv_Events_LiteDefaultFrontendHelper::get_item($id);

if(!empty($event)):
?>

<div entry="1" class="event-group">
    <hr>
    <div class="form-group">
        <center>
            <button type="button" class="btn btn-xs btn-warning svel-entry-delete" onclick="SVEL.application_del(1);"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_DELAPP_LBL'); ?></button>
        </center>
    </div>
    <div class="form-group required">
        <label class="col-md-4 control-label " for="application_data_event_enum1"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_EVENT_LBL'); ?></label>
        <div class="col-md-5">
            <select id="application_data_event_enum1" name="svelform[application_data][enum1][event]" type="text" placeholder="" class="form-control input-md" required="required">
                <?php echo Sv_Events_LiteDefaultFrontendHelper::get_items_option_list($id);?>
            </select>
        </div>
    </div>
    
    <div class="form-group required">
        <label class="col-md-4 control-label " for="application_data_childname_enum1"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_CHILDNAME_LBL'); ?></label>
        <div class="col-md-5">
            <input id="application_data_childname_enum1" name="svelform[application_data][enum1][childname]" type="text" placeholder="" class="form-control input-md" required="required">
        </div>
    </div>
    
    <div class="form-group required">
        <label class="col-md-4 control-label " for="application_data_birthday_enum1"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_BIRTHDAY_LBL'); ?></label>
        <div class="col-md-5">
            <input id="application_data_birthday_enum1" name="svelform[application_data][enum1][birthday]" type="text" placeholder="" class="form-control input-md" required="required">
        </div>
    </div>
    
    <div class="form-group required">
        <label class="col-md-4 control-label " for="application_data_class_enum1"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_CLASS_LBL'); ?></label>
        <div class="col-md-5">
            <input id="application_data_class_enum1" name="svelform[application_data][enum1][class]" type="text" placeholder="" class="form-control input-md" required="required">
        </div>
    </div>
    
</div>
<?php endif; ?>
 
