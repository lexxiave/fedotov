<!-- Event Name Guest List -->
  
  <div class="container" id="guestlist">
    <div class="row">

     <div class="col-lg-5">

       <h4 class="eventformtitle">Event Name Guest List</h4>
       <br clear="all" /> 


      <div class="form-group">
        <input type="text" class="form-control"  name="firstname" placeholder="First Name" data-validate="req,minlen=2">
      </div>


      <div class="form-group">
        <input type="text" class="form-control" name="lastname" placeholder="Last Name" data-validate="req,minlen=2">
      </div>


      <div class="form-group">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" data-validate="req,email">
      </div>


      <div class="form-group">
        <input type="email" class="form-control" name="confirm_email" placeholder="Confirm Email Address" data-validate="req,email,equalto='#email'">
      </div>


      <!--  Dynamic Form Fields - Add & Remove     -->
      <div class="control-group" id="fields">
       
        <label class="control-label" for="field1"><h4>Add Guest (s) <span class="glyphicon glyphicon-plus gs"></span> <small> unlimited number of guests to the list</small></h4></label>

        <div class="controls"> 
          <form role="form" autocomplete="off" class="form-horizontal">
             <div class="entry">
                <div class="col-xs-6">
                    <input class="form-control" name="firstname" type="text" placeholder="First Name" data-validate="req,minlen=2" />
                </div>
                <div class="input-group col-xs-6">
                  <input class="form-control" name="lastname" type="text" placeholder="Last Name" data-validate="req,minlen=2" />
                  <span class="input-group-btn">
                    <button class="btn btn-success btn-add" type="button">
                      <span class="glyphicon glyphicon-plus"></span>
                    </button>
                  </span>
                </div>
             </div>
          </form>
          <br>
        </div>
      </div>
      <!--   Dynamic Form Fields - Add & Remove  -->


       <!-- Button -->
      <div class="form-group">
        <center> <button id="bsubscribe" class="btn btn-success btn-lg btn-font">Subscribe</button> </center>
      </div>
      <!-- Button -->


    </div>  <!-- col-lg-6 -->
  </div>  <!-- row -->
</div>   <!-- container -->

<br clear="all" /> <br />
