  <div id="page-wrapper">
            
               <div class="row">
                <div class="col-md-12">
				<?php echo $this->session->flashdata('message'); ?>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
						
                        <div class="panel-heading">
                            <?php if(isset($pagetitle)) echo $pagetitle;?>
							
							<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_ITEMS_INDEX; ?>"><i class="fa fa-list"></i>
							</a>
                        </div>
                        <div class="panel-body">
						 
                            <div class="row">
							
							
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo get_languageword('item_details');?></a></li>

					<li role="presentation"><a href="#options" aria-controls="options" role="tab" data-toggle="tab"><?php echo get_languageword('options');?></a></li>
				</ul>	
				<!-- Nav tabs -->			
						
						
				 <!-- Tab panes -->	
				<div class="tab-content">

					<div role="tabpanel" class="tab-pane active" id="home">				 
						<?php
						$attributes = array('name'=>'item_from','id'=>'item_from');
						echo form_open_multipart(URL_EDIT_ITEM,$attributes);?>
							
                       <div class="col-md-6">
					   
					   <div class="form-group">
						 <label><?php echo get_languageword('menu').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->menu_id;
						}
						else if(isset($_POST))
						{
							$val = set_value('menu_id');
						}
						
						
						echo form_dropdown('menu_id',$menu_options,$val,'class="chzn-select form-control"').form_error('menu_id');
						?>
					  </div>
                                 
					<div class="form-group">
						<label><?php echo get_languageword('item_name').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->item_name;
						}
						else if(isset($_POST))
						{
							$val = set_value('item_name');
						}
						
						$element = array('name'=>'item_name',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('item_name');
						?>
					  </div>
					
					<div class="form-group">
						 <label><?php echo get_languageword('item_price').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->item_cost;
						}
						else if(isset($_POST))
						{
							$val = set_value('item_cost');
						}
						
						$element = array('name'=>'item_cost',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('item_cost');
						?>
					  </div>
					  
					  <div class="form-group">
						 <label><?php echo get_languageword('item_type').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->item_type_id;
						}
						else if(isset($_POST))
						{
							$val = set_value('item_type');
						}
						
						
						echo form_dropdown('item_type',$item_type_options,$val,'class="chzn-select form-control"').form_error('item_type');
						?>
					  </div>
					  
					  
					  <div class="form-group">
						<label><?php echo get_languageword('addons');?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $item_addons;
						}
						else if(isset($_POST))
						{
							$val = set_value('addons');
						}
						
						
						echo form_multiselect('addons[]',$addon_options,$val,'class="chzn-select form-control"').form_error('addons');
						?>
					  </div>
					  
					  <div class="form-group">
						 <label><?php echo get_languageword('is_it_popular_item').required_symbol();?></label>
						<?php
						
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->is_most_selling_item;
						}
						else if(isset($_POST))
						{
							$val = set_value('is_most_selling_item');
						}
						
						
						echo form_dropdown('is_most_selling_item',yesno(),$val,'class="chzn-select form-control"').form_error('is_most_selling_item');
						?>
					  </div>
					  
					 </div>
					 
					<div class="col-md-6">
					 
					  <div class="form-group">
						 <label><?php echo get_languageword('description').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->item_description;
						}
						else if(isset($_POST))
						{
							$val = set_value('item_description');
						}
						
						$element = array('name'=>'item_description',
						'value'=>$val,												'maxlength'=>'100',
						'class'=>'form-control');
						echo form_textarea($element).form_error('item_description');
						?>
					  </div>
					  
					   <div class="form-group">
							<label><?php echo get_languageword('item_image').required_symbol();?>(<small><strong><?php echo ALLOWED_TYPES;?></strong></small>) <br> <small>For better resolution min & max  width*height : 263*180 & 526*360 </small> </label>
							<input type="file" name="item_image" title="Item Image" onchange="photo(this,'item_image')">
							
							<?php 
							$src = "";
							$style="display:none;";
							if(isset($record->item_image_name) && $record->item_image_name != "" && file_exists(ITEM_IMG_UPLOAD_PATH_URL.$record->item_image_name)) 
							{
								$src = ITEM_IMG_PATH.$record->item_image_name;
								$style="";
							}
							?>
						<img id="item_image" src="<?php echo $src;?>" style="<?php echo $style;?>"> 
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
							$value = $record->item_id;
						}
						echo form_hidden('item_id',$value);?>
						
						<button type="submit" name="edit_item_save" value="edit_item_save" class="btn btn-primary"><?php echo get_languageword('save');?></button>
						
						<a class="btn btn-warning" href="<?php echo URL_ITEMS_INDEX;?>"><?php echo get_languageword('cancel');?></a>
					</div>
					
					
                        </div>
								<?php echo form_close();?>
						 </div>
                  
				  
				  <div role="tabpanel" class="tab-pane" id="options">

                  <div class="col-md-12">

				    <div class="col-md-4">
                      <div class="form-group">
                        <label><?php echo get_languageword('options');?><span style="color:red;">*</span></label>
                        <?php echo form_dropdown('option_name',$item_options,set_select('option_name'),'class="chzn-select form-control" id="option_name"').form_error('option_name');?>
                      </div>
                    </div>

                    <div class="col-md-4">

                      <label><?php echo get_languageword('price');?><span style="color:red;">*</span></label>

                      <?php echo form_input('price',set_value('price'),'id="price" class="form-control"'); ?>

                    </div>

                    <div class="col-md-4">  
                     <label><?php echo get_languageword('add_remove');?></label>
					 <input type="button" name="reset" class="btn btn-primary" onclick="AddOptionRow();" value="+">

					 <input type="button" name="add" class="btn btn-warning" onclick="removeOptionRow();" value="-">
                    </div>

					<?php 

					$attributes = array('name'=>'item_option','id'=>"item_option");

				  echo form_open(URL_EDIT_ITEM,$attributes); ?>

				   <input type="hidden" name="option_count" id="option_count" value="<?php if(isset($item_selected_options) && count($item_selected_options)>0) echo count($item_selected_options)+1; else echo "1";?>">

				    <input type="hidden" name="option_counts" id="option_counts">

				    <input type="hidden" name="item_id" value="<?php if(isset($record)) echo $record->item_id;?>">

                    <table class="table table-bordered" id="first" border="1">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th><?php echo get_languageword('options');?></th>
                          <th><?php echo get_languageword('price');?></th>
                        </tr>
                      </thead>
					
                      <tbody>
					  <?php
					  if(isset($item_selected_options) && !empty($item_selected_options)) {
						$i=1;
						$option_data = [];
						foreach($item_selected_options as $item_option):
						array_push($option_data,$item_option->option_id);
					  ?>
					  <tr>

					  <th scope="row"><?php echo $i; ?></th>

					  <td>

					  <input type="text" readonly name="option_name<?php echo $i; ?>" id="option_name<?php echo $i; ?>" value="<?php echo $item_option->option_name;?>" class="form-control">

					  </td>

					  <td>

					  <input type="hidden" value="<?php echo $item_option->option_id; ?>" name="option_id<?php echo $i;?>" id="option_id<?php echo $i;?>">

					  <input  type="text" value="<?php echo $item_option->price;?>" name="price<?php echo $i; ?>" id="price<?php echo $i; $i++; ?>" class="form-control">

					  </td>

					  </tr>

					  <?php endforeach; } ?>

                      </tbody>
					  
                    </table>

                    <div class="form-group pull-right">
					<button type="submit" name="item_options_save" class="btn btn-primary"><?php echo get_languageword('add');?></button>
                    </div>

					<?php echo form_close(); ?>

                  </div>

                </div>
				
				 
                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
    </div>
        <!-- /. PAGE INNER  -->
          
        <!-- /. PAGE WRAPPER  -->
		
		
