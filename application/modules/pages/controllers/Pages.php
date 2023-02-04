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
 * @category  Pages
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Pages Class
 * 
 * Pages CRUD operations.
 *
 * @category  Pages
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Pages extends MY_Controller
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
    | MODULE:           PAGES CONTROLLER
    | -----------------------------------------------------
    | This is Pages module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

    /**
     * Fetch pages
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
                    redirect(URL_PAGES_INDEX, REFRESH);
                }
                $msg='';
                $status=0;
                
                if ($param1 == "activate_selected") {
                    $rows_to_be_activated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_PAGES, array('status' => 'Active'), 'id', $rows_to_be_activated)) {
                        $msg .= get_languageword('selected_records_activated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_activated');
                    }

                } else if ($param1 == "deactivate_selected") {
                    $rows_to_be_deactivated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_PAGES, array('status' => 'Inactive'), 'id', $rows_to_be_deactivated)) {
                        $msg .= get_languageword('selected_records_deactivated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deactivated');
                        $status = 1;
                    }
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_PAGES_INDEX);
            }
        }
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_PAGES_AJAX_GET_LIST,
        'disablesorting' => '0,3',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = "pages";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_pages');
        $this->data['content']         = PAGE_PAGES;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Fetch pages
     *
     * @return array
     **/ 
    function ajax_get_list()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('tds.name','tds.description','tds.status');    
            
            $query     = "SELECT tds.* from ".TBL_PREFIX.TBL_PAGES." tds WHERE id != ''";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('id'=>'asc'));
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->id.'"> ';
                    $row[] = '<span>'.$record->name.'</span>';
                    $checked = '';
                    $class = 'badge danger';
                    if ($record->status == 'Active') {
                        $checked = ' checked';
                        $class = 'badge success';    
                    }
                    $row[] = '<span class="'.$class.'">'.$record->status.'</span>';
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_ADDEDIT_PAGE);
                    $dta .= '<input type="hidden" name="id" value="'.$record->id.'">';
                    $dta .= '<button type="submit" name="edit_page" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';
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
     * Add/Edit page
     *
     * @return array
     **/ 
    function addedit()
    {
        if (isset($_POST['addedit_page'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_PAGES_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('name', get_languageword('name'), 'required|xss_clean');
            $this->form_validation->set_rules('description', get_languageword('description'), 'required|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            $id = $this->input->post('id');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['name']         = $this->input->post('name');
                $data['description']= $this->input->post('description');
                $data['status']        = $this->input->post('status');
                
                if ($this->input->post('id') > 0) {
                    $where['id'] = $this->input->post('id');
                    if ($this->base_model->update_operation($data, TBL_PAGES, $where)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                } else {
                    $id = $this->base_model->insert_operation_id($data, TBL_PAGES);
                    if ($id) {
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
                redirect(URL_PAGES_INDEX, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('add_page');
        
        if (isset($_POST['edit_page'])) {
            $id = $this->input->post('id');
            
            if ($id > 0) {
                $pagetitle = get_languageword('edit_page');
                $record = $this->base_model->fetch_records_from(TBL_PAGES, array('id' => $id));
                
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_PAGES_INDEX);                
                }
                $this->data['record'] =    $record[0];
            } else {
                redirect(URL_PAGES_INDEX);
            }
        }
        
        $this->data['css_js_files']  = array('form_validation','ckeditor');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "pages";
        $this->data['activesubmenu'] = 'addedit_page';
        $this->data['content']          = PAGE_ADDEDIT_PAGE;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
}