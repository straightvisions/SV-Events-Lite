<?php

/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;

$app  = JFactory::getApplication();

$cmode = $app->get('captcha');

JPluginHelper::importPlugin('captcha');
$dispatcher = JDispatcher::getInstance();

if($cmode){
    
    // recaptcha --------------------------------------------------------------
    if($cmode=='recaptcha'){
       // This will put the code to load reCAPTCHA's JavaScript file into your <head>
        $dispatcher->trigger('onInit', 'dynamic_recaptcha_1');

        // This will return the array of HTML code.
        $recaptcha = $dispatcher->trigger('onDisplay', array(null, 'dynamic_recaptcha_1', 'class=""'));
        ?>
        <div class="form-group">
            <center>
            <?php echo (isset($recaptcha[0])) ? $recaptcha[0] : '';?>
            </center>
        </div> 
    <?php
    }
    // / recaptcha --------------------------------------------------------------
    
    // add here other possible captchas

}else{
    
    // THIS IS NOT SECURE, BUT BETTER THAN NOTHING
        ?>
        <div class="form-group required">
            
            <?php echo Sv_Events_LiteDefaultFrontendHelper::get_captcha(); ?>
          
        </div> 
        <?php
    }
