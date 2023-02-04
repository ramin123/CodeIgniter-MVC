  <div id="page-wrapper">

           
               <div class="row">

                <div class="col-md-12">

				<?php echo $this->session->flashdata('message'); ?>

                    <!-- Form Elements -->

                    <div class="panel panel-default">

						

                        <div class="panel-heading">

                            <?php if(isset($pagetitle)) echo $pagetitle;?>

							

							<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_FAQS_CATEGORIES_INDEX; ?>"><i class="fa fa-list"></i>

							</a>

                        </div>

                        <div class="panel-body">

						 

                            <div class="row">

							<?php

						$attributes = array('name'=>'fc_from','id'=>'fc_from');

						echo form_open(URL_ADDEDIT_FAQS_CATEGORIES,$attributes);?>

							

                       <div class="col-md-6">

                                 

						<div class="form-group">

						 <label><?php echo get_languageword('category').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->category;

						}

						else if(isset($_POST))

						{

							$val = set_value('category');

						}

						

						$element = array('name'=>'category',

						'value'=>$val,

						'class'=>'form-control');

						echo form_input($element).form_error('category');

						?>

					  </div>


					<div class="form-group">

						 <label><?php echo get_languageword('status').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->status;

						}

						else if(isset($_POST))

						{

							$val = set_value('status');

						}

						

						

						echo form_dropdown('status',activeinactive(),$val,'class="chzn-select form-control"').form_error('description');

						?>

					  </div>

					

					<div class="form-group pull-right">

						<?php 

						$value='';

						if(isset($record))

						{

							$value = $record->fc_id;

						}

						echo form_hidden('fc_id',$value);?>

						

						<button type="submit" name="addedit_fc" value="addedit_fc" class="btn btn-primary"><?php echo get_languageword('save');?></button>

						

						<a class="btn btn-warning" href="<?php echo URL_FAQS_CATEGORIES_INDEX;?>"><?php echo get_languageword('cancel');?></a>

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

		

        $('#fc_from').bootstrapValidator({

            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later

            /* feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid: 'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            }, */

			framework: 'bootstrap',

            excluded: ':disabled',

            fields: {

                category: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('faq_category_required');?>'

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