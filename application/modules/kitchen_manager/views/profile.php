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

						$attributes = array('name'=>'profile_form','id'=>'profile_form');

						echo form_open_multipart(URL_KM_PROFILE,$attributes);?>

							

                       <div class="col-md-6">

                                 

						<div class="form-group">

						 <label><?php echo get_languageword('first_name').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->first_name;

						}

						else if(isset($_POST))

						{

							$val = set_value('first_name');

						}

						

						$element = array('name'=>'first_name',

						'value'=>$val,

						'class'=>'form-control');

						echo form_input($element).form_error('first_name');

						?>

					  </div>

					

					  <div class="form-group">

						 <label><?php echo get_languageword('last_name').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->last_name;

						}

						else if(isset($_POST))

						{

							$val = set_value('last_name');

						}

						

						$element = array('name'=>'last_name',

						'value'=>$val,

						'class'=>'form-control');

						echo form_input($element).form_error('last_name');

						?>

					  </div>

					  

					  <div class="form-group">

						 <label><?php echo get_languageword('email').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->email;

						}

						else if(isset($_POST))

						{

							$val = set_value('email');

						}

						

						$element = array('name'=>'email',

						'value'=>$val,

						'class'=>'form-control',

						'type'=>'email',

						'readonly'=>true);

						echo form_input($element).form_error('email');

						?>

					  </div>

					  

					  <div class="form-group">

						 <label><?php echo get_languageword('phone').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->phone;

						}

						else if(isset($_POST))

						{

							$val = set_value('phone');

						}

						

						$element = array('name'=>'phone',

						'value'=>$val,

						'class'=>'form-control');

						echo form_input($element).form_error('phone');

						?>

					  </div>

					  

					  

					 <div class="form-group">

							<label><?php echo get_languageword('profile_image').required_symbol();?>(<small><strong><?php echo ALLOWED_TYPES;?></strong></small>)</label>

							<input type="file" name="user_image" title="Profile Image" onchange="photo(this,'user_image')">

							

							<?php 

							$src = "";

							$style="display:none;";

							if(isset($record->photo) && $record->photo != "" && file_exists(USER_IMG_UPLOAD_PATH_URL.$record->photo)) 

							{

								$src = USER_IMG_PATH.$record->photo;

								$style="";

							}

							?>

						<img id="user_image" src="<?php echo $src;?>" style="<?php echo $style;?>"> 

					</div>

					

					

					

					<div class="form-group pull-right">

						<button type="submit" name="update_profile" value="update_profile" class="btn btn-primary"><?php echo get_languageword('update');?></button>

						

						<a class="btn btn-warning" href="<?php echo URL_KM_PROFILE;?>"><?php echo get_languageword('cancel');?></a>

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



<link href="<?php echo CSS_ADMIN_OR_BOOTSTRAP_VALIDATOR;?>" rel="stylesheet">

<script type="text/javascript" src="<?php echo JS_ADMIN_BOOTSTRAP_VALIDATOR;?>"></script>

<script type="text/javascript">

    $(document).ready(function () {

		

        $('#profile_form').bootstrapValidator({

            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later

            /* feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid: 'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            }, */

			framework: 'bootstrap',

            excluded: ':disabled',

            fields: {

                first_name: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('first_name_required');?>'

                        }

                    }

                },

                last_name: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('last_name_required');?>'

                        }

                    }

                },

				phone: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('phone_required');?>'

                        }

                    }

                },

				profile_image: {

                    validators: {

                       file: {

							extension: 'jpeg,jpg,png,gif,svg',

							type: 'image/jpeg,image/png,image/gif,image/svg',

							message: '<?php echo get_languageword('profile_image_is_not_valid_file');?>'

						}

                    }

                }

			

            },

			 submitHandler: function(validator, form, submitButton) {

				form.submit();

			}

        })

    });

</script>

<?php } ?>