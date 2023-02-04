<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/* User Defined Constants*/
define('DS', '/');
define('DS_PATH', DIRECTORY_SEPARATOR);
define('FOLDERNAME', ltrim(str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']), "/") );

define('RESOURCES', 'assets');
$base = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$base .= '://'.$_SERVER['HTTP_HOST'].DS . FOLDERNAME;

define('SITEURL2',rtrim($base, "/"));
define('SITEURL',$base);

define('UPLOADS','uploads');

define('REFRESH','refresh');
define('ALLOWED_TYPES','gif|jpg|jpeg|png');
define('ALLOWED_FEVICON_TYPES','ico');


define('FEVICON',SITEURL.RESOURCES.DS.'favicon.ico');
define('LOADER',SITEURL.UPLOADS.DS.'loader.gif');

/**ADMIN ORANGE CSS**/
define('CSS_ADMIN_ORANGE',SITEURL.RESOURCES.DS.'admin'.DS.'css'.DS.'orange'.DS);
define('CSS_ADMIN_OR_BOOTSTRAP',CSS_ADMIN_ORANGE.'bootstrap.css');
define('CSS_ADMIN_OR_STYLE',CSS_ADMIN_ORANGE.'style.css');
define('CSS_ADMIN_OR_FONT_AWESOME',CSS_ADMIN_ORANGE.'font-awesome.css');
define('CSS_ADMIN_OR_CUSTOM',CSS_ADMIN_ORANGE.'custom.css');
define('CSS_ADMIN_OR_MORRIS',CSS_ADMIN_ORANGE.'morris'.DS.'morris-0.4.3.min.css');
define('CSS_ADMIN_OR_BOOTSTRAP_VALIDATOR',CSS_ADMIN_ORANGE.'bootstrapValidator.css');

define('CSS_ORANGE_ADMIN',CSS_ADMIN_ORANGE.'admin-css.css');

/***ADMIN JS**/
define('JS_ADMIN',SITEURL.RESOURCES.DS.'admin'.DS.'js'.DS);
define('JS_ADMIN_JQUERY',JS_ADMIN.'jquery.js');
define('JS_ADMIN_ANGULAR',JS_ADMIN.'angular.min.js');
define('JS_ADMIN_BOOTSTRAP',JS_ADMIN.'bootstrap.min.js');
define('JS_ADMIN_METIMENU',JS_ADMIN.'jquery.metisMenu.js');
define('JS_ADMIN_MIRROR_RAPHAEL',JS_ADMIN.'morris'.DS.'raphael.min.js');
define('JS_ADMIN_MIRROR_MIRROR',JS_ADMIN.'morris'.DS.'morris.js');
//define('JS_ADMIN_CUSTOM',JS_ADMIN.'custom.js');
define('JS_ADMIN_BOOTSTRAP_VALIDATOR',JS_ADMIN.'bootstrapValidator.min.js');
define('JS_ADMIN_BOOTSTRAP_MAXLENGTH_MIN',JS_ADMIN.'bootstrap-maxlength.min.js');

define('JS_ADMIN_SIDEBAR_MENU',JS_ADMIN.'sidebar-menu.js');

/***SITE ORANGE CSS**/
define('CSS_SITE_ORANGE',SITEURL.RESOURCES.DS.'site'.DS.'css'.DS.'orange'.DS);
define('CSS_SITE_MAIN',CSS_SITE_ORANGE.'main.css');
define('CSS_SITE_CUSTOM',CSS_SITE_ORANGE.'custom.css');


/**SITE JS***/
define('JS_SITE',SITEURL.RESOURCES.DS.'site'.DS.'js'.DS);
define('JS_SITE_BOOTSTRAP',JS_SITE.'bootstrap.min.js');
define('JS_SLICK_SLIDE',JS_SITE.'Slick-Slide.js');
define('JS_MAIN',JS_SITE.'main.js');
define('JS_WOW',JS_SITE.'wow.js');
define('JS_WOW_MIN',JS_SITE.'wow.min.js');
define('JS_STAR',JS_SITE.'star.js');
define('JS_JQUERY_MIN',JS_SITE.'jquery.min.js');
define('JS_VALIDATE_MIN',JS_SITE.'jquery.validate.min.js');


/**SITE IMAGES**/
define('SITE_IMAGES',SITEURL.RESOURCES.DS.'site'.DS.'images'.DS);

define('FRONT_IMAGES',SITEURL.RESOURCES.DS.'front'.DS.'images'.DS);
define('LOADER_IMG',FRONT_IMAGES.'loader.gif');


define('DEFAULT_IMG_HOME_PAGE',FRONT_IMAGES.'fbg2.jpg');


define('DEFAULT_SITE_LOGO',SITEURL.RESOURCES.DS.'front'.DS.'images'.DS.'primary_site_logo.png');
define('SECOND_DEFAULT_SITE_LOGO',SITEURL.RESOURCES.DS.'front'.DS.'images'.DS.'secondary_site_logo.png');


/***AUTO COMPLETE**/
define('AUTO_COMPLETE',SITEURL.RESOURCES.DS.'autocomplete'.DS);
define('AUTO_COMPLETE_JS',AUTO_COMPLETE.'js'.DS);
define('AUTO_COMPLETE_CSS',AUTO_COMPLETE.'css'.DS);
define('JS_JQUERY_AUTO_COMPLETE',AUTO_COMPLETE_JS.'jquery-auto-complete.min.js');
define('CSS_JQUERY_AUTO_COMPLETE',AUTO_COMPLETE_CSS.'jquery-auto-complete.css');


//SITE NEW CSS
define('CSS_FRONT',SITEURL.RESOURCES.DS.'front'.DS.'css'.DS);
define('CSS_FRONT_MAIN',CSS_FRONT.'main.css');

//SITE NEW JS
define('JS_FRONT',SITEURL.RESOURCES.DS.'front'.DS.'js'.DS);
define('JS_FRONT_JQUERY_MIN',JS_FRONT.'jquery-3.3.1.min.js');
define('JS_FRONT_SEARCH_BOX',JS_FRONT.'search-box.js');
define('JS_FRONT_BOOTSTRAP_MIN',JS_FRONT.'bootstrap.min.js');
define('JS_FRONT_BOOTSTRAP_OFFCANVAS',JS_FRONT.'bootstrap.offcanvas.js');
define('JS_FRONT_SLICK_SLIDE',JS_FRONT.'Slick-Slide.js');
define('JS_FRONT_MAIN',JS_FRONT.'main.js');
define('JS_FRONT_WOW',JS_FRONT.'wow.js');
define('JS_FRONT_WOW_MIN',JS_FRONT.'wow.min.js');
define('JS_JQUERY_VERTICAL_CAROUSEL',JS_FRONT.'jQuery.verticalCarousel.js');
define('JS_STICKY_MIN',JS_FRONT.'sticky.min.js');



/**CHOSEN JS && CSS**/
define('CHOSEN',SITEURL.RESOURCES.DS.'chosen'.DS);
define('JS_CHOSEN_JQUERY',CHOSEN.'chosen.jquery.js');
define('JS_CHOSEN_JQUERY_MIN',CHOSEN.'chosen.jquery.min.js');
define('CSS_CHOSEN',CHOSEN.'chosen.css');
define('CSS_CHOSEN_MIN',CHOSEN.'chosen.min.css');

/***TIMEPICKER JS && CSS**/
define('TIMEPICKER',SITEURL.RESOURCES.DS.'timepicker'.DS);
define('JS_TIMEPICKER_MIN',TIMEPICKER.'bootstrap-datetimepicker.min.js');
define('CSS_TIMEPICKER_MIN',TIMEPICKER.'bootstrap-datetimepicker.min.css');

/***ALERTIFY**/
define('ALERTIFY',SITEURL.RESOURCES.DS.'alertify'.DS);
define('ALERTIFY_MIN_JS',ALERTIFY.'alertify.min.js');
define('ALERTIFY_CSS',ALERTIFY.'css'.DS);
define('ALERTIFY_MIN_CSS',ALERTIFY_CSS.'alertify.min.css');

/***PNOTIFY****/
define('PNOTIFY',SITEURL.RESOURCES.DS.'pnotify'.DS);
define('PNOTIFY_MIN_JS',PNOTIFY.'dist/pnotify.js');
define('PNOTIFY_ANIMATE_JS',PNOTIFY.'dist/pnotify.animate.js');
define('PNOTIFY_BUTTON_JS',PNOTIFY.'dist/pnotify.buttons.js');
define('PNOTIFY_CALLBACK_JS',PNOTIFY.'dist/pnotify.callbacks.js');
define('PNOTIFY_CONFIRM_JS',PNOTIFY.'dist/pnotify.confirm.js');
define('PNOTIFY_DESKTOP_JS',PNOTIFY.'dist/pnotify.desktop.js');
define('PNOTIFY_MIN_CSS',PNOTIFY.'dist/pnotify.css');
define('PNOTIFY_BRIGHTTHEME_CSS',PNOTIFY.'dist/pnotify.brighttheme.css');
define('PNOTIFY_BUTTONS_CSS',PNOTIFY.'dist/pnotify.buttons.css');

define('PNOTIFY_ALL_CSS',PNOTIFY.'dist/pnotify-all.css');


/***FUNCTIONS JS**/
define('JS_FUNCTIONS',JS_FRONT.'functions.js');





/**ADMIN DATATABLES**/
define('TBL_JS_ADMIN',JS_ADMIN.'dataTables'.DS);
define('ADMIN_DATA_TBL_JS',JS_ADMIN.'data-table.js');
define('TBL_JS_ADMIN_DATATABLES',TBL_JS_ADMIN.'jquery.dataTables.js');
define('TBL_JS_ADMIN_DATATABLES_BOOTSTRAP',TBL_JS_ADMIN.'dataTables.bootstrap.js');
define('TBL_CSS_ADMIN_ORANGE_DATATABLE_BOOTSTRAP',TBL_JS_ADMIN.'orange'.DS.'dataTables.bootstrap.css');

/**ADMIN CKEDITOR**/
define('ADMIN_CKEDITOR',SITEURL.RESOURCES.DS.'ckeditor'.DS);
define('ADMIN_CKEDITOR_JS',ADMIN_CKEDITOR.'ckeditor.js');

/**DATEPICKER**/
define('DATEPICKER',SITEURL.RESOURCES.DS.'datepicker'.DS);
define('BOOTSTRAP_DATEPICKER_JS',DATEPICKER.'js'.DS.'bootstrap-datepicker.js');
define('DATEPICKER_CSS',DATEPICKER.'css'.DS.'datepicker.css');
define('DATEPICKER_LESS',DATEPICKER.'less'.DS.'datepicker.less');

/***IMAGE CRUD**/
define('IMAGE_CRUD',SITEURL.RESOURCES.DS.'image_crud'.DS);
define('IMAGE_CRUD_JS',IMAGE_CRUD.'js'.DS);
define('IMAGE_CRUD_CSS',IMAGE_CRUD.'css'.DS);
define('IMAGE_CRUD_JQUERYUI_MIN_JS',IMAGE_CRUD_JS.'jquery-ui.min.js');
define('IMAGE_CRUD_FINEUPLOAD_MIN_JS',IMAGE_CRUD_JS.'fineuploader-3.2.min.js');
define('IMAGE_CRUD_COLORBOX_MIN_JS',IMAGE_CRUD_JS.'jquery.colorbox-min.js');

define('IMAGE_CRUD_FINEUPLOADER_CSS',IMAGE_CRUD_CSS.'fineuploader.css');
define('IMAGE_CRUD_PHOTOGALLARY_CSS',IMAGE_CRUD_CSS.'photogallery.css');
define('IMAGE_CRUD_COLORBOX_CSS',IMAGE_CRUD_CSS.'colorbox.css');


/***FULL CALENDAR***/
define('FULLCALENDAR',SITEURL.RESOURCES.DS.'fullcalendar'.DS);
define('CSS_FULLCALENDAR_MIN',FULLCALENDAR.'fullcalendar.min.css');
define('CSS_FULLCALENDAR_PRINT_MIN',FULLCALENDAR.'fullcalendar.print.min.css');
define('JS_FULLCALENDAR_MOMENT_MIN',FULLCALENDAR.'lib'.DS.'moment.min.js');
define('JS_FULLCALENDAR_MIN',FULLCALENDAR.'fullcalendar.min.js');

define('GRP_USER', 2);

/* ACTIVE CLASS CONSTANTS */
define('ACTIVE_ADMIN','admin_dashboard');
define('ACTIVE_MENU','menu');

define('ACTIVE_ITEMS','items');
define('ACTIVE_LANGAUGE','language');
define('ACTIVE_ADDONS','addons');
define('ACTIVE_OPTIONS','options');
define('ACTIVE_OFFERS','offers');
define('ACTIVE_LOCATIONS','locations');
define('ACTIVE_MASTER_SETTINGS','master_settings');
define('ACTIVE_PAGES','pages');
define('ACTIVE_FAQS','faqs');
define('ACTIVE_REPORTS','reports');
define('ACTIVE_LOYALITY_POINTS','loyality_points');
define('ACTIVE_REFERRAL','referral_settings');
define('ACTIVE_CUSTOMERS','customers');
define('ACTIVE_ORDERS','orders');
define('ACTIVE_CARDS','cards');
define('ACTIVE_USERS','users');


/* TEMPLATE CONSTANTS */
define('TEMPLATE_ADMIN','templates/admin-template');
define('TEMPLATE_SITE','templates/site-template');
define('TEMPLATE_USER','templates/user-template');
define('TEMPLATE_KM','templates/km-template');
define('TEMPLATE_DM','templates/dm-template');


/**TABLE CONSTANTS**/
define('TBL_PREFIX','cr_');
define('DBPREFIX','cr_');
define('TBL_USERS','users');
define('TBL_USERS_GROUPS','users_groups');
define('TBL_GROUPS','groups');
define('TBL_LANGUAGEWORDS','languagewords');
define('TBL_MENU_CATEGORIES','menu_categories');
define('TBL_MENU','menu');
define('TBL_ITEMS','items');
define('TBL_ITEM_ADDONS','item_addons');
define('TBL_ITEM_OPTIONS','item_options');
define('TBL_ADDONS','addons');
define('TBL_OPTIONS','options');
define('TBL_OFFERS','offers');
define('TBL_OFFER_PRODUCTS','offer_products');
define('TBL_CITIES','cities');
define('TBL_SERVICE_PROVIDE_LOCATIONS','service_provide_locations');
define('TBL_PAGES','pages');
define('TBL_SITE_SETTINGS','site_settings');
define('TBL_TINIFY_SETTINGS','tinify_settings');
define('TBL_PAYPAL_SETTINGS','paypal_settings');
define('TBL_EMAIL_SETTINGS','email_settings');
define('TBL_SMS_GATEWAYS','sms_gate_ways');
define('TBL_SETTINGS_FIELDS','system_settings_fields');
define('TBL_EMAIL_TEMPLATES','email_templates');
define('TBL_SMS_TEMPLATES','sms_templates');
define('TBL_SEO_SETTINGS','seo_settings');
define('TBL_GALLARY','gallery');
define('TBL_FAQ_CATEGORIES','faq_categories');
define('TBL_FAQS','faqs');
define('TBL_SOCIAL_NETWORKS','social_networks');
define('TBL_ORDERS','orders');
define('TBL_ORDER_PRODUCTS','order_products');
define('TBL_ORDER_ADDONS','order_addons');
define('TBL_LOYALITY_POINTS','loyality_points');
define('TBL_USER_POINTS','user_points');
define('TBL_REFERRAL_SETTINGS','referral_settings');
define('TBL_CARD_IMAGES','card_images');
define('TBL_USER_ADDRESS','user_address');
define('TBL_ORDER_OFFER_PRODUCTS','order_offer_products');
define('TBL_ORDER_OFFERS','order_offers');
define('TBL_REFERRAL_USERS','referral_users');
define('TBL_ITEM_TYPES','item_types');
define('TBL_SERVICE_DELIVERED_LOCATIONS', 'service_provide_locations');



/**ADMIN URL CONSTATNS**/
define('URL_ADMIN_INDEX', SITEURL.'admin'.DS.'index');
define('URL_ADMIN_PROFILE',SITEURL.'admin'.DS.'profile');
define('URL_ADMIN_CHANGE_PASSWORD', SITEURL.'admin'.DS.'change-password');
define('URL_ADMIN_ORDERS_OVERVIEW', SITEURL.'admin'.DS.'orders-overview');

/**KITCHEN MANAGER URL CONSTATNS**/
define('URL_KITCHEN_MANAGER', SITEURL.'kitchen_manager'.DS.'index');
define('URL_KM_PROFILE',SITEURL.'kitchen_manager'.DS.'profile');
define('URL_KM_CHANGE_PASSWORD',SITEURL.'kitchen_manager'.DS.'change_password');
define('URL_KM_ORDERS',SITEURL.'kitchen_manager'.DS.'orders');
define('URL_KM_AJAX_GET_ORDERS',SITEURL.'kitchen_manager'.DS.'ajax_get_orders');
define('URL_KM_VIEW_ORDER',SITEURL.'kitchen_manager'.DS.'view_order');
define('URL_KM_UPDATE_ORDER',SITEURL.'kitchen_manager'.DS.'update_order');



/**DELIVERY MANAGER URL CONSTATNS**/
define('URL_DELIVERY_MANAGER', SITEURL.'delivery_manager'.DS.'index');
define('URL_DM_PROFILE',SITEURL.'delivery_manager'.DS.'profile');
define('URL_DM_CHANGE_PASSWORD',SITEURL.'delivery_manager'.DS.'change_password');
define('URL_DM_ORDERS',SITEURL.'delivery_manager'.DS.'orders');
define('URL_DM_AJAX_GET_ORDERS',SITEURL.'delivery_manager'.DS.'ajax_get_orders');
define('URL_DM_VIEW_ORDER',SITEURL.'delivery_manager'.DS.'view-order');
define('URL_DM_UPDATE_ORDER',SITEURL.'delivery_manager'.DS.'update_order');


/**USER URL CONSTATNS**/
define('URL_USER_INDEX', SITEURL.'user'.DS.'index');
define('URL_USER_PROFILE', SITEURL.'my-profile');
define('URL_USER_CHANGE_PASSWORD', SITEURL.'change-password');

define('URL_ADD_USER_ADDRESS', SITEURL.'address');
define('URL_DELETE_USER_ADDRESS', SITEURL.'user'.DS.'delete-address');

define('URL_USER_MY_ORDERS', SITEURL.'my-orders');
define('URL_USER_MY_POINTS', SITEURL.'my-points');

define('URL_USER_ADD_ADDRESS', SITEURL.'user'.DS.'add-address');
define('URL_USER_DEFAULT_ADDRESS', SITEURL.'user'.DS.'default-address');


/**AUTH URL CONSTATNS**/
define('URL_AUTH_INDEX', SITEURL.'auth'.DS.'index');
define('URL_AUTH_LOGIN', SITEURL.'login');
define('URL_AUTH_REGISTER', SITEURL.'register');
define('URL_AUTH_FORGOT_PASSWORD', SITEURL.'auth'.DS.'forgot_password');
define('URL_AUTH_RESET_PASSWORD', SITEURL.'auth'.DS.'reset_password');
define('URL_AUTH_LOGOUT', SITEURL.'auth'.DS.'logout');


/**WELCOME URL CONSTANTS**/
define('URL_WELCOME_INDEX', SITEURL.'welcome'.DS.'index');
define('URL_WELCOME_CONTACT_US', SITEURL.'welcome'.DS.'contact-us');
define('URL_WELCOME_ABOUT_US', SITEURL.'welcome'.DS.'about-us');
define('URL_WELCOME_FAQS', SITEURL.'welcome'.DS.'faqs');
define('URL_MENU', SITEURL.'menu');


define('URL_ABOUT_US', SITEURL.'about-us');
define('URL_CONTACT_US', SITEURL.'contact-us');
define('URL_HOW_IT_WORKS', SITEURL.'how-it-works');
define('URL_TERMS_CONDITIONS', SITEURL.'terms-conditions');
define('URL_PRIVACY_POLICY', SITEURL.'privacy-policy');
define('URL_FAQS', SITEURL.'faqs');



define('URL_SITE_MAP', SITEURL.'site-map');


define('URL_DOWNLOAD_APP', SITEURL.'download-app');



/**PAGE CONSTANTS**/
define('PAGE_ADMIN_DASHBOARD','dashboard');
define('PAGE_LANGUAGE_INDEX','table');
define('PAGE_MENU','menu');
define('PAGE_ADD_MENU','add_menu');
define('PAGE_ADDEDIT_MENU','addedit');
define('PAGE_ITEMS','items');
define('PAGE_ADDEDIT_ITEM','addedit');
define('PAGE_EDIT_ITEM','edit_item');
define('PAGE_ADDONS','addons');
define('PAGE_ADDEDIT_ADDON','addedit');
define('PAGE_OPTIONS','options');
define('PAGE_ADDEDIT_OPTION','addedit');
define('PAGE_ADD_OPTION','add_option');
define('PAGE_OFFERS','offers');
define('PAGE_ADD_OFFER','add_offer');
define('PAGE_EDIT_OFFER','edit_offer');
define('PAGE_CITIES','cities');
define('PAGE_ADDEDIT_CITY','addedit_city');
define('PAGE_SERVICE_PROVIDE_LOCATIONS','locations');
define('PAGE_ADDEDIT_LOCATION','addedit_location');
define('PAGE_PAGES','pages');
define('PAGE_ADDEDIT_PAGE','addedit');
define('PAGE_SITE_SETTINGS','site_settings');
define('PAGE_APP_SETTINGS','app_settings');
define('PAGE_PAYPAL_SETTINGS','paypal_settings');
define('PAGE_EMAIL_SETTINGS','email_settings');
define('PAGE_SMS_GATEWAYS','sms_gateways');
define('PAGE_SMS_UPDATE_FIELD_VALUES','sms_update_field_values');
define('PAGE_PUSH_NOTIFICATION_SETTINGS','push_notification_settings');
define('PAGE_EMAIL_TEMPLATES','email_templates');
define('PAGE_EDIT_EMAIL_TEMPLATE','edit_email_template');
define('PAGE_SMS_TEMPLATES','sms_templates');
define('PAGE_EDIT_SMS_TEMPLATE','edit_sms_template');
define('PAGE_ADD_IMAGES','add_images');
define('PAGE_EDIT_IMAGE','edit_image');
define('PAGE_HOME','home/index');
define('PAGE_ADMIN_RROFILE','profile');
define('PAGE_FAQS','faqs');
define('PAGE_ADDEDIT_FAQ','addedit');
define('PAGE_SOCIAL_NETWORKS','social_networks');
define('PAGE_RESTAURANT_TIMINGS','restaurant_timings');
define('PAGE_DATE_WISE_REPORTS','date_wise_reports');
define('PAGE_CLIENT_WISE_REPORTS','client_wise_reports');
define('PAGE_LOCATION_WISE_REPORTS','location_wise_reports');
define('PAGE_ITEM_WISE_REPORTS','item_wise_reports');
define('PAGE_POINT_SETTINGS','point_settings');
define('PAGE_REWARD_POINTS','reward_points');
define('PAGE_POINT_LOGS','point_logs');
define('PAGE_REFERRAL_SETTINGS','referral_settings');
define('PAGE_CUSTOMERS','customers');
define('PAGE_PROFILE','profile');
define('PAGE_CHANGE_PASSWORD','change_password');
define('PAGE_VIEW_CUSTOMER_DETAILS','view_details');
define('PAGE_CARDS','cards');
define('PAGE_ADDEDIT_CARD','addedit');
define('PAGE_ORDERS','orders');
define('PAGE_VIEW_ORDER','view_order');
define('PAGE_REFERRAL_USERS','referral_users');
define('PAGE_HOME_MENU','home_menu');
define('PAGE_MENU_ITEMS','menu_items');
define('PAGE_ITEM_TYPES','item_types');
define('PAGE_ADDEDIT_ITEMTYPE','addedit_itemtype');
define('PAGE_PUSHER_NOTIFICATION','pusher_notification');
define('PAGE_KITCHEN_MANAGERS','kitchen_managers');
define('PAGE_ADDEDIT_KITCHEN_MANAGER','addedit_km');
define('PAGE_DELIVERY_MANAGERS','delivery_managers');
define('PAGE_ADDEDIT_DELIVERY_MANAGER','addedit_dm');
define('PAGE_KM_DASHBOARD','dashboard');
define('PAGE_KM_RROFILE','profile');
define('PAGE_DM_DASHBOARD','dashboard');
define('PAGE_DM_RROFILE','profile');



/**USER IMAGE UPLOAD URLS***/
define('USER_IMG_UPLOAD_PATH_URL','uploads'.DS.'users'.DS);
define('USER_IMG_UPLOAD_THUMB_PATH_URL','uploads'.DS.'users'.DS.'thumbs'.DS);

/**MENU IMAGE UPLOAD URLS***/
define('MENU_IMG_UPLOAD_PATH_URL','uploads'.DS.'menu_images'.DS);
define('MENU_IMG_UPLOAD_THUMB_PATH_URL','uploads'.DS.'menu_images'.DS.'thumbs'.DS);

/**ITEM IMAGE UPLOAD URLS***/
define('ITEM_IMG_UPLOAD_PATH_URL','uploads'.DS.'item_images'.DS);
define('ITEM_IMG_UPLOAD_THUMB_PATH_URL','uploads'.DS.'item_images'.DS.'thumbs'.DS);

/**ADDON IMAGE UPLOAD URLS***/
define('ADDON_IMG_UPLOAD_PATH_URL','uploads'.DS.'addon_images'.DS);
define('ADDON_IMG_UPLOAD_THUMB_PATH_URL','uploads'.DS.'addon_images'.DS.'thumbs'.DS);

/**CARD IMAGE UPLOAD URLS***/
define('CARD_IMG_UPLOAD_PATH_URL','uploads'.DS.'card_images'.DS);
define('CARD_IMG_UPLOAD_THUMB_PATH_URL','uploads'.DS.'card_images'.DS.'thumbs'.DS);

/**OFFER IMAGE UPLOAD URLS***/
define('OFFER_IMG_UPLOAD_PATH_URL','uploads'.DS.'offer_images'.DS);
define('OFFER_IMG_UPLOAD_THUMB_PATH_URL','uploads'.DS.'offer_images'.DS.'thumbs'.DS);


/**SITELOGO UPLOAD URLS***/
define('LOGO_IMG_UPLOAD_PATH_URL','uploads'.DS.'logo'.DS);
define('LOGO_IMG_UPLOAD_THUMB_PATH_URL','uploads'.DS.'logo'.DS.'thumbs'.DS);


/**HOME PAGE IMAGE UPLOAD URLS***/
define('HOME_PAGE_IMG_UPLOAD_PATH_URL','uploads'.DS.'home_page'.DS);



/**FEVICON UPLOAD URLS***/
define('FEVICON_IMG_UPLOAD_PATH_URL','uploads'.DS.'fevicon'.DS);
define('FEVICON_IMG_UPLOAD_THUMB_PATH_URL','uploads'.DS.'fevicon'.DS.'thumbs'.DS);


/**USER IMG URL FOR GET IMAGE**/
define('USER_IMG_PATH',SITEURL.UPLOADS.DS.'users'.DS);
define('USER_IMG_THUMB_PATH',SITEURL.UPLOADS.DS.'users'.DS.'thumbs'.DS);
define('DEFAULT_USER_IMG', USER_IMG_PATH.'default-user-male.jpg');
define('IMG_DEFAULT',SITEURL.UPLOADS.DS.'default_images'.DS.'item.png');

define('OFFER_IMG_DEFAULT',SITEURL.UPLOADS.DS.'default_images'.DS.'offer.png');

// define('DEFAULT_USER_IMAGE', USER_IMG_PATH.'noimage.png');
define('DEFAULT_USER_IMAGE', FRONT_IMAGES.'user.png');


/**MENU IMG URL FOR GET IMAGE**/
define('MENU_IMG_PATH',SITEURL.UPLOADS.DS.'menu_images'.DS);
define('MENU_IMG_THUMB_PATH',SITEURL.UPLOADS.DS.'menu_images'.DS.'thumbs'.DS);



/**ITEM IMG URL FOR GET IMAGE**/
define('DEFAULT_ITEM_IMG',SITEURL.UPLOADS.DS.'item_images'.DS.'default_item_img.jpg');
define('ITEM_IMG_PATH',SITEURL.UPLOADS.DS.'item_images'.DS);
define('ITEM_IMG_THUMB_PATH',SITEURL.UPLOADS.DS.'item_images'.DS.'thumbs'.DS);

/**ADDON IMG URL FOR GET IMAGE***/
define('ADDON_IMG_PATH',SITEURL.UPLOADS.DS.'addon_images'.DS);
define('ADDON_IMG_THUMB_PATH',SITEURL.UPLOADS.DS.'addon_images'.DS.'thumbs'.DS);

/**CARD IMG URL FOR GET IMAGE***/
define('CARD_IMG_PATH',SITEURL.UPLOADS.DS.'card_images'.DS);
define('CARD_IMG_THUMB_PATH',SITEURL.UPLOADS.DS.'card_images'.DS.'thumbs'.DS);

/**OFFER IMG URL FOR GET IMAGE***/
define('OFFER_IMG_PATH',SITEURL.UPLOADS.DS.'offer_images'.DS);
define('OFFER_IMG_THUMB_PATH',SITEURL.UPLOADS.DS.'offer_images'.DS.'thumbs'.DS);


/**LOGO IMG URL FOR GET IMAGE***/
define('LOGO_IMG_PATH',SITEURL.UPLOADS.DS.'logo'.DS);
define('LOGO_IMG_THUMB_PATH',SITEURL.UPLOADS.DS.'logo'.DS.'thumbs'.DS);


/**HOME PAGE IMG URL FOR GET IMAGE***/
define('HOME_PAGE_IMG_PATH',SITEURL.UPLOADS.DS.'home_page'.DS);



/**FEVICON IMG URL FOR GET IMAGE***/
define('FEVICON_IMG_PATH',SITEURL.UPLOADS.DS.'fevicon'.DS);
define('FEVICON_IMG_THUMB_PATH',SITEURL.UPLOADS.DS.'fevicon'.DS.'thumbs'.DS);


/***LANGAUGE URL CONSTANTS***/
define('URL_LANGUAGE_INDEX', SITEURL.'language'.DS.'index');
define('URL_LANGUAGE_AJAX_GET_LANGUAGE_LIST', SITEURL.'language'.DS.'ajax_get_language_list');
define('URL_ADD_LANGUAGE', SITEURL.'language'.DS.'addlanguage');
define('URL_DELETE_LANGUAGE', SITEURL.'language'.DS.'deletelanguage');
define('URL_LANGUAGE_PHRASES', SITEURL.'language'.DS.'phrases');
define('URL_LANGUAGE_AJAX_GET_PHRASE_LIST', SITEURL.'language'.DS.'ajax_get_phrase_list');
define('URL_LANGUAGE_ADDEDIT_PHRASE', SITEURL.'language'.DS.'addedit-phrase');
define('URL_LANGUAGE_VIEW_PHRASE_DETAILS', SITEURL.'language'.DS.'view-phrase-details');
define('URL_LANGUAGE_ADDLANGUEGEPHRASES', SITEURL.'language'.DS.'addlanguagephrases');
/***LANGAUGE PAGE CONSTANTS***/



/***MENU MODULE URLS**/
define('URL_MENU_INDEX',SITEURL.'menu'.DS.'index');
define('URL_MENU_AJAX_GET_LIST', SITEURL.'menu'.DS.'ajax_get_list');
define('URL_ADDEDIT_MENU',SITEURL.'menu'.DS.'addedit'.DS);



/***ITEM TYPES MODULE URLS**/
define('URL_ITEM_TYPES_INDEX',SITEURL.'item_types'.DS.'index');
define('URL_ITEM_TYPES_AJAX_GET_LIST', SITEURL.'item_types'.DS.'ajax_get_list');
define('URL_ADDEDIT_ITEM_TYPE',SITEURL.'item_types'.DS.'addedit-itemtype'.DS);



/***ITEMS MODULE URLS**/
define('URL_ITEMS_INDEX',SITEURL.'items'.DS.'index');
define('URL_ITEMS_AJAX_GET_LIST', SITEURL.'items'.DS.'ajax_get_list');
define('URL_ADD_ITEM',SITEURL.'items'.DS.'add-item'.DS);
define('URL_EDIT_ITEM',SITEURL.'items'.DS.'edit-item'.DS);


/***ADDONS MODULE URLS**/
define('URL_ADDONS_INDEX',SITEURL.'addons'.DS.'index');
define('URL_ADDONS_AJAX_GET_LIST', SITEURL.'addons'.DS.'ajax_get_list');
define('URL_ADDEDIT_ADDON',SITEURL.'addons'.DS.'addedit'.DS);



/***OPTIONS MODULE URLS**/
define('URL_OPTIONS_INDEX',SITEURL.'options'.DS.'index');
define('URL_OPTIONS_AJAX_GET_LIST', SITEURL.'options'.DS.'ajax_get_list');
define('URL_ADDEDIT_OPTION',SITEURL.'options'.DS.'addedit'.DS);



/***ORDERS MODULE URLS**/
define('URL_ORDERS_INDEX',SITEURL.'orders'.DS.'index'.DS);
define('URL_ORDERS_AJAX_GET_LIST', SITEURL.'orders'.DS.'ajax_get_list');
define('URL_VIEW_ORDER',SITEURL.'orders'.DS.'view-order');
define('URL_DELETE_ORDER',SITEURL.'orders'.DS.'delete-order');
define('URL_UPDATE_ORDER',SITEURL.'orders'.DS.'update-order');


/***FAQS CATEGORIES MODULE URLS**/
define('URL_FAQS_CATEGORIES_INDEX',SITEURL.'faqs_categories'.DS.'index');
define('URL_FAQS_CATEGORIES_AJAX_GET_LIST', SITEURL.'faqs_categories'.DS.'ajax_get_list');
define('URL_ADDEDIT_FAQS_CATEGORIES',SITEURL.'faqs_categories'.DS.'addedit'.DS);



/***FAQS MODULE URLS**/
define('URL_FAQS_INDEX',SITEURL.'faqs'.DS.'index');
define('URL_FAQS_AJAX_GET_LIST', SITEURL.'faqs'.DS.'ajax_get_list');
define('URL_ADDEDIT_FAQ',SITEURL.'faqs'.DS.'addedit'.DS);


/***OFFERS MODULE URLS**/
define('URL_OFFERS_INDEX',SITEURL.'offers'.DS.'index');
define('URL_OFFERS_AJAX_GET_LIST', SITEURL.'offers'.DS.'ajax_get_list');
define('URL_ADD_OFFER',SITEURL.'offers'.DS.'add-offer');
define('URL_EDIT_OFFER',SITEURL.'offers'.DS.'edit-offer'.DS);


/***LOCATIONS MODULE URLS**/
define('URL_LOCATIONS_INDEX',SITEURL.'locations'.DS.'index');
define('URL_LOCATIONS_AJAX_GET_CITIES_LIST', SITEURL.'locations'.DS.'ajax_get_cities_list');
define('URL_ADDEDIT_CITY',SITEURL.'locations'.DS.'addedit-city'.DS);
define('URL_DELIVERY_LOCATIONS',SITEURL.'locations'.DS.'delivery_locations');
define('URL_DELIVERY_LOCATIONS_AJAX_GET_LIST', SITEURL.'locations'.DS.'ajax_get_delivery_locations');
define('URL_ADDEDIT_DELIVERY_LOCATION',SITEURL.'locations'.DS.'addedit-delivery-location'.DS);



/***PAGES MODULE URLS**/
define('URL_PAGES_INDEX',SITEURL.'pages'.DS.'index');
define('URL_PAGES_AJAX_GET_LIST', SITEURL.'pages'.DS.'ajax_get_list');
define('URL_ADDEDIT_PAGE',SITEURL.'pages'.DS.'addedit'.DS);


/***SETTINGS MODULE URLS**/
define('URL_SITE_SETTINGS',SITEURL.'settings'.DS.'site-settings');

define('URL_APP_SETTINGS',SITEURL.'settings'.DS.'app-settings');

define('URL_TINIFY_SETTINGS',SITEURL.'settings'.DS.'tinify-settings');

define('URL_SEO_SETTINGS',SITEURL.'settings'.DS.'seo-settings');


define('URL_PAYPAL_SETTINGS',SITEURL.'settings'.DS.'paypal-settings');
define('URL_EMAIL_SETTINGS',SITEURL.'settings'.DS.'email-settings');
define('URL_SMS_GATEWAYS',SITEURL.'settings'.DS.'sms-gateways');
define('URL_MAKE_DEFAULT',SITEURL.'settings'.DS.'makedefault');
define('URL_UPDATE_SMS_FIELD_VALUDS',SITEURL.'settings'.DS.'update-sms-field-values');
define('URL_PUSH_NOTIFICATION_SETTINGS',SITEURL.'settings'.DS.'push-notifications');
define('URL_EMAIL_TEMPLATES',SITEURL.'settings'.DS.'email-templates');
define('URL_SMS_TEMPLATES',SITEURL.'settings'.DS.'sms-templates');
define('URL_SOCIAL_NETWORKS',SITEURL.'settings'.DS.'social-networks');
define('URL_CHANGE_LANGUAGE', SITEURL.'settings'.DS.'change-language');
define('URL_PUSHER_NOTIFICATION_SETTINGS',SITEURL.'settings'.DS.'pusher-notifications');



/***REPORTS MODULE URLS**/
define('URL_REPORTS_INDEX',SITEURL.'reports'.DS.'index');
define('URL_REPORTS_CLIENT_WISE',SITEURL.'reports'.DS.'customer-wise-reports');
define('URL_REPORTS_LOCATION_WISE',SITEURL.'reports'.DS.'location-wise-reports');
define('URL_REPORTS_ITEM_WISE',SITEURL.'reports'.DS.'item-wise-reports');


/***POINT SETTINGS MODULE URLS***/
define('URL_POINTS_SETTINGS',SITEURL.'loyality_points'.DS.'points_settings');
define('URL_USER_REWARD_POINTS',SITEURL.'loyality_points'.DS.'user_reward_points');
define('GET_AJAX_USER_REWARD_POINTS',SITEURL.'loyality_points'.DS.'get_ajax_user_reward_points');
define('URL_POINT_LOGS',SITEURL.'loyality_points'.DS.'point_logs');


/***REFERRAL MODULE URLS***/
define('URL_REFERRAL_SETTINGS',SITEURL.'referral'.DS.'settings');
define('URL_REFERRAL_USERS',SITEURL.'referral'.DS.'users');
define('GET_AJAX_REFERRAL_USERS',SITEURL.'referral'.DS.'get_ajax_users');



/***CUSTOMERS MODULE URLS**/
define('URL_CUSTOMERS_INDEX',SITEURL.'customers'.DS.'index');
define('URL_CUSTOMERS_AJAX_GET_LIST', SITEURL.'customers'.DS.'ajax_get_list');
define('URL_VIEW_CUSTOMER',SITEURL.'customers'.DS.'view-details'.DS);


/***USERS MODULE URLS**/
define('URL_USERS_INDEX',SITEURL.'users'.DS.'index');
define('URL_USERS_AJAX_GET_KITCHEN_MANAGERS', SITEURL.'users'.DS.'ajax_get_kitchen_managers');
define('URL_ADDEDIT_KITCHEN_MANAGER',SITEURL.'users'.DS.'addedit_kitchen_manager'.DS);



define('URL_USERS_DELIVERY_MANAGERS',SITEURL.'users'.DS.'delivery_managers');
define('URL_USERS_AJAX_GET_DELIVERY_MANAGERS', SITEURL.'users'.DS.'ajax_get_delivery_managers');
define('URL_ADDEDIT_DELIVERY_MANAGER',SITEURL.'users'.DS.'addedit_delivery_manager'.DS);


/***CARD MODULE URLS**/
define('URL_CARDS_INDEX',SITEURL.'cards'.DS.'index');
define('URL_CARDS_AJAX_GET_LIST', SITEURL.'cards'.DS.'ajax_get_list');
define('URL_ADDEDIT_CARD',SITEURL.'cards'.DS.'addedit'.DS);


/***CART URLS**/
define('URL_CART_INDEX',SITEURL.'cart'.DS.'index');
define('URL_SUCCESS',SITEURL.'cart'.DS.'success');

define('URL_CART_ADD_ADDRESS',SITEURL.'cart'.DS.'add_address');


/***ICONS***/
define('CLASS_VIEW_BTN', 'btn btn-info margin-right-5');
define('CLASS_EDIT_BTN', 'btn btn-primary margin-right-5');
define('CLASS_DELETE_BTN', 'btn btn-warning margin-right-5');
define('CLASS_MAKE_DEFAULT_BTN', 'btn btn-success margin-right-5');
define('CLASS_VIEW_ADD_IMAGES', 'btn btn-success margin-right-5');
define('CLASS_FAVOURITE_BTN', 'btn btn-info margin-right-5');
define('CLASS_ICON_VIEW', 'fa fa-eye');
define('CLASS_ICON_EDIT', 'fa fa-edit');
define('CLASS_ICON_DELETE', 'fa fa-trash');
define('CLASS_ICON_MAKE_DEFAULT', 'fa fa-hand-o-right');
define('CLASS_ICON_VIEW_ADD_IMAGE', 'fa fa-picture-o');
define('CLASS_ICON_STAR', 'fa fa-star-o');
define('IMG_WIDTH_DATATABLE', '48');
define('IMG_HEIGHT_DATATABLE', '48');

define('DEMO', FALSE);


define('CONST_QTY_MIN', "1");
define('CONST_QTY_MAX', "99");
define('PER_PAGE',5);
define('ITEMS_PER_PAGE',9);
define('ADDRESS_PER_PAGE',3);
define('ORDERS_PER_PAGE',1);


define('MENU_ITEMS_PER_PAGE',8);


define('HOME_MENU_ITEMS_PER_PAGE',12);

/***THUMB IMAGE CONSTANTS****/

define('THUMB_IMG_WIDTH',200);
define('THUMB_IMG_HEIGHT',200);


define('VERSION','1.0');