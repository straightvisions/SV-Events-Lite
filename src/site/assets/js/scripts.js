// accordion feature
// since V 1.0
!function ($) {
    SVEL = new function(){
        
               
        
        $(document).ready(function(){
            var application_form = $('form#svel-event-application-form');
                application_form.on('submit',function(e){
                    
                    if(SVEL.application_form_submit()===true){
                        return true;
                    }
                    
                    e.preventDefault();
                    
            });
            
        });
        
        
        
    };
    
    SVEL.accordion = function(){

        var items = $('.accordion');
        
        if(items.length <= 0) return; // skip if items list is empty

        items.each(function(){

            var item = $(this);
            var body = item.find('.accordion-body');
            var trigger = item.find('.accordion-trigger:not(.accordion-ignore)');
            var closer  = item.find('.accordion-closer');
            
            // allowing clicks within an accordion trigger
            $('.accordion-ignore, .accordion-trigger a, .accordion-trigger button').on('click touchstart',function(e){ 
                e.stopPropagation();
            });
            
            trigger.unbind('click');
            trigger.unbind('touchstart');
            trigger.on('click touchstart', function(e){
                e.stopPropagation();
                e.preventDefault();

                var trigger = $(this);

                // double click event fix for labels
                if(trigger.find('[type="checkbox"],[type="radio"]').length > 0){

                    var check_inputs = trigger.find('[type="checkbox"],[type="radio"]');

                    $(check_inputs).each(function(){

                        var i = $(this);

                        if(i.prop('checked') == true){
                            i.prop('checked',false);
                        }else{
                            i.prop('checked',true);
                        }

                    });

                }

                trigger.addClass('triggered');

                var body = trigger.parent().find('.accordion-body');

                if(body.length <= 0){
                    // fallback
                    body = trigger.closest('.accordion').find('.accordion-body');

                    if(body.length <= 0){
                       if(window.console)console.log('ZEUS - ACCORDION - NO BODY FOUND');
                    } // no body found


                }

                if(trigger.hasClass('open') && closer.length <= 0){
                    body.slideUp();
                    trigger.removeClass('open');

                }else if(!trigger.hasClass('open')){

                    // close everything else
                    $('.accordion-trigger.open:not(.accordion-protected)').closest('.accordion').find('.accordion-body').slideUp();
                    $('.accordion-trigger.open:not(.accordion-protected)').removeClass('open');

                    // open child accordion body
                    body.slideDown(500);
                    trigger.addClass('open');
                }

                trigger.removeClass('triggered');

            });

            if(closer.length > 0){

                closer.on('click touchstart', function(){

                    if(body.length <= 0)return; // skip if no body is present

                    if(trigger.hasClass('open')){
                        body.slideUp();
                        trigger.removeClass('open');
                    }

                });

            }

            if(body.hasClass('accordion-open')){ // manually trigger
               trigger.trigger('click');
               body.removeClass('accordion-open');
            }

            if(body.hasClass('accordion-open-passive')){ // manually passive trigger
               body.slideDown();
               body.removeClass('accordion-open-passive');
            }

        });

    }; // this.accordion
    
    // reset form helper
    
    SVEL.reset = function(form,autosubmit){
        
        if(typeof autosubmit == 'undefined'){
            autosubmit = false;
        }
        
        var form = $(form);
        
        if(form.length <= 0){
            if(window.console)console.log('SVEL.reset() : form not found');
            return false;
        }
        
        form[0].reset();
        
        form.find('select').each(function(){
           $(this).prop('selectedIndex',0); 
        });
        
        if(autosubmit === true){
            form.submit();
        }
        
        return true;
        
    };
    
    
    // application form
    SVEL.application_form_submit = function(){
       
        var form = $('form#svel-event-application-form');
        
        if(form.length != 1){
            if(window.console)console.log('SVEL.reset() : form not found');
            return false;
        }
        
        // recaptcha support
        if(form.find('#g-recaptcha-response').length > 0){
            
            if(form.find('#g-recaptcha-response').val().length < 10){
                alert('CAPTCHA');
                return false;
            }
            
        }

        if(form.find('input#captcha').length > 0){
            var e = form.find('input#captcha');
            var num1 = parseInt(e.attr('anum'));
            var num2 = parseInt(e.attr('bnum'));
            var res  = parseInt(e.val());

            if(res !== num1+num2){

                alert('CAPTCHA');
                return false;
            }

        }
        
        if(form.find('.event-group').not('.event-group-sample').length < 1){
            alert('PLEASE ADD AN EVENT');
            return false;
        }

        
        return true;
        
    };
    
    SVEL.application_del = function(num){
        
        var form = $('form#svel-event-application-form');
        var egroups = form.find('.event-group');
        var etarget = form.find('.event-group[entry="'+num+'"]');
        
        if(egroups.length <= 1){
            return false;
        }
        
        if(etarget.length > 0){
            etarget.fadeOut(200,function(){
               $(this).remove(); 
            });
        }
        
        return false;
        
    };
    
    
    SVEL.application_add = function(){
        
        var form = $('form#svel-event-application-form');
        var egroups = form.find('.event-group');
        var draft = form.find('.event-group').last();
        
        if(draft.length < 1){
            return location.reload();
        }
        
        var ngroup = draft.clone();
        var num = parseInt(draft.attr('entry'))+1;
     
        ngroup.attr('entry',num);
        ngroup.find('button.svel-entry-delete').attr('onclick','SVEL.application_del('+num+');');
        ngroup.find('option:selected').removeAttr('selected');
        var pattern = 'enum'+(num-1);
    
        var ngroup = ngroup.prop('outerHTML').replace(new RegExp(pattern,'igm'),'enum'+num);
 
        $(ngroup).insertAfter(draft);
        
    };
    
    // ------------------------
    
    $(document).ready(function(){
    
        SVEL.accordion();
        
    });
    
    
}(window.jQuery);