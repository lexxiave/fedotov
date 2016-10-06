<h1>E-Mail templates</h1>
<form id="email-templates">
  <div class="form-group">
    <label for="seltmpl">Select template</label>
    <select class="form-control" id="seltmpl">
        <?php
           foreach($this->email_templates as $t)
           echo '<option value="'.$t.'">'.T($t).'</option>';
        ?>
    </select>
  </div>
 <h2>Admin Confirmation E-Mail template</h2>
 <div class="form-group">
    <label for="adminsubj">E-Mail Subject</label>
    <input type="text" class="form-control" id="adminsubj" placeholder="Email Subject">
  </div>
  <div class="form-group">
     <label for="adminbody">Email Body Template:</label>
     <textarea class="form-control" rows="5" id="adminbody"></textarea>
  </div>
 <h2>User Confirmation E-Mail template</h2>
 <div class="form-group">
    <label for="usersubj">E-Mail Subject</label>
    <input type="text" class="form-control" id="usersubj" placeholder="Email Subject">
  </div>
  <div class="form-group">
     <label for="userbody">Email Body Template:</label>
     <textarea class="form-control" rows="5" id="userbody"></textarea>
  </div>

  <h2>Autoresponder</h2>
  <div class="form-group">
    <label for="autorespsubj">Title</label>
    <input type="text" class="form-control" id="autorespsubj" placeholder="Title">
  </div>  
  <div class="form-group">
     <label for="autorespbody">Message:</label>
     <textarea class="form-control" rows="5" id="autorespbody"></textarea>
  </div>
  <button type="button" class="btn btn-default btn-default btn-info btn-lg" id="btchangepw">Save</button>
</form>
