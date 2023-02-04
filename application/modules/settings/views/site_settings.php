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
							$attributes = array('name'=>'site_settings_from','id'=>'site_settings_from');
							echo form_open_multipart(URL_SITE_SETTINGS,$attributes);?>
                                <div class="col-md-6">
                                   
                                        <div class="form-group">
                                            <label><?php echo get_languageword('site_title').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->site_title;
											}
											else if(isset($_POST))
											{
												$val = set_value('site_title');
											}
											
											$element = array('name'=>'site_title',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('site_title');
											?>
                                        </div>
										
                                        <div class="form-group">
                                            <label><?php echo get_languageword('address').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->address;
											}
											else if(isset($_POST))
											{
												$val = set_value('address');
											}
											
											$element = array('name'=>'address',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('address');
											?>
                                        </div>
										
										<div class="form-group">
                                            <label><?php echo get_languageword('city').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->city;
											}
											else if(isset($_POST))
											{
												$val = set_value('city');
											}
											
											$element = array('name'=>'city',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('city');
											?>
                                        </div>
										
										<div class="form-group">
                                            <label><?php echo get_languageword('state').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->state;
											}
											else if(isset($_POST))
											{
												$val = set_value('state');
											}
											
											$element = array('name'=>'state',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('state');
											?>
                                        </div>
										
										<div class="form-group">
                                            <label><?php echo get_languageword('country').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->country;
											}
											else if(isset($_POST))
											{
												$val = set_value('country');
											}
											
											$element = array('name'=>'country',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('country');
											?>
                                        </div>
										
										
                                        <div class="form-group">
                                            <label><?php echo get_languageword('pincode').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->zip;
											}
											else if(isset($_POST))
											{
												$val = set_value('zip');
											}
											
											$element = array('name'=>'zip',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('zip');
											?>
                                        </div>
                                       
                                         <div class="form-group">
                                            <label><?php echo get_languageword('latitude').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->latitude;
											}
											else if(isset($_POST))
											{
												$val = set_value('latitude');
											}
											
											$element = array('name'=>'latitude',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('latitude');
											?>
                                        </div>
										
										 <div class="form-group">
                                            <label><?php echo get_languageword('longitude').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->longitude;
											}
											else if(isset($_POST))
											{
												$val = set_value('longitude');
											}
											
											$element = array('name'=>'longitude',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('longitude');
											?>
                                        </div>
										
										 <div class="form-group">
                                            <label><?php echo get_languageword('ios_url');?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->ios_url;
											}
											else if(isset($_POST))
											{
												$val = set_value('ios_url');
											}
											
											$element = array('name'=>'ios_url',
											'value'=>$val,
											'class'=>'form-control',
											'type'=>'url');
											echo form_input($element).form_error('ios_url');
											?>
                                        </div>
										
										<div class="form-group">
                                            <label><?php echo get_languageword('android_url');?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->android_url;
											}
											else if(isset($_POST))
											{
												$val = set_value('android_url');
											}
											
											$element = array('name'=>'android_url',
											'value'=>$val,
											'class'=>'form-control',
											'type'=>'url');
											echo form_input($element).form_error('android_url');
											?>
                                        </div>
										
										<!--div class="form-group">
                                            <label><?php //echo get_languageword('facebook_api').required_symbol().' '.'('.'<small>'.get_languageword('app').'</small>'.')';?></label>
											<?php
											/* $val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->facebook_api;
											}
											else if(isset($_POST))
											{
												$val = set_value('facebook_api');
											}
											
											$element = array('name'=>'facebook_api',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('facebook_api'); */
											?>
                                        </div>
										
										<div class="form-group">
                                            <label><?php //echo get_languageword('google_api').required_symbol().' '.'('.'<small>'.get_languageword('app').'</small>'.')';?></label>
											<?php
											/* $val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->google_api;
											}
											else if(isset($_POST))
											{
												$val = set_value('google_api');
											}
											
											$element = array('name'=>'google_api',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('google_api'); */
											?>
                                        </div-->
										
										
																			<div class="form-group">
		<label><?php echo get_languageword('facebook_app_id').required_symbol().' '.'('.'<small>'.get_languageword('web').'</small>'.')';?></label>	
		<?php										
			$val='';										
			if(isset($record) && !empty($record))
			{											
				$val = $record->facebook_app_id;
			}										
			else if(isset($_POST))
			{											
				$val = set_value('facebook_app_id');
			}															$element = array('name'=>'facebook_app_id',					'value'=>$val,							 'class'=>'form-control');
			echo form_input($element).form_error('facebook_app_id');?>									
			</div>
			
			<div class="form-group">
		<label><?php echo get_languageword('facebook_app_secret').required_symbol().' '.'('.'<small>'.get_languageword('web').'</small>'.')';?></label>	<?php
																			$val='';										
		if(isset($record) && !empty($record))
		{											
			$val = $record->facebook_app_secret;
		}
		else if(isset($_POST))										{											
			$val = set_value('facebook_app_secret');
		}																$element = array('name'=>'facebook_app_secret',					'value'=>$val,
						'class'=>'form-control');
		echo form_input($element).form_error('facebook_app_secret');?>									
		</div>


						
				<div class="form-group">
					<label><?php echo get_languageword('google_client_id').required_symbol().' '.'('.'<small>'.get_languageword('web').'</small>'.')';?></label>
					<?php
					$val='';
					if(isset($record) && !empty($record))
					{
						$val = $record->google_client_id;
					}
					else if(isset($_POST))
					{
						$val = set_value('google_client_id');
					}
					
					$element = array('name'=>'google_client_id',
					'value'=>$val,
					'class'=>'form-control');
					echo form_input($element).form_error('google_client_id');
					?>
				</div>
				
				
				<div class="form-group">
					<label><?php echo get_languageword('google_client_secret').required_symbol().' '.'('.'<small>'.get_languageword('web').'</small>'.')';?></label>
					<?php
					$val='';
					if(isset($record) && !empty($record))
					{
						$val = $record->google_client_secret;
					}
					else if(isset($_POST))
					{
						$val = set_value('google_client_secret');
					}
					
					$element = array('name'=>'google_client_secret',
					'value'=>$val,
					'class'=>'form-control');
					echo form_input($element).form_error('google_client_secret');
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
										<label><?php echo get_languageword('land_line').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->land_line;
										}
										else if(isset($_POST))
										{
											$val = set_value('land_line');
										}
										
										$element = array('name'=>'land_line',
										'value'=>$val,
										'class'=>'form-control');
										echo form_input($element).form_error('land_line');
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo get_languageword('fax').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->fax;
										}
										else if(isset($_POST))
										{
											$val = set_value('fax');
										}
										
										$element = array('name'=>'fax',
										'value'=>$val,
										'class'=>'form-control');
										echo form_input($element).form_error('fax');
										?>
									</div>
									
								 	<div class="form-group">										<label><?php echo get_languageword('contact_email').required_symbol();?></label>										<?php										$val='';										if(isset($record) && !empty($record))										{											$val = $record->portal_email;										}										else if(isset($_POST))										{											$val = set_value('portal_email');										}																				$element = array('name'=>'portal_email',										'value'=>$val,										'class'=>'form-control',										'type'=>'email');										echo form_input($element).form_error('portal_email');										?>									</div>
									
									
									<div class="form-group">										<label><?php echo get_languageword('site_language').required_symbol();?></label>										<?php										$val='';										if(isset($record) && !empty($record))										{											$val = $record->site_language;										}										else if(isset($_POST))										{											$val = set_value('site_language');										}																				echo form_dropdown('site_language',$lang_opts,$val,'class="form-control chzn-select" ');										echo form_error('site_language');										?>									</div>
									
									
									<div class="form-group">
										<label><?php echo get_languageword('site_country').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->site_country;
										}
										else if(isset($_POST))
										{
											$val = set_value('site_country');
										}
										
										$element = array('name'=>'site_country',
										'value'=>$val,
										'class'=>'form-control',
										'placeholder'=>'US');
										echo form_input($element).form_error('site_country');
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo get_languageword('time_zone').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->time_zone;
										}
										else if(isset($_POST))
										{
											$val = set_value('time_zone');
										}
										
										echo form_dropdown('time_zone',$time_zone_options,$val,'class="form-control chzn-select" ');
										echo form_error('time_zone');
										?>
									</div>


									<div class="form-group">
										<label><?php echo get_languageword('contact_map').required_symbol();?> <a href="https://www.embedgooglemap.net/" target="_blank" title="Generate script here">Generate script here</a> </label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->contact_map_script;
										}
										else if(isset($_POST))
										{
											$val = set_value('contact_map_script');
										}
										
										$element = array('name'=>'contact_map_script',
										'value'=>$val,
										'class'=>'form-control',
										'placeholder'=>'Contact map script');
										echo form_input($element).form_error('contact_map_script');
										?>
									</div>
									

								</div>
                                
                                <div class="col-md-6">
								
									<div class="form-group">
										<label><?php echo get_languageword('currency').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->currency;
										}
										else if(isset($_POST))
										{
											$val = set_value('currency');
										}
										
										echo form_dropdown('currency',$currency_opts,$val,'class="form-control chzn-select" ');
										echo form_error('currency');
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo get_languageword('currency_symbol').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->currency_symbol;
										}
										else if(isset($_POST))
										{
											$val = set_value('currency_symbol');
										}
										
										$element = array('name'=>'currency_symbol',
										'value'=>$val,
										'class'=>'form-control');
										echo form_input($element).form_error('currency_symbol');
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo get_languageword('country_code').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->country_code;
										}
										else if(isset($_POST))
										{
											$val = set_value('country_code');
										}
										
										$element = array('name'=>'country_code',
										'value'=>$val,
										'class'=>'form-control');
										echo form_input($element).form_error('country_code');
										?>
									</div>
									
									<label><?php echo get_languageword('restaurant_timings').required_symbol();?></label>
									<div class="form-group">
										
										<div class="col-md-6 input-append date crunchy-append clearfix" id="datetimepicker">
										<small><?php echo get_languageword('from');?></small><span class="add-on">
										<i class="fa fa-clock-o"></i>
										</span>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->from_time;
										}
										else if(isset($_POST))
										{
											$val = set_value('from_time');
										}
										
										$element = array('name'=>'from_time',
										'value'=>$val,
										'class'=>'form-control',
										'data-format'=>'hh:mm');
										echo form_input($element).form_error('from_time');
										?>
										
										</div>
										
										<div id="datetimepickerto" class="col-md-6 input-append date  clearfix">
										<small><?php echo get_languageword('to');?></small><span class="add-on">
										<i class="fa fa-clock-o"></i>
										</span>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->to_time;
										}
										else if(isset($_POST))
										{
											$val = set_value('to_time');
										}
										
										$element = array('name'=>'to_time',
										'value'=>$val,
										'class'=>'form-control',
										'data-format'=>'hh:mm');
										echo form_input($element).form_error('to_time');
										?>
										</div>
									</div>
									
									<label class="crunchy-field"><?php echo get_languageword('notifications');?></label>

									<div class="form-group">
									<div class="col-md-6 cruncy-checkbox">
									<small><?php echo get_languageword('sms_notifications');?></small>
									<?php $checked='';
									if(isset($record) && $record->sms_notifications=='Yes')
									{
										$checked='checked';
									}?>
									
									<div class="digiCrud">
									<div class="slideThree slideBlue">
									<input type="checkbox" class="crunch-vanish" id="sms_notifications" name="sms_notifications" <?php echo $checked; ?> />
									<label for="sms_notifications"></label>
									</div>
									</div>
									
									</div>
									
									
									<!--div class="col-md-6 cruncy-checkbox">
									<small><?php //echo get_languageword('push_notifications');?></small>
									<?php /* $checked='';
									if(isset($record) && $record->fcm_push_notifications=='Yes')
									{
										$checked='checked';
									} */?>
									
									<div class="digiCrud">
									<div class="slideThree slideBlue">
									<input type="checkbox" class="crunch-vanish" id="fcm_push_notifications" name="fcm_push_notifications" <?php //echo $checked; ?>/>
									<label for="fcm_push_notifications"></label>
									</div>
									</div>
									</div-->
									
									</div>
									
									
									<div class="col-md-12 crunchy-design">
									<label><?php echo get_languageword('design_by').required_symbol();?></label></div>
									<div class="form-group">
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->design_by;
										}
										else if(isset($_POST))
										{
											$val = set_value('design_by');
										}
										
										$element = array('name'=>'design_by',
										'value'=>$val,
										'class'=>'form-control');
										echo form_input($element).form_error('design_by');
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo get_languageword('rights_reserved').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->rights_reserved_content;
										}
										else if(isset($_POST))
										{
											$val = set_value('rights_reserved_content');
										}
										
										$element = array('name'=>'rights_reserved_content',
										'value'=>$val,
										'class'=>'form-control');
										echo form_input($element).form_error('rights_reserved_content');
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo get_languageword('date_format').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->date_format;
										}
										else if(isset($_POST))
										{
											$val = set_value('date_format');
										}
										
										$options=array('Y-m-d'=>'YYYY-MM-DD',
										'Y.m.d'=>'YYYY.MM.DD',
										'd-m-Y'=>'DD-MM-YYYY',
										'd/m/Y'=>'DD/MM/YYYY',
										'd.m.Y'=>'DD.MM.YYYY',
										'm-d-Y'=>'MM-DD-YYYY',
										'm/d/Y'=>'MM/DD/YYYY',
										'm.d.Y'=>'MM.DD.YYYY'
										);
										echo form_dropdown('date_format',$options,$val,'class="form-control chzn-select" ');
										echo form_error('date_format');
										?>
									</div>
									
									
									<div class="form-group">
										<label><?php echo get_languageword('payment_methods').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record->payment_methods))
										{
											$val = explode(',',$record->payment_methods);
										}
										else if(isset($_POST))
										{
											$val = set_value('payment_methods');
										}
										
										$options=array('online'=>get_languageword('online'),
										'cash_on_delivery'=>get_languageword('cash_on_delivery'),
										'card_on_delivery'=>get_languageword('card_on_delivery')
										);
										echo form_multiselect('payment_methods[]',$options,$val,'class="form-control chzn-select" ');
										echo form_error('payment_methods');
										?>
									</div>
									
									
									
									
									
									<div class="form-group">
										<label><?php echo get_languageword('home_page_caption').required_symbol();?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->home_page_caption;
										}
										else if(isset($_POST))
										{
											$val = set_value('home_page_caption');
										}
										
										$element = array('name'=>'home_page_caption',
										'value'=>$val,
										'class'=>'form-control');
										echo form_input($element).form_error('home_page_caption');
										?>
									</div>
									
									<div class="form-group">
										<label><?php echo get_languageword('home_page_tagline');?></label>
										<?php
										$val='';
										if(isset($record) && !empty($record))
										{
											$val = $record->home_page_tagline;
										}
										else if(isset($_POST))
										{
											$val = set_value('home_page_tagline');
										}
										
										$element = array('name'=>'home_page_tagline',
										'value'=>$val,
										'class'=>'form-control');
										echo form_input($element).form_error('home_page_tagline');
										?>
									</div>
									
									 <div class="form-group">
                                        <label><?php echo get_languageword('fevicon').required_symbol();?>(<small><strong><?php echo ALLOWED_FEVICON_TYPES;?></strong></small>)</label>
                                        <input type="file" name="fevicon" title="Fevicon" onchange="photo(this,'feviconn')">
										
										<?php 
										$src = "";
										$style="display:none;";
										if(isset($record->fevicon) && $record->fevicon != "" && file_exists(FEVICON_IMG_UPLOAD_PATH_URL.$record->fevicon)) 
										{
											$src = FEVICON_IMG_PATH.$record->fevicon;
											$style="";
										}
										?>
									<img id="feviconn" src="<?php echo $src;?>" style="<?php echo $style;?>"> 
                                     </div>
									 
									 <div class="form-group">
                                        <label><?php echo get_languageword('home_page_site_logo').required_symbol();?>(<small><strong><?php echo ALLOWED_TYPES;?></strong></small>)</label>
                                        <input type="file" name="site_logo" title="Primary Site Logo" onchange="photo(this,'site_logoo')">
										
										<?php 
										$src = "";
										$style="display:none;";
										if(isset($record->site_logo) && $record->site_logo != "" && file_exists(LOGO_IMG_UPLOAD_PATH_URL.$record->site_logo)) 
										{
											$src = LOGO_IMG_PATH.$record->site_logo;
											$style="";
										}
										?>
									<img id="site_logoo" src="<?php echo $src;?>" style="<?php echo $style;?>" alt="Primary Site Logo"> 
                                     </div>
									 
									 
									 
									  
									 <div class="form-group">
                                        <label><?php echo get_languageword('other_pages_site_logo').required_symbol();?>(<small><strong><?php echo ALLOWED_TYPES;?></strong></small>)</label>
                                        <input type="file" name="second_site_logo" title="Secondary Site Logo" onchange="photo(this,'second_site_logoo')">
										
										<?php 
										$src = "";
										$style="display:none;";
										if(isset($record->second_site_logo) && $record->second_site_logo != "" && file_exists(LOGO_IMG_UPLOAD_PATH_URL.$record->second_site_logo)) 
										{
											$src = LOGO_IMG_PATH.$record->second_site_logo;
											$style="";
										}
										?>
									<img id="second_site_logoo" src="<?php echo $src;?>" style="<?php echo $style;?>" alt="Secondary Site Logo"> 
                                     </div>
									 
									 
									 
									  <div class="form-group">
                                        <label><?php echo get_languageword('home_page_image').required_symbol();?>(<small><strong><?php echo ALLOWED_TYPES;?></strong> </small>) <small>(min & max height*width: 1980*448 & 2000*500)</small> </label>
                                        <input type="file" name="home_page_img" title="Home Page Background Image" onchange="photo(this,'home_page_imge')">
										
										<?php 
										$src = "";
										$style="display:none;";
										if(isset($record->home_page_img) && $record->home_page_img != "" && file_exists(HOME_PAGE_IMG_UPLOAD_PATH_URL.$record->home_page_img)) 
										{
											$src = HOME_PAGE_IMG_PATH.$record->home_page_img;
											$style="";
										}
										?>
									<img id="home_page_imge" src="<?php echo $src;?>" style="<?php echo $style;?>" alt="Home Page Background Image"> 
                                     </div>
									   
									
									<button type="submit" name="site_settings" value="site_settings" class="btn btn-primary"><?php echo get_languageword('update');?></button>
                                    <a class="btn btn-warning" href="<?php echo URL_SITE_SETTINGS;?>"><?php echo get_languageword('cancel');?></a>
										
										
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

        $('#site_settings_from').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            /* feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }, */
			framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
                site_title: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('site_title_is_required');?>'
                        }
                    }
                },
               /*  site_name: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('site_name_is_required');?>'
                        }
                        
                    }
                }, */
				address: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('address_is_required');?>'
                        }
                        
                    }
                },
				city: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('city_is_required');?>'
                        }
                        
                    }
                },
				state: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('state_is_required');?>'
                        }
                        
                    }
                },
				country: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('country_is_required');?>'
                        }
                        
                    }
                },
				zip: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('pincode_is_required');?>'
                        }
                        
                    }
                },
				latitude: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('latitude_is_required');?>'
                        }
                        
                    }
                },
				longitude: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('longitude_is_required');?>'
                        }
                        
                    }
                },
				phone: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('phone_number_is_required');?>'
                        }
                        
                    }
                },
				land_line: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('landline_number_is_required');?>'
                        }
                        
                    }
                },
				fax: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('fax_is_required');?>'
                        }
                        
                    }
                },
				portal_email: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('contact_email_is_required');?>'
                        }
                        
                    }
                },
				site_country: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('site_country_is_required');?>'
                        }
                        
                    }
                },
				site_language: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('site_language_is_required');?>'
                        }
                        
                    }
                },
				currency: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('currency_is_required');?>'
                        }
                        
                    }
                },
				currency_symbol: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('currency_symbol_is_required');?>'
                        }
                        
                    }
                },
				country_code: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('country_code_is_required');?>'
                        }
                        
                    }
                },
				time_zone: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('time_zone_is_required');?>'
                        }
                        
                    }
                },
				from_time: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('restaurant_from_time_is_required');?>'
                        }
                        
                    }
                },
				to_time: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('restaurant_to_time_is_required');?>'
                        }
                        
                    }
                },
				design_by: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('design_by_is_required');?>'
                        }
                        
                    }
                },
				rights_reserved_content: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('rights_reserved_is_required');?>'
                        }
                        
                    }
                },
				home_page_caption: {
					 validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('home_page_caption_required');?>'
                        }
                        
                    }
				},					
				facebook_app_id: {                    
				validators: {                        
					notEmpty: {                            
						message: '<?php echo get_languageword('facebook_app_id_required');?>'
						}                                            
					}   
				},				
				facebook_app_secret: {                    
				validators: {                        
					notEmpty: {                            
						message: '<?php echo get_languageword('facebook_app_secret_required');?>'
					}                                            
					}
				},
				google_client_id: {                    
				validators: {                        
					notEmpty: {                            
						message: '<?php echo get_languageword('google_client_id_required');?>'
						}                                            
					}   
				},	
				google_client_secret: {                    
				validators: {                        
					notEmpty: {                            
						message: '<?php echo get_languageword('google_client_secret_required');?>'
						}                                            
					}   
				},	
				"payment_methods[]": {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('payment_methods_required');?>'
                        }
                        
                    }
                },
				site_logo: {
					validators: {
						file: {
							extension: 'jpeg,jpg,png,gif,svg',
							type: 'image/jpeg,image/png,image/gif,image/svg',
							message: '<?php echo get_languageword('home_page_site_logo_file_is_not_valid');?>'
						}
                    }
				},
				second_site_logo: {
					validators: {
						file: {
							extension: 'jpeg,jpg,png,gif,svg',
							type: 'image/jpeg,image/png,image/gif,image/svg',
							message: '<?php echo get_languageword('inner_pages_site_logo_file_is_not_valid');?>'
						}
                    }
				},
				home_page_img: {
					validators: {
						file: {
							extension: 'jpeg,jpg,png,gif,svg',
							type: 'image/jpeg,image/png,image/gif,image/svg',
							message: '<?php echo get_languageword('home_page_image_file_is_not_valid');?>'
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

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CSS_TIMEPICKER_MIN;?>">
<script type="text/javascript" src="<?php echo JS_TIMEPICKER_MIN;?>"></script>  
<script type="text/javascript">
  $('#datetimepicker,#datetimepickerto').datetimepicker({
   pickDate: false,
   pick12HourFormat:true,
   pickSeconds: false
  });
</script>

<?php } ?>		