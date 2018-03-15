<?php

/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;
require_once(__DIR__.'/event.php');

?>
<hr>
<div class="form-group">
    <center><button type="button" class="btn btn-primary" onclick="SVEL.application_add();"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_ADDAPP_LBL'); ?></button></center>
</div>