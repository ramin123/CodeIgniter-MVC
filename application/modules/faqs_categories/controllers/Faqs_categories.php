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
 * @category  FAQSCATEGORIES
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter FAQS Categories Class
 * 
 * FAQS categories CRUD operations.
 *
 * @category  FAQSCATEGORIES
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */

class Faqs_categories extends MY_Controller
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
    | MODULE:           FAQS CATEGORIES CONTROLLER
    | -----------------------------------------------------
    | This is FAQS CATEGORIES controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }



    /**
     * Fetch faqs categories
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

                    redirect(URL_FAQS_CATEGORIES_INDEX, REFRESH);

                }

                $msg='';

                $status=0;

                if ($param1 == "delete") {

                    if ($this->base_model->delete_record_new(TBL_FAQ_CATEGORIES, array('fc_id' => $param2))) {

                        $msg .= get_languageword('record_deleted_successfully');

                        $status = 0;

                    } else {

                        $msg .= get_languageword('record_not_deleted');

                        $status =1;

                    }

                } else if ($param1 == "delete_selected") {

                    $rows_to_be_deleted = explode(',', $param2);

                    if ($this->base_model->delete_record(TBL_FAQ_CATEGORIES, 'fc_id', $rows_to_be_deleted)) {

                        $msg .= get_languageword('selected_records_deleted_successfully');

                        $status = 0;

                    } else {

                        $msg .= get_languageword('record_not_deleted');

                        $status = 1;

                    }

                } else if ($param1 == "activate_selected") {

                    $rows_to_be_activated = explode(',', $param2);

                    if ($this->base_model->changestatus_multiple_recs(TBL_FAQ_CATEGORIES, array('status' => 'Active'), 'fc_id', $rows_to_be_activated)) {

                        $msg .= get_languageword('selected_records_activated_successfully');

                        $status = 0;

                    } else {

                        $msg .= get_languageword('record_not_activated');

                    }



                } else if ($param1 == "deactivate_selected") {

                    $rows_to_be_deactivated = explode(',', $param2);

                    if ($this->base_model->changestatus_multiple_recs(TBL_FAQ_CATEGORIES, array('status' => 'Inactive'), 'fc_id', $rows_to_be_deactivated)) {

                        $msg .= get_languageword('selected_records_deactivated_successfully');

                        $status = 0;

                    } else {

                        $msg .= get_languageword('record_not_deactivated');

                        $status = 1;

                    }

                }

                $this->prepare_flashmessage($msg, $status);

                redirect(URL_FAQS_CATEGORIES_INDEX);

            }

        }

        

        $this->data['ajaxrequest'] = array(

        'url' => URL_FAQS_CATEGORIES_AJAX_GET_LIST,

        'disablesorting' => '0,3',

        );

        

        $this->data['css_js_files'] = array('data_tables');
        
        $this->data['activemenu']     = "faqs_menu";
        
        $this->data['actv_submenu'] = "faqs_categories";

        $this->data['message']         = $this->session->flashdata('message');

        $this->data['pagetitle']     = get_languageword('faqs_categories');

        $this->data['content']         = 'fc';

        $this->_render_page(TEMPLATE_ADMIN, $this->data);

    }

    
    /**
     * Fetch faqs categories
     *
     * @return array
     **/ 
    function ajax_get_list()
    {

        if ($this->input->is_ajax_request()) {
            $data = array();

            $no = $_POST['start'];



            $conditions = array();



            $columns = array('tds.category','tds.status');    

            

            $query     = "SELECT tds.* from ".TBL_PREFIX.TBL_FAQ_CATEGORIES." tds WHERE fc_id != ''";

            

            

            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('fc_id'=>'desc'));

            

            if (!empty($records)) {



                foreach ($records as $record) {

                    $no++;

                    $row = array();



                

                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->fc_id.'"> ';

                    

                    $row[] = '<span>'.$record->category.'</span>';

                    

                    $checked = '';

                    $class = 'badge danger';

                    if ($record->status == 'Active') {

                        $checked = ' checked';

                        $class = 'badge success';    

                    }

                    $row[] = '<span class="'.$class.'">'.$record->status.'</span>';

                    

                    $dta ='';

                    $dta .= '<span>';

                    $dta .= form_open(URL_ADDEDIT_FAQS_CATEGORIES);

                    $dta .= '<input type="hidden" name="fc_id" value="'.$record->fc_id.'">';

                    $dta .= '<button type="submit" name="edit_fc" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';

                    $dta .= form_close();

                    $dta .= '</span>';

                    

                    $str = $dta;

                    

                

                    $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->fc_id.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';

                    

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
     * Add/Edit faqs category
     *
     * @return boolean
     **/ 
    function addedit()
    {

        if (isset($_POST['addedit_fc'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_FAQS_CATEGORIES_INDEX, REFRESH);
            }

            $msg='';

            $status=0;

            

            $this->form_validation->set_rules('category', get_languageword('category'), 'required|xss_clean');

        
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            

            $fc_id = $this->input->post('fc_id');

            

            if ($this->form_validation->run() == TRUE) {

                $data = array();

                $data['category']   = $this->input->post('category');

                $data['status']        = $this->input->post('status');

                

                if ($this->input->post('fc_id') > 0) {
                    
                    $data['updated'] = date('Y-m-d H:i:s');

                    
                    $where['fc_id'] = $this->input->post('fc_id');

                    if ($this->base_model->update_operation($data, TBL_FAQ_CATEGORIES, $where)) {

                        $msg .= get_languageword('details_saved_successfully');

                        $status = 0;

                    } else {

                        $msg .= get_languageword('details_not_saved');

                        $status = 1;

                    }

                } else {
                    
                    $data['created'] = date('Y-m-d H:i:s');
                    
                    $id = $this->base_model->insert_operation_id($data, TBL_FAQ_CATEGORIES);

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

                redirect(URL_FAQS_CATEGORIES_INDEX, REFRESH);

            }

        }

        

        $pagetitle = get_languageword('add_faq_category');

        if (isset($_POST['edit_fc'])) {

            $fc_id = $this->input->post('fc_id');

            if ($fc_id > 0) {

                $pagetitle = get_languageword('edit_faq_category');

                $record = $this->base_model->fetch_records_from(TBL_FAQ_CATEGORIES, array('fc_id' => $fc_id));

                if (empty($record)) {

                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);

                    redirect(URL_FAQS_CATEGORIES_INDEX);                

                }

                $this->data['record'] =    $record[0];

            } else {
                redirect(URL_FAQS_CATEGORIES_INDEX);
            }

        }
        $this->data['css_js_files']  = array('form_validation');

        $this->data['pagetitle']     = $pagetitle;

        $this->data['activemenu']     = "faqs_menu";
        
        $this->data['actv_submenu'] = "faqs_categories";
        
        $this->data['content']          = 'addedit';

        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
}