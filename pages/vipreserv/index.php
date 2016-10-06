<!-- Book Your VIP Reservation Registration -->

  <div class="container" id="vipreserv">
    <div class="row">

     <div class="col-lg-5">

       <h4 class="eventformtitle">Book Your VIP Reservation</h4>
       <br clear="all" /> 


       <!-- Bootstrap Datepicker Enabled/Disabled Dates -->
       <div class="form-group">
        <div class='input-group date' id='datetimepicker'>
          <input type='text' class="form-control" name="bookdate" placeholder="11/28/2016"  data-validate="req,regexp='^(0?[1-9]|1[012])[\/](0?[1-9]|[12][0-9]|3[01])[\/\-]([0-9]{4})$',msg='Invalid date format!'"/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>

      <!-- Bootstrap Datepicker Enabled/Disabled Dates -->

      <div class="form-group">
        <input type="text" class="form-control" name="firstname" placeholder="First Name"  data-validate="req,minlen=2">
      </div>


      <div class="form-group">
        <input type="text" id="email" class="form-control" name="lastname" placeholder="Last Name" data-validate="req,minlen=2">
      </div>


      <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Email Address" data-validate="req,email" data-validate="req,email">
      </div>

      <div class="form-group">
        <input type="tel" class="form-control" name="phone" placeholder="Contact Number" data-validate="req,minlen=5,maxlen=15,regexp='^[\+]?[0-9]+$',msg='Invalid phone number format! Example: 6781234567'">
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


      <div class="form-group">
        <label class="control-label" for="radios"><h4>Select VIP Package (s)</h4></label>

        <div class="radio">
          <label for="radios-0">
            <input type="radio" name="vippackage" id="vippackage1" value="1" data-validate="reqradio='vippackage'">
            $150 Birthday Special incl. tip + gratuity.  1 Champagne Bottle + 25 Wing Platter + 1 Hookah ($60 DEPOSIT)   Reserved Section seats 6 VIP Guests Unlimited Guestlist til 12am + Shout Outs from the DJ!
          </label>
        </div>

        <div class="radio">
          <label for="radios-0">
            <input type="radio" name="vippackage" value="2">
            $400 VIP Party Upgrade Package incl. tip + gratuity.  1 Premium Bottle (Ciroc, Hennessy or Grey Goose) + 1 Complimentary Bottle of Champagne  ($100 DEPOSIT)  Reserved Section for 10 VIP Guests Unlimited Guestlist til 12am + Shout Outs from the DJ!
          </label>
        </div>

      </div> 
      <!-- form-group -->

      <!-- Button -->
      <div class="form-group">
        <center> <button id="bsubscribe" class="btn btn-success btn-lg btn-font">Subscribe</button> </center>
      </div>
      <!-- Button -->


    </div>  <!-- col-lg-6 -->
  </div>  <!-- row -->
</div>   <!-- container -->

 <!-- Book Your VIP Reservation Registration -->
