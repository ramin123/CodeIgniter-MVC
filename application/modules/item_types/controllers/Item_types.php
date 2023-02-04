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
 * @category  Itemtypes
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Itemtypes Class
 * 
 * Itemtypes CRUD operations.
 *
 * @category  Itemtypes
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Item_types extends MY_Controller
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
    | MODULE:           ITEM TYPES CONTROLLER
    | -----------------------------------------------------
    | This is Item types module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

    /**
     * Fetch Item types
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
            
            if (in_array($param1, array('delete', 'delete_selected')) && !empty($param2)) {
                if (DEMO) {
                    $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                    redirect(URL_ITEM_TYPES_INDEX, REFRESH);
                }
                $msg='';
                $status=0;
                if ($param1 == "delete") {
                    $record = $this->base_model->fetch_records_from(TBL_ITEM_TYPES, array('item_type_id'=>$param2));
                    
                    if ($this->base_model->delete_record_new(TBL_ITEM_TYPES, array('item_type_id' => $param2))) {
                        $msg .= get_languageword('record_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status =1;
                    }
                } else if ($param1 == "delete_selected") {
                    $rows_to_be_deleted = explode(',', $param2);
                    
                    if ($this->base_model->delete_record(TBL_ITEM_TYPES, 'item_type_id', $rows_to_be_deleted)) {
                        $msg .= get_languageword('selected_records_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status = 1;
                    }
                } 
                
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_ITEM_TYPES_INDEX);
            }
        }
        
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_ITEM_TYPES_AJAX_GET_LIST,
        'disablesorting' => '0,2',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = "item_types";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_item_types');
        $this->data['content']         = PAGE_ITEM_TYPES;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Fetch Item types
     *
     * @return array
     **/ 
    function ajax_get_list()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('tds.item_type');    
            
            $query     = "SELECT tds.* from ".TBL_PREFIX.TBL_ITEM_TYPES." tds WHERE item_type_id != ''";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('item_type_id'=>'desc'));
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    
                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->item_type_id.'"> ';

                    $row[] = '<span>'.$record->item_type.'</span>';
                    
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_ADDEDIT_ITEM_TYPE);
                    $dta .= '<input type="hidden" name="item_type_id" value="'.$record->item_type_id.'">';
                    $dta .= '<button type="submit" name="edit_item_type" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    
                    
                    $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->item_type_id.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';
                    
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
     * Add/Edit Item type
     *
     * @return boolean
     **/ 
    function addedit_itemtype()
    {
        if (isset($_POST['addedit_item_type'])) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_ITEM_TYPES_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('item_type', get_languageword('item_type'), 'required|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            $item_type_id = $this->input->post('item_type_id');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['item_type'] = $this->input->post('item_type');
                
                if ($this->input->post('item_type_id') > 0) {
                    $where['item_type_id'] = $this->input->post('item_type_id');
                    if ($this->base_model->update_operation($data, TBL_ITEM_TYPES, $where)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                } else {
                    $item_type_id = $this->base_model->insert_operation_id($data, TBL_ITEM_TYPES);
                    if ($item_type_id) {
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
                redirect(URL_ITEM_TYPES_INDEX, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('add_item_type');
        if (isset($_POST['edit_item_type'])) {
            $item_type_id = $this->input->post('item_type_id');
            if ($item_type_id > 0) {
                $pagetitle = get_languageword('edit_item_type');
                $record = $this->base_model->fetch_records_from(TBL_ITEM_TYPES, array('item_type_id' => $item_type_id));
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_ITEM_TYPES_INDEX);                
                }
                $this->data['record'] =    $record[0];
            } else {
                redirect(URL_ITEM_TYPES_INDEX);
            }
        }
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "item_types";
        $this->data['content']          = PAGE_ADDEDIT_ITEMTYPE;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
}