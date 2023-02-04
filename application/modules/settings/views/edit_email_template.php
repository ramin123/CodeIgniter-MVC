  <div id="page-wrapper">


               <div class="row">

                <div class="col-md-12">

				<?php echo $this->session->flashdata('message'); ?>

                    <!-- Form Elements -->

                    <div class="panel panel-default">

						

                        <div class="panel-heading">

                            <?php if(isset($pagetitle)) echo $pagetitle;?>
							
							<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_EMAIL_TEMPLATES;?>"><i class="fa fa-list"></i>
							</a>

                        </div>

                        <div class="panel-body">

						 

                            <div class="row">

							
							

                       <div class="col-md-6 cleafix">

                                 <?php

						$attributes = array('name'=>'email_template_from','id'=>'email_template_from');

						echo form_open(URL_EMAIL_TEMPLATES,$attributes);?>


						<div class="form-group">

						 <label><?php echo get_languageword('subject').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->subject;

						}

						else if(isset($_POST))

						{

							$val = set_value('subject');

						}

						

						$element = array('name'=>'subject',

						'value'=>$val,

						'class'=>'form-control',

						'readonly'=>true);

						echo form_input($element).form_error('subject');

						?>

					  </div>

					

					<div class="form-group">

						 <label><?php echo get_languageword('email_template').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->email_template;

						}

						else if(isset($_POST))

						{

							$val = set_value('email_template');

						}

						

						$element = array('name'=>'email_template',

						'value'=>$val,

						'class'=>'ckeditor');

						echo form_textarea($element).form_error('email_template');

						?>

					  </div>

					  

					

					<div class="form-group pull-right">

					

						<?php echo form_hidden('id',$record->id);?>

						<button type="submit" name="update_email_template" value="update_email_template" class="btn btn-primary"><?php echo get_languageword('update');?></button>

						

						<a class="btn btn-warning" href="<?php echo URL_EMAIL_TEMPLATES;?>"><?php echo get_languageword('cancel');?></a>

					</div>

					

					<?php echo form_close();?>

                        </div>

								

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





<script type="text/javascript">

    $(document).ready(function () {



        $('#email_template_from').bootstrapValidator({

            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later

            /* feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid: 'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            }, */

			framework: 'bootstrap',

            excluded: ':disabled',

            fields: {

                subject: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('subject_required');?>'

                        }

                    }

                },

                email_template: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('email_template_required');?>'

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

		