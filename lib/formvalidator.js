// Simple form validator by Fedotov V.V. 2016

function formValidator(selector)
{   var hints = {req:'Required value!', minlen:'Value is too short!', 
    email:'Wrong e-mail format!', equalto:'Confirmation field is not match!',
    maxlen:'Value is too long!',reqradio:'No one option is selected!'}
    
    // delayed run
    function delayedRun(msec)
    { var timer = null;
      function run(fu)
      {  if (timer!=null)  clearTimeout(timer);
         timer = setTimeout(fu, msec);
      }   
      return {run:run};
    }
    
    function setDelayedCheck(i,v)
    {    var d = new delayedRun(700); 
         $(v).keyup(function(){
             d.run(function(){ 
                 validateSingle(v);
             });
         }).parent().removeClass('has-error').removeClass('has-success');
    }
    
    function keyupValidateOn(ctrls_selector)
    {   if ( typeof(ctrls_selector)=="object" ) 
            ctrls_selector.each(setDelayedCheck);
        else 
            $(selector+' '+ctrls_selector).each(setDelayedCheck);
    }

    function validateEmail(email) 
    { var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

   function parseParams(s)
    { var a = s.split(',');
      var c = [];
      var r = {};
      for(var i in a)
      { b = a[i].split('=');
        if (b.length>0)
        {   var id = b[0];
            if (b.length==2) 
            {   var v = b[1];
                if ( $.isNumeric(v) ) v = 1*v; else
                if (v=='true') v=true; else
                if (v=='false') v=false; else
                if (v.charAt(0)=="'") v = v.replace(/^\'+|\'+$/g, '');
                r[id]=v;
            } else r[id]=true;
        }
      }      
      return r;
    }

    function setInvalid(ctrl, hints)
    { $(ctrl).parent().removeClass('has-success').addClass('has-error');
      $(ctrl).attr('title', hints);
      $(ctrl).popover('show');
    }
   
    function setValid(ctrl)
    { $(ctrl).parent().removeClass('has-error').addClass('has-success');
      $(ctrl).attr('title', '');
      $(ctrl).popover('hide');
    }
    
    function validateSingle(ctrl)
    {   var prm;
        var valid = true;
        if (ctrl.getAttribute!=undefined) prm = ctrl.getAttribute('data-validate');
        if (prm!=undefined)
        {   var h = [];
            p = parseParams(prm);
            
            if (p.req!=undefined && p.req && ctrl.value=='')
            {  valid=false;
               h.push(hints.req);
            }
            
            if (p.minlen!=undefined 
                && ctrl.value!='' 
                && ctrl.value.trim().length<p.minlen) 
            { 
                valid=false;
                h.push(hints.minlen);
            }
            
            if (p.maxlen!=undefined 
                && ctrl.value!='' 
                && ctrl.value.trim().length>p.maxlen) 
            { 
                valid=false;
                h.push(hints.maxlen);
            }
            
            if (p.email!=undefined && ctrl.value!='' && !validateEmail(ctrl.value)) 
            {
                valid=false;
                h.push(hints.email);
                
            }
            
            if (p.equalto!=undefined && $(p.equalto).val()!=ctrl.value ) 
            {
                valid=false; 
                h.push(hints.equalto);
            }
            
            if (p.reqradio!=undefined) 
            {   var c = 0;
                var ctrls = $(selector+' input[type="radio"]');
                for (var i=0; i<ctrls.length; i++)
                {   var r = $(ctrls[i]);
                    if (r.attr('name')==p.reqradio && r[0].checked) c++;                    
                }
                if (c==0)
                {  valid=false; 
                    h.push(hints.reqradio);
                }
            }
            
            if (p.regexp!=undefined && p.msg!=undefined)
            {   var r = new RegExp(p.regexp);
                if (!r.test(ctrl.value)) 
                { h.push(p.msg);
                  valid=false;
                }
            }
            
            if (valid) setValid(ctrl); else setInvalid(ctrl, h.join("\n"));
        }
        return valid;
    }
    
    function validate()
    {   var res = true;
        var ctrls = $(selector+' .form-control');        
        for (var i=0; i<ctrls.length; i++)
        {  res &= validateSingle(ctrls[i]);
        }
        var ctrls = $(selector+' input[type="radio"]');
        for (var i=0; i<ctrls.length; i++)
        {  res &= validateSingle(ctrls[i]);
        }
        return res;
    }
   
    function validateRadioGroups()
    {  var ctrls = $(selector+' input[type="radio"]');
       for (var i=0; i<ctrls.length; i++)
       {  validateSingle(ctrls[i]);
       }
    }
   
    var props = {
         trigger:'click',
         container:'body',
         placement: 'left',
         content:function(){         
            return $(this).attr('title'); 
         }
    }

    // Text inputs initialisation
    $(selector+' input.form-control').popover(props);
    
    // Radio groups initialisation
    $(selector+' input[type="radio"]').each(function(i,e)
    {   if ($(e).attr('data-validate')!=undefined)
        {  $(e).popover(props);           
        }
        $(e).click(function()
        { validateRadioGroups();
        });
    });
    
    return {validate:validate, validateSingle:validateSingle, keyupValidateOn:keyupValidateOn}
}



