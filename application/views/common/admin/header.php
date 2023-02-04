<!DOCTYPE html>
<html lang="<?php echo get_language_code();?>" dir="<?php echo language_type();?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="<?php echo get_fevicon();?>"/>
    <title> <?php if(isset($pagetitle)) echo $pagetitle;?> :: <?php echo get_languageword('admin_panel');?> :: </title>

    <?php if($this->config->item('site_settings')->admin_css=='orange') {?>
    <link href="<?php echo CSS_ORANGE_ADMIN;?>" rel="stylesheet" />
    <?php } ?>
	
	<!--CHOSEN CSS-->
	<link href="<?php echo CSS_CHOSEN_MIN;?>" rel="stylesheet" />
	
	
     <!-- GOOGLE FONTS-->
   <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> -->

    <link href="<?php echo CSS_FRONT;?>fonts.css" rel="stylesheet">
   
   <?php if(isset($css_js_files) && in_array('image_crud',$css_js_files)) {?>
   <link type="text/css" rel="stylesheet" href="<?php echo IMAGE_CRUD_FINEUPLOADER_CSS;?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo IMAGE_CRUD_PHOTOGALLARY_CSS;?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo IMAGE_CRUD_COLORBOX_CSS;?>"/>
   <?php } ?>
   
   <!-- DATEPICKER Scripts Start -->
<?php if(!empty($css_js_files) && in_array("datepicker",$css_js_files)) { ?>
<link href="<?php echo DATEPICKER_CSS;?>" rel="stylesheet"/>
<?php } ?>
 
    <!-- JQUERY SCRIPTS -->
    <script language="javascript" type="text/javascript">
 function lanfTrans(lan)
 {
   switch(lan)
   {
   case 'en': document.getElementById('dlang').value='en';document.langForm.submit(); break;
   case 'fr': document.getElementById('dlang').value='fr'; document.langForm.submit(); break;
   case 'es': document.getElementById('dlang').value='es'; document.langForm.submit(); break;
   } 
 }
</script>
    <script type="text/javascript" src="<?php echo JS_ADMIN_JQUERY;?>"></script>

    

      <!-- BOOTSTRAP SCRIPTS -->
    <script type="text/javascript" src="<?php echo JS_ADMIN_BOOTSTRAP;?>"></script>
	<?php if(isset($edit_email_template) && $edit_email_template==1) {?>
	<link href="<?php echo CSS_ADMIN_OR_BOOTSTRAP_VALIDATOR;?>" rel="stylesheet">

	<script type="text/javascript" src="<?php echo JS_ADMIN_BOOTSTRAP_VALIDATOR;?>"></script>
	<?php } ?>
</head>
<body>
    <div id="wrapper">
<form name="langForm" id="langForm" action="<?php echo base_url().'welcome/languages';?>" method="post"> 

<?php // 'welcome' - [Home page controller] ?>

<input type="hidden" name="dlang" id="dlang"> 

<?php // 'dlang' - [Language choosen] ?>

<input type="hidden" name="current" id="current" value="<?php echo substr(uri_string(),1,strlen(uri_string()));?>">

<?php // 'current' - [Current page url] ?>

<?php // [Language images] ?>
 
<img src="<?=base_url()?>images/fr.png" onClick="lanfTrans('fr');" width="16" height="11" title="To French"> &nbsp; 

<img src="<?=base_url()?>images/en.png" onClick="lanfTrans('en');" width="16" height="11" title="To English"> &nbsp;
<img src="<?=base_url()?>images/es_flag.gif" onClick="lanfTrans('es');" width="16" height="11" title="To Spanish"> &nbsp;

<?php echo form_close(); ?>


         <nav class="navbar navbar-default navbar-cls-top navbar-fixed-top" role="navigation" style="margin-bottom: 0">

         	<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light"> -->


         	<a class="navbar-brand" href="<?php echo SITEURL;?>"><img src="<?php echo get_second_site_logo();?>"  alt="logo" class="img-responsive"/></a> 

		    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="display: none;">
		   	 <span class="navbar-toggler-icon"><i class="fa fa-bars"></i></span>
		  	</button>


            <!-- <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
            </div> -->
            <!--End of the search bar-->

            <!-- <div>  -->
			
             <ul class="nav navbar-nav navbar-right">
			 
			  <?php $languages = get_language_opts(); 
			 
			  if(!empty($languages)) {
			  ?>
			  
			  <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="hidden-xs"><?php echo get_languageword('change_language');?></span>
					</a>
					<ul class="dropdown-menu">
						<?php foreach ($languages as $key => $value) { ?>
						<li>
                            <a href="<?php echo URL_CHANGE_LANGUAGE.'/'.$key;?>"><?php if($this->config->item('site_settings')->site_language == $key) echo '<i class="fa fa-check"></i>'; ?> <?php echo $value;?></a>
						</li>
						<?php } ?>
					</ul>
				</li>
				
			  <?php } ?>
			
				
                  <li class="crungh-logout dropdown clearfix">
				  <a href="#" class="dropdown-toggle avatar crunch-profile-log" data-toggle="dropdown">
				    <span>
				    <?php 
				    $user=getUserRec();
					
				    echo $user->username;?></span>
	        		<img src="<?php echo get_user_image();?>"></a>
					
	        		<ul class="dropdown-menu">
						<li class="m_2"><a href="<?php echo URL_ADMIN_PROFILE;?>"><i class="fa fa-user"></i><?php echo get_languageword('profile');?></a></li>
						<li class="m_2"><a href="<?php echo URL_ADMIN_CHANGE_PASSWORD;?>"><i class="fa fa-lock"></i> <?php echo get_languageword('change_password');?> </a></li>
						
						<li class="m_2"><a href="<?php echo URL_ADMIN_ORDERS_OVERVIEW;?>"><i class="fa fa-calendar"></i> <?php echo get_languageword('orders_overview');?> </a></li>
						
						<li class="m_2"><a href="<?php echo URL_AUTH_LOGOUT;?>"><i class="fa fa-sign-out"></i> <?php echo get_languageword('logout');?> </a></li>	
	        		</ul>
	      		</li>
				
                  </ul>
				  
            <!-- </div> -->

            </nav>   