<!-- Form Validation Plugins /Start -->
<?php if(!empty($css_js_files) && in_array('form_validation', $css_js_files)) { ?>

<link href="<?php echo CSS_ADMIN_OR_BOOTSTRAP_VALIDATOR;?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo JS_ADMIN_BOOTSTRAP_VALIDATOR;?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
		
        $('#item_from').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            /* feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }, */
			framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
				menu_id: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('menu_required');?>'
                        }
                    }
                },
                item_name: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('item_name_required');?>'
                        }
                    }
                },
                item_cost: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('item_price_required');?>'
                        }
                    }
                },
				item_type: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('item_type_required');?>'
                        }
                    }
                },
				item_description: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('item_description_required');?>'
                        }
                    }
                },
				item_image: {
                    validators: {
                       file: {
							extension: 'jpeg,jpg,png,gif,svg',
							type: 'image/jpeg,image/png,image/gif,image/svg',
							message: '<?php echo get_languageword('item_image_is_not_valid_file');?>'
						}
                    }
                }
			
            },
			 submitHandler: function(validator, form, submitButton) {
				form.submit();
			}
        });
		
		 $('#item_option').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            /* feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }, */
			framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
				option_counts: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('select_atleast_one_option');?>'
                        }
                    }
                }
                
            },
			 submitHandler: function(validator, form, submitButton) {
				form.submit();
			}
        });
		
    });
