<!DOCTYPE html>
<html lang="<?php echo get_language_code();?>" dir="<?php echo language_type();?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="<?php echo get_fevicon();?>"/>
    <title> <?php if(isset($pagetitle)) echo $pagetitle;?> :: <?php echo get_languageword('admin_panel');?> :: </title>

    <?php if($this->config->item('site_settings')->admin_css=='orange') {?>
	 <!-- BOOTSTRAP STYLES-->
    <link href="<?php echo CSS_ADMIN_OR_BOOTSTRAP;?>" rel="stylesheet" />
     <!--Style Sheet style.css-->
    <link href="<?php echo CSS_ADMIN_OR_STYLE;?>" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="<?php echo CSS_ADMIN_OR_FONT_AWESOME;?>" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
	<!--link href="<?php //echo CSS_ADMIN_OR_MORRIS;?>" rel="stylesheet" /-->
        <!-- CUSTOM STYLES-->
    <link href="<?php echo CSS_ADMIN_OR_CUSTOM;?>" rel="stylesheet" />
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
         <nav class="navbar navbar-default navbar-cls-top navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo SITEURL;?>"><img src="<?php echo get_second_site_logo();?>"  alt="logo" class="img-responsive"/></a> 
            </div>
            <!--End of the search bar-->
            <div> 
			
             <ul class="nav navbar-nav navbar-right">
			 
                  <li class="crungh-logout dropdown clearfix">
				  <a href="#" class="dropdown-toggle avatar crunch-profile-log" data-toggle="dropdown">
				    <span>
				    <?php 
				    $user=getUserRec();
					
				    echo $user->username;?></span>
	        		<img src="<?php echo get_user_image();?>"></a>
					
	        		<ul class="dropdown-menu">
						<li class="m_2"><a href="<?php echo URL_KM_PROFILE;?>"><i class="fa fa-user"></i><?php echo get_languageword('profile');?></a></li>
						
						<li class="m_2"><a href="<?php echo URL_KM_CHANGE_PASSWORD;?>"><i class="fa fa-lock"></i> <?php echo get_languageword('change_password');?> </a></li>
						
						
						<li class="m_2"><a href="<?php echo URL_AUTH_LOGOUT;?>"><i class="fa fa-sign-out"></i> <?php echo get_languageword('logout');?> </a></li>	
	        		</ul>
	      		</li>
				
                  </ul>
				  
            </div>
            </nav>   
