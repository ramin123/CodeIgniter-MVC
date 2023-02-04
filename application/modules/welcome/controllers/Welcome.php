<?php
/**
 * MENORAH RESTAURANT-DIGISAMARITAN
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, DIGISAMARITAN
 *
 * @category  Welcome
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Welcome Class
 * 
 * Welcome operations.
 *
 * @category  Welcome
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Welcome extends MY_Controller
{

    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     MENORAH RESTAURANT
    | -----------------------------------------------------
    | AUTHOR:           DIGISAMARITAN
    | -----------------------------------------------------
    | EMAIL:            digisamaritan@gmail.com
    | -----------------------------------------------------
    | COPYRIGHTS:       RESERVED BY DIGISAMARITAN
    | -----------------------------------------------------      
    | http://codecanyon.net/user/digisamaritan
    | http://conquerorstech.net/
    | -----------------------------------------------------
    |
    | MODULE:           WELCOME CONTROLLER
    | -----------------------------------------------------
    | This is Welcome module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        
        if ($this->ion_auth->logged_in()) {
            if ($this->ion_auth->is_admin()) {
                redirect(URL_ADMIN_INDEX);
            } else if ($this->ion_auth->is_kitchen_manager()) {
                redirect(URL_KITCHEN_MANAGER);
            } else if ($this->ion_auth->is_delivery_manager()) {
                redirect(URL_DELIVERY_MANAGER);
            }
        }
    }
    
    
    /**
     * Home page
     * Fetch latest 8 menus
     *
     * @return array
     **/
    public function index()
    {
        //get latest 8 menus
        //get all active menus
        $m=0;
        $menus=array();
        $records = $this->base_model->get_query_result("select menu_id,menu_name from ".TBL_PREFIX.TBL_MENU." where status='Active' order by menu_id desc");
        
        if (!empty($records)) {
            foreach ($records as $record) {
                
                if ($m==8) {
                    break;
                }
                
                //check items exist under menu 
                $items = array();
                
                $items = $this->base_model->get_query_result("select * from ".TBL_PREFIX.TBL_ITEMS." where menu_id=".$record->menu_id." and item_cost>0 and status='Active' ");
                
                if (!empty($items)) {
                
                    array_push($menus, $record);
                    $m++;
                }
            }
        }

        $this->data['menus']        = $menus;
        
        $this->data['home_page_caption']        = $this->config->item('site_settings')->home_page_caption;
        $this->data['home_page_tagline']        = $this->config->item('site_settings')->home_page_tagline;
        
        $this->data['activemenu']     = "home";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('home');
        $this->data['content']         = PAGE_HOME;
        $this->_render_page('templates/home-template', $this->data);
        
    }
    
     
    
    /**
     * Home page Items block
     * Fetch 12 items of selected menu
     * AJAX CALL
     *
     * @return array
     **/
    function get_home_menu_items_block() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page='';
            
            $menu_id     = $this->input->post('menu_id');
            
            $offset = 0;//current offset
            
            
            $items          = $this->welcome_model->get_home_menu_items($offset, $menu_id);
            $total_items = $this->welcome_model->numrows;
            
            
            $offset = $offset+HOME_MENU_ITEMS_PER_PAGE;//next offset
            $page = $this->load->view('home/fc-home-menu-items', array('items'=>$items,'offset'=>$offset,'total_items'=>$total_items));
            
            echo $page;
        }
    }
    
    
    /**
     * Contact US
     *
     * @return boolean
     **/
    function contact_us()
    {
        if (isset($_POST['contactus'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_CONTACT_US, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            //Form Validations
            $this->form_validation->set_rules('name', get_languageword('name'), 'required|xss_clean');
            $this->form_validation->set_rules('email', get_languageword('email'), 'required|valid_email|xss_clean');
            $this->form_validation->set_rules('subject', get_languageword('subject'), 'required|xss_clean');
            $this->form_validation->set_rules('message', get_languageword('message'), 'required|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                
                $name        = $this->input->post('name');        
                $email       = $this->input->post('email');
                $subject     = $this->input->post('subject');
                $message     = $this->input->post('message');
                
                $email_template = $this->base_model->fetch_records_from(TBL_EMAIL_TEMPLATES, array('subject'=>'contact_query','status'=>'Active'));
                
                if (!empty($email_template)) {
                    
                    $email_template = $email_template[0];
                    
                    $content         = $email_template->email_template;
                    
                
                    $logo_img='<img src="'.get_site_logo().'" class="img-responsive">';
                    
                    $content         = str_replace("__SITE_LOGO__", $logo_img, $content);
                            
                    $content         = str_replace("__SITE_TITLE__", $this->config->item('site_settings')->site_title, $content);
                    
                    $content         = str_replace("__USER__", $name, $content);
                    
                    $content         = str_replace("__USER_NAME__", $name, $content);
                    
                    $content         = str_replace("__EMAIL__", $email, $content);
                    
                    $content         = str_replace("__SUBJECT__", $subject, $content);
                    
                    $content         = str_replace("__MESSAGE__", $message, $content);
                    
                    $content         = str_replace("__SITE_TITLE__", $this->config->item('site_settings')->site_title, $content);
                    
                    $from     = $email;
                    $to     = $this->config->item('site_settings')->portal_email;
                    $sub = get_languageword('contact_query').' - '.$this->config->item('site_settings')->site_title;
                    
                    if (sendEmail($from, $to, $sub, $content)) {
                        $msg .= get_languageword('your_contact_request_sent_successfully');
                        $status=0;
                    } else {
                        $msg .= get_languageword('your_contact_request_not_sent_due_to_some_technical_issue_please_contact_us_after_some_time_thankyou');
                        $status=2;
                    }
                } else {
                    $msg .= get_languageword('your_contact_query_not_sent_due_to_some_technical_issue_please_contact_us_after_sometime_thank_you');
                    $status=1;
                }
                
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_CONTACT_US);
            }
        }
        $this->data['css_js_files']  = array('form_validation');
        $this->data['activemenu']     = "contact_us";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('contact_us');
        $this->data['content']         = 'contact_us';
        $this->_render_page(getTemplate(), $this->data);
    }
    
    
    /**
     * About US
     *
     * @return boolean
     **/
    function about_us()
    {
        $record = $this->base_model->fetch_records_from(TBL_PAGES, array('slug'=>'about-us','status'=>'Active'));
        if (!empty($record)) {
            $record = $record[0];
        }
        
        $this->data['record']        = $record;
        $this->data['activemenu']     = "about_us";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('about_us');
        $this->data['content']         = 'about_us';
        
        
        $this->_render_page(getTemplate(), $this->data);
    }
    
    
    /**
     * How It Works
     *
     * @return boolean
     **/
    function how_it_works()
    {
        $record = $this->base_model->fetch_records_from(TBL_PAGES, array('slug'=>'how-it-works','status'=>'Active'));
        if (!empty($record)) {
            $record = $record[0];
        }
        
        $this->data['record']        = $record;
        $this->data['activemenu']     = "home";
        $this->data['pagetitle']     = get_languageword('how_it_works');
        $this->data['content']         = 'how_it_works';
        $this->_render_page(getTemplate(), $this->data);
    }
    
    
    /**
     * Terms Conditions
     *
     * @return boolean
     **/
    function terms_conditions()
    {
        $record = $this->base_model->fetch_records_from(TBL_PAGES, array('slug'=>'terms-conditions','status'=>'Active'));
        if (!empty($record)) {
            $record = $record[0];
        }
        
        $this->data['record']        = $record;
        $this->data['activemenu']     = "home";
        $this->data['pagetitle']     = get_languageword('terms_conditions');
        $this->data['content']         = 'terms_conditions';
        $this->_render_page(getTemplate(), $this->data);
    }
    
    
    /**
     * Privacy Policy
     *
     * @return boolean
     **/
    function privacy_policy()
    {
        $record = $this->base_model->fetch_records_from(TBL_PAGES, array('slug'=>'privacy-policy','status'=>'Active'));
        if (!empty($record)) {
            $record = $record[0];
        }
        
        $this->data['record']        = $record;
        $this->data['activemenu']     = "home";
        $this->data['pagetitle']     = get_languageword('privacy_policy');
        $this->data['content']         = 'privacy_policy';
        $this->_render_page(getTemplate(), $this->data);
    }
    
    
    /**
     * FAQs Page
     * Get Faqs categories
     *
     * @return array
     **/
    function faqs()
    {
        //faq categories
        $categories = $this->base_model->get_categories_options('Active');
        
        $this->data['categories']    = $categories;
        $this->data['activemenu']     = "home";
        $this->data['pagetitle']     = get_languageword('faqs');
        $this->data['content']         = 'faqs-page';
        $this->_render_page(getTemplate(), $this->data);
    }
    
    
    /**
     * Get FAQs of selected category
     * AJAX CALL
     *
     * @return array
     **/
    function get_faqs_list() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page='';
            
            $fc_id = $this->input->post('fc_id');
            
            $faqs = $this->base_model->fetch_records_from(TBL_FAQS, array('fc_id'=>$fc_id,'status'=>'Active'));
            
            $page = $this->load->view('faqs-list-block', array('faqs'=>$faqs));
            
            echo $page;
        }
        
    }
    
    
    /**
     * SITE MAP
     *
     * @return page
     **/
    function site_map()
    {
        $this->data['activemenu']     = "home";
        $this->data['pagetitle']     = get_languageword('site_map');
        $this->data['content']         = 'sitemap';
        $this->_render_page(getTemplate(), $this->data);
    }
    
    
    /**
     * MENU PAGE
     * FETCH ALL MENUS
     *
     * @return array
     **/
    function fc_menu() 
    {
        
        $search_item ='';
        if ($this->input->post('search_item')) {
            $search_item = $this->input->post('search_item');
        }
        
        //get all active menus
        $menus=array();
        $records = $this->base_model->fetch_records_from(TBL_MENU, array('status'=>'Active'), '', 'menu_name');
        
        if (!empty($records)) {
            foreach ($records as $record) {
                //check items exist under menu 
                $items = array();
                
                $items = $this->base_model->fetch_records_from(TBL_ITEMS, array('menu_id'=>$record->menu_id,'item_cost >'=>0,'status'=>'Active'));
                
                if (!empty($items)) {
                    array_push($menus, $record);
                }
            }
        }
        
        $this->data['menus']        = $menus;
        
        $this->data['search_item']    = $search_item;
        $this->data['activemenu']     = "menu";
        $this->data['pagetitle']     = "MENU";
        $this->data['content']         = 'fc-menu-page';
        $this->_render_page(getTemplate(), $this->data);
    }
    
    
    /**
     * MENU PAGE
     * FETCH SELECTED MENU ITEMS
     * AJAX CALL
     *
     * @return array
     **/
    function get_menu_items_block() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page='';
            
            $menu_id     = $this->input->post('menu_id');
            $menu_name   = $this->input->post('menu_name');
            
            $offset = 0;//current offset
            
            
            $items          = $this->welcome_model->get_menu_items($offset, $menu_id);
            $total_items = $this->welcome_model->numrows;
            
            
            $offset = $offset+MENU_ITEMS_PER_PAGE;//next offset
            $page = $this->load->view('fc-menu-items-block', array('items'=>$items,'menu_id'=>$menu_id,'menu_name'=>$menu_name,'offset'=>$offset,'total_items'=>$total_items));
            
            echo $page;
        }
    }
    
    
    /**
     * MENU PAGE
     * FETCH SELECTED MENU MORE ITEMS  - LOAD MORE
     * AJAX CALL
     *
     * @return array
     **/
    function get_menu_more_items_block() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page='';
            
            $menu_id     = $this->input->post('menu_id');
            
            $offset = $this->input->post('offset');
            
            $items          = $this->welcome_model->get_menu_items($offset, $menu_id);
            $total_items = $this->welcome_model->numrows;
            
            
            
            $page = $this->load->view('fc-menu-more-items-block', array('items'=>$items));
            
            echo $page;
        }
    }
    
    
    /**
     * MENU PAGE
     * FETCH OFFER ITEMS
     * AJAX CALL
     *
     * @return array
     **/
    function get_offers_block() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page='';
            
            $offset = 0;//current offset
            
            $offers    = $this->welcome_model->get_menu_offers($offset);
            $total_offers = $this->welcome_model->numrows;
            
            $offset = $offset+MENU_ITEMS_PER_PAGE;//next offset
            
            $page = $this->load->view('fc-menu-offers-block', array('offers'=>$offers,'offset'=>$offset,'total_offers'=>$total_offers));
            
            echo $page;
        }
    }
    
    
    /**
     * MENU PAGE
     * FETCH OFFER ITEMS - LOAD MORE
     * AJAX CALL
     *
     * @return array
     **/
    function get_more_offers() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page='';
            
            $offset = $this->input->post('offset');
            
            $offers         = $this->welcome_model->get_menu_offers($offset);
            $total_offers = $this->welcome_model->numrows;
            
            
            $page = $this->load->view('fc-more-offers-block', array('offers'=>$offers));
            
            echo $page;
        }
    }
    
    /**
     * MENU PAGE
     * FETCH POPULAR ITEMS
     * AJAX CALL
     *
     * @return page
     **/
    function get_popular_items_block() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page='';
            
            $offset = 0;//current offset
            
            $items          = $this->welcome_model->get_popular_items($offset);
            $total_items = $this->welcome_model->numrows;
            
            $offset = $offset+MENU_ITEMS_PER_PAGE;//next offset
            
            $page = $this->load->view('fc-popular-items-block', array('items'=>$items,'offset'=>$offset,'total_items'=>$total_items));
            
            echo $page;
        }
    }
    
    
    /**
     * MENU PAGE
     * FETCH POPULAR ITEMS - LOAD MORE
     * AJAX CALL
     *
     * @return array
     **/
    function get_more_popular_items() 
    {
    
        if ($this->input->is_ajax_request()) {
            
            $page='';
            
            $offset = $this->input->post('offset');
            
            $items         = $this->welcome_model->get_popular_items($offset);
            $total_items = $this->welcome_model->numrows;
            
            $page = $this->load->view('fc-popular-more-items-block', array('items'=>$items));
            
            echo $page;
        }    
    }
    
    
    
    /**
     * MENU PAGE
     * FETCH SEARCH ITEMS
     * AJAX CALL
     *
     * @return array
     **/
    function get_search_items_block() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page='';
            
            $offset = 0;//current offset
            
            $search_string = $this->input->post('strng');
            
            
            $items           = $this->welcome_model->get_search_items($offset, $search_string);
            $total_items   = $this->welcome_model->numrows;
            
            $offset = $offset+MENU_ITEMS_PER_PAGE;//next offset
            
            
            $page = $this->load->view('fc-search-items-block', array('items'=>$items,'offset'=>$offset,'total_items'=>$total_items,'search_string'=>$search_string));
    
            
            echo $page;
        }
    }
    
    
    /**
     * MENU PAGE
     * FETCH SEARCH ITEMS - LOAD MORE
     * AJAX CALL
     *
     * @return array
     **/
    function get_more_search_items() 
    {
    
        if ($this->input->is_ajax_request()) {
            
            $page='';
            
            $search_string = $this->input->post('strng');
            
            $offset = $this->input->post('offset');
            
            
            $items         = $this->welcome_model->get_search_items($offset, $search_string);
            $total_items = $this->welcome_model->numrows;
            
            $page = $this->load->view('fc-search-more-items-block', array('items'=>$items,'search_string'=>$search_string));
            
            echo $page;
        }    
    }
    
    
    
    /**
     * HOME PAGE, MENU PAGE - ITEM POPUP
     * GET ITEM ADDONS OPTIONS
     * return @PAGE CONTENT FOR MODAL
     * Popup content
     *
     * @return array
     **/
    function get_item_addons_options() 
    {
        
        if ($this->input->is_ajax_request()) {
            $page='';
            $item_id = $this->input->post('item_id');
            
            
            if ($item_id > 0) {
                
                //get item_record
                $record = $this->base_model->get_query_result("select * from ".TBL_PREFIX.TBL_ITEMS." where item_id=".$item_id." and status='Active' and item_cost>0 ");
                
                if (!empty($record)) {
                    
                    $currency_symbol = $this->config->item('site_settings')->currency_symbol;
                    
                    $record = $record[0];
                    
                    //
                    // $frm="modal";
                    
                    $item_price = $record->item_cost;
                    
                    //get options
                    $options = $this->welcome_model->getItemOptions($item_id);
                    
                    if (!empty($options)) {
                        $item_price = $options[0]->price;
                    }
                    
                    $page .= '<div class="row"> <div class="mt-2 mb-2 clearfix">
                    <div class="col-sm-6">
                      <div class="cart-item-title">'.$record->item_name.'</div>
                      <div class="card-item-price">'.$currency_symbol.'<span id="hp_final_cost">'.$item_price.'</span>'.'</div>
                    </div>

					<div class="col-sm-6">
					<a href="javascript:void(0);" onclick="addToCart()" class="btn btn-sm btn-round btn-primary card-btn">Add to Cart</a>
					</div></div>';
                    
                    
                    
                    
                    
                    $page .= '<input type="hidden" id="selected_item_id" value="'.$record->item_id.'">
					<input type="hidden" id="selected_item_price" value="'.$record->item_cost.'">
					<input type="hidden" id="selected_menu_id" value="'.$record->menu_id.'">
					<input type="hidden" id="itemFrom" value="items">
					
                 </div>';
                 
                 
                    //get addons
                    $addons = $this->welcome_model->getItemAddons($item_id);
                
                    if (!empty($addons)) {
                     
                        $page .= '<div class="category-title">Addons</div>
								<div class="menu-list">
								<div class="row">
								';
               
                        foreach ($addons as $addon) {
                    
                            $page .= '<div class="form-check dm-add-qty">
						<label class="form-check-label">
						
						  <input type="checkbox" name="addonqty_'.$addon->addon_id.'" id="'.$addon->addon_id.'" class="form-check-input" value="'.$addon->addon_id.'" data-val="'.$addon->price.'" onclick="update_cost();">
						  
						 <span>'.$addon->addon_name.'</span>
						 <span>'.$currency_symbol.$addon->price.'</span>
						</label>
					  </div>';
                 
                        }                        
               
               
                        $page .= '</div>
								</div>
								</div>';
                    }
                 
                 
                 
                    if (!empty($options)) {
                     
                        $page .= '<div class="category-title">Options</div>
								<div class="menu-list">
								<div class="row">
								';
                        $o=0;
                        foreach ($options as $option) {
                            $o++;
                    
                            $checked='';
                            if ($o==1) { 
                                $checked='checked="checked"';
                            }
                    
                        
                  
                            $page .= '<div class="form-check">
				  <label class="form-check-label">
					<input class="form-check-input" type="radio" name="item_option_id" data-val="'.$option->price.'" value="'.$option->item_option_id.'" '.$checked.' onclick="update_cost();">
					
					<span>'.$option->option_name.'</span>
					<span>'.$currency_symbol.$option->price.'</span>
					
				  </label>
				</div>';
                 
                        }                        
               
               
                        $page .= ' </div>
								</div>
								</div>';
                    }
                 
                 
                 
                 
                 
                 
                    echo $page;
                    
                } else {
                    echo FALSE;//item record not found
                }
                
            } else {
                echo FALSE;//item_id not found
            }
        }
    }
    
    
    /**
     * MENU PAGE - CART DIV
     * GET ITEM ADDONS OPTIONS
     * return @PAGE CONTENT FOR MODAL
     * Popup content
     *
     * @return array
     **/
    function get_cart_itm_adns_optns() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page='';
            $item_id = $this->input->post('item_id');
            
            $record=array();
            
            if ($item_id > 0 && !empty($this->cart->contents())) {
                
                foreach ($this->cart->contents() as $item) {
                                
                    if ($item['id']==$item_id) {
                        array_push($record, $item);
                        break;
                    }
                }
                
                
                if (!empty($record)) {
                    
                    $currency_symbol = $this->config->item('site_settings')->currency_symbol;
                    
                    $record = $record[0];
                    
                    
                    $item_price=0;
                    if (isset($record['options']['item_option_price'])) {
                        
                        $item_price = $record['qty']*$record['options']['item_option_price'];
                        
                    } else {
                        
                        $item_price = $record['qty']*$record['options']['item_cost'];
                    }
                    
                    
                    if (isset($record['options']['extra_costs_total'])) {
                        $item_price += $record['options']['extra_costs_total'];
                    }
                    
                    
                    //$record['subtotal'];
            
                    
                    
                    
                    
                    
                    
                    //get options
                    $options = $this->welcome_model->getItemOptions($item_id);
                    
                    
                    $page .= '<div class="row"><div class="mt-2 mb-2 clearfix">
                    <div class="col-sm-6">
                      <div class="cart-item-title">'.$record['name'].'</div>
                      <div class="card-item-price">'.$currency_symbol.'<span id="hpp_final_cost">'.$item_price.'</span>'.'</div>
                    </div>
					<div class="col-sm-6">
					<a href="javascript:void(0);" onclick="updateToCart()" class="btn btn-sm btn-round btn-primary card-btn">Update to Cart</a>
					</div></div>';
                    
                    
                    
                    $page .= '<input type="hidden" id="selected_item_id" value="'.$record['id'].'">
					
					<input type="hidden" id="selected_item_price" value="'.$record['options']['item_cost'].'">
					
					<input type="hidden" id="rowid" value="'.$record['rowid'].'">
					<input type="hidden" id="itemFrom" value="items">
					
					<input type="hidden" id="itm_qty" value="'.$record['qty'].'">
					
                 </div>';
                 
                 
                    //get addons
                    $addons = $this->welcome_model->getItemAddons($item_id);
                 
                    if (!empty($addons)) {
                     
                        $page .= '<div class="category-title">Addons</div>
								<div class="menu-list">
								<div class="row">
								';
                    
                    
                        $slctd_addons=array();
                        if (isset($record['options']['addons'])) {
                        
                            foreach ($record['options']['addons'] as $adn) {
                            
                                $adn = explode('=', $adn);
                                if (!empty($adn)) {
                                    array_push($slctd_addons, $adn[0]);
                                }
                            }
                        }
                    
                    
                        foreach ($addons as $addon) {
                    
                            $checked='';
                            if (in_array($addon->addon_id, $slctd_addons)) {
                                $checked='checked="checked"';
                            }
                    
                    
                            $page .= '<div class="form-check dm-add-qty">
						<label class="form-check-label">
						
						  <input type="checkbox" name="addonqty_'.$addon->addon_id.'" id="'.$addon->addon_id.'" class="form-check-input" value="'.$addon->addon_id.'" data-val="'.$addon->price.'" onclick="cart_update_cost();" '.$checked.'>
						  
						 <span>'.$addon->addon_name.'</span>
						 <span>'.$currency_symbol.$addon->price.'</span>
						</label>
					  </div>';
                 
                        }                        
               
               
                        $page .= '</div>
								</div>
								</div>';
                    }
                 
                 
                 
                    if (!empty($options)) {
                     
                        $page .= '<div class="category-title">Options</div>
								<div class="menu-list">
								<div class="row">
								';
                    
                        foreach ($options as $option) {
                    
                    
                            $checked='';
                            if ($option->item_option_id==$record['options']['item_option_id'] && $option->option_id==$record['options']['option_id']) { 
                                $checked='checked="checked"';
                            }
                    
                        
                            $page .= '<div class="form-check">
				  <label class="form-check-label">
					<input class="form-check-input" type="radio" name="item_option_id" data-val="'.$option->price.'" value="'.$option->item_option_id.'" '.$checked.' onclick="cart_update_cost();">
					
					<span>'.$option->option_name.'</span>
					<span>'.$currency_symbol.$option->price.'</span>
					
				  </label>
				</div>';
                 
                        }                        
               
               
                        $page .= ' </div>
								</div>
								</div>';
                    }
                 
                 
                 
                 
                 
                 
                    echo $page;
                    
                } else {
                    echo FALSE;//item record not found
                }
                
            } else {
                echo FALSE;//item_id not found
            }
        }
    }
    
    
    /**
     * MENU PAGE
     * SHOW OFFER ITEMS
     * return @PAGE CONTENT FOR MODAL
     * Popup content
     *
     * @return array
     **/
    function get_offr_itms() 
    {
        
        if ($this->input->is_ajax_request()) {
            $page='';
            $offer_id = $this->input->post('offer_id');
            
            $frm = $this->input->post('frm');
            
            
            if ($offer_id > 0) {
                
                //get offer_record
                $record = $this->base_model->get_query_result("SELECT * FROM ".TBL_PREFIX.TBL_OFFERS." WHERE offer_id=".$offer_id." AND status='Active' AND CURDATE() BETWEEN offer_start_date AND offer_valid_date AND offer_cost>0");
                
                
                if (!empty($record)) {
                    
                    $currency_symbol = $this->config->item('site_settings')->currency_symbol;
                    
                    $record = $record[0];
                    
                    
                    $item_price = $record->offer_cost;
                    
                    //get offer_products
                    $query     = "SELECT * FROM ".TBL_PREFIX.TBL_OFFER_PRODUCTS." WHERE offer_id=".$offer_id." AND quantity > 0 ORDER BY item_name ";
                    $offer_products = $this->base_model->get_query_result($query);
                    
                    
                    
                    $page .= '<div class="row">
					<div class="mt-2 mb-2 clearfix">
                    <div class="col-sm-6">
                      <div class="cart-item-title">'.$record->offer_name.'</div>
                      <div class="card-item-price">'.$currency_symbol.'<span id="hp_final_cost">'.$item_price.'</span>'.'</div>
                    </div>';
                    
                    if ($frm=='') {
                    
                        $page .= '<div class="col-sm-6">
					<a href="javascript:void(0);" onclick="addOfferToCart()" class="btn btn-sm btn-round btn-primary card-btn">Add to Cart</a>
					</div>';
                    
                        $page .= '<input type="hidden" id="selected_offer_id" value="'.$record->offer_id.'">
					<input type="hidden" id="selected_offer_price" value="'.$record->offer_cost.'">
					<input type="hidden" id="itemFrom" value="offers">';
                    
                    }
                    
                    
                    
                    $page .= '</div>';
                 
                 
                 
                    if (!empty($offer_products)) {
                     
                        $page .= '<div class="category-title">Offer Products</div>
								<div class="menu-list">';
               
                        foreach ($offer_products as $product) {
                    
                            $page .= '
					<div class="row offr-name">
						<div class="col-xs-9">
						 <span>'.$product->item_name.'</span>
						 </div>
						 <div class="col-xs-3">
						 <span>'.$product->quantity.'</span>
						 </div>
						</div>';
                      
                      
                    
                 
                        }                        
               
               
                        $page .= '</div>
								</div>';
                    }
                 
                 
                    echo $page;
                    
                } else {
                    echo FALSE;//offer record not found
                }
                
            } else {
                echo FALSE;//offer_id not found
            }
        }
    }
    
    
    
    /**
     * MENU PAGE
     * LOAD CART DIV
     *
     * @return page
     **/
    function load_cart_div() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page = $this->load->view('fc-cart-div');
            
            echo $page;
        }
    }
    
    
    
    /**
     * CHECK OUT PAGE
     * LOAD CART SUMMARY DIV
     *
     * @return page
     **/
    function load_cart_summary_div() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $ua_id=0;
            if ($this->input->post('ua_id')) {
                $ua_id = $this->input->post('ua_id');
            }
        
        
            $delivery_fee=0;
            
            $user_id = $this->ion_auth->get_user_id();
            //user address
            
            
            $cond="";
            if ($ua_id>0) {
                $cond = " AND ua.ua_id=".$ua_id." ";
            } else {
                $cond = " AND ua.is_default='Yes'";
            }
            
            
            $query = "SELECT ua.*,s.delivery_fee,s.delivery_from_time, s.delivery_to_time,s.delivery_time_units FROM ".TBL_PREFIX.TBL_USER_ADDRESS." ua INNER JOIN ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." s ON ua.location_id = s.service_provide_location_id WHERE ua.user_id =".$user_id." AND s.status='Active' ".$cond." ";

            $user_address = $this->db->query($query)->result();
            
            
            
            if (!empty($user_address)) {
                $delivery_fee = $user_address[0]->delivery_fee;
            }
            
            
            
            $no_of_points=0;
            $points_discount=0;
            
            if ($this->input->post('checked')) {
                
                $this->load->model('cart/cart_model');
                
                $checked=$this->input->post('checked');
                
                if ($checked=='yes') {
                    
                    $check_redeem_points = $this->cart_model->check_redeem_points();
                    if (!empty($check_redeem_points)) {
                        $check_redeem_points = explode("=", $check_redeem_points);
                        
                        $no_of_points    = $check_redeem_points[2];
                        $points_discount = $check_redeem_points[0];
                    }
                    
                } else {
                    
                    $no_of_points=0;
                    $points_discount=0;
                    
                }
            }
            
            
            $page = $this->load->view('cart-summary-div', array('delivery_fee'=>$delivery_fee,'no_of_points'=>$no_of_points,'points_discount'=>$points_discount));
            
            echo $page;
        }
    }
    
    
    /**
     * CHECK OUT PAGE - CART DIV
     * SHOW CUSTOMIZE ITEM POPUP
     * CONTENT FOR MODAL Popup content
     *
     * @return PAGE
     **/
    function get_item_popup() 
    {
        
        if ($this->input->is_ajax_request()) {
            
            $page='';
            $item_id = $this->input->post('item_id');
            
            $record=array();
            
            if ($item_id > 0 && !empty($this->cart->contents())) {
                
                foreach ($this->cart->contents() as $item) {
                                
                    if ($item['id']==$item_id) {
                        array_push($record, $item);
                        break;
                    }
                }
                
                
                if (!empty($record)) {
                    
                    $currency_symbol = $this->config->item('site_settings')->currency_symbol;
                    
                    $record = $record[0];
                    
                    
                    $item_price=0;
                    if (isset($record['options']['item_option_price'])) {
                        
                        $item_price = $record['qty']*$record['options']['item_option_price'];
                        
                    } else {
                        
                        $item_price = $record['qty']*$record['options']['item_cost'];
                    }
                    
                    
                    if (isset($record['options']['extra_costs_total'])) {
                        $item_price += $record['options']['extra_costs_total'];
                    }
                    
                    
                    //$record['subtotal'];
            
                    
                    //get options
                    $options = $this->welcome_model->getItemOptions($item_id);
                    
                    
                    $page .= '<div class="row">
                    <div class="col-xs-12 col-sm-6">
                      <div class="cart-item-title">'.$record['name'].'</div>
                    </div>
					
					<div class="col-xs-6 col-sm-3">
                        <div class="card-item-price">'.$currency_symbol.'<span>'.$item_price.'</span>'.'</div>
                    </div>
					
					
                 </div> <br>';
                 
                 
                    //get addons
                    $addons = $this->welcome_model->getItemAddons($item_id);
                 
                    if (!empty($addons)) {
                     
                        $page .= '<div class="category-title">Addons</div>
								<div class="menu-list">';
                    
                    
                        $slctd_addons=array();
                        if (isset($record['options']['addons'])) {
                        
                            foreach ($record['options']['addons'] as $adn) {
                            
                                $adn = explode('=', $adn);
                                if (!empty($adn)) {
                                    array_push($slctd_addons, $adn[0]);
                                }
                            }
                        }
                    
                    
                    
                    
                        foreach ($addons as $addon) {
                    
                            if (in_array($addon->addon_id, $slctd_addons)) {
                        
                                /* $page .= '<div class="form-check dm-add-qty">
                                <label class="form-check-label">
							
                                <span>'.$addon->addon_name.'</span>
                                <span>'.$currency_symbol.$addon->price.'</span>
                                </label>
                                </div>'; */
                          
                          
                                $page .= '<div class="row offr-name">
						<div class="col-xs-9">
						 <span>'.$addon->addon_name.'</span>
						 </div>
						 <div class="col-xs-3">
						 <span>'.$currency_symbol.$addon->price.'</span>
						 </div>
						</div>';
                          
                            }    
                        }
                    
               
               
                        $page .= '</div>
								</div>';
                    }
                 
                 
                 
                    if (!empty($options)) {
                     
                        $page .= '<div class="category-title">Options</div>
								<div class="menu-list">';
                        // $o=0;
                        foreach ($options as $option) {
                            // $o++;
                    
                            $checked='';
                            if ($option->item_option_id==$record['options']['item_option_id'] && $option->option_id==$record['options']['option_id']) {
                                $checked='checked="checked"';
                    
                        
                                /*  $page .= '<div class="form-check">
                                <label class="form-check-label">
				  
                                <span>'.$option->option_name.'</span>
                                <span>'.$currency_symbol.$option->price.'</span>
					
                                </label>
                                </div>'; */
                
                
                                $page .= '<div class="row offr-name">
						<div class="col-xs-9">
						 <span>'.$option->option_name.'</span>
						 </div>
						 <div class="col-xs-3">
						 <span>'.$currency_symbol.$option->price.'</span>
						 </div>
						</div>';
                
                            }
                 
                        }                        
               
               
                        $page .= ' </div>
								</div>';
                    }
                 
                 
                 
                 
                 
                 
                    echo $page;
                    
                } else {
                    echo FALSE;//item record not found
                }
                
            } else {
                echo FALSE;//item_id not found
            }
        }
    }
    
    
    /**
     * DOWNLOAD APP
     *
     * @return PAGE
     **/
    function download_app()
    {
        $this->data['activemenu']     = "home";
        $this->data['pagetitle']     = get_languageword('download_app');
        $this->data['content']         = 'download_app';
        $this->_render_page(getTemplate(), $this->data);
    }
}