</script>

<link href="<?php echo ALERTIFY_MIN_CSS;?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo ALERTIFY_MIN_JS;?>"></script>
<script type="text/javascript">
var option_data = [];
$(document).ready(function(){
	<?php 
	 if(isset($item_selected_options) && !empty($item_selected_options)){
		 //echo "<pre>";print_R($item_selected_options);die();
		foreach($item_selected_options as $p):?>
		option_data.push('<?php echo $p->option_id;?>');
	 <?php endforeach; ?>   
	 $('#option_counts').val(option_data.length);
	 <?php } ?>
});

function AddOptionRow() 
{		
    var option_id = $('#option_name option:selected').val();

    if($('#option_name').val()=="")
    {
		alertify.error("<?php echo get_languageword('select_option');?>");
    }
    else if($('#price').val()=="")
    {
  	   alertify.error("<?php echo get_languageword('price_required');?>");
    }

    else if(isNaN($('#price').val()))
    {
  	   alertify.error("<?php echo get_languageword('please_enter_proper_value_for_price_field');?>");
    }
	else if(in_array(option_id,option_data))
	{
  	   alertify.error("<?php echo get_languageword('already_existed');?>");
    }
    else
    { 
  	   var cnt=$("#option_count").val();
  	   var ncnt = cnt;
  	   var sno = cnt;
	   
  	   $('#first tr').last().after('<tr><th scope="row">'+sno+'</th><td><input type="text" readonly name="option_name'+ncnt+'" id="option_name'+ncnt+'" value="'+$('#option_name option:selected').text()+'" class="form-control"></td><td><input type="hidden" readonly value="'+$('#option_name option:selected').val()+'" name="option_id'+ncnt+'" id="option_id'+ncnt+'"><input  type="text" value="'+$('#price').val()+'" name="price'+ncnt+'" id="price'+ncnt+'" class="form-control"></td></tr>');


  	   cnt=++cnt;
  	   $("#option_count").val(cnt);
  	   $("#option_counts").val(cnt);
  	   option_data.push(option_id);
    }
}
function in_array(search, array)
{
	for (i = 0; i < array.length; i++) 
	{
		if(array[i] ==search )
		{
			return true;
		}
	}
	return false;
}
function removeOptionRow()
{
    table = document.getElementById("first");
    var rowno = table.rows.length;

    if(table.rows.length > 1)
    {
  	   var cnt=$("#option_count").val();
  	   var ncnt = --cnt;	
  	   var option_id = $('#option_id'+ncnt).val();

  	    option_data = jQuery.grep(option_data, function(value) {
  			return value != option_id;
  		});

  		<?php if(isset($option_data)){ ?>
			table.deleteRow(rowno -1);
		<?php } else {?>
			$('#first tr:last-child').remove();
		 <?php } ?>
  	   $("#option_count").val(ncnt);
  	   $("#option_counts").val(ncnt);	
    }
    $("#option_counts").val("");
}
</script>
<?php } ?><script type="text/javascript" src="<?php echo JS_ADMIN_BOOTSTRAP_MAXLENGTH_MIN;?>"></script><script type="text/javascript">$('textarea').maxlength({	  alwaysShow: true,	  threshold: 10,	  warningClass: "label label-success",	  limitReachedClass: "label label-danger",	  separator: ' out of ',	  preText: 'You write ',	  postText: ' chars.',	  validate: true});</script>