<?php 
$signup_modal='signup';
$forgot_modal='forgot_pwd';
$lgin_modal='login';


	//google login
	include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
    include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
	// Google Project API Credentials
    
    $clientId = $this->config->item('site_settings')->google_client_id;
    $clientSecret = $this->config->item('site_settings')->google_client_secret;
    $redirectUrl = base_url() . 'user_authentication/';

	// Google Client Configuration
	$gClient = new Google_Client();
	$gClient->setApplicationName($this->config->item('site_settings')->site_title);
	$gClient->setClientId($clientId);
	$gClient->setClientSecret($clientSecret); 
	$gClient->setRedirectUri($redirectUrl);
	$gClient->setScopes('email');
	$google_oauthV2 = new Google_Oauth2Service($gClient);
	$aauthUrl = $gClient->createAuthUrl();

	
	//fb login
	$authUrl =  $this->facebook->login_url();
?>
					

<?php if (!$this->ion_auth->logged_in()) { ?>					
<!-- Login Modal -->
<div id="login-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
       <div class="login-block">

       	<!-- <div class="row"> -->

  			<!-- <div class="col-sm-6"> -->
	   
                <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
                <div class="login-block-header text-center"><img src="<?php echo FRONT_IMAGES;?>food.svg" alt="Login" class="d-icon"><?php echo get_languageword('login');?></div>
				
				<?php echo $this->session->flashdata('message'); ?>
				
               
				<?php 
					 $attributes = array('name'=>'login_form',
										'id'=>'login_form',
										'class'=>'form-horizontal');
					 echo form_open(URL_AUTH_LOGIN,$attributes);?>
					 
                    <div class="form-group">
					<?php 
					 $val='';
					 if(isset($_POST['login']))
					 {
						 $val = set_value('email');
					 }
					 $element = array('name'=>'email',
									  'id'=>'lemail',
									  'type'=>'email',
									  'class'=>'form-control form-control-lg',
									  'placeholder'=>get_languageword('email'));
					 echo form_input($element).form_error('email');		
					 ?>
                    </div>
					
					
					
                    <div class="form-group">
					<?php 
						 $val='';
						 if(isset($_POST['login']))
						 {
							 $val = set_value('password');
						 }
						 $element = array('name'=>'password',
										  'id'=>'lpassword',
										  'type'=>'password',
										  'class'=>'form-control form-control-lg',
										  'placeholder'=>get_languageword('password'));
						echo form_input($element).form_error('password');		
						?>  
                    </div>
					
					
                    <div class="form-group">
                        <button type="submit" name="login" class="btn btn-primary btn-block "><b><?php echo get_languageword('login');?></b></button>
                    </div>
					
                    <div class="form-group">
					
                        <a href="#" onclick="show_popup('<?php echo $signup_modal;?>')" class="sing-link"><?php echo get_languageword('sign_up');?></a>
                        <a href="#" onclick="show_popup('<?php echo $forgot_modal;?>')" class="forgot-password-link "><?php echo get_languageword('forgot_password?');?></a>
                    </div>
					
                 <?php echo form_close();?>
				 
			   
			  
						 
                <div class="login-with-social">
				
                   <span><?php echo get_languageword('or_login_through');?></span> 
				   
				 
				   <a href="<?php echo $aauthUrl;?>"><img src="<?php echo FRONT_IMAGES;?>sign-g.svg" alt="Login through Google" class="sc-icn"></a>
				   
				   <a href="<?php echo $authUrl;?>"><img src="<?php echo FRONT_IMAGES;?>sign-f.svg" alt="Login through Facebook" class="sc-icn"></a>
				   
                </div>
				
			<!-- </div> --> <!--col-6-->


        <!-- </div> row -->

      </div>
    </div>
  </div>
</div>
</div>
<!-- Login Modal -->





<!-- Register Modal -->
<div id="register-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
       <div class="login-block">
                 <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
                <div class="login-block-header text-center"><img src="<?php echo FRONT_IMAGES;?>food.svg" alt="Register" class="d-icon"><?php echo get_languageword('register');?></div>
				
				<?php echo $this->session->flashdata('message'); ?>
				
                <?php 

					 $attributes = array('name'=>'register_form',

										'id'=>'register_form',

										'class'=>'crunch-change');

					 echo form_open(URL_AUTH_REGISTER,$attributes);?>
					 
					 
                   <div class="form-group">
				   
				    <?php 

						 $val='';

						 if(isset($_POST['register']))
						 {
							 $val = set_value('first_name');
						 }

						 $element = array('name'=>'first_name',

										  'id'=>'first_name',

										  'type'=>'text',

										  'class'=>'form-control form-control-lg',

										  'placeholder'=>get_languageword('first_name')
										 );

						echo form_input($element).form_error('first_name');		
						 ?>
                    </div>
					
					
					<div class="form-group">
					<?php 

						 $val='';

						 if(isset($_POST['register']))

						 {

							 $val = set_value('last_name');

						 }

						 $element = array('name'=>'last_name',

										  'id'=>'last_name',

										  'type'=>'text',

										  'class'=>'form-control form-control-lg',

										  'placeholder'=>get_languageword('last_name'));

						echo form_input($element).form_error('last_name');		

						 ?>
						
                    </div>
					
					
                    <div class="form-group">
					
					<?php 

						 $val='';

						 if(isset($_POST['register']))

						 {

							 $val = set_value('email');

						 }

						 $element = array('name'=>'email',

										  'id'=>'email',

										  'type'=>'email',

										  'class'=>'form-control form-control-lg',

										  'placeholder'=>get_languageword('email'));

						echo form_input($element).form_error('email');		

						 ?>		
					
                    </div>
					
					
                    <div class="form-group">
					<?php 

						 $val='';

						 if(isset($_POST['register']))

						 {

							 $val = set_value('phone');

						 }

						 $element = array('name'=>'phone',

										  'id'=>'phone',

										  'class'=>'form-control form-control-lg',

										  'placeholder'=>get_languageword('phone'));

						echo form_input($element).form_error('phone');		

						 ?>
						 
                    </div>
					
					
					
                    <div class="form-group">
					
					<?php 

						 $val='';

						 if(isset($_POST['register']))

						 {

							 $val = set_value('password');

						 }

						 $element = array('name'=>'password',

										  'id'=>'password',

										  'type'=>'password',

										  'class'=>'form-control form-control-lg',

										  'placeholder'=>get_languageword('password').' '.get_languageword('min_length_should_be'.' '.$this->config->item('min_password_length', 'ion_auth')));

						echo form_input($element).form_error('password');		

						 ?>
						 
                       
                    </div>
					
					
					
					
                    
					
					
					
					<?php if($this->config->item('referral_settings')->referral_enabled=='Yes') {?>
					
                     <div class="form-group">
					 
					 <?php 

						 $val='';

						 if(isset($_POST['register']))

						 {

							 $val = set_value('referral_code');

						 }

						 $element = array('name'=>'referral_code',

										  'id'=>'referral_code',

										  'class'=>'form-control form-control-lg',

										  'placeholder'=>get_languageword('referral_code'));

						echo form_input($element).form_error('referral_code');		

						 ?>
						
                    </div>
					<?php } ?>
					
					
					
					
					
                    <div class="form-group">
                        <button type="submit" name="register" class="btn btn-primary btn-block "><b><?php echo get_languageword('register');?></b></button>
                    </div>
					
                    <div class="form-group">
					
                        <a href="#" onclick="show_popup('<?php echo $lgin_modal;?>')" class="sing-link"><?php echo get_languageword('login');?></a>
                        <a href="<?php echo URL_TERMS_CONDITIONS;?>" class="forgot-password-link"><?php echo get_languageword('terms_conditions');?></a>
                    </div>
					
                <?php echo form_close();?>
				
				
                <div class="login-with-social">
                   <span><?php echo get_languageword('or_signup_through');?></span> 
				   <a href="<?php echo $aauthUrl;?>"><img src="<?php echo FRONT_IMAGES;?>sign-g.svg" alt="" class="sc-icn"></a>
				   
				   <a href="<?php echo $authUrl;?>"><img src="<?php echo FRONT_IMAGES;?>sign-f.svg" alt="" class="sc-icn"></a>
				   
                </div>
				
				
            </div>
      </div>
    </div>
  </div>
</div>
<!-- Register Modal -->
 <?php } ?>   
	
	
	
	
