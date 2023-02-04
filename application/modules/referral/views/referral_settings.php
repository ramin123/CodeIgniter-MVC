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
						$attributes = array('name'=>'referral_from','id'=>'referral_from');
						echo form_open(URL_REFERRAL_SETTINGS,$attributes);?>
							
                       <div class="col-md-6">
                                 
						<div class="form-group">
						 <label><?php echo get_languageword('referral_enabled').required_symbol();?></label>
						<?php
						$checked=false;
						if(isset($record) && $record->referral_enabled=='Yes')
						{
							$checked='checked';
						}
						?>
						<div class="digiCrud">
						<div class="slideThree slideBlue">
						<input type="checkbox" class="crunch-vanish" id="referral_enabled" name="referral_enabled" <?php echo $checked;?> />
						<label for="referral_enabled"></label>
						</div>
						</div>
					  </div>
					  
					
					<div class="form-group">
						 <label><?php echo get_languageword('	points_for_referring_person').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->points_for_refer_anyone;
						}
						else if(isset($_POST))
						{
							$val = set_value('points_for_refer_anyone');
						}
						
						$element = array('name'=>'points_for_refer_anyone',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('points_for_refer_anyone');
						?>
					  </div>
					  
					  <div class="form-group">
						 <label><?php echo get_languageword('	points_for_referred_person').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->points_for_referred_by_anyone;
						}
						else if(isset($_POST))
						{
							$val = set_value('points_for_referred_by_anyone');
						}
						
						$element = array('name'=>'points_for_referred_by_anyone',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('points_for_referred_by_anyone');
						?>
					  </div>
					  
					 <div class="form-group pull-right">
						<button type="submit" name="update_referral" value="update_referral" class="btn btn-primary"><?php echo get_languageword('save');?></button>
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
		
        $('#referral_from').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            /* feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }, */
			framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
                points_for_refer_anyone: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('points_for_refer_anyone_required');?>'
                        }
                    }
                },
                points_for_referred_by_anyone: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('points_for_referred_by_anyone_required');?>'
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