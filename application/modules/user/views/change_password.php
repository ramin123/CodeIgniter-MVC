<div class="container pt-8 pb-8">
   <div class="row">
      <div class="col-md-3">
	  
        <ul class="dash-menu">
          <li><a href="<?php echo URL_USER_PROFILE;?>"><i class="pe pe-7s-user"></i><?php echo get_languageword('my_profile');?></a></li>
		  
          <li><a href="<?php echo URL_USER_MY_ORDERS;?>"><i class="pe pe-7s-box1"></i><?php echo get_languageword('my_orders');?></a></li>
		  
          <li><a href="<?php echo URL_USER_MY_POINTS;?>"><i class="pe pe-7s-wallet"></i><?php echo get_languageword('my_points');?></a></li>
		  
          <li><a href="<?php echo URL_ADD_USER_ADDRESS;?>"><i class="pe pe-7s-notebook"></i><?php echo get_languageword('my_addresses');?></a></li>
		  
		  <li class="active"><a href="<?php echo URL_USER_CHANGE_PASSWORD;?>"><i class="pe pe-7s-unlock"></i><?php echo get_languageword('change_password');?></a></li>
        </ul>
		
      </div>
	  
      <div class="col-md-9">
	  <?php echo $this->session->flashdata('message'); ?>
	  
         <div class="cs-card cart-card card-show">
           <div class="card-header bordered card-header-lg"><?php if (isset($pagetitle)) echo $pagetitle;?> </div>
               <div class="cs-card-content card-items-list">
               		  <!--PROFILE-->
               		  <div class="row">
                  <div class="col-sm-12 col-md-7 col-lg-5" >
                     
					  
					  
					  
                      <?php 
					 $attributes = array('name'=>'change_password_form',
										'id'=>'change_password_form',
										'class'=>'crunch-change');
					 echo form_open(URL_USER_CHANGE_PASSWORD,$attributes);?>
					 
					
                       <div class="form-group">
						  <?php echo form_input($old_password);?>
						</div>
					   
                      <div class="form-group">
						 <?php echo form_input($new_password);?>
						</div>
						
						<div class="form-group">
						  <?php echo form_input($new_password_confirm);?>
						</div>
						
						
						
						<div class="form-group text-center">
						
						  <?php if(isset($user_id))
						echo form_hidden('user_id',$user_id);?>
					
						 <button type="submit" name="change_pwd" class="btn btn-primary"><?php echo get_languageword('submit');?></button>
					    </div>
						
                      <?php echo form_close();?>
                  </div>
              </div>
				  <!--PROFILE-->
               </div>
           </div>
            </div>
         </div>
      </div>


	
<script type="text/javascript" src="<?php echo JS_VALIDATE_MIN;?>"></script>
<script type="text/javascript">
(function($,W,D)
{
      var JQUERY4U = {};
   
      JQUERY4U.UTIL =
      {
          setupFormValidation: function()
          {
              //Additional Methods
			  
			//form validation rules
              $("#change_password_form").validate({
					ignore: "",
                  rules: {
					 old_password: {
						 required: true
					 },
                     new_password: {
						required: true,
						rangelength:[6,20]
					 },
					 new_confirm_password: {
						 equalTo: "#new_password"
					 }
					 
   		
                  },
				 messages: {
					 old_password: {
						 required: "<?php echo get_languageword('old_password_required');?>"
					 },
					 new_password: {
						 required: "<?php echo get_languageword('new_password_required');?>"
					 },
					 new_confirm_password: {
						 equalTo: "<?php echo get_languageword('password_confirm_password_should_be_same');?>"
					 }
   			},
                  
                  submitHandler: function(form) {
                      form.submit();
                  }
              });
          }
      }
   
      //when the dom has loaded setup form validation rules
      $(D).ready(function($) {
          JQUERY4U.UTIL.setupFormValidation();
      });
   
   })(jQuery, window, document); 
</script>