<div class="container pt-8 pb-8">
   <div class="row">
      <div class="col-md-3">
	  
        <ul class="dash-menu">
          <li class="active"><a href="<?php echo URL_USER_PROFILE;?>"><i class="pe pe-7s-user"></i><?php echo get_languageword('my_profile');?></a></li>
		  
          <li><a href="<?php echo URL_USER_MY_ORDERS;?>"><i class="pe pe-7s-box1"></i><?php echo get_languageword('my_orders');?></a></li>
		  
          <li><a href="<?php echo URL_USER_MY_POINTS;?>"><i class="pe pe-7s-wallet"></i><?php echo get_languageword('my_points');?></a></li>
		  
          <li><a href="<?php echo URL_ADD_USER_ADDRESS;?>"><i class="pe pe-7s-notebook"></i><?php echo get_languageword('my_addresses');?></a></li>
		  
		  <li><a href="<?php echo URL_USER_CHANGE_PASSWORD;?>"><i class="pe pe-7s-unlock"></i><?php echo get_languageword('change_password');?></a></li>
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
					 $attributes = array('name'=>'profile_form',
										'id'=>'profile_form',
										'class'=>'crunch-change');
					 echo form_open(URL_USER_PROFILE,$attributes);?>
					 
					<div class="form-group">
					  <div class="img-profile" data-toggle="modal" data-target="#profile_image_modal">
                      <img src="<?php echo get_user_image();?>" alt="" class="img-responsive">
                      </div>
					  </div>
					 
                       <div class="form-group">
						 <?php 
						 $val='';
						 if(isset($user))
						 {
							 $val = $user->first_name;
						 }
						 else if(isset($_POST['update_profile']))
						 {
							 $val = set_value('first_name');
						 }
						
						 $element = array('name'=>'first_name',
										  'id'=>'first_name',
										  'class'=>'form-control',
										  'placeholder'=>get_languageword('first_name'),
										  'value'=>$val);
						echo form_input($element).form_error('first_name');		
						 ?>
						</div>
					   
                      <div class="form-group">
						 <?php 
						 $val='';
						 if(isset($user))
						 {
							 $val = $user->last_name;
						 }
						 else if(isset($_POST['update_profile']))
						 {
							 $val = set_value('last_name');
						 }
						 $element = array('name'=>'last_name',
										  'id'=>'last_name',
										  'class'=>'form-control',
										  'placeholder'=>get_languageword('last_name'),
										  'value'=>$val);
						echo form_input($element).form_error('last_name');		
						 ?>
						</div>
						
						<div class="form-group">
						 <?php 
						 $val='';
						 if(isset($user))
						 {
							 $val = $user->email;
						 }
						 else if(isset($_POST['update_profile']))
						 {
							 $val = set_value('email');
						 }
						 $element = array('name'=>'email',
										  'id'=>'email',
										  'type'=>'email',
										  'class'=>'form-control',
										  'placeholder'=>get_languageword('email'),
										  'value'=>$val,
										  'readonly'=>true);
						echo form_input($element).form_error('email');		
						 ?>
						</div>
						
						<div class="form-group">
						 <?php 
						 $val='';
						 if(isset($user))
						 {
							 $val = $user->phone;
						 }
						 else if(isset($_POST['update_profile']))
						 {
							 $val = set_value('phone');
						 }
						 $element = array('name'=>'phone',
										  'id'=>'phone',
										  'class'=>'form-control',
										  'placeholder'=>get_languageword('phone'),
										  'value'=>$val);
						echo form_input($element).form_error('phone');		
						 ?>
						</div>
						
						<div class="form-group text-center">
						 <button type="submit" name="update_profile" class="btn btn-primary"><?php echo get_languageword('update');?></button>
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


	  
<!--Profile Picture Modal -->
<div class="modal fade" id="profile_image_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content choose-modal">
        <div class="modal-header moiz-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> <?php echo get_languageword('profile_picture');?> </h4>
        </div>
        <div class="modal-body">
         <?php 
		 $attributes = array('name'=>'profile_image_form',
							'id'=>'profile_image_form',
							'class'=>'crunch-change');
		 echo form_open_multipart(URL_USER_PROFILE,$attributes);
		 
		 $src = "";
		 $style="display:none;";?>
		 
	  <div class="form-group">
		 <label> <?php echo get_languageword('profile_image');?></label>
		<input type="file" name="profile_image" class="form-control" placeholder="Profile Image" onchange="photo(this,'profile_image')" required/>
		<img id="profile_image" src="<?php echo $src;?>" style="<?php echo $style;?>" class="img-responsive" alt="User Photo" width="80"> 
	  </div>
	  
	  <div class="text-right">
	  <button type="submit" name="profile_image" class="btn btn-warning crunch-newaddr"><?php echo get_languageword('save');?></button>
	  </div>
	<?php echo form_close();?>
          
        </div>
        
      </div>
      
    </div>
  </div>
<!--Profile Picture Modal -->
  

  
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
              $("#profile_form").validate({
				ignore: "",
                  rules: {
					 first_name: {
						 required: true
					 },
                     last_name: {
						required: true
					 },
					 phone: {
						 required: true
					 }
					 
                  },
   			
				messages: {
					 first_name: {
						required: "<?php echo get_languageword('first_name_required');?>"
					 },
                     last_name: {
						required: "<?php echo get_languageword('last_name_required');?>"
					 },
					 phone: {
						 required: "<?php echo get_languageword('phone_required');?>"
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