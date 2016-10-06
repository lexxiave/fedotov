
function VIPreserv(selector)
{   function getData()
    {   var r = {};
        r.rows = [];
        
        // moment($("input[name='bookdate']").val(), 'MM/DD/YYYY').format('YYYY-MM-DD');
        
        var ctrls = $(selector+' .form-control');
        for (var i=0; i<ctrls.length; i++)
        { var ctrl = $(ctrls[i]);
          var id = ctrl.attr('name');  
          if ( $(ctrl).parents('.entry').length==0 )
          {   if ( $(ctrl).parents('.date').length==1 )
              {   // convert to SQL format
                  r[id] =  moment(ctrl.val(), 'MM/DD/YYYY').format('YYYY-MM-DD');
              }
              else r[id] = ctrl.val();
          }
        }
        
        var v=null;
        var ctrls = $(selector+' input[name="vippackage"]');
        for (var i=0; i<ctrls.length; i++)
        { var ctrl = ctrls[i];
          if (ctrl.checked) v=ctrl.value;
        }
        r['vippackage_id'] = v;
        
        var entryes = $(selector+' .entry');
        for (var i=0; i<entryes.length; i++)
        {  var e = $(entryes[i]);
           var row = {};
           row.firstname=e.find("input[name='firstname']").val();
           row.lastname=e.find("input[name='lastname']").val();
           if (row.firstname!='' && row.lastname!='')
           { r.rows.push(row);
           }
        }

        return r;
    }
    
   function save()
   {   var r = getData();
       ajx('/pages/vipreserv/Save', r, function(d)
       {  if (!d.error)
          { htview('/pages/vipreserv/thank', selector);
          }
       });  
   }
   
    return {save:save};
}

$(function()
{   var vld = new formValidator('#vipreserv');
    vld.keyupValidateOn('input.form-control');
 
    var vipres= new VIPreserv('#vipreserv');
    
    $('#bsubscribe').click(function(){
        if ( vld.validate() ) vipres.save();
    });
    
    $('#datetimepicker').datetimepicker({
        format: "MM/DD/YYYY",
        disabledDates: [
            moment("10/03/2016"),
            moment("10/04/2016"),
            new Date(2013, 11 - 1, 21)
        ]
    }).on('dp.change', function(e){
         var inp = $(e.target).find('input');
         vld.validateSingle(inp[0]);
    });
    
    $(document).on('click', '.btn-add', function(e)
    {
      e.preventDefault();
      var controlForm = $('.controls form:first'),
      currentEntry = $(this).parents('.entry:first'),
      newEntry = $(currentEntry.clone()).appendTo(controlForm);
      vld.keyupValidateOn( newEntry.find('input') );
      newEntry.find('input').val('');
      controlForm.find('.entry:not(:last) .btn-add')
      .removeClass('btn-add').addClass('btn-remove')
      .removeClass('btn-success').addClass('btn-danger')
      .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
      $(this).parents('.entry:first').remove();
      e.preventDefault();
      return false;
    });
});
