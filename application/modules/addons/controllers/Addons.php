<?php
/**
 * 
 * Menorah Restaurant-DigiSamaritan
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, DigiSamaritan
 * 
 * 
 *
 * @category  Addons
 * @package   Menorah Restaurant
 * @author    DigiSamaritan <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DigiSamaritan
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * CodeIgniter Addons Class
 * 
 * Permits View/Create/Edit/Delete Addons.
 * 
 * 
 *
 * @category  Addons
 * @package   Menorah Restaurant
 * @author    DigiSamaritan <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DigiSamaritan
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Addons extends MY_Controller
{

    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     RESTAURANT
    | -----------------------------------------------------
    | AUTHOR:           DigiSamaritan
    | -----------------------------------------------------
    | EMAIL:            digisamaritan@gmail.com
    | -----------------------------------------------------
    | COPYRIGHTS:       RESERVED BY DigiSamaritan
    | -----------------------------------------------------      
    | http://codecanyon.net/user/digisamaritan
    | http://conquerorstech.net/
    | -----------------------------------------------------
    |
    | MODULE:           ADDONS CONTROLLER
    | -----------------------------------------------------
    | This is Addons module controller file.
    | -----------------------------------------------------
     **/
    function __construct()    
    {
        parent::__construct();
        check_access('admin');
    }

    /**
     * 
     * Displays the Index Page 
     *
     * @return array
     **/
    function index()    
    {
        if ($this->input->post()) {
            /***
            * 
            * 
             * Delete Operation - Start 
            ***/
            $param1 = $this->input->post('param1');
            $param2 = $this->input->post('param2');
            
            if (in_array($param1, array('delete', 'delete_selected', 'activate_selected', 'deactivate_selected')) && !empty($param2)) {
                if (DEMO) {
                    $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                    redirect(URL_ADDONS_INDEX, REFRESH);
                
                }
                $msg='';
                $status=0;
                if ($param1 == "delete") {
                    $record = $this->base_model->fetch_records_from(TBL_ADDONS, array('addon_id'=>$param2));
                    
                    if ($this->base_model->delete_record_new(TBL_ADDONS, array('addon_id' => $param2))) {
                        if (!empty($record)) {
                            $record=$record[0];
                            if ($record->addon_image != '' && file_exists(ADDON_IMG_UPLOAD_PATH_URL.$record->addon_image)) {
                                unlink(ADDON_IMG_UPLOAD_PATH_URL.$record->addon_image);
                                unlink(ADDON_IMG_UPLOAD_THUMB_PATH_URL.$record->addon_image);
                            
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
                    foreach($rows_to_be_deleted as $row):
                        $record = $this->base_model->fetch_records_from(TBL_ADDONS, array('addon_id'=>$row));
                        if (!empty($record)) {
                            $record=$record[0];
                            if ($record->addon_image != '' && file_exists(ADDON_IMG_UPLOAD_PATH_URL.$record->addon_image)) {
                                unlink(ADDON_IMG_UPLOAD_PATH_URL.$record->addon_image);
                                unlink(ADDON_IMG_UPLOAD_THUMB_PATH_URL.$record->addon_image);
                            
                            }
                        
                        }
                    
                    endforeach;
                    
                    if ($this->base_model->delete_record(TBL_ADDONS, 'addon_id', $rows_to_be_deleted)) {
                        $msg .= get_languageword('selected_records_deleted_successfully');
                        $status = 0;
                    
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status = 1;
                    
                    }
                
                } else if ($param1 == "activate_selected") {
                    $rows_to_be_activated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_ADDONS, array('status' => 'Active'), 'addon_id', $rows_to_be_activated)) {
                        $msg .= get_languageword('selected_records_activated_successfully');
                        $status = 0;
                    
                    } else {
                        $msg .= get_languageword('record_not_activated');
                    
                    }

                
                } else if ($param1 == "deactivate_selected") {
                    $rows_to_be_deactivated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_ADDONS, array('status' => 'Inactive'), 'addon_id', $rows_to_be_deactivated)) {
                        $msg .= get_languageword('selected_records_deactivated_successfully');
                        $status = 0;
                    
                    } else {
                        $msg .= get_languageword('record_not_deactivated');
                        $status = 1;
                    
                    }
                
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_ADDONS_INDEX);
            
            }
        
        }
        
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_ADDONS_AJAX_GET_LIST,
        'disablesorting' => '0,5',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = "addons";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_addons');
        $this->data['content']         = PAGE_ADDONS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    
    }
    
    /**
     * 
     * Display Addons
     *
     * @return array
     **/
    function ajax_get_list()    
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('tds.addon_name', 'tds.price','tds.description','tds.status');    
            
            $query     = "SELECT tds.* from ".TBL_PREFIX.TBL_ADDONS." tds WHERE addon_id != ''";
            
                     $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('addon_name'=>'asc'));
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    $image = IMG_DEFAULT;
                    if ($record->addon_image != '' && file_exists(ADDON_IMG_UPLOAD_PATH_URL.$record->addon_image)) {
                        $image = ADDON_IMG_PATH.$record->addon_image;
                    
                    }
                    
                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->addon_id.'"> ';

                    $row[] = '<span>'.$record->addon_name.'</span>';
                    $row[] = '<span>'.$record->price.'</span>';
                    
                    
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
                    $dta .= form_open(URL_ADDEDIT_ADDON);
                    $dta .= '<input type="hidden" name="addon_id" value="'.$record->addon_id.'">';
                    $dta .= '<button type="submit" name="edit_addon" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    
                    
                    $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->addon_id.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';
                    
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
     * 
     * 
     * Add / Update an Addon 
     * 
     *
     * @return boolean
     **/
    function addedit()    
    {
        if (isset($_POST['addedit_addon'])) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_ADDONS_INDEX, REFRESH);
            
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('addon_name', get_languageword('addon_name'), 'required|xss_clean');
            $this->form_validation->set_rules('price', get_languageword('price'), 'required|xss_clean');
            $this->form_validation->set_rules('description', get_languageword('description'), 'required|max_length[100]|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            $addon_id = $this->input->post('addon_id');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['addon_name'] = $this->input->post('addon_name');
                $data['price']         = $this->input->post('price');
                $data['description']= $this->input->post('description');
                $data['status']        = $this->input->post('status');
                
                if ($this->input->post('addon_id') > 0) {
                    $where['addon_id'] = $this->input->post('addon_id');
                    if ($this->base_model->update_operation($data, TBL_ADDONS, $where)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    
                    }
                
                } else {
                    $addon_id = $this->base_model->insert_operation_id($data, TBL_ADDONS);
                    if ($addon_id) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    
                    }
                
                }
                unset($data, $where);
                
                //Upload Add on image
                if ($addon_id > 0 && count($_FILES) > 0) {
                    if ($_FILES['addon_image']['name'] != '' && $_FILES['addon_image']['error'] != 4) {
                        if ($this->input->post('addon_id') > 0) {
                            $record = $this->base_model->fetch_records_from(TBL_ADDONS, array('addon_id'=>$addon_id));
                        
                            if (!empty($record)) {
                                $record = $record[0];
                                if ($record->addon_image != '' && file_exists(ADDON_IMG_UPLOAD_PATH_URL.$record->addon_image)) {
                                    unlink(ADDON_IMG_UPLOAD_PATH_URL.$record->addon_image);
                                    unlink(ADDON_IMG_UPLOAD_THUMB_PATH_URL.$record->addon_image);
                                
                                }
                            
                            }
                        
                        }
                        
                        
                        $ext = pathinfo($_FILES['addon_image']['name'], PATHINFO_EXTENSION);
                        $file_name = 'addon_'.$addon_id.'.'.$ext;
                        $config['upload_path']         = ADDON_IMG_UPLOAD_PATH_URL;
                        $config['allowed_types']     = ALLOWED_TYPES;
                        
                        $config['file_name']  = $file_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('addon_image')) {
                            $data = array();
                            $data['addon_image'] = $file_name;
                            //CHECK FOR TINIFY IMAGES
                            if ($this->config->item('tinify_settings')->use_tinify=='Yes') {
                                $destination = FCPATH.ADDON_IMG_UPLOAD_PATH_URL.$file_name;
                                $source = base_url().ADDON_IMG_UPLOAD_PATH_URL.$file_name;
                                
                                $this->load->library('FCTinify');
                                $fct = new FCTinify();
                                //TINIFY IMAGE COMPRESSING
                                if ($this->config->item('tinify_settings')->compress=='Yes') {
                                    $result = $fct->imageCompress($source, $destination);
                                
                                }
                                // TINIFY IMAGE THUMB CREATION
                                if ($this->config->item('tinify_settings')->thumb=='Yes') {
                                    $thumb_destination = FCPATH.ADDON_IMG_UPLOAD_THUMB_PATH_URL.$file_name;
                                    $fct->imageResize($source, $thumb_destination, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT, 'cover');
                                
                                } else {    
                                    $this->create_thumbnail($config['upload_path'].$file_name, ADDON_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                                
                                }
                                
                            } else {    
                                
                                $this->create_thumbnail($config['upload_path'].$file_name, ADDON_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                            
                            }
                            
                            
                            $this->base_model->update_operation($data, TBL_ADDONS, array('addon_id'=>$addon_id));
                        
                        } else {
                            $msg .= '<br>'.strip_tags($this->upload->display_errors());
                            $status =1;
                        
                        }
                    
                    }
                
                }
                    
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_ADDONS_INDEX, REFRESH);
            
            }
        
        }
        
        $pagetitle = get_languageword('add_addon');
        if (isset($_POST['edit_addon'])) {
            $addon_id = $this->input->post('addon_id');
            if ($addon_id > 0) {
                $pagetitle = get_languageword('edit_addon');
                $record = $this->base_model->fetch_records_from(TBL_ADDONS, array('addon_id' => $addon_id));
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_ADDONS_INDEX);                
                }
                $this->data['record'] =    $record[0];
            
            } else {
                redirect(URL_ADDONS_INDEX);
            }
        
        }
        
        $status_options = $this->base_model->status_options();
        $this->data['status_options'] = $status_options[0];
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "addons";
        $this->data['content']          = PAGE_ADDEDIT_ADDON;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }

}