<!-- FP Modal -->
<div id="forgot-pwd-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
       <div class="login-block">
                 <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
                <div class="login-block-header text-center"><img src="<?php echo FRONT_IMAGES;?>food.svg" alt="Forgot Password" class="d-icon"><?php echo get_languageword('forgot_password?');?></div>
				
				<?php echo $this->session->flashdata('message'); ?>
				
				
               <?php 

					 $attributes = array('name'=>'forgot_password_form','id'=>'forgot_password_form','class'=>'crunch-change');

					 echo form_open(URL_AUTH_FORGOT_PASSWORD,$attributes);?>
					 
                    <div class="form-group">
					
					 <?php 

						 $val='';

						 if(isset($_POST['forgot_pwd']))

						 {

							 $val = set_value('email');

						 }

						 $element = array('name'=>'email',

										  // 'id'=>'email',

										  'type'=>'email',

										  'class'=>'form-control form-control-lg',

										  'placeholder'=>get_languageword('email'));

						echo form_input($element).form_error('email');		

						 ?>
						 
                    </div>
					
                    
					
                    <div class="form-group">
                        <button type="submit" name="forgot_pwd" class="btn btn-primary btn-block "><b><?php echo get_languageword('submit');?></b></button>
                    </div>
					
					
                    <div class="form-group">
					
					<a href="#" onclick="show_popup('<?php echo $lgin_modal;?>')" class="forgot-password-link"><?php echo get_languageword('login');?></a>
					
                    <a href="#" onclick="show_popup('<?php echo $signup_modal;?>')" class="sing-link"><?php echo get_languageword('sign_up');?></a>
                        
                    </div>
                </form>
                <div class="login-with-social">
                   <span><?php echo get_languageword('or_login_through');?></span> <a href="#"><img src="<?php echo FRONT_IMAGES;?>sign-g.svg" alt="" class="sc-icn"></a><a href="#"><img src="<?php echo FRONT_IMAGES;?>sign-f.svg" alt="" class="sc-icn"></a>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>
