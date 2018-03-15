<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_sv_events_lite/assets/css/style.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'event.cancel') {
            Joomla.submitform(task, document.getElementById('item-form'));
        }
        else {
            
            if (task != 'event.cancel' && document.formvalidator.isValid(document.id('item-form'))) {
                
                Joomla.submitform(task, document.getElementById('item-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_sv_events_lite&layout=edit&event_id=' . (int) $this->item->event_id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="item-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SV_EVENTS_LITE_TITLE_EVENT', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    		<input type="hidden" name="jform[event_id]" value="<?php echo $this->item->event_id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

				<?php } 
				else{ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

				<?php } ?>			
                              
                                <?php echo $this->form->renderField('title'); ?>
                                <?php echo $this->form->renderField('state'); ?>
                                <?php echo $this->form->renderField('featured'); ?>
                                <?php echo $this->form->renderField('language'); ?>
                                <?php echo $this->form->renderField('application_form'); ?>
                                <?php echo $this->form->renderField('datetime_end_application'); ?>
                                <?php echo $this->form->renderField('categories'); ?>
                                <?php echo $this->form->renderField('datetime_start'); ?>
                                <?php echo $this->form->renderField('datetime_end'); ?>
                                <?php echo $this->form->renderField('datetime_start_from'); ?>
                                <?php echo $this->form->renderField('show_time'); ?>
                       
                                <?php echo $this->form->renderField('text'); ?>
                                <?php echo $this->form->renderField('text2'); ?>


                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        <?php if (JFactory::getUser()->authorise('core.admin','sv_events_lite')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
		<?php echo $this->form->getInput('rules'); ?>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
<?php endif; ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>

<script>
!function ($) {

    $(document).ready(function(){
        
      start = $('#jform_datetime_start');
      end = $('#jform_datetime_end');
        
       start.on('change mouseleave mouseover',function(){

          if(end.val() === ''){
              end.val($(this).val());
          }

       });
       
       end.parent().children().on('click mouseover',function(){
          start.trigger('change'); 
       });
       
       start.parent().children().on('click mouseover',function(){
          start.trigger('change'); 
       });

    });
}(window.jQuery);    
</script>
    