  <div id="page-wrapper">
                
               <div class="row">
                <div class="col-md-12">
				<?php echo $this->session->flashdata('message'); ?>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
						
                        <div class="panel-heading">
                            <?php if(isset($pagetitle)) echo $pagetitle;?>
							
							<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_CARDS_INDEX; ?>"><i class="fa fa-list"></i>
							</a>
                        </div>
                        <div class="panel-body">
						 
                            <div class="row">
							<?php
						$attributes = array('name'=>'card_from','id'=>'card_from');
						echo form_open_multipart(URL_ADDEDIT_CARD,$attributes);?>
							
                       <div class="col-md-6">
                            
					<div class="form-group">
							<label><?php echo get_languageword('card_image').required_symbol();?>(<small><strong><?php echo ALLOWED_TYPES;?></strong></small>)</label>
							<input type="file" name="card_image" title="Card Image" onchange="photo(this,'card_image')">
							
							<?php 
							$src = "";
							$style="display:none;";
							if(isset($record->image_name) && $record->image_name != "" && file_exists(CARD_IMG_UPLOAD_PATH_URL.$record->image_name)) 
							{
								$src = CARD_IMG_PATH.$record->image_name;
								$style="";
							}
							?>
						<img id="card_image" src="<?php echo $src;?>" style="<?php echo $style;?>"> 
					</div>
					
					<div class="form-group">
						 <label><?php echo get_languageword('alternative_text');?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->alt_text;
						}
						else if(isset($_POST))
						{
							$val = set_value('alt_text');
						}
						
						$element = array('name'=>'alt_text',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('alt_text');
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
						
						echo form_dropdown('status',activeinactive(),$val,'class="chzn-select form-control"').form_error('status');
						?>
				    </div>
					
					<div class="form-group pull-right">
						<?php 
						$value='';
						if(isset($record))
						{
							$value = $record->card_image_id;
						}
						echo form_hidden('card_image_id',$value);?>
						
						<button type="submit" name="addedit_card" value="addedit_card" class="btn btn-primary"><?php echo get_languageword('save');?></button>
						
						<a class="btn btn-warning" href="<?php echo URL_CARDS_INDEX;?>"><?php echo get_languageword('cancel');?></a>
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
		
        $('#card_from').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            /* feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }, */
			framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
                
				card_image: {
                    validators: {
                       file: {
							extension: 'jpeg,jpg,png,gif,svg',
							type: 'image/jpeg,image/png,image/gif,image/svg',
							message: '<?php echo get_languageword('card_image_is_not_valid_file');?>'
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