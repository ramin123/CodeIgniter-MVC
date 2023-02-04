<!DOCTYPE html>
<html lang="<?php echo get_language_code();?>" dir="<?php echo language_type();?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Conquerors Team">
	
    <meta name="keywords" content="<?php if(isset($this->config->item('seo_settings')->meta_keyword)) echo $this->config->item('seo_settings')->meta_keyword;?>">
    <meta name="description" content="<?php if(isset($this->config->item('seo_settings')->meta_description)) echo $this->config->item('seo_settings')->meta_description;?>">
	
    <link rel="icon" href="<?php echo get_fevicon();?>">

    <title><?php if(isset($pagetitle)) echo $pagetitle;?> :: <?php if(isset($this->config->item('site_settings')->site_title)) echo $this->config->item('site_settings')->site_title;?> ::</title>


    <link href="<?php echo CSS_FRONT_MAIN;?>" rel="stylesheet">
   
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   
    <link href="<?php echo CSS_CHOSEN_MIN;?>" rel="stylesheet" />

    
   <!-- PNOTIFY CSS-->
    <link href="<?php echo PNOTIFY_ALL_CSS;?>" rel="stylesheet">

	 
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--Slick Slider Section-->

    <script src="<?php echo JS_FRONT_JQUERY_MIN;?>"></script>
	
	
	<!--script><?php //if(isset($this->config->item('seo_settings')->google_analytics)) echo $this->config->item('seo_settings')->google_analytics;?></script-->

</head>
<!-- =======================NAVBAR=========================== -->

<body>
    <div class="main-wrapper">
        <div  class="ct-banner-image primary-navbar" style="background: url(<?php echo get_home_page_img();?>)">
        <div class="navbar-wrapper">
            <!--Food Court Navbar Section-->
            <nav class="navbar navbar-static-top ct-navbar-statictop fc-nav-bar">
                <div class="container">
                    <div class="row">
                        <div class="ct-logo">
                            <div class="navbar-header ct-toggle2">
                                <button type="button" class="navbar-toggle offcanvas-toggle" data-toggle="offcanvas" data-target="#ct-bootstrap-offcanvas">
                                    <span class="sr-only">Toggle navigation</span>
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                </button>
								
                                <a class="navbar-brand" href="<?php echo SITEURL;?>"><img class="img-responsive flogo" src="<?php echo get_site_logo();?>"alt="FoodCourt">
                                </a>
                            </div>
                         </div>
                         <div class="ct-navbar">
                          
                           <div class="navbar-offcanvas navbar-offcanvas-touch navbar-right" id="ct-bootstrap-offcanvas">
                              <ul class="nav navbar-nav ct-list ">
                                  <li><a href="<?php echo URL_MENU;?>"><?php echo get_languageword('menu');?></a></li>
                                  <li><a href="<?php echo URL_ABOUT_US;?>"><?php echo get_languageword('about_us');?></a></li>
                                  <li><a href="<?php echo URL_CONTACT_US;?>"><?php echo get_languageword('contact_us');?></a></li>
								  
                               
								  
								  
                               
								<?php if (!$this->ion_auth->logged_in()):
								$login_popup='login';
								?>
                                  <li><a class="btn btn nav-btn" href="javascript:void(0);" onclick="show_popup('<?php echo $login_popup;?>')"><?php echo get_languageword('login');?></a></li>
								  
								  <?php else: ?>
								  
								  <li class="dropdown">
								  
                                    <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><img src="<?php echo get_user_image();?>" class="nav-profile-img" alt="Your Account"><?php echo get_languageword('my_account');?>
									
                                    <span class="fa fa-angle-down"></span></a>
									
                                    <ul class="dropdown-menu">
									
                                      <li><a href="<?php echo URL_USER_PROFILE;?>"><i class="pe pe-7s-user"></i> <?php echo get_languageword('my_profile');?></a></li>
									  
                                      <li><a href="<?php echo URL_USER_MY_ORDERS;?>"><i class="pe pe-7s-box1"></i><?php echo get_languageword('my_orders');?></a></li>
									  
									  <li><a href="<?php echo URL_USER_MY_POINTS;?>"><i class="pe pe-7s-wallet"></i><?php echo get_languageword('my_points');?></a></li>
									  
									 
									   <li role="separator" class="divider"></li>
                                      <li><a href="<?php echo URL_AUTH_LOGOUT;?>"><i class="pe pe-7s-next-2"></i><?php echo get_languageword('logout');?></a></li>
									  
                                    </ul>
                              </li>
							  
							  <?php endif;?>
								  
								  
                                  <li class="hidden-xs">
                                <a class="nav-cart" href="<?php echo URL_CART_INDEX;?>"><span><i class="fa fa-shopping-cart" aria-hidden="true"></i><span id="items_cnt" class="fc-count"><?php echo count($this->cart->contents());?></span></span> </a>
                              </li>
                              </ul>
                            </div>
                           </div>
                        </div>
                      </div>
                   </nav>
                </div>
				
			
