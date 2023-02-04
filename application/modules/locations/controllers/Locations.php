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
 * @category  Locations
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Locations Class
 * 
 * Locations CRUD operations.
 *
 * @category  Locations
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Locations extends MY_Controller
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
    | MODULE:           LOCATIONS CONTROLLER
    | -----------------------------------------------------
    | This is Locations module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

     /**
      * Fetch locations
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
            
            if (in_array($param1, array('delete', 'delete_selected', 'activate_selected', 'deactivate_selected')) && !empty($param2)) {
                if (DEMO) {
                    $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                    redirect(URL_LOCATIONS_INDEX, REFRESH);
                }
                $msg='';
                $status=0;
                if ($param1 == "delete") {
                    if ($this->base_model->delete_record_new(TBL_CITIES, array('city_id'=>$param2))) {
                        $this->base_model->delete_record_new(TBL_SERVICE_PROVIDE_LOCATIONS, array('city_id'=>$param2));
                        
                        $msg .= get_languageword('record_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status =1;
                    }
                } else if ($param1 == "delete_selected") {
                    $rows_to_be_deleted = explode(',', $param2);
                    if ($this->base_model->delete_record(TBL_CITIES, 'city_id', $rows_to_be_deleted)) {
                        $this->base_model->delete_record(TBL_SERVICE_PROVIDE_LOCATIONS, 'city_id', $rows_to_be_deleted);
                        
                        $msg .= get_languageword('selected_records_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status = 1;
                    }
                } else if ($param1 == "activate_selected") {
                    $rows_to_be_activated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_CITIES, array('status' => 'Active'), 'city_id', $rows_to_be_activated)) {
                        $this->base_model->changestatus_multiple_recs(TBL_SERVICE_PROVIDE_LOCATIONS, array('status' => 'Active'), 'city_id', $rows_to_be_activated);
                        
                        $msg .= get_languageword('selected_records_activated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_activated');
                    }

                } else if ($param1 == "deactivate_selected") {
                    $rows_to_be_deactivated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_CITIES, array('status' => 'Inactive'), 'city_id', $rows_to_be_deactivated)) {
                        $this->base_model->changestatus_multiple_recs(TBL_SERVICE_PROVIDE_LOCATIONS, array('status' => 'Inactive'), 'city_id', $rows_to_be_deactivated);
                        
                        $msg .= get_languageword('selected_records_deactivated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deactivated');
                        $status = 1;
                    }
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_LOCATIONS_INDEX);
            }
        }
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_LOCATIONS_AJAX_GET_CITIES_LIST,
        'disablesorting' => '0,3',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        
        $this->data['activemenu']     = "locations";
        $this->data['actv_submenu'] = 'cities';
        
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_cities');
        $this->data['content']         = PAGE_CITIES;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Fetch locations
     *
     * @return array
     **/
    function ajax_get_cities_list()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('tds.city_name','tds.status');    
            
            $query     = "SELECT tds.* from ".TBL_PREFIX.TBL_CITIES." tds WHERE city_id != ''";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('city_name'=>'asc'));
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->city_id.'"> ';

                    $row[] = '<span>'.$record->city_name.'</span>';
                    
                    $checked = '';
                    $class = 'badge danger';
                    if ($record->status == 'Active') {
                        $checked = ' checked';
                        $class = 'badge success';    
                    }
                    $row[] = '<span class="'.$class.'">'.$record->status.'</span>';
                    
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_ADDEDIT_CITY);
                    $dta .= '<input type="hidden" name="city_id" value="'.$record->city_id.'">';
                    $dta .= '<button type="submit" name="edit_city" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    
                    $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->city_id.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';
                    
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
     * Fetch delivery locations
     *
     * @return array
     **/
    function delivery_locations()
    {
        if ($this->input->post()) {
            /***
            * 
             * Delete Operation - Start 
            ***/
            $param1 = $this->input->post('param1');
            $param2 = $this->input->post('param2');
            
            if (in_array($param1, array('delete', 'delete_selected', 'activate_selected', 'deactivate_selected')) && !empty($param2)) {
                if (DEMO) {
                    $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                    redirect(URL_DELIVERY_LOCATIONS, REFRESH);
                }
                $msg='';
                $status=0;
                if ($param1 == "delete") {
                    if ($this->base_model->delete_record_new(TBL_SERVICE_PROVIDE_LOCATIONS, array('service_provide_location_id' => $param2))) {
                        $msg .= get_languageword('record_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status =1;
                    }
                } else if ($param1 == "delete_selected") {
                    $rows_to_be_deleted = explode(',', $param2);
                    if ($this->base_model->delete_record(TBL_SERVICE_PROVIDE_LOCATIONS, 'service_provide_location_id', $rows_to_be_deleted)) {
                        $msg .= get_languageword('selected_records_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status = 1;
                    }
                } else if ($param1 == "activate_selected") {
                    $rows_to_be_activated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_SERVICE_PROVIDE_LOCATIONS, array('status' => 'Active'), 'service_provide_location_id', $rows_to_be_activated)) {
                        $msg .= get_languageword('selected_records_activated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_activated');
                    }

                } else if ($param1 == "deactivate_selected") {
                    $rows_to_be_deactivated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_SERVICE_PROVIDE_LOCATIONS, array('status' => 'Inactive'), 'service_provide_location_id', $rows_to_be_deactivated)) {
                        $msg .= get_languageword('selected_records_deactivated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deactivated');
                        $status = 1;
                    }
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_DELIVERY_LOCATIONS);
            }
        }
        
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_DELIVERY_LOCATIONS_AJAX_GET_LIST,
        'disablesorting' => '0,9',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = "locations";
        $this->data['actv_submenu'] = 'dlocations';
        
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_service_provide_locations');
        $this->data['content']         = PAGE_SERVICE_PROVIDE_LOCATIONS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * Add/Edit City
     *
     * @return boolean
     **/
    function addedit_city()
    {
        if (isset($_POST['addedit_city'])) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_LOCATIONS_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('city_name', get_languageword('city_name'), 'required|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            $city_id = $this->input->post('city_id');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['city_name'] = $this->input->post('city_name');
                $data['status']        = $this->input->post('status');
                
                if ($this->input->post('city_id') > 0) {
                    $where['city_id'] = $this->input->post('city_id');
                    if ($this->base_model->update_operation($data, TBL_CITIES, $where)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                } else {
                    
                    if ($this->base_model->insert_operation_id($data, TBL_CITIES)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                }
                unset($data, $where);
                
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_LOCATIONS_INDEX, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('add_city');
        
        if (isset($_POST['edit_city'])) {
            $city_id = $this->input->post('city_id');
            if ($city_id > 0) {
                $pagetitle = get_languageword('edit_addon');
                $record = $this->base_model->fetch_records_from(TBL_CITIES, array('city_id' => $city_id));
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_LOCATIONS_INDEX);                
                }
                $this->data['record'] =    $record[0];
            } else {
                redirect(URL_LOCATIONS_INDEX);
            }
        }
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        
        $this->data['activemenu']      = "locations";
        $this->data['actv_submenu']  = 'cities';
        $this->data['content']          = PAGE_ADDEDIT_CITY;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
    
    /**
     * Fetch delivery locations
     *
     * @return array
     **/
    function ajax_get_delivery_locations()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('tds.locality','tds.pincode','tds.status','c.city_name');    
            
            $query     = "SELECT tds.*,c.city_name from ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." tds INNER JOIN ".TBL_PREFIX.TBL_CITIES." c ON tds.city_id=c.city_id WHERE service_provide_location_id != ''";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('city_name'=>'asc'));
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->service_provide_location_id.'"> ';
                    
                    $row[] = '<span>'.$record->city_name.'</span>';
                    $row[] = '<span>'.$record->locality.'</span>';
                    $row[] = '<span>'.$record->pincode.'</span>';
                    $row[] = '<span>'.$record->delivery_from_time.'</span>';            
                    
                    $row[] = '<span>'.$record->delivery_to_time.'</span>';
                    $row[] = '<span>'.$record->delivery_time_units.'</span>';    
                    
                    $row[] = '<span>'.$record->delivery_fee.'</span>';
                    
                    $checked = '';
                    $class = 'badge danger';
                    if ($record->status == 'Active') {
                        $checked = ' checked';
                        $class = 'badge success';    
                    }
                    $row[] = '<span class="'.$class.'">'.$record->status.'</span>';
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_ADDEDIT_DELIVERY_LOCATION);
                    $dta .= '<input type="hidden" name="service_provide_location_id" value="'.$record->service_provide_location_id.'">';
                    $dta .= '<button type="submit" name="edit_location" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    
                    $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->service_provide_location_id.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';
                    
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
     * Add/Edit delivery location
     *
     * @return boolean
     **/
    function addedit_delivery_location()
    {
        if (isset($_POST['addedit_location'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_DELIVERY_LOCATIONS, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('locality', get_languageword('locality'), 'required|xss_clean');
            $this->form_validation->set_rules('pincode', get_languageword('pincode'), 'required|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            $service_provide_location_id = $this->input->post('service_provide_location_id');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['city_id']     = $this->input->post('city_id');
                $data['locality']    = $this->input->post('locality');
                $data['pincode']    = $this->input->post('pincode');
                $data['status']        = $this->input->post('status');
                
                if ($this->input->post('delivery_fee') > 0) {
                    $data['delivery_fee']         = $this->input->post('delivery_fee');
                    $data['delivery_from_time'] = $this->input->post('delivery_from_time');
                    $data['delivery_to_time']     = $this->input->post('delivery_to_time');
                    $data['delivery_time_units']= $this->input->post('delivery_time_units');
                    
                } else {
                    $data['delivery_fee']           = NULL;
                    $data['delivery_from_time']     = NULL;
                    $data['delivery_to_time']       = NULL;
                    $data['delivery_time_units']    = NULL;
                }
                
                if ($this->input->post('service_provide_location_id') > 0) {
                    $where['service_provide_location_id'] = $this->input->post('service_provide_location_id');
                    if ($this->base_model->update_operation($data, TBL_SERVICE_PROVIDE_LOCATIONS, $where)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                } else {
                    
                    if ($this->base_model->insert_operation_id($data, TBL_SERVICE_PROVIDE_LOCATIONS)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                }
                unset($data, $where);
                
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_DELIVERY_LOCATIONS, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('add_service_provide_location');
        
        if (isset($_POST['edit_location'])) {
            $service_provide_location_id = $this->input->post('service_provide_location_id');
            if ($service_provide_location_id > 0) {
                $pagetitle = get_languageword('edit_service_provide_location');
                $record = $this->base_model->fetch_records_from(TBL_SERVICE_PROVIDE_LOCATIONS, array('service_provide_location_id' => $service_provide_location_id));
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_DELIVERY_LOCATIONS);                
                }
                $this->data['record'] =    $record[0];
                
                $cities_options = $this->base_model->get_cities_options();
                if (!empty($cities_options)) {
                    $this->data['cities_options']= $cities_options[0];
                }
            } else {
                redirect(URL_DELIVERY_LOCATIONS);
            }
        } else {
            
            $cities_options = $this->base_model->get_cities_options('Active');
            if (!empty($cities_options)) {
                $this->data['cities_options']= $cities_options[0];
            }
        }
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        
        $this->data['activemenu']      = "locations";
        $this->data['actv_submenu']  = 'dlocations';
        
        $this->data['content']          = PAGE_ADDEDIT_LOCATION;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
}