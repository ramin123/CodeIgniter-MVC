<?php
/**
 * Menorah Restaurant-DIGISAMARATIN
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, DIGISAMARATIN
 *
 * @category  Customers
 * @package   Menorah Restaurant
 * @author    DIGISAMARATIN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARATIN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Customers Class
 * 
 * Admin can view customers.
 *
 * @category  Customers
 * @package   Menorah Restaurant
 * @author    DIGISAMARATIN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARATIN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Customers extends MY_Controller
{

    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     Menorah Restaurant
    | -----------------------------------------------------
    | AUTHOR:           DIGISAMARATIN
    | -----------------------------------------------------
    | EMAIL:            digisamaritan@gmail.com
    | -----------------------------------------------------
    | COPYRIGHTS:       RESERVED BY DIGISAMARATIN
    | -----------------------------------------------------      
    | http://codecanyon.net/user/digisamaritan
    | http://conquerorstech.net/
    | -----------------------------------------------------
    |
    | MODULE:           CUSTOMERS CONTROLLER
    | -----------------------------------------------------
    | This is Customers module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

    /**
     * Displays the Index Page
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
                    redirect(URL_CUSTOMERS_INDEX, REFRESH);
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
                redirect(URL_CUSTOMERS_INDEX);
            }
        }
        
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_CUSTOMERS_AJAX_GET_LIST,
        'disablesorting' => '0,6',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = ACTIVE_CUSTOMERS;
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_customers');
        $this->data['content']         = PAGE_CUSTOMERS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Displays the Index Page
     *
     * @return array
     **/ 
    function ajax_get_list()
    {
        if ($this->input->is_ajax_request()) {
            
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('tds.first_name','tds.last_name','tds.email','tds.phone','tds.referral_code','tds.username');    
            
            $query     = "SELECT CONCAT(tds.first_name,' ',tds.last_name) as username,tds.email,tds.id,tds.phone,tds.active,tds.photo,tds.referral_code from ".TBL_PREFIX.TBL_USERS." tds INNER JOIN ".TBL_PREFIX.TBL_USERS_GROUPS." ug on tds.id=ug.user_id WHERE ug.group_id=2";
            
            
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
                    $row[] = '<span>'.$record->referral_code.'</span>';
                    
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
                    $dta .= form_open(URL_VIEW_CUSTOMER);
                    $dta .= '<input type="hidden" name="id" value="'.$record->id.'">';
                    $dta .= '<button type="submit" name="view_details" class="'.CLASS_VIEW_BTN.'"><i class="'.CLASS_ICON_VIEW.'" ></i></button>';
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
     * View user details
     *
     * @return array
     **/     
    function view_details()
    {
        $pagetitle = get_languageword('view_details');
        
        if (isset($_POST['view_details'])) {
            $id = $this->input->post('id');
            if ($id > 0) {
                $record = $this->base_model->fetch_records_from(TBL_USERS, array('id' => $id));
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_CUSTOMERS_INDEX);                
                }
                $this->data['record'] =    $record[0];
                
                $addresses     =    $this->base_model->fetch_records_from(TBL_USER_ADDRESS, array('user_id'=>$id));
        
                $this->data['addresses'] = $addresses; 
            } else {
                redirect(URL_CUSTOMERS_INDEX);
            }
        }
        
        $this->data['activemenu']     = ACTIVE_CUSTOMERS;
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['content']         = PAGE_VIEW_CUSTOMER_DETAILS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
}