<?php
/**
 * Menorah Restaurant-DigiSamaritan
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, DigiSamaritan
 *
 * @category  Admin
 * @package   Menorah Restaurant
 * @author    DigiSamaritan <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DigiSamaritan
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Addons Class
 * 
 * Admin can perform operations.
 *
 * @category  Admin
 * @package   Menorah Restaurant
 * @author    DigiSamaritan <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DigiSamaritan
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Admin extends MY_Controller
{

    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     Menorah Restaurant
    | -----------------------------------------------------
    | AUTHOR:           CODECAKES TEAM
    | -----------------------------------------------------
    | EMAIL:            digisamaritan@gmail.com
    | -----------------------------------------------------
    | COPYRIGHTS:       RESERVED BY DigiSamaritan
    | -----------------------------------------------------      
    | http://codecanyon.net/user/digisamaritan
    | http://conquerorstech.net/
    | -----------------------------------------------------
    |
    | MODULE:           ADMIN CONTROLLER
    | -----------------------------------------------------
    | This is Admin module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

    /**
     * ADMIN DASHBOARD 
     * Fetch records count of modules
     *
     * @return array
     **/    
    function index()
    {
        $this->load->model('admin_model');
        
        $data = $this->admin_model->get_modules_count();
        $this->data['modules_count']  =  (object) $data;
        
        $this->data['activemenu']     = ACTIVE_ADMIN;
        
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']       = get_languageword('admin_dashboard');
        $this->data['content']         = PAGE_ADMIN_DASHBOARD;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * ADMIN DASHBOARD 
     * Fetch Orders summary with status
     * to show in graph format
     *
     * @return array
     **/ 
    function orders_summary()
    {
        $result=array();
        
        $years=array();
        
        //get first order date
        $first_order = $this->base_model->get_query_result("select order_date from cr_orders order by order_id asc limit 1");
        if (!empty($first_order)) {
            $first_order = $first_order[0];
            
            $year = date('Y', strtotime($first_order->order_date));
            $month = date('n', strtotime($first_order->order_date));
            
            
            
            if ($month==1) {
                
                $years=array($year);
                
                for ($m=1; $m<=12; ++$m) {
                    
                    $data = array();
                    
                    $numbr = 0;//rand(0,99999);
                    
                    $orders = $this->base_model->get_query_result("SELECT SUM(total_cost) as amount FROM cr_orders WHERE YEAR(order_date)='".$year."' and  Month(order_date) IN ($m)");
                    
                    if (!empty($orders)) {
                        $numbr = $orders[0]->amount;
                    }
                    
                    $data = array('month'=>date('M', mktime(0, 0, 0, $m, 1)),'amount'=>$numbr);
                    array_push($result, $data);
                    unset($data);
                    
                }
            } else {
                
                for ($m=$month; $m<=12; ++$m) {
                    
                    $data = array();
                    
                    $numbr = 0;
                    
                    $orders = $this->base_model->get_query_result("SELECT SUM(total_cost) as amount FROM cr_orders WHERE YEAR(order_date)='".$year."' and  Month(order_date) IN ($m)");
                    
                    if (!empty($orders)) {
                        $numbr = $orders[0]->amount;
                    }
                    
                    $data = array('month'=>date('M', mktime(0, 0, 0, $m, 1)),'amount'=>$numbr);
                    array_push($result, $data);
                    unset($data);
                }
                
                
                $next_year = $year+1;
                
                $years=array($year.'-'.$next_year);
                
                
                //get remaining months
                for ($m=1; $m<$month; ++$m) {
                    
                    $data = array();
                    
                    $numbr = 0;
                    
                    $orders = $this->base_model->get_query_result("SELECT SUM(total_cost) as amount FROM cr_orders WHERE YEAR(order_date)='".$next_year."' and  Month(order_date) IN ($m)");
                    
                    if (!empty($orders)) {
                        $numbr = $orders[0]->amount;
                    }
                    
                    $data = array('month'=>date('M', mktime(0, 0, 0, $m, 1)),'amount'=>$numbr);
                    array_push($result, $data);
                    unset($data);
                }
                
            }
            
            array_push($result, $years);
        }
        
        
        echo json_encode($result);
    }
    
    /**
     * Admin Profile 
     *
     * @return boolean
     **/
    function profile()
    {
        $user_id = $this->ion_auth->get_user_id();
        
        if (isset($_POST['update_profile'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_ADMIN_PROFILE);
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
                redirect(URL_ADMIN_PROFILE, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('update_profile');
            
        $record = $this->base_model->fetch_records_from(TBL_USERS, array('id' => $user_id));
        if (empty($record)) {
            $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
            redirect(URL_ADMIN_INDEX);                
        }
        $this->data['record'] =    $record[0];
            
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        
        $this->data['activemenu']      = ACTIVE_ADMIN;
        
        $this->data['content']          = PAGE_ADMIN_RROFILE;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
    
    /**
     * Change Password 
     *
     * @return boolean
     **/
    function change_password()
    {
        if (isset($_POST['change_pwd'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_ADMIN_CHANGE_PASSWORD);
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
                    redirect(URL_ADMIN_CHANGE_PASSWORD, REFRESH);
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
        $this->data['activemenu']     = ACTIVE_ADMIN;
        $this->data['pagetitle']     = get_languageword('change_password');
        $this->data['content']         = PAGE_CHANGE_PASSWORD;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * ADMIN DASHBOARD
     * Fetch Orders summary with status
     * to show in calendar
     *
     * @return array
     **/    
    function orders_overview()
    {
        $this->data['activemenu']     = ACTIVE_ADMIN;
        $this->data['pagetitle']     = get_languageword('orders_overview');
        
        $this->data['content']         = 'calendar_orders';
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * ADMIN DASHBOARD
     * Fetch Orders summary with status
     * to show in calendar
     *
     * @return array
     **/ 
    function fetch_orders_overview()
    {
        //get count of orders - datewise -
        
        $data=array();
        
        $query = "SELECT distinct(order_date) from ".TBL_PREFIX.TBL_ORDERS." order by order_date ";
        $orders = $this->db->query($query)->result();
        
        foreach($orders as $order):
            
            $query = "SELECT count(order_id) as new_orders from ".TBL_PREFIX.TBL_ORDERS." WHERE order_date='".$order->order_date."' and status='new'";
            $new = $this->db->query($query)->result();
            
            if (!empty($new)) {
                if ($new[0]->new_orders > 0) {
                    array_push($data, array('title'=>'New '.$new[0]->new_orders,'start'=>$order->order_date,'end'=>$order->order_date));
                }
                
            }
            
            
            $query = "SELECT count(order_id) as out_to_deliver from ".TBL_PREFIX.TBL_ORDERS." WHERE order_date='".$order->order_date."' and status='out_to_deliver'";
            $out_to_deliver = $this->db->query($query)->result();
            if (!empty($out_to_deliver)) {
                if ($out_to_deliver[0]->out_to_deliver > 0) {
                    array_push($data, array('title'=>'Out to Deliver '.$out_to_deliver[0]->out_to_deliver,'start'=>$order->order_date,'end'=>$order->order_date));
                }
            }
            
            $query = "SELECT count(order_id) as processing from ".TBL_PREFIX.TBL_ORDERS." WHERE order_date='".$order->order_date."' and status='process'";
            $process = $this->db->query($query)->result();
            if (!empty($process)) {
                if ($process[0]->processing > 0) {
                    array_push($data, array('title'=>'Process '.$process[0]->processing,'start'=>$order->order_date,'end'=>$order->order_date));
                }
            }
            
            
            $query = "SELECT count(order_id) as delivered from ".TBL_PREFIX.TBL_ORDERS." WHERE order_date='".$order->order_date."' and status='delivered'";
            $delivered = $this->db->query($query)->result();
            
            if (!empty($delivered)) {
                if ($delivered[0]->delivered > 0) {
                    array_push($data, array('title'=>'Delivered '.$delivered[0]->delivered,'start'=>$order->order_date,'end'=>$order->order_date));
                }
            }
            
            $query = "SELECT count(order_id) as cancelled from ".TBL_PREFIX.TBL_ORDERS." WHERE order_date='".$order->order_date."' and status='cancelled'";
            $cancelled = $this->db->query($query)->result();
            
            if (!empty($cancelled)) {
                if ($cancelled[0]->cancelled > 0) {
                    array_push($data, array('title'=>'Cancelled '.$cancelled[0]->cancelled,'start'=>$order->order_date,'end'=>$order->order_date));
                }
            }
        
        endforeach;
        
        echo json_encode($data);
    }
}
