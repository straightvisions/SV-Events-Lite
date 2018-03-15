<?php
/**
 * @version    CVS: 1.0.0
 * @package    com_sv_events_lite
 * @author     Dennis Heiden <info@heiden-medien.de>
 * @copyright  2016 Heiden Medien - Dennis Heiden, Frank Hauffe GbR
 * @license    GNU General Public License Version 2 oder später; siehe LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_sv_events_lite/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'category.cancel') {
			Joomla.submitform(task, document.getElementById('category-form'));
		}
		else {
			
			if (task != 'category.cancel' && document.formvalidator.isValid(document.id('category-form'))) {
				
				Joomla.submitform(task, document.getElementById('category-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_sv_events_lite&layout=edit&category_id=' . (int) $this->item->category_id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="category-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('Info', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

				<input type="hidden" name="jform[category_id]" value="<?php echo $this->item->category_id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				
				<?php if(empty($this->item->modified_by)){ ?>
					<input type="hidden" name="jform[modified_by]" value="<?php echo JFactory::getUser()->id; ?>" />

				<?php } 
				else{ ?>
					<input type="hidden" name="jform[modified_by]" value="<?php echo $this->item->modified_by; ?>" />

				<?php } ?>
                                    
                                    <?php echo $this->form->renderField('name'); ?>
                                    <?php echo $this->form->renderField('state'); ?>
                                    <?php echo $this->form->renderField('language'); ?>
                                    <?php //echo $this->form->renderField('image'); ?>
                                    <?php echo $this->form->renderField('color'); ?>
                                    <?php echo $this->form->renderField('text'); ?>
                                        
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
            

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>
