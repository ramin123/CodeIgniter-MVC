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
 * @category  User
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter User Class
 * 
 * User can perform operations.
 *
 * @category  User
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class User extends MY_Controller
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
    | MODULE:           User CONTROLLER
    | -----------------------------------------------------
    | This is User module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('user');
    }

    /**
     * HOME PAGE
     *
     * @return page
     **/ 
    function index()
    {
        redirect(URL_WELCOME_INDEX);
    }
    
    /**
     * USER PROFILE
     *
     * @return boolean
     **/
    function profile()
    {
        $user_id = $this->ion_auth->get_user_id();
        
        if (isset($_POST['update_profile'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_USER_PROFILE);
            }
                    
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('first_name', get_languageword('first name'), 'required|xss_clean');    
            $this->form_validation->set_rules('last_name', get_languageword('last_name'), 'required|xss_clean');    
            $this->form_validation->set_rules('phone', get_languageword('phone'), 'required|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run()==TRUE) {
                $data = array();
                
                $data['first_name']     = $this->input->post('first_name'); 
                $data['last_name']      = $this->input->post('last_name'); 
                $data['username']       = $this->input->post('first_name').' '.$this->input->post('last_name');
                $data['phone']          = $this->input->post('phone'); 
                
                $where['id']  = $this->ion_auth->get_user_id();
                
                if ($this->base_model->update_operation($data, TBL_USERS, $where)) {
                    unset($data, $where);
                    $msg .= get_languageword('profile_updated_successfully');
                    $status=0;
                } else {
                    $msg .= get_languageword('profile_not_updated');
                    $status=1;
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_USER_PROFILE, REFRESH);
            }    
            
        } else if (isset($_POST['profile_image'])) {
            
            $msg='';
            $status=0;
            $data = array();
            
            //Upload Site Logo
            if (count($_FILES) > 0) {
                
                if ($_FILES['profile_image']['name'] != '' && $_FILES['profile_image']['error'] != 4) {
                    $user = getUserRec();
                    
                    if (!empty($user)) {
                        
                        if ($user->photo != '' && file_exists(USER_IMG_UPLOAD_PATH_URL.$user->photo)) {
                            unlink(USER_IMG_UPLOAD_PATH_URL.$user->photo);
                            unlink(USER_IMG_UPLOAD_THUMB_PATH_URL.$user->photo);
                        }
                    }
                    
                    $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                    $file_name = 'user_'.$user->id.'.'.$ext;
                    $config['upload_path']          = USER_IMG_UPLOAD_PATH_URL;
                    $config['allowed_types']        = ALLOWED_TYPES;
                    $config['max_size']             = 5120;
                    
                    $config['file_name']  = $file_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('profile_image')) {
                        $data['photo'] = $file_name;
                        $this->create_thumbnail($config['upload_path'].$file_name, USER_IMG_UPLOAD_THUMB_PATH_URL.$file_name, 200, 200);

                    $msg .= get_languageword('profile_image_updated_successfully');                        
                    $status=0;

                    } else {
                        $msg .= strip_tags($this->upload->display_errors());
                        $status =1;
                    }
                }
                
                if (!empty($data)) {
                    $this->base_model->update_operation($data, TBL_USERS, array('id'=>$user->id));
                }
            
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_USER_PROFILE, REFRESH);
            }
        }
        
        
        $user = $this->base_model->fetch_records_from(TBL_USERS, array('id'=>$user_id));
        if (!empty($user)) {
            $this->data['user'] = $user[0];
        } else {
            $msg = get_languageword('record_not_found');
            $this->prepare_flashmessage($msg, 1);
            redirect(URL_USER_PROFILE, REFRESH);
        }
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['activemenu']     = "profile";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('my_account');
        $this->data['content']      = 'my-profile';
        $this->_render_page(getTemplate(), $this->data);
    }
    
    
    /**
     * MY POINTS
     *
     * @return array
     **/  
    function my_points()
    {
        $user=getUserRec();
        
        $this->data['offset'] = $this->input->post('offset');
        
        $ajax = $this->input->post('ajax');
        if (empty($this->data['offset'])) {
            $this->data['offset'] = 0;
        }
        $this->data['start'] = ($this->data['offset']+1);
        $this->load->library('pagination');
        
        
        $this->data['user_total_points'] = $user->user_points;
        
        $data = array();
        $this->load->model('crunchy_model');
        $points = $this->crunchy_model->get_user_points($this->data['offset'], $user->id);
        $numrows = $this->crunchy_model->numrows;
        
        
        $this->data['activemenu']     = 'my_points';
        $this->data['pagetitle']     = get_languageword('my_points');
        
        $this->data['user_points']  = $points;
        
        $this->set_pagination('user/my_points', $this->data['offset'], $numrows, PER_PAGE, 'fetch_more');
        $this->data['content']         = 'my_points';  
        
        if ($ajax == 1) {
            // $this->load->view('my_points_view',$this->data);
            $this->load->view($this->data['content'], $this->data);
        } else {
            $this->_render_page(getTemplate(), $this->data);
        }
    }
    
    
    /**
     * MY ADDRESSES
     *
     * @return array
     **/  
    function my_addresses()
    {
        $user=getUserRec();
        
        $addresses     =    $this->base_model->fetch_records_from(TBL_USER_ADDRESS, array('user_id'=>$user->id));
        
        $this->data['addresses'] = $addresses;
        
        $this->data['activemenu']    = 'my_addresses';
        $this->data['pagetitle']     = get_languageword('my_addresses');
        $this->data['content']       = 'my_addresses';  
        $this->_render_page(getTemplate(), $this->data);
    }
    
    /**
     * DELETE ADDRESS
     *
     * @return boolean
     **/ 
    function delete_address()
    {
        if (isset($_POST['delete_address'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_ADD_USER_ADDRESS);
            }
            
            $ua_id = $this->input->post('ua_id');
            
            if ($ua_id > 0) {
                
                $record = $this->base_model->fetch_records_from(TBL_USER_ADDRESS, array('ua_id'=>$ua_id));
                
                if (!empty($record)) {
                    
                    $msg='';
                    $status=0;
                    if ($this->base_model->delete_record_new(TBL_USER_ADDRESS, array('ua_id' => $ua_id))) {
                        $msg .= get_languageword('address_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('address_not_deleted');
                        $status =1;
                    }
                    $this->prepare_flashmessage($msg, $status);
                    redirect(URL_ADD_USER_ADDRESS);
                } else {
                    redirect(URL_ADD_USER_ADDRESS);
                }
            } else {
                redirect(URL_ADD_USER_ADDRESS);
            }
        } else {
            redirect(URL_ADD_USER_ADDRESS);
        }
    }
    
    /**
     * ADD ADDRESS
     *
     * @return boolean
     **/ 
    function add_address() 
    {
        
        if (isset($_POST['add_address'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_ADD_USER_ADDRESS);
            }
            
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('pincode', get_languageword('pincode'), 'required|xss_clean');
            $this->form_validation->set_rules('house_no', get_languageword('house_no'), 'required|xss_clean');
            $this->form_validation->set_rules('street', get_languageword('street'), 'required|xss_clean');
            $this->form_validation->set_rules('landmark', get_languageword('landmark'), 'required|xss_clean');
            
            if ($this->form_validation->run()==TRUE) {
                
                $data = array();
                
                $spl_id = $this->input->post('locality');
                
                if ($spl_id > 0) {
                    
                    $record = $this->base_model->get_query_result("select s.locality,s.pincode,c.city_name from ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." s inner join ".TBL_PREFIX.TBL_CITIES." c on s.city_id=c.city_id where s.service_provide_location_id=".$spl_id." and s.status='Active' ");
                    
                    if (!empty($record)) {
                        
                        $record = $record[0];
                        
                        $data['user_id']        = $this->ion_auth->get_user_id();
                        $data['city']           = $record->city_name;
                        $data['locality']       = $record->locality;
                        
                        $data['house_no']       = $this->input->post('house_no');
                        $data['street']         = $this->input->post('street');
                        $data['landmark']       = $this->input->post('landmark');
                        $data['pincode']        = $this->input->post('pincode');
                        $data['location_id']    = $spl_id;
                        
                        if ($this->base_model->insert_operation($data, 'user_address')) {
                            $msg .= get_languageword('address_added_successfully');
                            $status=0;
                        } else {
                            $msg .= get_languageword('address_not_added');
                            $status=1;
                        }
                        $this->prepare_flashmessage($msg, $status);
                        redirect(URL_ADD_USER_ADDRESS);
                        
                    } else { 
                        redirect(URL_ADD_USER_ADDRESS);
                    }
                
                } else { 
                    redirect(URL_ADD_USER_ADDRESS);
                }
                
            } else {
                $this->prepare_flashmessage(strip_tags(validation_errors()), 1);
                redirect(URL_ADD_USER_ADDRESS);
            }
        } else {
            redirect(URL_ADD_USER_ADDRESS);
        }
    }
    
    /**
     * SET DEFAULT ADDRESS
     *
     * @return boolean
     **/ 
    function default_address() 
    {
        
        if (isset($_POST['default_address'])) {
            
            $ua_id = $this->input->post('default_adrs_id');
            
            if ($ua_id > 0) {
                
                $msg='';
                $status=0;
                
                $user_id = $this->ion_auth->get_user_id();
                
                $data=array();
                $data['is_default'] = 'No';
                $where['user_id']   = $user_id;
                
                if ($this->base_model->update_operation($data, TBL_USER_ADDRESS, $where) ) {
                    unset($data, $where);
                    
                    
                    $data=array();
                    $data['is_default']='Yes';
                    $where['ua_id'] = $ua_id;
                    
                    if ($this->base_model->update_operation($data, TBL_USER_ADDRESS, $where)) {
                        
                        $msg .= get_languageword('default_address_set_successfully');
                        $status=0;
                    
                    } else {
                        $msg  .= get_languageword('default_address_not_updated');
                        $status= 1;
                    }
                
                } else {
                    
                    $msg  .= get_languageword('default_address_not_updated');
                    $status= 1;
                }
                
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_ADD_USER_ADDRESS);
            } else { 
                redirect(URL_ADD_USER_ADDRESS);
            }
        } else {
            redirect(URL_ADD_USER_ADDRESS);
        }
    }
    
    /**
     * Change password
     *
     * @return boolean
     **/
    function change_password()
    {
        if (isset($_POST['change_pwd'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_USER_CHANGE_PASSWORD);
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
                    redirect(URL_USER_CHANGE_PASSWORD, REFRESH);
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
        $this->data['activemenu']     = 'change_password';
        $this->data['activesubmenu']= 'change_password';
        $this->data['pagetitle']     = get_languageword('change_password');
        $this->data['content']         = PAGE_CHANGE_PASSWORD;
        $this->_render_page(getTemplate(), $this->data);
    }
    

    /**
     * GET PINCODES
     * AJAX CALL
     *
     * @return array
     **/  
    function ajax_get_pincodes()
    {
        if ($this->input->is_ajax_request()) {
            $code = $this->input->get('pincode');
            $codes = $this->base_model->admin_delivery_codes($code);
            if (!empty($codes)) {
                echo json_encode($codes);
            }
        }
    }
    
    /**
     * GET City Locality
     * AJAX CALL
     *
     * @return array
     **/ 
    function get_city_locality()
    {
        if ($this->input->is_ajax_request()) {
            $result = array();
            $code = $this->input->post('pin');
            
            if ($code) {
                
                $query="select s.locality,c.city_name from ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." s inner join ".TBL_PREFIX.TBL_CITIES." c on s.city_id=c.city_id WHERE s.pincode='".$code."'";
                
                $delivry_loctin = $this->base_model->get_query_result($query);
                if (!empty($delivry_loctin)) {
                    echo json_encode($delivry_loctin[0]);
                }
            }
        }
    }
    
    /**
     * GET DELIVERY PINCODE
     * AJAX CALL
     *
     * @return boolean
     **/
    public function check_delivery_pincode()
    {
        $valid_code = $this->base_model->check_pincode($this->input->post('pincode'));
        if ($valid_code) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
}