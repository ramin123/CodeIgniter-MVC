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
 * @category  Menu
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Menu Class
 * 
 * MENU CRUD operations.
 *
 * @category  Menu
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Menu extends MY_Controller
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
    | MODULE:           MENU CONTROLLER
    | -----------------------------------------------------
    | This is Menu module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

     /**
      * Fetch records
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
                    redirect(URL_MENU_INDEX, REFRESH);
                }
                $msg='';
                $status=0;
                
                if ($param1 == "delete") {
                    $record=$this->base_model->fetch_records_from(TBL_MENU, array('menu_id'=>$param2));
                    
                    if ($this->base_model->delete_record_new(TBL_MENU, array('menu_id' => $param2))) {
                        if (!empty($record)) {
                            
                            $record=$record[0];
                            if ($record->menu_image_name != '' && file_exists(MENU_IMG_UPLOAD_PATH_URL.$record->menu_image_name)) {
                                unlink(MENU_IMG_UPLOAD_PATH_URL.$record->menu_image_name);
                                unlink(MENU_IMG_UPLOAD_THUMB_PATH_URL.$record->menu_image_name);
                            }
                        }
                        $msg .= get_languageword('record_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status =1;
                    }
                } else if ($param1 == "delete_selected") {
                    
                    $rows_to_be_deleted = explode(',', $param2);
                    
                    foreach ($rows_to_be_deleted as $row):
                    
                        $record = $this->base_model->fetch_records_from(TBL_MENU, array('menu_id'=>$row));
                        if (!empty($record)) {
                            
                            $record=$record[0];
                            if ($record->menu_image_name != '' && file_exists(MENU_IMG_UPLOAD_PATH_URL.$record->menu_image_name)) {
                                unlink(MENU_IMG_UPLOAD_PATH_URL.$record->menu_image_name);
                                unlink(MENU_IMG_UPLOAD_THUMB_PATH_URL.$record->menu_image_name);
                            }
                        }
                    endforeach;
                    
                    if ($this->base_model->delete_record(TBL_MENU, 'menu_id', $rows_to_be_deleted)) {
                        $msg .= get_languageword('selected_records_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status = 1;
                    }
                } else if ($param1 == "activate_selected") {
                    $rows_to_be_activated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_MENU, array('status' => 'Active'), 'menu_id', $rows_to_be_activated)) {
                        $msg .= get_languageword('selected_records_activated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_activated');
                    }

                } else if ($param1 == "deactivate_selected") {
                    
                    $rows_to_be_deactivated = explode(',', $param2);
                    
                    if ($this->base_model->changestatus_multiple_recs(TBL_MENU, array('status' => 'Inactive'), 'menu_id', $rows_to_be_deactivated)) {
                        $msg .= get_languageword('selected_records_deactivated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deactivated');
                        $status = 1;
                    }
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_MENU_INDEX);
            }
        }
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_MENU_AJAX_GET_LIST,
        'disablesorting' => '0,5',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = "menu";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_menu');
        $this->data['content']         = PAGE_MENU;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    /**
     * 
     * Fetch records
     * 
     *
     * @return array
     **/ 
    function ajax_get_list()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            //columns to be visible in table header
            $columns = array('tds.menu_id', 'tds.menu_name', 'tds.punch_line', 'tds.description', 'tds.status');

            $query  = "SELECT tds.* FROM ".TBL_PREFIX.TBL_MENU." tds WHERE tds.menu_id != '' "; 


            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('menu_name'=>'asc'));
            
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    $image = IMG_DEFAULT;
                    if ($record->menu_image_name != '' && file_exists(MENU_IMG_UPLOAD_PATH_URL.$record->menu_image_name)) {
                        $image = MENU_IMG_THUMB_PATH.$record->menu_image_name;
                    }
                    
                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->menu_id.'"> ';
                    
                    $row[] = $record->menu_name;
                    $row[] = $record->punch_line;
                    
                    $row[] = '<span><img src="'.$image.'" class="img-responsive center-block"/></span>';
                    
                    $checked = '';
                    $class = 'badge danger';
                    if ($record->status == 'Active') {
                        $checked = ' checked';
                        $class = 'badge success';    
                    }
                    
                    $row[] = '<span class="'.$class.'">'.$record->status.'</span>';
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_ADDEDIT_MENU);
                    $dta .= '<input type="hidden" name="menu_id" value="'.$record->menu_id.'">';
                    $dta .= '<button type="submit" name="edit_menu" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    
                    $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->menu_id.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';

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
     * Add/Edit Menu
     *
     * @return boolean
     **/ 
    function addedit()
    {
        if (isset($_POST['addedit_menu'])) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_MENU_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('menu_name', get_languageword('menu_name'), 'required|xss_clean');
            $this->form_validation->set_rules('punch_line', get_languageword('punch_line'), 'required|xss_clean');
            $this->form_validation->set_rules('description', get_languageword('description'), 'required|max_length[100]|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            $menu_id = $this->input->post('menu_id');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                
                $data['menu_name']  = $this->input->post('menu_name');
                $data['punch_line'] = $this->input->post('punch_line');
                $data['description']= $this->input->post('description');
                $data['status']        = $this->input->post('status');
                
                if ($this->input->post('menu_id') > 0) {
                    $where['menu_id'] = $this->input->post('menu_id');
                    if ($this->base_model->update_operation($data, TBL_MENU, $where)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                } else {
                    $menu_id = $this->base_model->insert_operation_id($data, TBL_MENU);
                    if ($menu_id) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                }
                unset($data, $where);
                
                //Upload Site Logo
                if ($menu_id > 0 && count($_FILES) > 0) {
                    if ($_FILES['menu_image_name']['name'] != '' && $_FILES['menu_image_name']['error'] != 4) {
                        if ($this->input->post('menu_id') > 0) {
                            $record = $this->base_model->fetch_records_from(TBL_MENU, array('menu_id'=>$menu_id));
                        
                            if (!empty($record)) {
                                $record = $record[0];
                                if ($record->menu_image_name != '' && file_exists(MENU_IMG_UPLOAD_PATH_URL.$record->menu_image_name)) {
                                    unlink(MENU_IMG_UPLOAD_PATH_URL.$record->menu_image_name);
                                    unlink(MENU_IMG_UPLOAD_THUMB_PATH_URL.$record->menu_image_name);
                                }
                            }
                        }
                        
                        
                        $ext = pathinfo($_FILES['menu_image_name']['name'], PATHINFO_EXTENSION);
                        $file_name = 'menu_'.$menu_id.'.'.$ext;
                        $config['upload_path']         = MENU_IMG_UPLOAD_PATH_URL;
                        $config['allowed_types']     = ALLOWED_TYPES;
                        
                        $config['file_name']  = $file_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        
                        if ($this->upload->do_upload('menu_image_name')) {
                            $data = array();
                            $data['menu_image_name'] = $file_name;
                            
                            // TINIFY IMAGE COMPRESSING & THUMB
                            if ($this->config->item('tinify_settings')->use_tinify=='Yes') {
                                $destination = FCPATH.MENU_IMG_UPLOAD_PATH_URL.$file_name;
                                $source = base_url().MENU_IMG_UPLOAD_PATH_URL.$file_name;
                                
                                $this->load->library('FCTinify');
                                $fct = new FCTinify();
                                //TINIFY IMAGE COMPRESSING
                                if ($this->config->item('tinify_settings')->compress=='Yes') {
                                    $result = $fct->imageCompress($source, $destination);
                                }
                                // TINIFY IMAGE THUMB CREATION
                                if ($this->config->item('tinify_settings')->thumb=='Yes') {
                                    $thumb_destination = FCPATH.MENU_IMG_UPLOAD_THUMB_PATH_URL.$file_name;
                                    $fct->imageResize($source, $thumb_destination, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT, 'cover');
                                } else {    
                                    $this->create_thumbnail($config['upload_path'].$file_name, MENU_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                                }
                                
                            } else {    
                                $this->create_thumbnail($config['upload_path'].$file_name, MENU_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                            }
                            $this->base_model->update_operation($data, TBL_MENU, array('menu_id'=>$menu_id));
                        } else {
                            $msg .= '<br>'.strip_tags($this->upload->display_errors());
                            $status =1;
                        }
                    }
                }
                    
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_MENU_INDEX, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('add_menu');
        
        if (isset($_POST['edit_menu'])) {
            $menu_id = $this->input->post('menu_id');
            if ($menu_id > 0) {
                $pagetitle = get_languageword('edit_menu');
                $record = $this->base_model->fetch_records_from(TBL_MENU, array('menu_id' => $menu_id));
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_MENU_INDEX);                
                }
                $this->data['record'] =    $record[0];
            } else {
                redirect(URL_MENU_INDEX);
            }
        }
        
        
        $status_options = $this->base_model->status_options();
        $this->data['status_options'] = $status_options[0];
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "menu";
        $this->data['content']          = PAGE_ADDEDIT_MENU;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
}