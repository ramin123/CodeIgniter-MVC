  <div id="page-wrapper">

               <div class="row">

                <div class="col-md-12">

				<?php echo $this->session->flashdata('message'); ?>

                    <!-- Form Elements -->

                    <div class="panel panel-default">

						

                        <div class="panel-heading">

                            <?php if(isset($pagetitle)) echo $pagetitle;?>

                        </div>

						

                        <div class="panel-body">

						 

                            <div class="row">

							<?php

						$attributes = array('name'=>'password_form','id'=>'password_form');

						echo form_open(URL_DM_CHANGE_PASSWORD,$attributes);?>

							

                       <div class="col-md-6">

                                 

						<div class="form-group">

						 <label><?php echo get_languageword('current_password').required_symbol();?></label>

						<?php echo form_input($old_password);?>

					    </div>

					

						<div class="form-group">

						 <label><?php echo get_languageword('new_password').required_symbol();?></label>

						<?php echo form_input($new_password);?>

					    </div>

					

						<div class="form-group">

						 <label><?php echo get_languageword('new_confirm_password').required_symbol();?></label>

						<?php echo form_input($new_password_confirm);?>

					    </div>

						

					<div class="form-group pull-right">

						<button type="submit" name="change_pwd" value="change_pwd" class="btn btn-primary"><?php echo get_languageword('change');?></button>

						

						<a class="btn btn-warning" href="<?php echo URL_DM_CHANGE_PASSWORD;?>"><?php echo get_languageword('cancel');?></a>

					</div>

					

					

                        </div>

								<?php echo form_close();?>

                            </div>

                        </div>

                    </div>

                     <!-- End Form Elements -->

                </div>

            </div>

   

        <!-- /. PAGE INNER  -->

            </div>

        <!-- /. PAGE WRAPPER  -->

		

		

<!-- Form Validation Plugins /Start -->

<?php if(!empty($css_js_files) && in_array('form_validation', $css_js_files)) { ?>

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

              $("#password_form").validate({

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

<?php } ?>