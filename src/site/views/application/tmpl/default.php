<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
defined('_JEXEC') or die;

require_once(__DIR__.'/logic.php');

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
        <h1 itemprop="headline"><?php echo JText::_('COM_SV_EVENTS_LITE_VIEW_APPLICATION_TITLE');?></h1>
    </div>
</div>

<p></p>

<?php if($posted === false):?>
<form id="svel-event-application-form" class="form-horizontal svel-event-application-form" method="post">
    <fieldset>
     
    <?php if($params->get('application_field_salutation')): ?>
    <!-- Select Basic -->
    <div class="form-group <?php echo ($params->get('application_field_salutation_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="salutation" ><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_SALUTATION_LBL');?></label>
      <div class="col-md-2">
        <select id="salutation" name="svelform[salutation]" class="form-control"> <?php echo ($params->get('application_field_salutation_required'))?'required':''; ?>
          <option value="0">---</option>
          <option value="Frau">Frau</option>
          <option value="Herr">Herr</option>
        </select>
      </div>
    </div>
    <?php endif; ?>
    
    <?php if($params->get('application_field_lastname')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_lastname_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="lastname"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_LASTNAME_LBL');?></label>  
      <div class="col-md-5">
      <input id="lastname" name="svelform[lastname]" type="text" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_lastname_required'))?'required':''; ?>>
      <span class="help-block">Erziehungsberechtigter</span>  
      </div>
    </div>
    <?php endif; ?>
    
    <?php if($params->get('application_field_firstname')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_firstname_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="firstname"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_FIRSTNAME_LBL');?></label>  
      <div class="col-md-5">
      <input id="firstname" name="svelform[firstname]" type="text" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_firstname_required'))?'required':'';  ?>>
      <span class="help-block">Erziehungsberechtigter</span>  
      </div>
    </div>
    <?php endif; ?>
    
    <?php if($params->get('application_field_street')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_street_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="street"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_STREET_LBL');?></label>  
      <div class="col-md-5">
      <input id="street" name="svelform[street]" type="text" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_street_required'))?'required':'';  ?>>

      </div>
    </div>
    <?php endif; ?>
    
     <?php if($params->get('application_field_street_number')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_street_number_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="street_number"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_STREET_NUMBER_LBL');?></label>  
      <div class="col-md-2">
      <input id="street_number" name="svelform[street_number]" type="text" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_street_number_required'))?'required':'';  ?>>

      </div>
    </div>
    <?php endif; ?>
    
    <?php if($params->get('application_field_zip')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_zip_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="zip"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_ZIP_LBL');?></label>  
      <div class="col-md-2">
      <input id="zip" name="svelform[zip]" type="text" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_zip_required'))?'required':'';  ?>>

      </div>
    </div>
    <?php endif; ?>
    
    <?php if($params->get('application_field_city')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_city_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="city"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_CITY_LBL');?></label>  
      <div class="col-md-5">
      <input id="city" name="svelform[city]" type="text" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_city_required'))?'required':'';  ?>>

      </div>
    </div>
    <?php endif; ?>
    
    <?php if($params->get('application_field_country')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_country_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="country"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_COUNTRY_LBL');?></label>  
      <div class="col-md-5">
      <input id="country" name="svelform[country]" type="text" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_country_required'))?'required':'';  ?>>

      </div>
    </div>
    <?php endif; ?>
    
    <?php if($params->get('application_field_phone')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_phone_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="phone"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_PHONE_LBLF');?></label>  
      <div class="col-md-5">
      <input id="phone" name="svelform[phone]" type="text" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_phone_required'))?'required':'';  ?>>
      <span class="help-block">Telefonnummer unter der Sie während des Kurses erreichbar sind!</span>  
      </div>
    </div>
    <?php endif; ?>
    
     <?php if($params->get('application_field_phone2')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_phone2_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="phone"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_PHONE_LBL');?></label>  
      <div class="col-md-5">
      <input id="phone" name="svelform[phone2]" type="text" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_phone2_required'))?'required':'';  ?>>
      <span class="help-block">Telefonnummer unter der Sie während des Kurses erreichbar sind!</span>  
      </div>
    </div>
    <?php endif; ?>
    
    <?php if($params->get('application_field_email')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_email_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="email"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_EMAIL_LBL');?></label>  
      <div class="col-md-5">
      <input id="email" name="svelform[email]" type="email" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_email_required'))?'required':'';  ?>>
      <span class="help-block">E-Mailadresse an die wir die Bestätigungsmail senden können</span>  
      </div>
    </div>
    <?php endif; ?>
    
    <?php if($params->get('application_field_subject')): ?>
    <!-- Text input-->
    <div class="form-group <?php echo ($params->get('application_field_subject_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="subject"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_SUBJECT_LBL');?></label>  
      <div class="col-md-5">
      <input id="subject" name="svelform[subject]" type="text" placeholder="" class="form-control input-md" <?php echo ($params->get('application_field_subject_required'))?'required':'';  ?>>

      </div>
    </div>
    <?php endif; ?>
    
    <?php if($params->get('application_field_comment')): ?>
    <!-- Textarea -->
    <div class="form-group <?php echo ($params->get('application_field_comment_required'))?'required':''; ?>">
      <label class="col-md-4 control-label" for="comment"><?php echo JText::_('COM_SV_EVENTS_LITE_CONFIG_APPLICATION_FIELDS_COMMENT_LBL');?></label>
      <div class="col-md-4">                     
        <textarea class="form-control" id="comment" name="svelform[comment]" <?php echo ($params->get('application_field_comment_required'))?'required':'';  ?>></textarea>
      </div>
    </div>
    <?php endif; ?>
    
    <?php require_once(__DIR__.'/extended.php'); ?>
    
    <?php require_once(__DIR__.'/captcha.php'); ?>
    
    <div class="form-group">
        <center>
        <button type="submit" class="btn btn-success">Anmeldung absenden</button>
        </center>
        <input type="hidden" name="svelform[SVEL_APPLICATION_FORM_SUBMIT]" value="true" />
        <?php echo JHtml::_( 'form.token' ); ?>
    </div>
    </fieldset>
</form>
<?php else:
    echo $message;
endif;

        
