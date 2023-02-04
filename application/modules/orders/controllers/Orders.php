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
 * @category  Orders
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Orders Class
 * 
 * Orders operations.
 *
 * @category  Orders
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Orders extends MY_Controller
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
    | MODULE:           ORDERS CONTROLLER
    | -----------------------------------------------------
    | This is Orders module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

    /**
     * Fetch Orders Records
     * 
     *
     * @param string $order_type 
     *
     * @return array
     **/ 
    function index($order_type='')
    {
        if ($order_type=='') {
            $order_type='new';
        }
        
        
        $active_submenu=$order_type;
        
        
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_ORDERS_AJAX_GET_LIST,
        'disablesorting' => '0,8',
        'type' => $order_type
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = "orders";
        $this->data['actv_submenu'] = $active_submenu;
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_orders');
        $this->data['content']         = PAGE_ORDERS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Fetch Orders Records
     *
     * @return array
     **/ 
    function ajax_get_list()
    {
        if ($this->input->is_ajax_request()) {
            
            $data = array();
            $no = $_POST['start'];
            $order_type = $this->input->post('type');
            
            $conditions = array();

            $columns = array('tds.order_id','tds.order_date','tds.order_time','tds.total_cost','tds.customer_name','tds.phone','tds.status');    
            
            $query     = "SELECT tds.* from ".TBL_PREFIX.TBL_ORDERS." tds WHERE tds.status = '".$order_type."' ";
            
            
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
                    $dta .= form_open(URL_VIEW_ORDER);
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
     * VIEW ORDER
     *
     * @return array
     **/     
    function view_order()
    {
        if (isset($_POST['view_order'])) {
            
            $order_id = $this->input->post('order_id');
            $order_type = $this->input->post('order_type');
            
            $order=array();
            $order_products = array();
            $order_addons     = array();
            $order_offers   = array();
            
            if ($order_id > 0 && $order_type != '') {
                
                $active_submenu=$order_type;
                $this->data['actv_submenu'] = $active_submenu;
        
        
                //order
                
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
                    redirect(URL_ORDERS_INDEX.'new');
                }
            } else {
                redirect(URL_ORDERS_INDEX.'new');
            }
        } else {
            redirect(URL_ORDERS_INDEX.'new');
        }
        
        
        $this->data['order']            = $order;
        $this->data['order_products']    = $order_products;
        $this->data['order_addons']        = $order_addons;
        $this->data['order_offers']        = $order_offers;
        
        if ($order->status == 'new' || $order->status == 'process') {
            $kitchen_managers = $this->base_model->get_users_options(3);
            $this->data['kitchen_managers'] = $kitchen_managers;
    
       
            $dm_options=array();
            $order_city_id = $order->city_id;
            
            if ($order_city_id > 0) {
                
                $dm_users = $this->base_model->get_query_result("select id,username from ".TBL_PREFIX.TBL_USERS." where FIND_IN_SET($order_city_id,assigned_cities) and active=1 ");
                
                if (!empty($dm_users)) {
                    
                    $dm_options = array(''=>get_languageword('select'));
                    
                    foreach ($dm_users as $dm):
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
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * DELETE ORDER ITEM 
     *
     * @return boolean
     **/ 
    function delete_order()
    {
        if (isset($_POST['delete_item'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_ORDERS_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $details = explode("=", $this->input->post('delete_item_id'));
            
            if (!empty($details)) {
                $order_id     = $details[0];
                $deleted_id = $details[1];
                $type         = $details[2];
                
                $order_record = $this->base_model->fetch_records_from(TBL_ORDERS, array('order_id'=>$order_id));
                $order_record = $order_record[0];
                
                $redirect_path = URL_ORDERS_INDEX.$order_record->status;
                
                if ($type=='product') {
                    //no_of_items
                    $product = $this->base_model->fetch_records_from(TBL_ORDER_PRODUCTS, array('op_id'=>$deleted_id));
                    
                    if (!empty($product)) {
                        $product = $product[0];
                        $product_cost = $product->final_cost;
                        
                        $data = array();
                        $data['is_deleted'] = 1;
                        
                        if ($this->base_model->update_operation($data, TBL_ORDER_PRODUCTS, array('op_id'=>$deleted_id))) {
                            //order product deleted bit updated
                            //order_cost
                            
                            unset($data);
                            $order_cost = ($order_record->total_cost) - ($product_cost);
                            if ($order_cost <= 0) {
                                $order_cost = 0;
                            } else {
                                $order_cost = $order_cost;
                            }
                            
                            
                            $data = array();
                            $data['no_of_items'] = $order_record->no_of_items - 1;
                            $data['total_cost']     = $order_cost;
                            
                            
                            if ($this->base_model->update_operation($data, TBL_ORDERS, array('order_id'=>$order_id))) {
                                //order product deleted
                                //order cost updated
                                //send email to user - 
                                unset($data);
                                $result = $this->send_email_to_customer($order_record, $product, $type);
                                $msg .= get_languageword('order_item_deleted_successfully').'<br>'.$result;
                                $status=0;
                            } else {
                                //order cost not updated
                                unset($data);
                                $msg .= get_languageword('order_item_not_deleted');
                                $status=1;
                            
                                $data = array();
                                $data['is_deleted'] = 0;
                                $this->base_model->update_operation($data, TBL_ORDER_PRODUCTS, array('op_id'=>$deleted_id));
                            }
                            $this->prepare_flashmessage($msg, $status);
                            redirect($redirect_path);
                        } else {
                            $msg .= get_languageword('item_not_deleted');
                            $status=1;
                            $this->prepare_flashmessage($msg, $status);
                            redirect($redirect_path);
                        }
                    } else {
                        $msg .= get_languageword('item_not_found');
                        $status=1;
                        $this->prepare_flashmessage($msg, $status);
                        redirect($redirect_path);
                    }
                    
                } else if ($type=='addon') {
                    
                    $addon = $this->base_model->fetch_records_from(TBL_ORDER_ADDONS, array('oa_id'=>$deleted_id));
                    
                    if (!empty($addon)) {
                        
                        $addon = $addon[0];
                        
                        $addon_cost = $addon->final_cost;
                        
                        $data = array();
                        $data['is_deleted'] = 1;
                        if ($this->base_model->update_operation($data, TBL_ORDER_ADDONS, array('oa_id'=>$deleted_id))) {
                            //order addon deleted bit updated
                            //order_cost
                            
                            unset($data);
                            $order_cost = ($order_record->total_cost) - ($addon_cost);
                            if ($order_cost <= 0) {
                                $order_cost = 0;
                            } else {
                                $order_cost = $order_cost;
                            }
                            
                            $data = array();
                            $data['total_cost']     = $order_cost;
                            
                            if ($this->base_model->update_operation($data, TBL_ORDERS, array('order_id'=>$order_id))) {
                                //order addon deleted
                                //order cost updated
                                //send email to user - 
                                unset($data);
                                $result = $this->send_email_to_customer($order_record, $addon, $type);
                                $msg .= get_languageword('order_addon_item_deleted_successfully').'<br>'.$result;
                                $status=0;
                                
                            } else {
                                
                                //order cost not updated
                                unset($data);
                                $msg .= get_languageword('order_addon_item_not_deleted');
                                $status=1;
                            
                                $data = array();
                                $data['is_deleted'] = 0;
                                $this->base_model->update_operation($data, TBL_ORDER_ADDONS, array('oa_id'=>$deleted_id));
                            }
                            $this->prepare_flashmessage($msg, $status);
                            redirect($redirect_path);
                            
                        } else {
                            $msg .= get_languageword('addon_not_deleted');
                            $status=1;
                            $this->prepare_flashmessage($msg, $status);
                            redirect($redirect_path);
                        }
                    } else {
                        $msg .= get_languageword('addon_not_found');
                        $status=1;
                        $this->prepare_flashmessage($msg, $status);
                        redirect($redirect_path);
                    }
                    
                } else if ($type=='offer') {
                    
                    //no_of_items
                    $offer = $this->base_model->fetch_records_from(TBL_ORDER_OFFERS, array('order_offer_id'=>$deleted_id));
                    
                    if (!empty($offer)) {
                        $offer = $offer[0];
                        
                        $offer_cost = $offer->offer_final_cost;
                        
                        $data = array();
                        $data['is_deleted'] = 1;
                        
                        if ($this->base_model->update_operation($data, TBL_ORDER_OFFERS, array('order_offer_id'=>$deleted_id))) {
                            //order offer item deleted bit updated
                            //order_cost
                            
                            unset($data);
                            $order_cost = ($order_record->total_cost) - ($offer_cost);
                            if ($order_cost <= 0) {
                                $order_cost = 0;
                            } else {
                                $order_cost = $order_cost;
                            }
                            
                            $data = array();
                            $data['no_of_items'] = $order_record->no_of_items - 1;
                            $data['total_cost']     = $order_cost;
                            
                            if ($this->base_model->update_operation($data, TBL_ORDERS, array('order_id'=>$order_id))) {
                                //order offer item deleted
                                //order cost updated
                                //send email to user - 
                                unset($data);
                                $result = $this->send_email_to_customer($order_record, $offer, $type);
                                $msg .= get_languageword('order_offer_item_deleted_successfully').'<br>'.$result;
                                $status=0;
                            } else {
                                //order cost not updated
                                unset($data);
                                $msg .= get_languageword('order_offer_item_not_deleted');
                                $status=1;
                            
                                $data = array();
                                $data['is_deleted'] = 0;
                                $this->base_model->update_operation($data, TBL_ORDER_OFFERS, array('order_offer_id'=>$deleted_id));
                            }
                            $this->prepare_flashmessage($msg, $status);
                            redirect($redirect_path);
                        } else {
                            $msg .= get_languageword('offer_item_not_deleted');
                            $status=1;
                            $this->prepare_flashmessage($msg, $status);
                            redirect($redirect_path);
                        }
                        
                    } else {
                        $msg .= get_languageword('offer_item_not_found');
                        $status=1;
                        $this->prepare_flashmessage($msg, $status);
                        redirect($redirect_path);
                    }
                } else {
                    redirect($redirect_path);
                }
            } else {
                redirect(URL_ORDERS_INDEX.'new');
            }
        } else {
            redirect(URL_ORDERS_INDEX.'new');
        }
    }
    
    /**
     * SEND E-MAIL TO USER
     * @param  [array]  $order_record [description]
     * @param  [array]  $item_details [description]
     * @param  [string] $type         [description]
     * @return [boolean]               [description]
     */
    function send_email_to_customer($order_record,$item_details,$type)
    {
        $msg='';
        $item_name='';
        $item_type='';
        
        if (!empty($order_record)) {
            
            if ($type=='product') {
                $item_name = $item_details->item_name;
                $item_type = 'Item';
            } else if ($type=='addon') {
                $item_name = $item_details->addon_name;
                $item_type = 'Addon';                
            } else if ($type=='offer') {
                $item_name = $item_details->offer_name;
                $item_type = 'Offer Item';                    
            }
            
            $user=getUserRec($order_record->user_id);
            if (!empty($user)) {
                //send email to user
                $email_template = $this->base_model->fetch_records_from(TBL_EMAIL_TEMPLATES, array('subject'=>'order_cancelled','status'=>'Active'));
                
                if (!empty($email_template)) {
                    $from     = $this->config->item('site_settings')->portal_email;
                    $to     = $user->email;
                    $sub     = $this->config->item('site_settings')->site_title.' - '.get_languageword('order_update');
        
                    $email_template = $email_template[0];            
                    $content         = $email_template->email_template;
                    
                    
                    $logo_img='<img src="'.get_site_logo().'" class="img-responsive" style="max-width:250px;">';
                    
                        
                    $content         = str_replace("__SITE_LOGO__", $logo_img, $content);
                    
                    $content         = str_replace("__SITE_TITLE__", $this->config->item('site_settings')->site_title, $content);
                    
                    $content         = str_replace("__NAME__", $order_record->customer_name, $content);

                    $content         = str_replace("__ITEM_NAME__", $item_type.' '.$item_name, $content);
                    
                    $content     = str_replace("__ORDER_NO__", $order_record->order_id, $content);
                    
                    $content         = str_replace("__CONTACT__EMAIL__", $this->config->item('site_settings')->portal_email, $content);
                    
                    $content         = str_replace("__CONTACT__NO__", $this->config->item('site_settings')->land_line, $content);
                    
                    $content     = str_replace("__ANDROID__", '<a href="'.$this->config->item('site_settings')->android_url.'"><img src="'.get_android_img().'" class="img-responsive"></a>', $content);

                    $content     = str_replace("__IOS__", '<a href="'.$this->config->item('site_settings')->ios_url.'"><img src="'.get_ios_img().'" class="img-responsive"></a>', $content);
                
                    $content         = str_replace("__SITE_TITLE__", $this->config->item('site_settings')->site_title, $content);
                
                    $content         = str_replace("__COPY_RIGHTS__", $this->config->item('site_settings')->rights_reserved_content, $content);
                    
                    if (sendEmail($from, $to, $sub, $content)) {
                        $msg .= get_languageword('email_sent_to_user');
                    }
                } else {
                    $msg .= get_languageword('email_sms_not_send_to_user');
                }
                    
                // SEND PUSH NOTIFICATION IF IT IS ENABLE
                if ($this->config->item('site_settings')->fcm_push_notifications=='Yes') {
                    $device_id = $order_details->device_id;
                    if ($device_id=='') {
                        $device_id = $user->device_id;
                    }
                        
                    if (!empty($device_id)) {
                        $message = array(
                        "en" => $item_type.' '.$item_name.' Removed From Your Order No:'.$order_record->order_id,
                        "title" => 'Item Removed '.$this->config->item('site_settings')->site_title,
                        "sound" => "default",
                        "icon" => "myicon"
                        ); 
                        $data = array(
                        "body" => $item_type.' '.$item_name.' Removed From Your Order No:'.$order_record->order_id,
                        "title" => 'Item Removed '.$this->config->item('site_settings')->site_title
                        );
                        $gcpm = new OneSignalPush();
                        $gcpm->setDevices($device_id);
                        $gcpm->send($message, $data);
                    }
                } 
                // PUSH NOTIFICATION CODE ENDS HERE
                    
                    
                    
                // SEND SMS IF ENABLE
                if ($this->config->item('site_settings')->sms_notifications=='Yes') {
                    $sms_details = $this->base_model->fetch_records_from(TBL_SMS_TEMPLATES, array('subject'=>'item_deleted'));
                        
                    if (!empty($sms_details)) {
                            
                        $content = strip_tags($sms_details[0]->sms_template);
                            
                        $content         = str_replace("__ORDER__ID__", $order_record->order_id, $content);
                        $content         = str_replace("__ITEM__NAME__", $item_type.' '.$item_name, $content);
                            
                        $mobile_number     = $order_details->phone;
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
            } else {
                $msg .= get_languageword('email_sms_not_send_to_user');
            }
        } else {
            $msg .= get_languageword('email_sms_not_send_to_user');
        }
        return $msg;
    }
    
    
    /**
     * UPDATE ORDER
     *
     * @return boolean
     **/ 
    function update_order()
    {
        if (isset($_POST['update_order_status'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_ORDERS_INDEX, REFRESH);
            }
            
            $msg='';
            $status=0;
            
            $order_id = $this->input->post('order_id');
            $order = $this->base_model->fetch_records_from(TBL_ORDERS, array('order_id'=>$order_id));
            
            if (!empty($order)) {
                $order = $order[0];
                $user=getUserRec($order->user_id);
                $redirect_path = URL_ORDERS_INDEX.$order->status;
                
                
                $data = array();
                $data['status']    = $this->input->post('order_status');
                
                
                $data['last_updated_by']  = $this->ion_auth->get_user_id();
                $data['last_updated']     = date('Y-m-d H:i:s');
                
                
                if ($data['status']=='process' && $this->input->post('km_id') > 0) {
                    $data['is_admin_sent_to_km'] = 'Yes';
                    $data['km_id']     = $this->input->post('km_id');
                    $data['km_received_datetime'] = date('Y-m-d H:i:s');
                    
                    
                    // send push notification to the kitchen_manager
                    if ($this->config->item('site_settings')->pusher_status=='Yes') {
                        $this->load->library('Pusher');
                        $options = array(
                        'cluster' => 'ap2',
                        'encrypted' => TRUE
                        );
                           
                        $pusher = new Pusher($options);
                        $order_km_data['order_id'] = $order_id;
                        $pusher->trigger('my-channel', 'km_event', $order_km_data); 
                    }
                }
                
                if ($data['status']=='out_to_deliver' && $this->input->post('dm_id') > 0) {
                    $data['is_admin_sent_to_dm'] = 'Yes';
                    $data['is_km_sent_to_dm'] = 'No';
                    $data['sent_km_id']       = NULL;
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
                        $pusher->trigger('my-channel', 'admin_dm_event', $order_km_data); 
                    }
                }
                
                $data['message']   = $this->input->post('message');
                
                
                if ($data['status']=='delivered' && $order->paid_amount=='' && $order->paid_date=='') {
                    $data['paid_amount']    = $order->total_cost;
                    $data['paid_date']        = date('Y-m-d');
                }
                
                
                if ($data['status']=='delivered') {
                    
                    $data['delivered_status'] = 'admin';
                    $data['delivered_status_datetime'] = date('Y-m-d H:i:s');
                }
                
                
                if ($data['status']=='cancelled') {
                    
                    $data['cancelled_status'] = 'admin';
                    $data['cancelled_status_datetime'] = date('Y-m-d H:i:s');
                }
                
                $where['order_id'] = $order_id;
                if ($this->base_model->update_operation($data, TBL_ORDERS, $where)) {
                    unset($data);
                    $msg .= get_languageword('order_status_updated_successfully');
                    $status=0;
                    
                    if ($this->input->post('order_status')=='delivered') {
                        //check for redeem points
                        
                        $user=getUserRec($order->user_id);
                        //check for first order
                        if ($this->config->item('point_settings')->points_enabled=='Yes' && $this->config->item('point_settings')->points_for_first_order > 0) {
                            $orders = $this->base_model->fetch_records_from(TBL_ORDERS, array('user_id'=>$order->user_id,'status'=>'delivered'));
                            if (count($orders)==1) {
                                //add points
                                $data = array();
                                $data['user_points'] = ($user->user_points)+$this->config->item('point_settings')->points_for_first_order;
                                
                                if ($this->base_model->update_operation($data, TBL_USERS, array('id'=>$user->id))) {
                                    //point logs
                                    unset($data);
                                    $data = array();
                                    $data['user_id']     = $user->id;
                                    $data['points']      = $this->config->item('point_settings')->points_for_first_order;
                                    $data['transaction_type'] = 'Earned';
                                    $data['order_id']           = $order->order_id;
                                    
                                    $data['description'] = get_languageword('points_earned_for_first_order');
                                    
                                    $data['created_on']          = date('Y-m-d H:i:s');
                                    
                                    $this->base_model->insert_operation($data, TBL_USER_POINTS);
                                    unset($data);
                                }
                            }
                        }
                        
                        $user=getUserRec($order->user_id);
                        //check for order earning points
                        if ($this->config->item('point_settings')->points_enabled=='Yes' && $this->config->item('point_settings')->maximum_earning_points_for_customer > 0) {
                            //add points
                            $data = array();
                            $data['user_points'] = $user->user_points+$this->config->item('point_settings')->maximum_earning_points_for_customer;
                            
                            $whr['id'] = $user->id;
                            if ($this->base_model->update_operation($data, TBL_USERS, $whr)) {
                                //point logs
                                unset($data);
                                $data = array();
                                $data['user_id']     = $user->id;
                                $data['points']      = $this->config->item('point_settings')->maximum_earning_points_for_customer;
                                $data['transaction_type'] = 'Earned';
                                $data['order_id']           = $order->order_id;
                                
                                $data['description'] = get_languageword('points_earned_for_buy_an_item_order');
                                
                                $data['created_on']          = date('Y-m-d H:i:s');
                                    
                                $this->base_model->insert_operation($data, TBL_USER_POINTS);
                                unset($data);
                            }
                        }
                    }
                    
                    if ($this->input->post('order_status')=='cancelled') {
                        //check for redeem points
                        if ($order->is_points_redeemed=='Yes' && $order->no_of_points_redeemed > 0) {
                            //redeem points
                            $data = array();
                            $data['user_points'] = ($user->user_points)+$order->no_of_points_redeemed;
                            
                            if ($this->base_model->update_operation($data, TBL_USERS, array('id'=>$user->id))) {
                                //point logs
                                unset($data);
                                $data = array();
                                $data['user_id']     = $user->id;
                                $data['points']      = $order->no_of_points_redeemed;
                                $data['transaction_type'] = 'Earned';
                                $data['order_id']           = $order->order_id;
                                $data['description']     = get_languageword('points_returned_for_cancelled_an_item_order');
                                $data['created_on']          = date('Y-m-d H:i:s');
                                
                                $this->base_model->insert_operation($data, TBL_USER_POINTS);
                                unset($data);
                            }
                        }
                    }
                    
                    
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
                        
                        
                        $logo_img='<img src="'.get_site_logo().'" class="img-responsive" style="max-width:250px;">';
                        
                        
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
            redirect(URL_ORDERS_INDEX.'new');
        } else {
            redirect(URL_ORDERS_INDEX.'new');
        }
    }
}