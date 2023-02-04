  <div id="page-wrapper">

            <div>

       

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

							$attributes = array('name'=>'tinify_settings_from','id'=>'tinify_settings_from');

							echo form_open(URL_TINIFY_SETTINGS,$attributes);?>

                                <div class="col-md-6">

                   
	
	<div class="form-check">
    <label class="form-check-label">
      <input type="checkbox" name="use_tinify" value="1" <?php if(isset($record) && $record->use_tinify=='Yes') echo 'checked="checked"';?>> &nbsp;&nbsp;
<?php 
echo get_languageword('would_you_like_to_use_tinify_settings_for_images?'); ?>
    </label>
  </div>

  <br>
	
		<div class="form-group">

			<label><?php echo get_languageword('tinify_API_KEY');?>     <?php echo anchor('https://tinypng.com/','REFERENCE',array('target='=>'_blank'))?></label>

			<?php

			$val='';

			if(isset($record) && !empty($record))
			{
				$val = $record->API_Key;

			}
			else if(isset($_POST))

			{

				$val = set_value('API_Key');

			}

			$element = array('name'=>'API_Key',

			'value'=>$val,

			'class'=>'form-control');

			echo form_input($element).form_error('API_Key');

			?>

		</div>
		
		
		
		
	<div class="form-check">
    <label class="form-check-label">
      <input type="checkbox" name="compress" value="1" <?php if(isset($record) && $record->compress=='Yes') echo 'checked="checked"';?>> &nbsp;&nbsp;
     
	  <?php 
echo get_languageword('would_you_like_to_use_tinify_for_image_compression?'); ?>
    </label>
  </div>

  <br>
  
  
  <div class="form-check">
    <label class="form-check-label">
      <input type="checkbox" name="thumb" value="1" <?php if(isset($record) && $record->thumb=='Yes') echo 'checked="checked"';?>> &nbsp;&nbsp;
     
	  <?php 
echo get_languageword('would_you_like_to_use_tinify_for_create_image_thumbnails?'); ?>
    </label>
  </div>

  <br>
  
  
  
  <div class="form-group pull-right">
  
  <button type="submit" name="tinify_settings" value="tinify_settings" class="btn btn-primary"><?php echo get_languageword('update');?></button>
  
  <a class="btn btn-warning" href="<?php echo URL_TINIFY_SETTINGS;?>"><?php echo get_languageword('cancel');?></a>
 </div>	
										
					 

				</div>

				
				<div class="col-md-6">
				
				<div class="card-border">
					
					<p>First 500 images per month - Free</p>
					
					
					<div class="progress-label mb-1"><?php echo get_languageword('tinify_used_for');?> <?php echo $imgs_count;?> <?php echo get_languageword('images_in_current_month');?>  
					</div>
					
					<div class="progress">
						<div class="progress-bar bg-success" role="progressbar" style="width: 7px; height: 6px;" aria-valuenow="<?php echo $imgs_count;?>" aria-valuemin="0" aria-valuemax="500"></div>
					</div>
					
				</div>

				<?php echo form_close();?>

			</div>

		</div>

	</div>

	 <!-- End Form Elements -->

</div>

            </div>

    </div>

        <!-- /. PAGE INNER  -->

            </div>

        <!-- /. PAGE WRAPPER  -->