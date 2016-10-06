$(function()
{  
  var vld = new formValidator('#form');
  vld.keyupValidateOn('input.form-control');

  function signup()
  { var email = $('#exampleInputEmail1').val();
    if (vld.validate()) 
    ajx('/pages/signup/SaveSign',{email:email},
    function(d){
      if (!d.error)
      {  htview('/pages/signup/thank', '#form');
      } else $('#errors').html(d.errmsg).show();
    },'json');
  }

  $('#button1id').click(signup);
  
}
);
