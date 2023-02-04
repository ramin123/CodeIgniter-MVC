<div class="gray-bg pt-8">
<div class="container ">
	<div class="search-wrapper contact-overlay">
        <div class="row">
            <div class="col-sm-6 col-md-5 col-xs-12">
               <?php 
$site_adres='';
$site_adres .= $this->config->item('site_settings')->address.',';
$site_adres .= $this->config->item('site_settings')->city.',';
$site_adres .= $this->config->item('site_settings')->state.'-';
$site_adres .= $this->config->item('site_settings')->zip;
?>		 
		<h4 class="w-head"><?php echo get_languageword('get_in_touch');?></h4>
		<div class="c-media">
			<div class="media-left">
				<i class="fa fa-fw fa-map-o" aria-hidden="true"></i>
			</div>
			<div class="media-body">
				<p><?php echo $site_adres;?></p>
			</div>
		</div>
		<div class="c-media">
			<div class="media-left">
				<i class="fa fa-fw fa-phone" aria-hidden="true"></i>
			</div>
			<div class="media-body">
				<p><?php echo $this->config->item('site_settings')->land_line;?></p>
				<p><?php echo $this->config->item('site_settings')->phone;?></p>
			</div>
		</div>
		<div class="c-media">
			<div class="media-left">
				 <i class="fa fa-fw fa-envelope-o" aria-hidden="true"></i>
			</div>
			<div class="media-body">
				<p><?php echo $this->config->item('site_settings')->portal_email;?></p>
			</div>
		</div>
	<h4 class="w-head mt-5"><?php echo get_languageword('follow_us');?></h4>
		   <ul class="ct-social ul">
				  
				  <?php if(isset($this->config->item('social_networks')->facebook) && $this->config->item('social_networks')->facebook != '') { ?>
					<a href="<?php echo $this->config->item('social_networks')->facebook;?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
				  <?php } if(isset($this->config->item('social_networks')->twitter) && $this->config->item('social_networks')->twitter != '') { ?>
				 <a href="<?php echo $this->config->item('social_networks')->twitter;?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
				  <?php } if(isset($this->config->item('social_networks')->instagram) && $this->config->item('social_networks')->instagram != '') {?>
				  <a href="<?php echo $this->config->item('social_networks')->instagram;?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
				  <?php } if(isset($this->config->item('social_networks')->google_plus) && $this->config->item('social_networks')->google_plus != '') { ?> 
				  <a href="<?php echo $this->config->item('social_networks')->google_plus;?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
				 <?php } if(isset($this->config->item('social_networks')->tumblr) && $this->config->item('social_networks')->tumblr != '') {?>
				  <a href="<?php echo $this->config->item('social_networks')->tumblr;?>" target="_blank"><i class="fa fa-tumblr" aria-hidden="true"></i></a>
				  <?php } if(isset($this->config->item('social_networks')->pinterest) && $this->config->item('social_networks')->pinterest != '') {?>
				  <a href="<?php echo $this->config->item('social_networks')->pinterest;?>" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
				  <?php } if(isset($this->config->item('social_networks')->linked_in) && $this->config->item('social_networks')->linked_in != '') {?>
				  <a href="<?php echo $this->config->item('social_networks')->linked_in;?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
				   <?php } ?> 
				   
				   </ul> 
			 </div>
		<!--address details for contactus-->
			<div class="col-sm-12 col-md-1 col-xs-12 hidden-sm"></div>
			
			
			<div class="col-sm-6 col-md-6 col-xs-12">
				 <?php echo $this->session->flashdata('message'); ?>
				 
			<h4 class="w-head m-mt-3"><?php if(isset($pagetitle)) echo $pagetitle;?></h4>
			
			
				<?php 
					 $attributes = array('name'=>'reset_password_form',
										'id'=>'reset_password_form',
										'class'=>'crunch-change');
					 echo form_open(URL_AUTH_RESET_PASSWORD.DS.$code,$attributes);?>
				
				
				<!-- Text input-->
				<div class="form-group">
				
					<?php echo form_input($new_password);?>
					
				</div>
				
				
				
				
				<div class="form-group">
					<?php echo form_input($new_password_confirm);?>
				</div>
				
			
			
			
				
				
			<!-- Button -->
			<div class="form-group">
			
			<?php if(isset($user_id))
				echo form_hidden('user_id',$user_id);
			
				echo form_hidden($csrf); ?>
						 
			<button type="submit" name="reset_pwd" class="btn btn-primary"><?php echo get_languageword('submit');?> </button>
			
			</div>
			
			<?php echo form_close();?>
			
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
              $("#reset_password_form").validate({
					ignore: "",
                  rules: {
					 new_password: {
						 required: true,
						 rangelength:[6,20]
					 },
					 new_confirm: {
						 required: true,
						 equalTo: "#new_password"
					 }
                     
                  },
				 messages: {
					 new_password: {
						 required: "<?php echo get_languageword('password_required');?>"
					 },
					 new_confirm: {
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