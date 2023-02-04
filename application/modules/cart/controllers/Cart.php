<?php
/**
 * Restaurant-DIGISAMARITAN
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, DIGISAMARITAN
 *
 * @category  Cart
 * @package   Menorah Restaurant
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Cart Class
 * 
 * Cart operations.
 *
 * @category  Cart
 * @package   Menorah Restaurant
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Cart extends MY_Controller
{

    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     Menorah Restaurant
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
    | MODULE:           CART CONTROLLER
    | -----------------------------------------------------
    | This is Cart module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        $this->load->model('cart_model');
    }
    
    /**
     * Check out page 
     * SHOWING CART ITEMS
     *
     * @return array
     **/     
    function index()
    {
        if (empty($this->cart->contents())) {
            redirect(URL_MENU);
        }
        
        if (!$this->ion_auth->logged_in()) {
            
            $this->session->set_userdata(array('loginup'=>TRUE));
            $this->prepare_flashmessage(get_languageword('please_login_to_continue'), 2);    
            redirect(SITEURL);
        }
        
        
        check_access('user');
        

        
        if ($this->input->post('submit_type')=='save_order') {

            if (DEMO) 
            {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_CART_INDEX, REFRESH);
            }
            

            $current_time = strtotime(date('H:i:s'));
            $from_time = strtotime($this->config->item('site_settings')->from_time);
            $to_time = strtotime($this->config->item('site_settings')->to_time);
            
            
           
            if ($current_time >= $from_time && $current_time <= $to_time) {
               
                $this->save_order();
            } else {
                
                $this->prepare_flashmessage(get_languageword('order_can_not_be_booked_please_follow_restaurant_timings'), 2);
                redirect(URL_MENU);
            }
        }
        
        
        $this->data['card_types'] = $this->base_model->fetch_records_from(TBL_CARD_IMAGES, array('status' => 'Active'));
        
        
        $check_redeem_points = $this->cart_model->check_redeem_points();
        if (!empty($check_redeem_points)) {
            $this->data['redeem_points'] = $check_redeem_points;
        }
        
        $this->data['content'] = 'n_cart';
        
        $this->_render_page(getTemplate(), $this->data);
    }
    
    
    /**
     * Add/Update Cart Items
     *
     * @return boolean
     **/  
    function add_cart_item()
    {
        $model_fun = 'validate_add_cart_item';

        if ($this->input->post('item_from') != '' && $this->input->post('item_from')=='offers') {
            $model_fun = 'validate_add_cart_offer';
        }

        
        $result = $this->cart_model->$model_fun();
        
        
        if ($result) {
        
            // Check if user has javascript enabled
            if ($this->input->post('ajax') != '1') {

                redirect(URL_CART_INDEX); // If javascript is not enabled, reload the page with new data

            } else if ($result>0 && $result!=999) {

                echo count($this->cart->contents()); // If javascript is enabled, return true, so the cart gets updated //item added/updated
                
            } else if ($result<=0 && $result!=999) {
                
                echo $result;//Item not added/updated
                
            } else if ($result==999) {
                
                echo $result;//Item already exist
            }
        }
        
    }
    
    
    /**
     * Update Cart Items
     *
     * @return boolean
     **/
    function update_cart_item() 
    {
        
        $model_fun = 'update_cart_item';
        
        $result = $this->cart_model->$model_fun();
        
        
        if ($result) {
        
            // Check if user has javascript enabled
            if ($this->input->post('ajax') != '1') {

                redirect(URL_CART_INDEX); // If javascript is not enabled, reload the page with new data

            } else if ($result>0 && $result!=999 && $result!=9999) {
                
                echo count($this->cart->contents()); // If javascript is enabled, return true, so the cart gets updated //item added/updated
                
            } else if ($result<=0 && $result!=999 && $result!=9999) {
                
                echo $result;//Item not added/updated
                
            } else if ($result==999) {
                
                echo $result;//Item already exist
                
            } else if ($result==9999) {
                
                echo $result;//no items in cart
            }
        }
        
    }
    
    
    /**
     * Remove Cart Items
     *
     * @return boolean
     **/
    function remove_cart_item()
    {
        $item_row_id = $this->input->post('item_row_id');//rowid

        if (empty($item_row_id)) {
            return FALSE;
        }

        if ($this->cart->remove($item_row_id)) {

            // Check if user has javascript enabled
            if ($this->input->post('ajax') != '1') {

                redirect(URL_CART_INDEX); // If javascript is not enabled, reload the page with new data

            } else {

                // echo count($this->cart->contents()); // If javascript is enabled, return true, so the cart gets updated
                
                //item removed from cart
                //check cart items empty or not
                $total_items = count($this->cart->contents());
                if ($total_items>0) {
                    echo $total_items;
                } else {
                    echo 999;//cart items empty
                }
                
            }
        } else {
            return FALSE;
        }
    }
    
    /**
     * Empty Cart Items
     *
     * @return boolean
     **/
    function empty_cart()
    {
        $this->cart->destroy(); // Destroy all cart data
        redirect(URL_CART_INDEX); // Refresh te page
    }
    
    
    
    /**
     * Save Order
     *
     * @return boolean
     **/
    function save_order()
    {
        if (!$this->ion_auth->logged_in()) {
            $this->prepare_flashmessage("Please login to continue", 2);
            redirect(URL_AUTH_LOGIN);
        }

        if (!$this->cart->contents()) {
            $this->prepare_flashmessage(get_languageword('please_add_items_to_your_cart'), 2);
            redirect(URL_MENU);
        }

        if (!($this->input->post('zipcode'))) {
            $this->prepare_flashmessage(get_languageword('please_select_your_delivery_address_and_continue'), 2);
            redirect(URL_CART_INDEX);
        }

        if (!($this->input->post('payment_type'))) {
            $this->prepare_flashmessage(get_languageword('please_select_payment_type_and_continue'), 2);
            redirect(URL_CART_INDEX);
        }
        
        
        $user=getUserRec();
        $user_id = $user->id;

        $total_cost = $this->cart->total();//only total items cost - exclude addons_cost,delivery_fee,points.

        $zipcode = $this->input->post('zipcode');//ua_id - cr_user_address table
    
        $input_data = array();
        $input_data['delivery_fee'] = 0;
        
        
        $user_addr_det = $this->cart_model->get_user_shipping_address($user_id, $zipcode);
        
        
        
        if (!empty($user_addr_det)) {

            $user_addr_det = $user_addr_det[0];

            $input_data['delivery_fee']       = $user_addr_det->delivery_fee;
            $input_data['house_no']         = $user_addr_det->house_no;
            $input_data['street']              = $user_addr_det->street;
            $input_data['landmark']         = $user_addr_det->landmark;
            $input_data['locality']             = $user_addr_det->locality;
            $input_data['city']             = $user_addr_det->city;
            $input_data['city_id']            = $user_addr_det->city_id;
            $input_data['pincode']          = $user_addr_det->pincode;
        }
        
        
        
        $total_cost += $input_data['delivery_fee'];//total items cost+delivery_fee - exclude addons_cost,points.

        
        //
        $input_data['is_points_redeemed']           = 'No';
        $input_data['no_of_points_redeemed']        = NULL;
        $input_data['points_value']                 = NULL;
        
        if ($this->input->post('no_of_redeemed_points')>0) {
            $redeem_points = $this->cart_model->check_redeem_points();
            
            if (!empty($redeem_points)) {
                
                $redeem_points = explode("=", $redeem_points);
                $total_cost -= $redeem_points[0];//total items cost+delivery_fee+points - exclude addons_cost.
                
                $input_data['is_points_redeemed']         = 'Yes';
                $input_data['no_of_points_redeemed']     = $redeem_points[2];
                $input_data['points_value']             = $redeem_points[0];
            }
        }
        
        
        
        //Addons cost
        $addons_total=0;
        foreach ($this->cart->contents() as $items) {
                    
            if (isset($items['options']['addons_cost_per_item'])) {
                $addons_total =  $addons_total+$items['options']['addons_cost_per_item'];
            }
        }
        $total_cost += $addons_total;//total items cost+delivery_fee+points+addons_cost.
        //Addons cost
        
        
        
        $input_data['user_id']          = $user_id;
        $input_data['order_date']       = date("Y-m-d");
        $input_data['order_time']       = date('H:i A');
        $input_data['total_cost']       = $total_cost;
        
        
        $input_data['customer_name']    = $user->username;
        $input_data['phone']            = $user->phone;
        $input_data['status']           = "new";
        $input_data['payment_type']     = $this->input->post('payment_type');

        if ($input_data['payment_type'] == 'cashCard') {
            $input_data['payment_card'] = $this->input->post('payment_card');
        }

        $input_data['no_of_items']      = count($this->cart->contents());

        $input_data['date_created']     = date('Y-m-d H:i:s');
        $input_data['date_updated']     = date('Y-m-d');

        
        $this->session->set_userdata('is_valid_request', 1);
        $this->session->set_userdata('order_data', $input_data);
        
        
        if ($input_data['payment_type'] == 'cash' || $input_data['payment_type'] == 'cashCard') {
            $this->order_success();
        } else if ($input_data['payment_type'] == 'online') {
            //Paypal Payment
            $config['return']                 = base_url().'cart/order_success';
            $config['cancel_return']         = base_url().'cart/paypal_cancel';
            $config['production']             = TRUE;
            $config['currency_code']         = 'USD';


            if (isset($this->config->item('paypal_settings')->paypal_email) && $this->config->item('paypal_settings')->paypal_email != '') {
                $config['business']     = $this->config->item('paypal_settings')->paypal_email;
            }

            if (isset($this->config->item('paypal_settings')->account_type) && $this->config->item('paypal_settings')->account_type == 'sandbox') {    
                $config['production'] = FALSE;
            }    
             
            if (isset($this->config->item('paypal_settings')->currency) && $this->config->item('paypal_settings')->currency != '') {    
                $config['currency_code'] = $this->config->item('paypal_settings')->currency;
            }    

            if (isset($this->config->item('site_settings')->site_logo) && $this->config->item('site_settings')->site_logo != '') {
                $config['cpp_header_image'] = '<img src="'.get_site_logo().'" class="img-responsive">';
            } else {
                $config['cpp_header_image'] = $this->config->item('site_settings')->site_title;
            }


            $this->load->library('paypal', $config);
            $this->paypal->__initialize($config);
            $this->paypal->add('Your Order', $total_cost);
            $this->paypal->pay(); //Process the payment
        }
    }
    
     /**
      * Order Success
      *
      * @return boolean
      **/
    function order_success()
    {
        $success = 0;
        
        
        if ($this->session->userdata('order_data') && $this->session->userdata('is_valid_request')) {
            $input_data = $this->session->userdata('order_data');

            if ($input_data['payment_type'] == 'cash' || $input_data['payment_type'] == 'cashCard') {
                $input_data['paid_date']            = NULL;
                $input_data['transaction_id']       = NULL;
                $input_data['payer_id']             = NULL;
                $input_data['payer_email']          = NULL;
                $input_data['payer_name']           = NULL;
                $input_data['payment_status']       = NULL;

                $success = 1;
            } else if ($input_data['payment_type'] == 'online' && $this->input->post()) {
                $input_data['paid_date']          = $this->input->post('payment_date');
                $input_data['transaction_id']   = $this->input->post('txn_id');
                $input_data['paid_amount']       = $this->input->post('mc_gross');
                $input_data['payer_id']          = $this->input->post('payer_id');
                $input_data['payer_email']      = $this->input->post('payer_email');
                $input_data['payer_name']          = $this->input->post('first_name')." ".$this->input->post('last_name');
                $input_data['payment_status']   = $this->input->post('payment_status');

                $success = 1;
            } else {
                $this->prepare_flashmessage("Invalid Operation", 1);
                redirect(URL_CART_INDEX);
            }


            
            if ($success == 1) {
                $order_id = $this->base_model->insert_operation_id($input_data, TBL_ORDERS);
                
                if ($order_id > 0) {
                    
                    // If Points Redeemed, log the data & update user points - Start 
                    //check for redeem points
                    if ($input_data['is_points_redeemed']=='Yes' && $input_data['no_of_points_redeemed'] > 0) {
                        //redeem points
                        $user=getUserRec($input_data['user_id']);
                        
                        $data = array();
                        $data['user_points'] = ($user->user_points)-$input_data['no_of_points_redeemed'];
                        
                        if ($this->base_model->update_operation($data, TBL_USERS, array('id'=>$user->id))) {
                            //point logs
                            unset($data);
                            $data = array();
                            $data['user_id']     = $user->id;
                            $data['points']      = $input_data['no_of_points_redeemed'];
                            $data['transaction_type'] = 'Redeem';
                            $data['order_id']           = $order->order_id;
                            $data['description']       = get_languageword('points_redeemed_for_buy_an_item_order');
                            $data['created_on']          = date('Y-m-d H:i:s');
                            
                            $this->base_model->insert_operation($data, TBL_USER_POINTS);
                            unset($data);
                        }
                            
                    }
                    //If Points Redeemed, log the data & update user points - End
                    
                    

                    $products_data     = array();
                    $addons_data    = array();
                    $offers_data    = array();
                    $offer_products_data=array();
                   
                    if ($this->cart->contents()) {
                        
                        foreach ($this->cart->contents() as $items) {
                            
                            $common_id = random_string('numeric', 2);
                            //Prepare Products Data, If it is not an offer item
                            if ($items['options']['is_offer'] == 0) {
                                
                                //Start 
                                $final_cost = "";
                                if (!empty($items['options']['item_option_price'])) {
                                    $final_cost = (($items['options']['item_option_price'])*$items['qty']);//items_cost
                                } else if (!empty($items['options']['item_cost'])) {
                                    $final_cost = (($items['options']['item_cost'])*$items['qty']);//items_cost
                                }
                            
                                
                                if (!empty($items['options']['addons_cost_per_item'])) {
                                    $final_cost += $items['options']['addons_cost_per_item'];//items_cost+addons_cost
                                }
                                //End 
                            
                            

                                array_push(
                                    $products_data, 
                                    array(
                                    "is_deleted"        => 0,
                                    "order_id"             => $order_id,
                                    "item_id"             => $items['id'],
                                    "menu_id"             => $items['options']['menu_id'],
                                    "item_name"         => $items['name'],
                                    "item_image_name"    => $items['options']['image'],
                                    "size_id"            => isset($items['options']['option_id']) ? $items['options']['option_id']: '',
                                    "size_name"            => isset($items['options']['item_option_name'])?$items['options']['item_option_name']:'',
                                    "item_size_id"        => isset($items['options']['item_option_id'])?$items['options']['item_option_id']:'',
                                    "size_price"        => isset($items['options']['item_option_price']) ? $items['options']['item_option_price']: '',
                                    "item_qty"            => $items['qty'],
                                    "common_id"            => $common_id,
                                    "item_cost"            => $items['price'],
                                    "final_cost"        => $final_cost
                                    )
                                );
                            }

                            
                            //Prepare Add-ons Data
                            if (!empty($items['options']['addons'])) {
                                
                                foreach ($items['options']['addons'] as $key => $value) {
                                    $vals = explode('=', $value);

                                    array_push(
                                        $addons_data, 
                                        array(
                                        "order_id"        => $order_id,
                                        "item_id"        => $items['id'],
                                        "addon_name"    => $vals[3],
                                        "addon_image"    => $vals[4],
                                        "price"            => $vals[1],
                                        "quantity"        => $vals[2],
                                        "final_cost"    => ($vals[1] * $vals[2]),
                                        "common_id"        => $common_id,
                                        "is_deleted"    => 0
                                        )
                                    );
                                }
                            }


                            //Prepare Offer Data
                            if ($items['options']['is_offer'] == 1) {
                                
                                $offer_det = $this->base_model->fetch_records_from(TBL_OFFERS, array('offer_id' => $items['id']));

                                if (!empty($offer_det)) {

                                    $offer = $offer_det[0];

                                    array_push(
                                        $offers_data, 
                                        array(
                                        "order_id"                => $order_id,
                                        "offer_id"                => $offer->offer_id,
                                        "offer_name"            => $offer->offer_name,
                                        "offer_cost"            => $offer->offer_cost,
                                        "offer_quantity"        => $items['qty'],
                                        "offer_final_cost"        => $items['subtotal'],
                                        "offer_start_date"        => $offer->offer_start_date,
                                        "offer_valid_date"        => $offer->offer_valid_date,
                                        "offer_conditions"        => $offer->offer_conditions,
                                        "no_of_products"        => $offer->no_of_products,
                                        "offer_image_name"        => $offer->offer_image_name,
                                        "is_deleted"            => 0
                                        //'common_id'=>$common_id
                                        )
                                    );
                                        
                                    //Prepare Offer Products Data
                                    $offer_products = $this->base_model->get_query_result("select * from ".TBL_PREFIX.TBL_OFFER_PRODUCTS." where offer_id=".$offer->offer_id." and quantity > 0 ");
                                
                                    if (!empty($offer_products)) {
                                    
                                        foreach ($offer_products as $op):
                                    
                                            array_push(
                                                $offer_products_data, 
                                                array(
                                                "order_id"    => $order_id,
                                                "offer_id"    => $offer->offer_id,
                                                "item_id"    => $op->item_id,
                                                "menu_id"    => $op->menu_id,
                                                "item_name"    => $op->item_name,
                                                "item_quantity" => $op->quantity,
                                                "is_deleted" => 0,
                                                'common_id'  => $common_id
                                                )
                                            );
                                    
                                        endforeach;
                                    }
                                
                                }
                                
                            }
                        }
                        
                        
                        
                        if (!empty($products_data)) {
                            $this->db->insert_batch(TBL_PREFIX.TBL_ORDER_PRODUCTS, $products_data);
                        }
                        if (!empty($addons_data)) {
                            $this->db->insert_batch(TBL_PREFIX.TBL_ORDER_ADDONS, $addons_data);
                        }
                        if (!empty($offers_data)) {
                            $this->db->insert_batch(TBL_PREFIX.TBL_ORDER_OFFERS, $offers_data);
                        }
                        
                        if (!empty($offer_products_data)) {
                            $this->db->insert_batch(TBL_PREFIX.TBL_ORDER_OFFER_PRODUCTS, $offer_products_data);
                        }
                        
                    }
                    
                    
                    
                    // send push notification to the admin
                    if ($this->config->item('site_settings')->pusher_status=='Yes') {
                        $this->load->library('Pusher');
                        $options = array(
                        'cluster' => 'ap2',
                        'encrypted' => TRUE
                        );
                           
                        $pusher = new Pusher($options);
                        $notfn_data['order_id'] = $order_id;
                        $pusher->trigger('my-channel', 'my_event', $notfn_data); 
                    }
                

                    
                    //Email/SMS Alerts to User/Admin
                    $email_template = $this->db->get_where(TBL_PREFIX.TBL_EMAIL_TEMPLATES, array('subject'=>'when_user_order_booked_template_mail_to_user','status'=>'Active'))->result();

                    if (!empty($email_template)) {
                        $from     = $this->config->item('site_settings')->portal_email;
                        $to     = $this->session->userdata('email');
                        $sub     = $this->config->item('site_settings')->site_title . ' - ' . ' ORDER ';

                        $email_template = $email_template[0];            
                        $content         = $email_template->email_template;
                        
                        
                        $logo_img='<img src="'.get_site_logo().'" class="img-responsive">';
                        
                
                
                        $content         = str_replace("__SITE_LOGO__", $logo_img, $content);
                        
                        $content         = str_replace("__SITE_TITLE__", $this->config->item('site_settings')->site_title, $content);
                        
                        $content         = str_replace("__USER_NAME__", $input_data['customer_name'], $content);
                        $content         = str_replace("__NO_OF_ITEMS__", $input_data['no_of_items'], $content);

                        $content         = str_replace("__ORDER_TIME__", $input_data['order_time'], $content);
                    
                        $content         = str_replace("__TOTAL_COST__", $this->config->item('site_settings')->currency_symbol.$input_data['total_cost'], $content);
                    
                        $content         = str_replace("__PAYMENT_MODE__", $input_data['payment_type'], $content);

                        $content         = str_replace("__CUSTOMER_MESSAGE__", 'Order Booked Successfully', $content);
                        
                        $content         = str_replace("__CONTACT_US__", $this->config->item('site_settings')->land_line, $content);
                        
                        $content     = str_replace("__ANDROID__", '<a href="'.$this->config->item('site_settings')->android_url.'"><img src="'.get_android_img().'" class="img-responsive"></a>', $content);

                        $content     = str_replace("__IOS__", '<a href="'.$this->config->item('site_settings')->ios_url.'"><img src="'.get_ios_img().'" class="img-responsive"></a>', $content);
                    
                    
                        $content         = str_replace("__SITE_TITLE__", $this->config->item('site_settings')->site_title, $content);
                    
                        $content         = str_replace("__COPY_RIGHTS__", $this->config->item('site_settings')->rights_reserved_content, $content);

                        sendEmail($from, $to, $sub, $content);
                    }

                    
                    
                    // SEND SMS IF ENABLE
                    if ($this->config->item('site_settings')->sms_notifications=='Yes' && $input_data['phone']!='') {
                        $sms_details = $this->base_model->fetch_records_from(TBL_SMS_TEMPLATES, array('subject'=>'order_saved'));
                        
                        if (!empty($sms_details)) {
                            $content='';
                            $content         = strip_tags($sms_details[0]->sms_template);
                            $content         = str_replace("__SITE__TITLE__", $this->config->item('site_settings')->site_title, $content);
                            $content         = str_replace("__ORDER__NO__", $order_id, $content);
                            $content         = str_replace("__TOTAL__COST__", $this->config->item('site_settings')->currency_symbol.$input_data['total_cost'], $content);
                            
                            
                            sendSMS($mobile_number, $content);
                        }
                    }
                    // SEND SMS END
                
                    
                    $email_template = $this->db->get_where(TBL_PREFIX.TBL_EMAIL_TEMPLATES, array('subject'=>'when_user_order_booked_template_mail_to_admin','status'=>'Active'))->result();
                    
                    
                    if (!empty($email_template)) {
                        $from     = $this->session->userdata('email');
                        $to     = $this->config->item('site_settings')->portal_email;
                        $sub     = $this->config->item('site_settings')->site_title . ' - ' .  ' ORDER ';
                    
                        $email_template = $email_template[0];            
                        $content         = $email_template->email_template;
                        
                        
                        $logo_img='<img src="'.get_site_logo().'" class="img-responsive">';
                        
                        
                        $content         = str_replace("__SITE_LOGO__", $logo_img, $content);
                        
                        $content         = str_replace("__SITE_TITLE__", $this->config->item('site_settings')->site_title, $content);
                        
                        $content         = str_replace("__USER_NAME__", $input_data['customer_name'], $content);
                        
                        $content         = str_replace("__USER_NAME__", $input_data['customer_name'], $content);
                        
                        $content         = str_replace("__EMAIL__", $this->session->userdata('email'), $content);
                        
                        $content         = str_replace("__PHONE__", $input_data['phone'], $content);


                        if (!empty($input_data['house_no'])) {
                            $content    = str_replace("__HOUSE__NO__", $input_data['house_no'], $content);
                        }

                        if (!empty($input_data['street'])) {
                            $content    = str_replace("__STREET__NAME__", $input_data['street'], $content);
                        }

                        
                        if (!empty($input_data['landmark'])) {
                            $content    = str_replace("__LAND_MARK__", $input_data['landmark'], $content);
                        }
                        
                        if (!empty($input_data['locality'])) {
                            $content    = str_replace("__LOCALITY__", $input_data['locality'], $content);
                        }

                        if (!empty($input_data['city'])) {
                            $content    = str_replace("__CITY__", $input_data['city'], $content);
                        }

                        if (!empty($input_data['pincode'])) {
                            $content    = str_replace("__PIN_CODE__", $input_data['pincode'], $content);
                        }

                        $content         = str_replace("__NO_OF_ITEMS__", $input_data['no_of_items'], $content);
                        
                        $content         = str_replace("__ORDER_TIME__", $input_data['order_time'], $content);
                        
                        
                        /* $content 		= str_replace("__TOTAL_COST__", money_format('%i',$input_data['total_cost']),$content);//money_format */
                        
                        $content         = str_replace("__TOTAL_COST__", $this->config->item('site_settings')->currency_symbol.$input_data['total_cost'], $content);
                        
                        
                        $content         = str_replace("__PAYMENT_MODE__", $input_data['payment_type'], $content);

                        $content         = str_replace("__CUSTOMER_MESSAGE__", 'Order Booked Successfully', $content);
                        
                        $content         = str_replace("__CONTACT_US__", $this->config->item('site_settings')->address, $content);
                        
                        $content     = str_replace("__ANDROID__", '<a href="'.$this->config->item('site_settings')->android_url.'"><img src="'.get_android_img().'" class="img-responsive"></a>', $content);

                        $content     = str_replace("__IOS__", '<a href="'.$this->config->item('site_settings')->ios_url.'"><img src="'.get_ios_img().'" class="img-responsive"></a>', $content);
                    
                    
                        $content         = str_replace("__SITE_TITLE__", $this->config->item('site_settings')->site_title, $content);
                    
                        $content         = str_replace("__COPY_RIGHTS__", $this->config->item('site_settings')->rights_reserved_content, $content);
                        
                        
                        sendEmail($from, $to, $sub, $content);
                    }


                    $this->session->unset_userdata('is_valid_request');
                    $this->session->unset_userdata('order_data');
                    $this->cart->destroy(); // Destroy all cart data

                   
                    $this->session->set_userdata('order_id', $order_id);
                    redirect(URL_SUCCESS);
                    
                } else {
                    $this->prepare_flashmessage("Order Not Saved due to some technical issue. Please contact Admin", 2);
                    redirect(URL_CART_INDEX);
                }
            } else {
                $this->prepare_flashmessage("Order not saved due to some technical issue. Please contact Admin", 2);
                redirect(URL_CART_INDEX);
            }
        } else {
            $this->prepare_flashmessage("Invalid Operation", 1);
            redirect(URL_CART_INDEX);
        }
    }
    
     /**
      * Book Order Success
      *
      * @return boolean
      **/
    function success()
    {
        if ($this->session->userdata('order_id')) {
            
            $order_id = $this->session->userdata('order_id');
            $this->session->unset_userdata('order_id');
            
            
            $this->data['order_id']        = $order_id;
            $this->data['activemenu']     = "home";
            $this->data['content']      = "n_success";
            $this->_render_page(getTemplate(), $this->data);
        } else { 
            redirect(URL_MENU);
        }
    }
    
     /**
      * Paypal Cancel
      *
      * @return boolean
      **/
    function paypal_cancel()
    {
        $this->session->unset_userdata('is_valid_request');
        $this->session->unset_userdata('order_data');
        $this->cart->destroy(); // Destroy all cart data
        $this->prepare_flashmessage('You have cancelled your transaction', 2);
        redirect(URL_CART_INDEX);
    }
    
    /**
     * ADD ADDRESS - CART PAGE
     * FETCH LOCALITIES OF SELECTED CITY
     * AJAX CALL
     *
     * @return array
     **/
    function get_localities() 
    {
        
        if ($this->ion_auth->logged_in()) {
            $options = '';
            
            $city_id = $this->input->post('city_id');
            
            if ($city_id > 0 ) {
                
                $records = $this->base_model->get_query_result("select service_provide_location_id,locality from ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." where city_id=".$city_id." and status='Active' ");
                
                if (!empty($records)) {
                    $options .= '<option value="">Select Locality</option>';
                    
                    foreach ($records as $r):
                    
                        $options .= '<option value="'.$r->service_provide_location_id.'">'.$r->locality.'</option>';
                    
                    endforeach;
                    
                } else {
                    
                    $options .= '<option value="">No Localities</option>';
                }
                
                echo $options;
                
            } else {
                echo FALSE;
            }
        } else { 
            echo 999;
        }
    }
    
    /**
     * ADD ADDRESS - CART PAGE
     * FETCH PINCODE OF SELECTED LOCALITY
     * AJAX CALL
     *
     * @return array
     **/ 
    function get_pincode() 
    {
        
        if ($this->ion_auth->logged_in()) {
            
            $city_id = $this->input->post('city_id');
            $spl_id     = $this->input->post('spl_id');
            
            if ($city_id > 0 && $spl_id > 0) {
                
                $record = $this->base_model->get_query_result("select pincode from ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." where service_provide_location_id=".$spl_id." and city_id=".$city_id." and status='Active' ");
                
                if (!empty($record)) {
                    
                    echo $record[0]->pincode;
                } else {
                    echo FALSE;
                }
                
            } else {
                echo FALSE;
            }
        } else {
            echo 999;
        }
    }
    
    /**
     * ADD ADDRESS - CART PAGE
     * SAVE ADDRESS OF USER
     *
     * @return boolean
     **/ 
    function add_address() 
    {
        
        if (isset($_POST['address'])) {
            
            
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('pincode', get_languageword('pincode'), 'required|xss_clean');
            $this->form_validation->set_rules('house_no', get_languageword('house_no'), 'required|xss_clean');
            $this->form_validation->set_rules('street', get_languageword('street'), 'required|xss_clean');
            $this->form_validation->set_rules('landmark', get_languageword('landmark'), 'required|xss_clean');
            
            if ($this->form_validation->run() == TRUE) {
                
                $data = array();
                
                $spl_id = $this->input->post('locality');
                
                if ($spl_id > 0) {
                    
                    $record = $this->base_model->get_query_result("select s.locality,s.pincode,c.city_name from ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." s inner join ".TBL_PREFIX.TBL_CITIES." c on s.city_id=c.city_id where s.service_provide_location_id=".$spl_id." and s.status='Active' ");
                    
                    if (!empty($record)) {
                        
                        $record = $record[0];
                        
                        $data['user_id']     = $this->ion_auth->get_user_id();
                        $data['city']        = $record->city_name;
                        $data['locality']     = $record->locality;
                        
                        $data['house_no']   = $this->input->post('house_no');
                        $data['street']     = $this->input->post('street');
                        $data['landmark']     = $this->input->post('landmark');
                        $data['pincode']      = $this->input->post('pincode');
                        $data['location_id']= $spl_id;
                        
                        if ($this->base_model->insert_operation($data, 'user_address')) {
                            $msg .= get_languageword('address_added_successfully');
                            $status=0;
                        } else {
                            $msg .= get_languageword('address_not_added');
                            $status=1;
                        }
                        $this->prepare_flashmessage($msg, $status);
                        redirect(URL_CART_INDEX);
                        
                    } else { 
                        redirect(URL_CART_INDEX);
                    }
                
                } else { 
                    redirect(URL_CART_INDEX);
                }
                
            } else {
                $this->prepare_flashmessage(strip_tags(validation_errors()), 1);
                redirect(URL_CART_INDEX);
            }
        } else {
            redirect(URL_CART_INDEX);
        }
    }
}