function rawItemList(selector)
{ var lastItem = null;
  var onclick = null;
 
  function click(f) { onclick = f;  }
 
  function selectItem(item)
  {    if (lastItem!=null) lastItem.removeClass('active');
       lastItem = $(item.target);
       lastItem.addClass('active');
       if (onclick!=null) onclick(lastItem);
  }
    
  function bind()
  {  $(selector).find('a').click(selectItem);     
  }
  
  function select(item)
  { selectItem({ target:item.get() });
  }
  
  bind();
  return {click:click, select:select};
}


function emailSettings(selector)
{ 
  function getSettings()
  { var r = {};
    var ctrls = $(selector+' .form-control');
    for (var i=0; i<ctrls.length; i++)
    { var ctrl = $(ctrls[i]);
      var id = ctrl.attr('id');
      r[id] = ctrl.val();
    }
    return r;
  }
  
  function setSettings(d)
  { var i;
    for (i in d.row)
    {
       $(selector+' #'+i).val(d.row[i]);
    }
  }
  
  function save()
  {  var r = getSettings();
     ajx('/pages/admin/SaveEmailSettings', r, function(d){
         if (!d.error) setOk(d.info);
     }); 
  }
  
  function load()
  { ajx('/pages/admin/LoadEmailSettings', {}, setSettings );
  }
  
  return {save:save, load:load};
}

function emailTemplates(selector)
{   var tmpl;
    
    function setTemplate(tmp)
    { tmpl = tmp;
      load();
    }
    
    function getData()
    {   var r = {};
        var ctrls = $(selector+' .form-control');
        for (var i=0; i<ctrls.length; i++)
        { var ctrl = $(ctrls[i]);
          var id = ctrl.attr('id');
          r[id] = ctrl.val();
        }
        return r;
    }

    function setData(d)
    {   var i;
        for (i in d.row)
        {
           $(selector+' #'+i).val(d.row[i]);
        }
    }
    
   function save()
   {   var r = getData();
       ajx('/pages/admin/SaveTmpl', r, function(d)
       { if (!d.error) setOk(d.info);
       });  
   }
  
   function load()
   {  ajx('/pages/admin/LoadTmpl/'+tmpl, {}, setData);       
   }
   
   return {save:save, load:load, setTemplate:setTemplate };
}


function tableList(selector, table, columns)
{  var ontotal = null;
   var onclick = null;
   var onloaded = null;

   function setData(d)
   {   var s = '';
       var i;
       for (i in d.rows)
       {   var j;
           var r = d.rows[i];
           if (r.id!=undefined) s+='<tr data-id="'+r.id+'">'; else s+='<tr>';
           for (j in columns) s+='<td>'+r[ columns[j] ]+'</td>';
           s+='</tr>';
       }
       $(selector+' tbody').html(s);
       if (ontotal!=null) ontotal(d.total);    
       if (onclick!=null)  $(selector+' tbody tr').click(onclick);
       if (onloaded!=null) onloaded(d);
   }
  
   function load(id)
   {   var pf = '';
       if (id!=undefined) pf+='/'+id;
       ajx('/pages/admin/LoadTable/'+table+pf, {}, setData);       
   }
   
   function total(fu){ ontotal = fu;}
   
   function click(fu){ onclick = fu;}
   
   function loaded(fu){ onloaded = fu;}
   
   return {load:load, total:total, click:click, loaded:loaded};
}

function changePassword(selector)
{ 
  function getSettings()
  { var r = {};
    var ctrls = $(selector+' .form-control');
    for (var i=0; i<ctrls.length; i++)
    { var ctrl = $(ctrls[i]);
      var id = ctrl.attr('id');
      r[id] = ctrl.val();
    }
    return r;
  }
  
  
  function save()
  {  var r = getSettings();
      
     ajx('/pages/admin/SavePassword', r, function(d){
         if (!d.error) setOk(d.info);
     }); 
  }
    
  return {save:save};
}



$(function()
{   var menu = new rawItemList('#admin-menu');
    var esettings = new emailSettings('#email-settings');
    var templates = new emailTemplates('#email-templates');
    var chpwd = new changePassword('#change-password');
    var views = new htviewCached();
    
    
    var views_init = {};
    
    
    views_init.emailtmpl = function(){
        $('#seltmpl').change(function(item){
           var tmpl = item.target.value;
           templates.setTemplate(tmpl);
        });
        $('#seltmpl').trigger('change');
        $('#btchangepw').click(templates.save)
    }
    
    views_init.changepass = function(){
        $('#btchangepw').click(chpwd.save);
    }
    
    views_init.emailsettings = function(){
         $('#btsmtpsave').click(esettings.save);
         esettings.load();
    }
    
    
    var signups = new tableList('#signup-table','signup',['created','email']);
        
    views_init.signuplist = function()
    {  signups.load();
       signups.total(function(t){
           $('#signup-list span.records-total').html(t); 
       })
    }

    var evnamegl = new tableList('#evnamegl-table','evnamegl',['created','email','firstname','lastname','guests']);
    var evnamegl_guests = new tableList('#table-guests','evnamegl_guests',['firstname','lastname']);

    views_init.evnamegl = function(){
       
       evnamegl.load();
       
       evnamegl.total(function(t){
           $('#evnamegl-list span.records-total').html(t); 
       });
       
       evnamegl.click(function(row){
           var id = $(row.target).parents('tr:first').attr('data-id');
           evnamegl_guests.loaded(function(d){
               var hds = $('#viewrecord p');
               for (var i=0; i<hds.length; i++)
               {   var r=$(hds[i]);
                   var fname = r.attr('data-name');
                   r.html( d.head[fname] );
               }
               $('#viewrecord').modal('show');
           });
           evnamegl_guests.load(id);
                     
           
       });
       
    }
    
    var vipreserv = new tableList('#vipreserv-table','vipreserv',['bookdate','firstname','lastname','email','phone','guests','package']);
    views_init.vipreserv = function(){
        vipreserv.load();
        vipreserv.total(function(t){
           $('#vipreserv-list span.records-total').html(t); 
       });
    }
    
    menu.click(function(it)
    {  var view = it.attr('data-view');
       if (view==undefined) return;
       views.view('/pages/admin/'+view,'#views', function(){ 
           if (views_init[view]!=undefined) views_init[view]();
           else setError(view+' init function not found! (admin.js)');
       });
    });
    
    menu.select( $('#admin-menu a:first') );
    

});
