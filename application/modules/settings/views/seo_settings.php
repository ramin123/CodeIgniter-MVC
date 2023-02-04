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

							$attributes = array('name'=>'seo_settings_from','id'=>'seo_settings_from');

							echo form_open(URL_SEO_SETTINGS,$attributes);?>
							
                                <div class="col-md-6">
                               
                                        <div class="form-group">

                                            <label><?php echo get_languageword('meta_keyword');?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->meta_keyword;

											}

											else if(isset($_POST))

											{

												$val = set_value('meta_keyword');

											}

											

											$element = array('name'=>'meta_keyword',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('meta_keyword');

											?>

                                        </div>

										

										<div class="form-group">

                                            <label><?php echo get_languageword('meta_description');?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->meta_description;

											}

											else if(isset($_POST))

											{

												$val = set_value('meta_description');

											}

											

											$element = array('name'=>'meta_description',

											'value'=>$val,

											'class'=>'form-control');

											echo form_textarea($element).form_error('meta_description');

											?>

                                        </div>

										

                                        <div class="form-group">

                                            <label><?php echo get_languageword('google_analytics');?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->google_analytics;

											}

											else if(isset($_POST))

											{

												$val = set_value('google_analytics');

											}

											

											$element = array('name'=>'google_analytics',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('google_analytics');

											?>

                                        </div>

										
								<div class="form-group">

								<button type="submit" name="seo_settings" value="seo_settings" class="btn btn-primary"><?php echo get_languageword('update');?></button>

                                <a class="btn btn-warning" href="<?php echo URL_PAYPAL_SETTINGS;?>"><?php echo get_languageword('cancel');?></a>

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