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
 * @category  Users
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Users Class
 * 
 * Admin can view users.
 *
 * @category  Users
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Users extends MY_Controller
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
    | MODULE:           Users CONTROLLER
    | -----------------------------------------------------
    | This is Users module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }
     
    
    /**
     * KITCHEN MANAGERS
     * Fetch records count of modules
     *
     * @return array
     **/
    function index()
    {
        if ($this->input->post()) {
            
            /***
            * 
            * Delete Operation - Start 
            ***/
            $param1 = $this->input->post('param1');
            $param2 = $this->input->post('param2');
            
            if (in_array($param1, array('activate_selected', 'deactivate_selected')) && !empty($param2)) {
                
                if (DEMO) {
                    $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                    redirect(URL_USERS_INDEX, REFRESH);
                }
                
                $msg='';
                $status=0;
                
                if ($param1 == "activate_selected") {
                    
                    $rows_to_be_activated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_USERS, array('active'=>1), 'id', $rows_to_be_activated)) {
                        $msg .= get_languageword('selected_records_activated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_activated');
                    }

                } else if ($param1 == "deactivate_selected") {
                    
                    $rows_to_be_deactivated = explode(',', $param2);
                    
                    if ($this->base_model->changestatus_multiple_recs(TBL_USERS, array('active' =>0), 'id', $rows_to_be_deactivated)) {
                        $msg .= get_languageword('selected_records_deactivated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deactivated');
                        $status = 1;
                    }
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_USERS_INDEX);
            }
        }
        
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_USERS_AJAX_GET_KITCHEN_MANAGERS,
        'disablesorting' => '0,5',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = ACTIVE_USERS;
        $this->data['actv_submenu'] = 'km_users';
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('kitchen_managers');
        $this->data['content']         = PAGE_KITCHEN_MANAGERS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * KITCHEN MANAGERS
     *
     * @return array
     **/
    function ajax_get_kitchen_managers()
    {
        if ($this->input->is_ajax_request()) {
            
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('tds.first_name','tds.last_name','tds.email','tds.phone','tds.username');    
            
            $query     = "SELECT CONCAT(tds.first_name,' ',tds.last_name) as username,tds.email,tds.id,tds.phone,tds.active,tds.photo from ".TBL_PREFIX.TBL_USERS." tds INNER JOIN ".TBL_PREFIX.TBL_USERS_GROUPS." ug on tds.id=ug.user_id WHERE ug.group_id=3";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('id'=>'desc'));
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    
                    $no++;
                    $row = array();

                    $image = DEFAULT_USER_IMAGE;                                    
                    if ($record->photo != '' && file_exists(USER_IMG_UPLOAD_PATH_URL.$record->photo)) {
                        $image = USER_IMG_PATH.$record->photo;
                    } else if ($record->photo != '') {
                        $image =$record->photo;
                    }
                    
                    
                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->id.'"> ';

                    
                    
                    $row[] = '<div class="media-left"><img src="'.$image.'" class="img-responsive icon-profile"/></div><div class="media-body media-middle">'.$record->username.'</div>';
                    
                    $row[] = '<span>'.$record->email.'</span>';
                    $row[] = '<span>'.$record->phone.'</span>';
                    
                    
                    $checked = '';
                    $class   = 'badge danger';
                    $status  = 'Inactive';
                    if ($record->active==1) {
                        $checked = ' checked';
                        $class   = 'badge success';
                        $status  = 'Active';                        
                    }
                    $row[] = '<span class="'.$class.'">'.$status.'</span>';
                    
                    
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_ADDEDIT_KITCHEN_MANAGER);

                    $dta .= '<input type="hidden" name="user_id" value="'.$record->id.'">';

                    $dta .= '<button type="submit" name="edit_km" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';

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
     * ADD / EDIT KITCHEN MANAGER
     *
     * @return boolean
     **/
    function addedit_kitchen_manager()
    {
        
        if (isset($_POST['addedit_km'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_USERS_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('first_name', get_languageword('first_name'), 'required|xss_clean');
            $this->form_validation->set_rules('last_name', get_languageword('last_name'), 'required|xss_clean');
            $this->form_validation->set_rules('email', get_languageword('email'), 'required|callback_checkduplicatekm|xss_clean');
            $this->form_validation->set_rules('phone', get_languageword('phone'), 'required|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                
                if ($this->input->post('id') > 0) {
                    $where['id'] = $this->input->post('id');
                    
                    $data = array();
                    $data['first_name'] = $this->input->post('first_name');
                    $data['last_name']  = $this->input->post('last_name');
                    $data['username']   = $data['first_name'].' '.$data['last_name'];
                    $data['phone']        = $this->input->post('phone');
                    
                    if ($this->base_model->update_operation($data, TBL_USERS, $where)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                    $this->prepare_flashmessage($msg, $status);
                    redirect(URL_USERS_INDEX);
                    
                } else {
                    
                    $identity_column = $this->config->item('identity', 'ion_auth');
                    
                    $email        = strtolower($this->input->post('email'));
                    $identity     = ($identity_column==='email') ? $email : $this->input->post('email');
                    $password     = $this->randomString(8);
                    $additional_data = array();
                    
                    //Prepare User related data
                    $first_name = $this->input->post('first_name');
                    $last_name  = $this->input->post('last_name');
                    $username   = $first_name.' '.$last_name;

                    
                    $additional_data = array(
                    'username' => $username,
                    'first_name'     => $first_name,
                    'last_name'      => $last_name,
                    'phone'           => $this->input->post('phone'),
                    'email'         => $this->input->post('email'),
                    'registration_through'=>'portal',
                    'registration_type'=>'normal',
                    'created_datetime'=> date('Y-m-d H:i:s')
                    );
                    
                    $groups = array(3);
                    
                    $id = $this->ion_auth->register($identity, $password, $email, $additional_data, $groups);
                    
                    if ($id) {
                        $msg .= get_languageword('user_record_created_successfully').' '.get_languageword($this->ion_auth->messages());
                        $status=0;
                        
                    } else {
                        $msg .= $this->ion_auth->errors();    
                        $status=1;
                    }
                    $this->prepare_flashmessage($msg, $status);
                    redirect(URL_USERS_INDEX);
                }
            }
        }
        
        
        $pagetitle = get_languageword('add_kitchen_manager');
        
        if (isset($_POST['edit_km'])) {
            $id = $this->input->post('user_id');
            
            if ($id > 0) {
                
                $pagetitle=get_languageword('edit_kitchen_manager');

                $record = $this->base_model->fetch_records_from(TBL_USERS, array('id' => $id));

                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);

                    redirect(URL_USERS_INDEX);                
                }
                $this->data['record'] =    $record[0];
            } else {
                redirect(URL_USERS_INDEX);
            }

        }
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = ACTIVE_USERS;
        $this->data['actv_submenu']  = 'km_users';
        $this->data['content']          = PAGE_ADDEDIT_KITCHEN_MANAGER;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * VALIDATION METHOD
     * CHECK DUPLICATE KM
     *
     * @return boolean
     **/
    function checkduplicatekm()
    {
        $email = $this->input->post('email');
        $condition = array('email'=>$email);
        
        if ($this->input->post('id') > 0) {
            $condition = array('email'=>$email,'id != '=>$this->input->post('id'));
        }
        
        $record = $this->base_model->fetch_records_from(TBL_USERS, $condition);
        
        if (!empty($record)) {
        $this->form_validation->set_message('checkduplicatekm', get_languageword('user_already_exists'));
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    
    /**
     * FETCH DELIVER MANAGERS
     *
     * @return array
     **/    
    function delivery_managers()
    {
        if ($this->input->post()) {
            
            /***
            * 
            * Delete Operation - Start 
            ***/
            $param1 = $this->input->post('param1');
            $param2 = $this->input->post('param2');
            
            if (in_array($param1, array('activate_selected', 'deactivate_selected')) && !empty($param2)) {
                
                if (DEMO) {
                    $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                    redirect(URL_USERS_DELIVERY_MANAGERS, REFRESH);
                }
                
                $msg='';
                $status=0;
                
                if ($param1 == "activate_selected") {
                    
                    $rows_to_be_activated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_USERS, array('active'=>1), 'id', $rows_to_be_activated)) {
                        $msg .= get_languageword('selected_records_activated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_activated');
                    }

                } else if ($param1 == "deactivate_selected") {
                    
                    $rows_to_be_deactivated = explode(',', $param2);
                    
                    if ($this->base_model->changestatus_multiple_recs(TBL_USERS, array('active' =>0), 'id', $rows_to_be_deactivated)) {
                        $msg .= get_languageword('selected_records_deactivated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deactivated');
                        $status = 1;
                    }
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_USERS_DELIVERY_MANAGERS);
            }
        }
        
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_USERS_AJAX_GET_DELIVERY_MANAGERS,
        'disablesorting' => '0,5',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        
        $this->data['activemenu']     = ACTIVE_USERS;
        $this->data['actv_submenu'] = 'dm_users';
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('delivery_managers');
        $this->data['content']         = PAGE_DELIVERY_MANAGERS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * FETCH DELIVER MANAGERS
     *
     * @return array
     **/ 
    function ajax_get_delivery_managers()
    {
        if ($this->input->is_ajax_request()) {
            
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('tds.first_name','tds.last_name','tds.email','tds.phone','tds.username');    
            
            $query     = "SELECT CONCAT(tds.first_name,' ',tds.last_name) as username,tds.email,tds.id,tds.phone,tds.active,tds.photo from ".TBL_PREFIX.TBL_USERS." tds INNER JOIN ".TBL_PREFIX.TBL_USERS_GROUPS." ug on tds.id=ug.user_id WHERE ug.group_id=4";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('id'=>'desc'));
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    $image = DEFAULT_USER_IMAGE;                                    
                    if ($record->photo != '' && file_exists(USER_IMG_UPLOAD_PATH_URL.$record->photo)) {
                        
                        $image = USER_IMG_PATH.$record->photo;
                    } else if ($record->photo != '') {
                        
                        $image =$record->photo;
                    }
                    
                    
                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->id.'"> ';

                    
                    $row[] = '<div class="media-left"><img src="'.$image.'" class="img-responsive icon-profile"/></div><div class="media-body media-middle">'.$record->username.'</div>';
                    
                    $row[] = '<span>'.$record->email.'</span>';
                    $row[] = '<span>'.$record->phone.'</span>';
                    
                    
                    $checked = '';
                    $class   = 'badge danger';
                    $status  = 'Inactive';
                    
                    if ($record->active==1) {
                        $checked = ' checked';
                        $class   = 'badge success';
                        $status  = 'Active';                        
                    }
                    $row[] = '<span class="'.$class.'">'.$status.'</span>';
                    
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_ADDEDIT_DELIVERY_MANAGER);

                    $dta .= '<input type="hidden" name="user_id" value="'.$record->id.'">';

                    $dta .= '<button type="submit" name="edit_dm" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';

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
     * ADD/EDIT DELIVER MANAGER
     *
     * @return boolean
     **/ 
    function addedit_delivery_manager()
    {
        
        if (isset($_POST['addedit_dm'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_USERS_DELIVERY_MANAGERS, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('first_name', get_languageword('first_name'), 'required|xss_clean');
            $this->form_validation->set_rules('last_name', get_languageword('last_name'), 'required|xss_clean');
            $this->form_validation->set_rules('email', get_languageword('email'), 'required|callback_checkduplicatekm|xss_clean');
            $this->form_validation->set_rules('phone', get_languageword('phone'), 'required|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                
                if ($this->input->post('id') > 0) {
                    
                    $where['id'] = $this->input->post('id');
                    
                    $data = array();
                    $data['first_name'] = $this->input->post('first_name');
                    $data['last_name']  = $this->input->post('last_name');
                    $data['username']   = $data['first_name'].' '.$data['last_name'];
                    $data['phone']        = $this->input->post('phone');
                    
                    if (!empty($this->input->post('assigned_cities'))) {
                        $assigned_cities = $this->input->post('assigned_cities');
                        
                        $data['assigned_cities'] = implode(',', $assigned_cities);
                        
                    } else {
                        $data['assigned_cities'] = NULL;
                    }
                    
                    
                    if ($this->base_model->update_operation($data, TBL_USERS, $where)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                    $this->prepare_flashmessage($msg, $status);
                    redirect(URL_USERS_DELIVERY_MANAGERS);
                    
                } else {
                    
                    $identity_column = $this->config->item('identity', 'ion_auth');
                    
                    $email        = strtolower($this->input->post('email'));
                    $identity     = ($identity_column==='email') ? $email : $this->input->post('email');
                    $password     = $this->randomString(8);
                    $additional_data = array();
                    
                    //Prepare User related data
                    $first_name = $this->input->post('first_name');
                    $last_name  = $this->input->post('last_name');
                    $username   = $first_name.' '.$last_name;

                    
                    $additional_data = array(
                    'username' => $username,
                    'first_name'     => $first_name,
                    'last_name'      => $last_name,
                    'phone'           => $this->input->post('phone'),
                    'email'         => $this->input->post('email'),
                    'registration_through'=>'portal',
                    'registration_type'=>'normal',
                    'created_datetime'=> date('Y-m-d H:i:s')
                    );
                    
                    $groups = array(4);
                    
                    $id = $this->ion_auth->register($identity, $password, $email, $additional_data, $groups);
                    
                    if ($id) {
                        $msg .= get_languageword('user_record_created_successfully').' '.get_languageword($this->ion_auth->messages());
                        $status=0;
                    } else {
                        $msg .= $this->ion_auth->errors();    
                        $status=1;
                    }
                    $this->prepare_flashmessage($msg, $status);
                    redirect(URL_USERS_DELIVERY_MANAGERS);
                }
            }
        }
        
        
        $pagetitle = get_languageword('add_delivery_manager');
        
        if (isset($_POST['edit_dm'])) {
            $id = $this->input->post('user_id');
            
            if ($id > 0) {
                
                $pagetitle=get_languageword('edit_delivery_manager');

                $record = $this->base_model->fetch_records_from(TBL_USERS, array('id' => $id));

                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);

                    redirect(URL_USERS_DELIVERY_MANAGERS);                
                }
                $this->data['record'] =    $record[0];
                
                
                $cities_options = $this->base_model->get_cities_options();
                if (!empty($cities_options)) {
                    $this->data['cities_options']= $cities_options[0];
                }
            
            } else {
                redirect(URL_USERS_DELIVERY_MANAGERS);
            }
        }
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']     = ACTIVE_USERS;
        $this->data['actv_submenu'] = 'dm_users';
        $this->data['content']          = PAGE_ADDEDIT_DELIVERY_MANAGER;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
}