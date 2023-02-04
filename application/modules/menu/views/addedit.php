  <div id="page-wrapper">
           
               <div class="row">
                <div class="col-md-12">
				<?php echo $this->session->flashdata('message'); ?>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
						
                        <div class="panel-heading">
                            <?php if(isset($pagetitle)) echo $pagetitle;?>
							
							<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_MENU_INDEX; ?>"><i class="fa fa-list"></i>
							</a>
                        </div>
                        <div class="panel-body">
						 
                            <div class="row">
							<?php
						$attributes = array('name'=>'menu_from','id'=>'menu_from');
						echo form_open_multipart(URL_ADDEDIT_MENU,$attributes);?>
							
                       <div class="col-md-6">
                      	 
						<div class="form-group">
						 <label><?php echo get_languageword('menu_name').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->menu_name;
						}
						else if(isset($_POST))
						{
							$val = set_value('menu_name');
						}
						
						$element = array('name'=>'menu_name',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('menu_name');
						?>
					  </div>
					
					<div class="form-group">
						 <label><?php echo get_languageword('punch_line').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->punch_line;
						}
						else if(isset($_POST))
						{
							$val = set_value('punch_line');
						}
						
						$element = array('name'=>'punch_line',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('punch_line');
						?>
					  </div>
					  
					  <div class="form-group">
						 <label><?php echo get_languageword('description').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->description;
						}
						else if(isset($_POST))
						{
							$val = set_value('description');
						}
						
						$element = array('name'=>'description',
						'value'=>$val,												'maxlength'=>'100',
						'class'=>'form-control');
						echo form_textarea($element).form_error('description');
						?>
					  </div>
					  
					   <div class="form-group">
							<label><?php echo get_languageword('menu_image').required_symbol();?>(<small><strong><?php echo ALLOWED_TYPES;?></strong></small>)</label>
							<input type="file" name="menu_image_name" title="Menu Image" onchange="photo(this,'menu_image')">
							
							<?php 
							$src = "";
							$style="display:none;";
							if(isset($record->menu_image_name) && $record->menu_image_name != "" && file_exists(MENU_IMG_UPLOAD_PATH_URL.$record->menu_image_name)) 
							{
								$src = MENU_IMG_PATH.$record->menu_image_name;
								$style="";
							}
							?>
						<img id="menu_image" src="<?php echo $src;?>" style="<?php echo $style;?>"> 
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
						
						
						echo form_dropdown('status',$status_options,$val,'class="chzn-select form-control"').form_error('description');
						?>
					  </div>
					
					<div class="form-group pull-right">
						<?php 
						$value='';
						if(isset($record))
						{
							$value = $record->menu_id;
						}
						echo form_hidden('menu_id',$value);?>
						
						<button type="submit" name="addedit_menu" value="addedit_menu" class="btn btn-primary"><?php echo get_languageword('save');?></button>
						
						<a class="btn btn-warning" href="<?php echo URL_MENU_INDEX;?>"><?php echo get_languageword('cancel');?></a>
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
		
        $('#menu_from').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            /* feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }, */
			framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
                menu_name: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('menu_name_required');?>'
                        }
                    }
                },
                punch_line: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('punch_line_required');?>'
                        }
                    }
                },
				description: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('description_required');?>'
                        }
                    }
                },
				menu_image_name: {
                    validators: {
                       file: {
							extension: 'jpeg,jpg,png,gif,svg',
							type: 'image/jpeg,image/png,image/gif,image/svg',
							message: '<?php echo get_languageword('menu_image_is_not_valid_file');?>'
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

<script type="text/javascript" src="<?php echo JS_ADMIN_BOOTSTRAP_MAXLENGTH_MIN;?>"></script>
<script type="text/javascript">
    $('textarea').maxlength({
        alwaysShow: true,
        threshold: 10,
        warningClass: "label label-success",
        limitReachedClass: "label label-danger",
        separator: ' out of ',
        preText: 'You write ',
        postText: ' chars.',
        validate: true
    });
</script>