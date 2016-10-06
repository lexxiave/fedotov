<h2>Event Name Guest Lists</h2>
<div id="evnamegl-list">
    <table id="evnamegl-table" class="table table-hover">
    <thead>
        <tr><th>Created</th><th>E-mail</th><th>First Name</th><th>Last Name</th><th>Guests</th></tr>
    </thead>
    <tbody>
    </tbody>    
    </table>
    <p><b>Events total: <span class="records-total"></span></b></p>
</div>
<a href="/html.php/pages/admin/evnamegl.csv" class="btn btn-info">Download evnamegl.csv</a>

<!-- Modal -->
<div id="viewrecord" class="modal fade" role="dialog">
  <div class="modal-dialog">
      
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View Event</h4>
      </div>
      <div class="modal-body form-horizontal">
         <div class="form-group">
             <div class="col-xs-2"><label>Created:</label></div>
             <div class="col-xs-4"><p data-name="created"></p></div>
             <div class="col-xs-2"><label>E-mail:</label></div>
             <div class="col-xs-4"><p data-name="email"></p></div>
         </div>
         <div class="form-group">
             <div class="col-xs-2"><label>First Name:</label></div>
             <div class="col-xs-4"><p data-name="firstname"></p></div>
             <div class="col-xs-2"><label>Last Name:</label></div>
             <div class="col-xs-4"><p data-name="lastname"></p></div>
          </div>
         <br />
         <label>Guests:</label>
         <table class="table table-striped" id="table-guests">
             <thead><tr><th>First Name</th><th>Last Name</th></tr></thead>
             <tbody></tbody>
         </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
