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
 * @category  KitchenManager
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Kitchen Manager Class
 * 
 * Kitchen Manager operations.
 *
 * @category  KitchenManager
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Kitchen_manager extends MY_Controller
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
    | MODULE:           KITCHEN MANAGER CONTROLLER
    | -----------------------------------------------------
    | This is Kitchen Manager module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('kitchen_manager');
    }

    /** 
     * KITCHEN MANAGER DASHBOARD
     *
     * @return page
     **/ 
    function index()
    {
        $this->load->model('kitchen_manager_model');
        
        $this->data['orders_count'] = $this->kitchen_manager_model->get_orders_count();
        
        $this->data['activemenu']     = "km_dashboard";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('kitchen_manager_dashboard');
        $this->data['content']         = PAGE_KM_DASHBOARD;
        $this->_render_page(TEMPLATE_KM, $this->data);
    }
    
    
    /**
     * KM PROFILE
     *
     * @return boolean
     **/ 
    function profile()
    {
        $user_id = $this->ion_auth->get_user_id();
        if (isset($_POST['update_profile'])) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_KM_PROFILE, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('first_name', get_languageword('first_name'), 'required|xss_clean');
            $this->form_validation->set_rules('last_name', get_languageword('last_name'), 'required|xss_clean');
            $this->form_validation->set_rules('phone', get_languageword('phone'), 'required|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['first_name'] = $this->input->post('first_name');
                $data['last_name']     = $this->input->post('last_name');
                $data['username']   = $this->input->post('first_name').' '.$this->input->post('last_name');
                $data['phone']        = $this->input->post('phone');
                
                $where['id'] = $user_id;
                if ($this->base_model->update_operation($data, TBL_USERS, $where)) {
                    $msg .= get_languageword('details_saved_successfully');
                    $status = 0;
                } else {
                    $msg .= get_languageword('details_not_saved');
                    $status = 1;
                }
                unset($data, $where);
                
                //Upload User Image
                if (count($_FILES) > 0) {
                    if ($_FILES['user_image']['name'] != '' && $_FILES['user_image']['error'] != 4) {
                        $record = $this->base_model->fetch_records_from(TBL_USERS, array('id'=>$user_id));
                    
                        if (!empty($record)) {
                            $record = $record[0];
                            if ($record->photo != '' && file_exists(USER_IMG_UPLOAD_PATH_URL.$record->photo)) {
                                unlink(USER_IMG_UPLOAD_PATH_URL.$record->photo);
                                unlink(USER_IMG_UPLOAD_THUMB_PATH_URL.$record->photo);
                            }
                        }
                        
                        
                        
                        $ext = pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);
                        $file_name = 'user_'.$user_id.'.'.$ext;
                        $config['upload_path']         = USER_IMG_UPLOAD_PATH_URL;
                        $config['allowed_types']     = ALLOWED_TYPES;
                        
                        $config['file_name']  = $file_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('user_image')) {
                            $data = array();
                            $data['photo'] = $file_name;
                            $this->create_thumbnail($config['upload_path'].$file_name, USER_IMG_UPLOAD_THUMB_PATH_URL.$file_name, 200, 200);
                            
                            $this->base_model->update_operation($data, TBL_USERS, array('id'=>$user_id));
                        } else {
                            $msg .= '<br>'.strip_tags($this->upload->display_errors());
                            $status =1;
                        }
                    }
                }
                    
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_KM_PROFILE, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('update_profile');
            
        $record = $this->base_model->fetch_records_from(TBL_USERS, array('id' => $user_id));
        if (empty($record)) {
            $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
            redirect(URL_KM_PROFILE);                
        }
        $this->data['record'] =    $record[0];
            
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "km_dashboard";
        $this->data['content']          = PAGE_ADMIN_RROFILE;
        $this->_render_page(TEMPLATE_KM, $this->data);    
    }
    
    /**
     * KM CHANGE PWD 
     *
     * @return boolean
     **/     
    function change_password()
    {
        if (isset($_POST['change_pwd'])) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_KM_CHANGE_PASSWORD, REFRESH);
            }
            
            $this->form_validation->set_rules('old_password', get_languageword('current_password'), 'required|xss_clean');
            
            $this->form_validation->set_rules('new_password', get_languageword('new_password'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|xss_clean');
            
            $this->form_validation->set_rules('new_confirm_password', get_languageword('new_confirm_password'), 'required|matches[new_password]|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                $identity = $this->session->userdata('identity');
                $change = $this->ion_auth->change_password($identity, $this->input->post('old_password'), $this->input->post('new_password'));
                
                if ($change) {
                    $this->prepare_flashmessage(get_languageword('password_changed_successfully'), 0);
                    redirect(URL_AUTH_LOGOUT.DS.'password', REFRESH);
                } else {
                    $this->prepare_flashmessage($this->ion_auth->errors(), 1);
                    redirect(URL_KM_CHANGE_PASSWORD, REFRESH);
                }
            }
        }
        
        $user = $this->ion_auth->user()->row();    
        $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
        $this->data['old_password'] = array(
        'name' => 'old_password',
        'id'   => 'old_password',
        'type' => 'password',
        'class' => 'form-control crunch-newpwd',
        'placeholder'=>get_languageword('current_password')
        );
        $this->data['new_password'] = array(
        'name'    => 'new_password',
        'id'      => 'new_password',
        'type'    => 'password',
        // 'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
        'class' => 'form-control crunch-newpwd',
        'placeholder'=>get_languageword('new_password')
        );
        $this->data['new_password_confirm'] = array(
        'name'    => 'new_confirm_password',
        'id'      => 'new_confirm_password',
        'type'    => 'password',
        // 'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
        'class' => 'form-control crunch-newpwd',
        'placeholder'=>get_languageword('new_confirm_password')
        );
        $this->data['user_id'] = array(
        'name'  => 'user_id',
        'id'    => 'user_id',
        'type'  => 'hidden',
        'value' => $user->id,
        );
        
        $this->data['css_js_files'] = array('form_validation');
        $this->data['activemenu']     = 'km_dashboard';
        $this->data['pagetitle']     = get_languageword('change_password');
        $this->data['content']         = PAGE_CHANGE_PASSWORD;
        $this->_render_page(TEMPLATE_KM, $this->data);
    }
    
    /**
     * KM VIEW ORDERS 
     *
     * @return array
     **/ 
    function orders()
    {
        $this->data['ajaxrequest'] = array(
        'url' => URL_KM_AJAX_GET_ORDERS,
        'disablesorting' => '-1'
        );
        
        $this->data['css_js_files']     = array('data_tables');
        $this->data['activemenu']       = "orders";
        $this->data['message']          = $this->session->flashdata('message');
        $this->data['pagetitle']        = get_languageword('view_orders');
        $this->data['content']          = PAGE_ORDERS;
        $this->_render_page(TEMPLATE_KM, $this->data);
    }
    
    /**
     * KM VIEW ORDERS 
     *
     * @return array
     **/ 
    function ajax_get_orders()
    {
        $user_id = $this->ion_auth->get_user_id();
        
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];
            
            $conditions = array();

            $columns = array('tds.order_id','tds.order_date','tds.order_time','tds.total_cost','tds.customer_name','tds.phone','tds.house_no','tds.street','tds.landmark','tds.locality','tds.city','tds.pincode','tds.status');    
            
            $query     = "SELECT tds.* from ".TBL_PREFIX.TBL_ORDERS." tds WHERE tds.km_id = '".$user_id."' ";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('order_id'=>'desc'));
            
            $currency_symbol = $this->config->item('site_settings')->currency_symbol;
            
            if (!empty($records)) {
    
                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    $row[] = $no;
                    $row[] = '<span>'.$record->order_id.'</span>';
                    $row[] = '<span>'.get_date($record->order_date).'</span>';
                    $row[] = '<span>'.$record->order_time.'</span>';
                    $row[] = '<span>'.$currency_symbol.$record->total_cost.'</span>';
                    $row[] = '<span>'.$record->customer_name.'</span>';
                    $row[] = '<span>'.$record->phone.'</span>';
                    
                    $addres='';
                    if (!empty($record->house_no)) {
                        $addres .= $record->house_no;
                    }
                    if (!empty($record->street)) {
                        $addres .= ','.$record->street;
                    }
                    if (!empty($record->landmark)) {
                        $addres .= ','.$record->landmark;
                    }
                    if (!empty($record->locality)) {
                        $addres .= ','.$record->locality;
                    }
                    if (!empty($record->city)) {
                        $addres .= ','.$record->city;
                    }
                    if (!empty($record->pincode)) {
                        $addres .= ','.$record->pincode;
                    }
                    
                    $row[] = '<span>'.$addres.'</span>';
                    
                    
                    $class = 'badge danger';
                    if ($record->status == 'new') {
                        $class = 'badge new-order';    
                    } else if ($record->status == 'delivered') {
                        $class = 'badge delivered';    
                    } else if ($record->status == 'process') {
                        $class = 'badge process';    
                    } else if ($record->status == 'out_to_deliver') {
                        $class = 'badge out_to_deliver';    
                    } 
                    
                    $row[] = '<span class="'.$class.'">'.ucwords(str_replace("_", " ", $record->status)).'</span>';
                    
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_KM_VIEW_ORDER);
                    $dta .= '<input type="hidden" name="order_id" value="'.$record->order_id.'"><input type="hidden" name="order_type" value="'.$record->status.'">';
                    $dta .= '<button type="submit" name="view_order" class="'.CLASS_VIEW_BTN.'"><i class="'.CLASS_ICON_VIEW.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    
                    $row[] = $str;
                    
                    $data[] = $row;
                }
            }

            $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->base_model->numrows,
            "recordsFiltered" => $this->base_model->numrows,
            "data" => $data,
            );

            echo json_encode($output);
        }
    }
    
    
    /**
     * KM VIEW ORDER DETAILS 
     *
     * @return array
     **/ 
    function view_order()
    {
        if (isset($_POST['view_order'])) {
            $order_id = $this->input->post('order_id');
            
            $order=array();
            $order_products = array();
            $order_addons     = array();
            $order_offers   = array();
            
            if ($order_id > 0) {
                $order = $this->base_model->get_query_result("SELECT o.*,k.username as kitchen_manager,sk.username as sent_km_user,d.username as delivery_manager FROM ".TBL_PREFIX.TBL_ORDERS." o LEFT JOIN ".TBL_PREFIX.TBL_USERS." k ON o.km_id=k.id LEFT JOIN ".TBL_PREFIX.TBL_USERS." sk ON o.sent_km_id=sk.id LEFT JOIN ".TBL_PREFIX.TBL_USERS." d ON o.dm_id=d.id WHERE o.order_id=".$order_id." ");
                
                if (!empty($order)) {
                    $order = $order[0];
                    
                    //order items
                    $order_products = $this->base_model->fetch_records_from(TBL_ORDER_PRODUCTS, array('order_id'=>$order_id,'is_deleted'=>0));
                    if (!empty($order_products)) {
                        //order addons
                        $order_addons = $this->base_model->fetch_records_from(TBL_ORDER_ADDONS, array('order_id'=>$order_id));
                    }
                    
                    //order offers
                    $order_offers = $this->base_model->fetch_records_from(TBL_ORDER_OFFERS, array('order_id'=>$order_id));
                    
                } else {
                    redirect(URL_KM_ORDERS);
                }
            } else {
                redirect(URL_KM_ORDERS);
            }
        } else {
            redirect(URL_KM_ORDERS);
        }
        
        
        $this->data['order']            = $order;
        $this->data['order_products']    = $order_products;
        $this->data['order_addons']        = $order_addons;
        $this->data['order_offers']        = $order_offers;
        
        if ($order->status=='process') {
            //$delivery_managers = $this->base_model->get_users_options(4);
            //$this->data['delivery_managers'] = $delivery_managers;
            
            $dm_options=array();
            $order_city_id = $order->city_id;
            if ($order_city_id > 0) {
                
                $dm_users = $this->base_model->get_query_result("select id,username from ".TBL_PREFIX.TBL_USERS." where FIND_IN_SET($order_city_id,assigned_cities) and active=1 ");
                
                if (!empty($dm_users)) {
                    
                    $dm_options = array(''=>get_languageword('select'));
                    
                    foreach($dm_users as $dm):
                        $dm_options[$dm->id] = $dm->username;
                    endforeach;
                    
                } 
            }
            $this->data['delivery_managers'] = $dm_options; 
        }
        
        $this->data['css_js_files'] = array('form_validation');
        $this->data['activemenu']     = "orders";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_order');
        $this->data['content']         = PAGE_VIEW_ORDER;
        $this->_render_page(TEMPLATE_KM, $this->data);
    }
    
    
    /**
     * UDPATE ORDER
     *
     * @return boolean
     **/ 
    function update_order()
    {
        if (isset($_POST['update_order_status'])) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_KM_ORDERS, REFRESH);
            }
            
            $msg='';
            $status=0;
            
            $order_id = $this->input->post('order_id');
            $order = $this->base_model->fetch_records_from(TBL_ORDERS, array('order_id'=>$order_id));
            if (!empty($order)) {
                $order = $order[0];
                $user=getUserRec($order->user_id);
                $redirect_path = URL_KM_ORDERS;
                
                
                $data = array();
                $data['status']    = $this->input->post('order_status');
                
                $data['last_updated_by']  = $this->ion_auth->get_user_id();
                $data['last_updated']     = date('Y-m-d H:i:s');
                
                if ($data['status']=='out_to_deliver' && $this->input->post('dm_id') > 0) {
                    $data['is_admin_sent_to_dm'] = 'No';
                    $data['is_km_sent_to_dm'] = 'Yes';
                    $data['sent_km_id']       = $this->ion_auth->get_user_id();
                    $data['dm_id']              = $this->input->post('dm_id');
                    $data['dm_received_datetime'] = date('Y-m-d H:i:s');
                    
                    // send push notification to the delivery_manager
                    if ($this->config->item('site_settings')->pusher_status=='Yes') {
                        $this->load->library('Pusher');
                        $options = array(
                        'cluster' => 'ap2',
                        'encrypted' => TRUE
                        );
                           
                        $pusher = new Pusher($options);
                        $order_km_data['order_id'] = $order_id;
                        $pusher->trigger('my-channel', 'km_dm_event', $order_km_data); 
                    }
                    
                    
                    // send push notification to admin
                    if ($this->config->item('site_settings')->pusher_status=='Yes') {
                        $this->load->library('Pusher');
                        $options = array(
                        'cluster' => 'ap2',
                        'encrypted' => TRUE
                        );
                           
                        $pusher = new Pusher($options);
                        $order_km_data['order_id'] = $order_id;
                        $pusher->trigger('my-channel', 'km_admin_event', $order_km_data); 
                    }
                }
                
                
                $where['order_id'] = $order_id;
                if ($this->base_model->update_operation($data, TBL_ORDERS, $where)) {
                    unset($data);
                    $msg .= get_languageword('order_status_updated_successfully');
                    $status=0;
                    
                    
                    $order = $this->base_model->fetch_records_from(TBL_ORDERS, array('order_id'=>$this->input->post('order_id')));                    
                    $order = $order[0];
                    //SEND EMAIL TO USER
                    $email_template = $this->base_model->fetch_records_from(TBL_EMAIL_TEMPLATES, array('subject'=>'order_status_changed','status'=>'Active'));
                    
                    if (!empty($email_template)) {
                        $email_template = $email_template[0];
                        
                        $from     = $this->config->item('site_settings')->portal_email;
                        $to     = $user->email;
                        $sub     = $this->config->item('site_settings')->site_title.' - '.get_languageword('order_status');
                    
                        $content         = $email_template->email_template;
                        
                        
                        $logo_img='<img src="'.get_site_logo().'" class="img-responsive">';
                        
                        
                        $content         = str_replace("__SITE_LOGO__", $logo_img, $content);
                        
                        $content         = str_replace("__SITE_TITLE__", $this->config->item('site_settings')->site_title, $content);
                        
                        $content         = str_replace("__NAME__", $order->customer_name, $content);
                        
                        $content         = str_replace("__ORDER__NO__", $order->order_id, $content);
                        
                        $content     = str_replace("__NO_OF_ITEMS__", $order->no_of_items, $content);

                        $content         = str_replace("__ORDER_TIME__", $order->order_time, $content);
                    
                        $content         = str_replace("__TOTAL_COST__", $this->config->item('site_settings')->currency_symbol.$order->total_cost, $content);
                    
                        $content         = str_replace("__PAYMENT_MODE__", ucfirst($order->payment_type), $content);
                        
                        $content         = str_replace("__MESSAGE__", $this->input->post('message'), $content);
                        
                        $content         = str_replace("__STATUS__", ucwords(str_replace("_", " ", $order->status)), $content);
                    
                        $content         = str_replace("__CONTACT__EMAIL__", $this->config->item('site_settings')->portal_email, $content);
                        
                        $content         = str_replace("__CONTACT__NO__", $this->config->item('site_settings')->land_line, $content);
                    
                        $content     = str_replace("__ANDROID__", '<a href="'.$this->config->item('site_settings')->android_url.'"><img src="'.get_android_img().'" class="img-responsive"></a>', $content);

                        $content     = str_replace("__IOS__", '<a href="'.$this->config->item('site_settings')->ios_url.'"><img src="'.get_ios_img().'" class="img-responsive"></a>', $content);
                        
                        
                        $content         = str_replace("__SITE_TITLE__", $this->config->item('site_settings')->site_title, $content);
                    
                        $content         = str_replace("__COPY_RIGHTS__", $this->config->item('site_settings')->rights_reserved_content, $content);
                    
                        if (sendEmail($from, $to, $sub, $content)) {
                            $msg .= ' '.get_languageword('email_sent_to_user');
                        } else {
                            $msg .= ' '.get_languageword('email_not_send_to_user');
                        }                            
                    }
                    //SEND EMAIL TO USER
                    
                    
                    // SEND PUSH NOTIFICATION IF IT IS ENABLE
                    if ($this->config->item('site_settings')->fcm_push_notifications=='Yes') {
                        $device_id = $order->device_id;
                        $status_translated = get_languageword($this->input->post('order_status'));
                        
                        if ($device_id=='') {
                            $device_id = $user->device_id;
                        }
                        
                        if (!empty($device_id)) {
                            $message = array(
                            "en" => $this->input->post('message'),
                            "title" => "Order Update ".$this->config->item('site_settings')->site_title,
                            "icon" => "myicon",
                            "sound" => "default"
                            );
                            $data = array(
                            "body" => $this->input->post('message'),
                            "title" => "Order Update ".$this->config->item('site_settings')->site_title
                            );    
                            
                            $data['status'] = $status_translated;
                            $gcpm = new OneSignalPush();
                            $gcpm->setDevices($device_id);
                            $gcpm->send($message, $data);
                        } 
                    } 
                    // SEND PUSH NOTIFICATION IF IT IS ENABLE
                    
                    
                    
                    // SEND SMS IF ENABLE
                    if ($this->config->item('site_settings')->sms_notifications=='Yes') {
                        $sms_details = $this->base_model->fetch_records_from(TBL_SMS_TEMPLATES, array('subject'=>'order_update'));
                        if (!empty($sms_details)) {
                            $content = strip_tags($sms_details[0]->sms_template);
                            
                            $content         = str_replace("__ORDER__ID__", $order->order_id, $content);
                            $content         = str_replace("__STATUS__", ucwords(str_replace('_', ' ', $order->status)), $content);
                            $content         = str_replace("__MESSAGE__", $this->input->post('message'), $content);
                            
                            
                            
                            $mobile_number     = $user->phone;
                            if ($mobile_number == '') {
                                $mobile_number = $user->phone;
                            }
                            
                            
                            $response = sendSMS($mobile_number, $content);
                            
                            if ($response['result']==1) {
                                $msg .= ' '.get_languageword('sms_sent_to_user');
                            } else {
                                $msg .= ' '.get_languageword('sms_sent_to_user');
                            }
                        }
                    }
                    // SEND SMS END
                    
                    
                    $this->prepare_flashmessage($msg, $status);
                    redirect($redirect_path);
                } else {
                    $msg .= get_languageword('order_status_not_updated');
                    $status=1;
                    $this->prepare_flashmessage($msg, $status);
                    redirect($redirect_path);
                }
            } else {
                $msg .= get_languageword('order_status_not_updated');
                $status=1;
            }
            $this->prepare_flashmessage($msg, $status);
            redirect(URL_KM_ORDERS);
        } else {
            redirect(URL_KM_ORDERS);
        }
    }
    
}