<!-- FP Modal -->	




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
              $("#login_form").validate({
					ignore: "",
                  rules: {
					 email: {
						 required: true,
						 email:true
					 },
                     password: {
						required: true
					 }
					 
                  },
				 messages: {
					 email: {
						 required: "<?php echo get_languageword('email_required');?>"
					 },
                     password: {
						required: "<?php echo get_languageword('password_required');?>"
					 }
   			},
                  
                  submitHandler: function(form) {
                      form.submit();
                  }
              });
			  
			  
			  
			  
			  //form validation rules

              $("#register_form").validate({

					ignore: "",

                  rules: {

					 first_name: {

						 required: true

					 },

                     last_name: {

						required: true

					 },

					 email: {

						 required: true,

						 email: true

					 },

					 phone: {

						 required: true

					 },

					 password: {

						 required: true,

						 rangelength:[6,20]

					 }



                  },

				 messages: {

					 first_name: {

						 required: "<?php echo get_languageword('first_name_required');?>"

					 },

                     last_name: {

						required: "<?php echo get_languageword('last_name_required');?>"

					 },

					 email: {

						 required: "<?php echo get_languageword('email_required');?>"

					 },

					 phone: {

						 required: "<?php echo get_languageword('phone_required');?>"

					 },

					 password: {

						 required: "<?php echo get_languageword('password_required');?>"

					 }

   			},

                  

                  submitHandler: function(form) {

                      form.submit();

                  }

              });
			  
			  
			  
			  //form validation rules

              $("#forgot_password_form").validate({

					ignore: "",

                  rules: {

					 email: {
						 required: true,
						 email: true
					 }
                  },

				 messages: {

					 email: {

						 required: "<?php echo get_languageword('email_required');?>"

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


<script type="text/javascript">
// A $( document ).ready() block.
$( document ).ready(function() {


$.ajaxPrefilter(function( options, originalOptions, jqXHR ) { options.async = true; });

	
    <?php 
	$popup_type='';
	if ($this->session->userdata('loginup'))
		$popup_type='login';
		
		
	if ($this->session->userdata('signup_popup'))
		$popup_type='signup';
		
		
	if ($this->session->userdata('forgtup'))
		$popup_type='forgot_pwd';
	
	
	
	if ($popup_type!='') {?>
	show_popup('<?php echo $popup_type;?>');
	<?php } ?>
});



function show_popup(type) {
	
	<?php
	/* if ($this->ion_auth->logged_in()) {
		redirect(SITEURL);
	} */

	
	if ($this->session->userdata('loginup'))
		$this->session->unset_userdata('loginup');
	 
	if ($this->session->userdata('signup_popup'))
		$this->session->unset_userdata('signup_popup');
	
	if ($this->session->userdata('forgtup'))
		$this->session->unset_userdata('forgtup');
	?>
	
	$("#login-modal").modal('hide');
	$("#register-modal").modal('hide');
	$("#forgot-pwd-modal").modal('hide');
	
	if (type=='login') {
		$("#login-modal").modal('show');
	} else if (type=='signup') {
		$("#register-modal").modal('show');
	} else if (type=='forgot_pwd') {
		$("#forgot-pwd-modal").modal('show');
	}
}
</script>











<!--Addons and Options Popup-->
<div id="addons-options-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
       <div class="login-block">
	   
		<button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
		
		
		<div id="adons-options-block">
		
		</div>
			
        </div>
      </div>
    </div>
  </div>
</div>
<!--Addons and Options Popup-->


<!--Offer Popup-->
<div id="offr-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
       <div class="login-block">
	   
		<button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
		
		
		<div id="offr-block">
		
		</div>
			
        </div>
      </div>
    </div>
  </div>
</div>
<!--Offer Popup-->








<!--Item Popup-->
<div id="itm-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
       <div class="login-block">
	   
		<button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
		
		
		<div id="itms-block">
		
		</div>
			
        </div>
      </div>
    </div>
  </div>
</div>
<!--Item Popup-->








<!--Address Modal-->
<div id="address-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog ">
  
    <!-- Modal content-->
	
    <div class="modal-content">
	
	
					 
					 
      <div class="modal-body">
       <div class="login-block">
	   
               <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			   
               <div class="login-block-header text-center"><?php echo get_languageword('add_address');?></div>
				
				<?php echo $this->session->flashdata('message'); ?>
				
               <?php 
				 $attributes = array('name'=>'address_form',
									'id'=>'address_form',
									'class'=>'form-horizontal');
				 echo form_open(URL_CART_ADD_ADDRESS,$attributes);?>
				
					 
                    <div class="form-group">
					<?php 
					 $cities = $this->base_model->get_cities();
					 $val=array();
					 
					 echo form_dropdown('city_id',$cities,$val,'class="form-control form-control-lg chzn-select" placeholder="city" id="city_id" onchange="get_localities()"');	
					 ?>
                    </div>
					
					
					
                    <div class="form-group">
					<?php 
					$val=array();
						
					echo form_dropdown('locality','',$val,'class="form-control form-control-lg chzn-select" id="locality" placeholder="locality" onchange="get_pincode()"');
					
					?>  
                    </div>
					
					
					<div class="form-group">
					<?php 
					$element = array('type'=>'text',
									'name'=>'pincode',
									'id'=>'pincode',
									'readonly'=>true,
									'class'=>'form-control form-control-lg',
									'placeholder'=>get_languageword('pincode')
									);
						
					echo form_input($element);
					?>  
                    </div>
					
					
					<div class="form-group">
					<?php 
					$element = array('type'=>'text',
									'name'=>'house_no',
									'id'=>'house_no',
									'class'=>'form-control form-control-lg',
									'placeholder'=>get_languageword('house_no')
									);
						
					echo form_input($element);
					?>  
                    </div>
					
					<div class="form-group">
					<?php 
					$element = array('type'=>'text',
									'name'=>'street',
									'id'=>'street',
									'class'=>'form-control form-control-lg',
									'placeholder'=>get_languageword('street')
									);
						
					echo form_input($element);
					?>  
                    </div>
					
					<div class="form-group">
					<?php 
					$element = array('type'=>'text',
									'name'=>'landmark',
									'id'=>'landmark',
									'class'=>'form-control form-control-lg',
									'placeholder'=>get_languageword('landmark')
									);
						
					echo form_input($element);
					?>  
                    </div>
					
					
                    <div class="form-group">
                        <button type="submit" name="address" class="btn btn-primary btn-block "><b><?php echo get_languageword('add');?></b></button>
                    </div>
					
               
				 <?php echo form_close();?> 
            </div>
      </div>
	  
	   
    </div>
  </div>
</div>
<!--Address Modal-->


<script>
function get_adns_options(item_id) {
	
	if (item_id>0) {
		
		$("#adons-options-block").empty();
		$('#addons-options-modal').modal('hide');
		
		$("body").addClass("ajax-load");
		$.ajax({
		url:'<?php echo base_url();?>welcome/get_item_addons_options',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&item_id='+item_id,
		success :function(response){
			
			$("body").removeClass("ajax-load");
			if (response!='') {
				$("#adons-options-block").html(response);
			
				$('#addons-options-modal').modal('show');
			} else {
				$("#adons-options-block").empty();
				$('#addons-options-modal').modal('hide');
			}
		}
	});
		
	}
}


function get_cart_itm_adns_options(item_id) {
	
	
	if (item_id>0) {
		
		$("#adons-options-block").empty();
		$('#addons-options-modal').modal('hide');
		
		$("body").addClass("ajax-load");	
		$.ajax({
		url:'<?php echo base_url();?>welcome/get_cart_itm_adns_optns',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&item_id='+item_id,
		success :function(response){
			
			$("body").removeClass("ajax-load");
			
			if (response!='') {
				$("#adons-options-block").html(response);
			
				$("#addons-options-modal").modal('show');
			} else {
				$("#adons-options-block").empty();
				$("#addons-options-modal").modal('hide');
			}
		}
	});
		
	}
}


function get_offer_popup(offer_id,frm='') {
	
	if (offer_id>0) {
		
		$("#offr-block").empty();
		$('#offr-modal').modal('hide');
		
		$("body").addClass("ajax-load");

		$.ajax({
		url:'<?php echo base_url();?>welcome/get_offr_itms',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&offer_id='+offer_id+'&frm='+frm,
		success :function(response){
			
			$("body").removeClass("ajax-load");

			if (response!='') {
				$("#offr-block").html(response);
			
				$('#offr-modal').modal('show');
			} else {
				$("#offr-block").empty();
				$('#offr-modal').modal('hide');
			}
		}
	});
		
	}
}

function load_cart_div() {
	
	$("#fc-cart-div").html('<img class="abs-loader" src="<?php echo LOADER_IMG;?>" alt="Loader" align="middle">');
	
	$.ajax({
		url:'<?php echo base_url();?>welcome/load_cart_div',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name()?>=<?php echo $this->security->get_csrf_hash()?>',
		success :function(response){
			
			
			if (response!='') {
				$("#fc-cart-div").html(response);
			} else {
				$("#fc-cart-div").empty();
			}
		}
	});
}



function load_cart_summary_div() {
	
	$("body").addClass("ajax-load");

	$("#cart-div").html('<div class="loader-pad"><img class="abs-loader" src="<?php echo LOADER_IMG;?>" alt="Loader" align="middle"></div>');
	
	$.ajax({
		url:'<?php echo base_url();?>welcome/load_cart_summary_div',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name()?>=<?php echo $this->security->get_csrf_hash()?>',
		success :function(response){
			
			$("body").removeClass("ajax-load");

			if (response!='') {
				$("#cart-div").html(response);
			} else {
				$("#cart-div").empty();
			}
		}
	});
}


function check_address(ua_id) {
	
	if (ua_id>0) {
	

	$("#cart-div").html('<img class="abs-loader" src="<?php echo LOADER_IMG;?>" alt="Loader" align="middle">');
	
	
	var checked='no';
	
	var discount = 0;
	
	discount = $("form#cart-form input[name='user_redeem_points']:checked").val();
	
	if (discount>0)
		checked='yes';
	
	$("body").addClass("ajax-load");
	
	$.ajax({
		url:'<?php echo base_url();?>welcome/load_cart_summary_div',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&ua_id='+ua_id+'&discount='+discount+'&checked='+checked,
		success :function(response){

			$("body").removeClass("ajax-load");
			
			if (response!='') {
				$("#cart-div").html(response);
			} else {
				$("#cart-div").empty();
			}
		}
	});
	
	}
}

function check_points() {
	
	
	$("#cart-div").html('<img class="abs-loader" src="<?php echo LOADER_IMG;?>" alt="Loader" align="middle">');
	

	var ua_id = $("form#cart-form input[name='zipcode']:checked").val();
	
	
	var checked='no';
	
	var discount = 0;
	
	discount = $("form#cart-form input[name='user_redeem_points']:checked").val();
	
	if (discount>0)
		checked='yes';
	
	$("body").addClass("ajax-load");

	$.ajax({
		url:'<?php echo base_url();?>welcome/load_cart_summary_div',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&discount='+discount+'&checked='+checked+'&ua_id='+ua_id,
		success :function(response){
			
			$("body").removeClass("ajax-load");

			if (response!='') {
				$("#cart-div").html(response);
			} else {
				$("#cart-div").empty();
			}
		}
	});
}



function get_item_popup(item_id) {
	
	if (item_id>0) {
		
		$("#itms-block").empty();
		$('#itm-modal').modal('hide');
		
		$("body").addClass("ajax-load");

		$.ajax({
		url:'<?php echo base_url();?>welcome/get_item_popup',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&item_id='+item_id,
		success :function(response){
			
			$("body").removeClass("ajax-load");

			if (response!='') {
				$("#itms-block").html(response);
				$('#itm-modal').modal('show');
			} else {
				$("#itms-block").empty();
				$('#itm-modal').modal('hide');
			}
		}
	});
		
	}
}
</script>









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
              $("#address_form").validate({
				 ignore: "",
                  rules: {
					 city_id: {
						 required: true
					 },
                     locality: {
						required: true
					 },
					 pincode: {
						 required: true
					 },
					 house_no: {
						 required: true
					 },
					 street: {
						 required: true
					 },
					 landmark: {
						 required: true
					 }
					 
                  },
				 messages: {
					 city_id: {
						 required: "<?php echo get_languageword('city_required');?>"
					 },
                     locality: {
						required: "<?php echo get_languageword('locality_required');?>"
					 },
					 pincode: {
						 required: "<?php echo get_languageword('pincode_required');?>"
					 },
					 house_no: {
						 required: "<?php echo get_languageword('house_no_required');?>"
					 },
					 street: {
						 required: "<?php echo get_languageword('street_required');?>"
					 },
					 landmark: {
						 required: "<?php echo get_languageword('landmark_required');?>"
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
   
 
 
 
 
 
function get_localities() {
	
	$("#locality").empty();
	$("#locality").trigger('liszt:updated');
	
	$("#pincode").val('');
	
	var city_id = $("#city_id option:selected").val();
	
	if (city_id > 0 ) {
			
			$("body").addClass("ajax-load");

			$.ajax({			 
			 type: 'POST',			  
			 async: false,
			 cache: false,	
			 url: "<?php echo base_url();?>cart/get_localities",
			 data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&city_id='+city_id,
			 success: function(data) 
			 {

			 	$("body").removeClass("ajax-load");

				if(data != '' && data != 0)
				{
					$('#locality').empty();
					$('#locality').append(data);
				}
				else if(data==999)
				{
					window.location = '<?php echo SITEURL;?>';
				} 
				$("#locality").trigger("liszt:updated");
			 }		  		
		});
	}
}	


function get_pincode() {
	
	$("#pincode").val('');
	
	var city_id = $("#city_id option:selected").val();
	var spl_id = $("#locality option:selected").val();
	
	if (city_id > 0 && spl_id > 0) {
			
			$("body").addClass("ajax-load");

			$.ajax({			 
			 type: 'POST',			  
			 async: false,
			 cache: false,	
			 url: "<?php echo base_url();?>cart/get_pincode",
			 data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&city_id='+city_id+'&spl_id='+spl_id,
			 success: function(data) 
			 {
			 	$("body").removeClass("ajax-load");
			 	
				if(data != '' && data != 0)
				{
					$('#pincode').val(data);
				}
				else if(data==999)
				{
					window.location = '<?php echo SITEURL;?>';
				} 
			 }		  		
		});
	}
}

</script>