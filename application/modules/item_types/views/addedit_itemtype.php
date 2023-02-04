  <div id="page-wrapper">


               <div class="row">

                <div class="col-md-12">

				<?php echo $this->session->flashdata('message'); ?>

                    <!-- Form Elements -->

                    <div class="panel panel-default">

						

                        <div class="panel-heading">

                            <?php if(isset($pagetitle)) echo $pagetitle;?>

							

							<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_ITEM_TYPES_INDEX; ?>"><i class="fa fa-list"></i>

							</a>

                        </div>

                        <div class="panel-body">

						 

                            <div class="row">

							<?php

						$attributes = array('name'=>'item_type_from','id'=>'item_type_from');

						echo form_open(URL_ADDEDIT_ITEM_TYPE,$attributes);?>

                       <div class="col-md-6">

						<div class="form-group">

						 <label><?php echo get_languageword('item_type').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->item_type;

						}

						else if(isset($_POST))

						{

							$val = set_value('item_type');

						}

						

						$element = array('name'=>'item_type',

						'value'=>$val,

						'class'=>'form-control');

						echo form_input($element).form_error('item_type');

						?>

					  </div>

					

					<div class="form-group pull-right">

						<?php 

						$value='';

						if(isset($record))

						{

							$value = $record->item_type_id;

						}

						echo form_hidden('item_type_id',$value);?>

						

						<button type="submit" name="addedit_item_type" value="addedit_item_type" class="btn btn-primary"><?php echo get_languageword('save');?></button>

						

						<a class="btn btn-warning" href="<?php echo URL_ITEM_TYPES_INDEX;?>"><?php echo get_languageword('cancel');?></a>

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

		

        $('#item_type_from').bootstrapValidator({

            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later

            /* feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid: 'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            }, */

			framework: 'bootstrap',

            excluded: ':disabled',

            fields: {

                item_type: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('item_type_required');?>'

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