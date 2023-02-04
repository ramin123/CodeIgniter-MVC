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
 * @category  Items
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Items Class
 * 
 * Items CRUD operations.
 *
 * @category  Items
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Items extends MY_Controller
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
    | MODULE:           ITEMS CONTROLLER
    | -----------------------------------------------------
    | This is Items module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        $this->load->model('items_model');
        check_access('admin');
    }

    /**
     * Fetch Items
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
                    redirect(URL_ITEMS_INDEX, REFRESH);
                }
                $msg='';
                $status=0;
                if ($param1 == "delete") {
                    $record = $this->base_model->fetch_records_from(TBL_ITEMS, array('item_id'=>$param2));
                    
                    if ($this->base_model->delete_record_new(TBL_ITEMS, array('item_id' => $param2))) {
                        //delete item addons
                        $this->base_model->delete_record_new(TBL_ITEM_ADDONS, array('item_id' => $param2));
                        
                        //delete item options
                        $this->base_model->delete_record_new(TBL_ITEM_OPTIONS, array('item_id' => $param2));
                        
                        
                        if (!empty($record)) {
                            $record=$record[0];
                            if ($record->item_image_name != '' && file_exists(ITEM_IMG_UPLOAD_PATH_URL.$record->item_image_name)) {
                                unlink(ITEM_IMG_UPLOAD_PATH_URL.$record->item_image_name);
                                unlink(ITEM_IMG_UPLOAD_THUMB_PATH_URL.$record->item_image_name);
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
                        $record = $this->base_model->fetch_records_from(TBL_ITEMS, array('item_id'=>$row));
                        if (!empty($record)) {
                            $record=$record[0];
                            if ($record->item_image_name != '' && file_exists(ITEM_IMG_UPLOAD_PATH_URL.$record->item_image_name)) {
                                unlink(ITEM_IMG_UPLOAD_PATH_URL.$record->item_image_name);
                                unlink(ITEM_IMG_UPLOAD_THUMB_PATH_URL.$record->item_image_name);
                            }
                        }
                    endforeach;
                    
                    if ($this->base_model->delete_record(TBL_ITEMS, 'item_id', $rows_to_be_deleted)) {
                        //delete item addons
                        $this->base_model->delete_record(TBL_ITEM_ADDONS, 'item_id', $rows_to_be_deleted);
                        
                        //delete item options
                        $this->base_model->delete_record(TBL_ITEM_OPTIONS, 'item_id', $rows_to_be_deleted);
                        
                        $msg .= get_languageword('selected_records_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status = 1;
                    }
                } else if ($param1 == "activate_selected") {
                    $rows_to_be_activated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_ITEMS, array('status' => 'Active'), 'item_id', $rows_to_be_activated)) {
                        $msg .= get_languageword('selected_records_activated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_activated');
                    }

                } else if ($param1 == "deactivate_selected") {
                    $rows_to_be_deactivated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_ITEMS, array('status' => 'Inactive'), 'item_id', $rows_to_be_deactivated)) {
                        $msg .= get_languageword('selected_records_deactivated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deactivated');
                        $status = 1;
                    }
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_ITEMS_INDEX);
            }
        }
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_ITEMS_AJAX_GET_LIST,
        'disablesorting' => '0,7',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = "items";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_items');
        $this->data['content']         = PAGE_ITEMS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Fetch Items
     *
     * @return array
     **/ 
    function ajax_get_list()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $records = $this->items_model->get_datatables();
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    $image = IMG_DEFAULT;
                    if ($record->item_image_name != '' && file_exists(ITEM_IMG_UPLOAD_PATH_URL.$record->item_image_name)) {
                        $image = ITEM_IMG_PATH.$record->item_image_name;
                    }
                    
                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->item_id.'"> ';
                    
                    $row[] = '<span>'.$record->menu_name.'</span>';        
                    $row[] = '<span>'.$record->item_name.'</span>'; 
                    
                    $row[] = '<span>'.$record->item_cost.'</span>';
                    
                    $row[] = '<span>'.$record->item_type.'</span>';
                    
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
                    $dta .= form_open(URL_EDIT_ITEM);
                    $dta .= '<input type="hidden" name="item_id" value="'.$record->item_id.'">';
                    $dta .= '<button type="submit" name="edit_item" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    
                    $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->item_id.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';
                    
                    $row[] = $str;
                    
                    $data[] = $row;
                
                }
            }

            $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->items_model->count_all(),
            "recordsFiltered" => $this->items_model->count_filtered(),
            "data" => $data,
            );

            echo json_encode($output);
        }
    }
    
     /**
      * Add/Update Item
      *
      * @return boolean
      **/ 
    function add_item()
    {
        if (isset($_POST['addedit_item'])) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_ITEMS_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('item_name', get_languageword('item_name'), 'required|xss_clean');
            $this->form_validation->set_rules('item_cost', get_languageword('item_cost'), 'required|xss_clean');
            $this->form_validation->set_rules('item_description', get_languageword('item_description'), 'required|max_length[100]|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            $item_id = $this->input->post('item_id');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['menu_id']    = $this->input->post('menu_id');
                $data['item_name']     = $this->input->post('item_name');
                $data['item_cost']     = $this->input->post('item_cost');
                $data['item_type_id']     = $this->input->post('item_type');
                $data['item_description']= $this->input->post('item_description');
                $data['status']        = $this->input->post('status');
                $data['is_most_selling_item'] = $this->input->post('is_most_selling_item');
                
                
                if ($this->input->post('item_id') > 0) {
                    $where['item_id'] = $this->input->post('item_id');
                    if ($this->base_model->update_operation($data, TBL_ITEMS, $where)) {
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                } else {
                    $data['product_id'] = $this->randomString(16);
                    
                    $item_id = $this->base_model->insert_operation_id($data, TBL_ITEMS);
                    if ($item_id) { 
                        $msg .= get_languageword('details_saved_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('details_not_saved');
                        $status = 1;
                    }
                }
                unset($data, $where);
                
                
                $addons=0;
                $existed_item_addons=array();
                //ITEM ADDONS
                if ($this->input->post('item_id')>0) {
                    $existed_item_addons = $this->base_model->get_item_addons($item_id);
                    
                    if (!empty($existed_item_addons) && ($existed_item_addons==$this->input->post('addons'))) {
                        $addons=0;
                    } else {
                        $addons=1;
                    }    
                } else {
                    if (!empty($this->input->post('addons'))) {
                        $addons=1;
                    }
                }
                
                
                if ($addons==1) {
                    if (!empty($existed_item_addons)) {
                        
                        $itadons=array();
                        $itemaddons = $this->base_model->fetch_records_from(TBL_ITEM_ADDONS, array('item_id'=>$item_id));
                        if (!empty($itemaddons)) {
                            foreach ($itemaddons as $i):
                                array_push($itadons, $i->item_addon_id);
                            endforeach;
                            
                            $this->base_model->delete_record(TBL_ITEM_ADDONS, 'item_addon_id', $itadons);
                        }    
                    }
                    
                    $addons_data = array();
                    $data = array();
                    $item_addons = $this->input->post('addons');
                    if (!empty($item_addons)) {
                        foreach ($item_addons as $i):
                            if ($i > 0) {
                                $data['item_id']  = $item_id;
                                $data['addon_id'] = $i;
                                array_push($addons_data, $data);
                                unset($data);
                            }
                        endforeach;
                        
                        if (!empty($addons_data)) {
                            $this->db->insert_batch(TBL_ITEM_ADDONS, $addons_data);
                            unset($addons_data);
                        }
                    }
                }
                
                
                
                //Upload ITEM IMAGE
                if ($item_id > 0 && count($_FILES) > 0) {
                    if ($_FILES['item_image']['name'] != '' && $_FILES['item_image']['error'] != 4) {
                        if ($this->input->post('item_id') > 0) {
                            $record = $this->base_model->fetch_records_from(TBL_ITEMS, array('item_id'=>$item_id));
                        
                            if (!empty($record)) {
                                $record = $record[0];
                                if ($record->item_image_name != '' && file_exists(ITEM_IMG_UPLOAD_PATH_URL.$record->item_image_name)) {
                                    unlink(ITEM_IMG_UPLOAD_PATH_URL.$record->item_image_name);
                                    unlink(ITEM_IMG_UPLOAD_THUMB_PATH_URL.$record->item_image_name);
                                }
                            }
                        }
                        
                        
                        $ext = pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION);
                        $file_name = 'item_'.$item_id.'.'.$ext;
                        $config['upload_path']         = ITEM_IMG_UPLOAD_PATH_URL;
                        $config['allowed_types']     = ALLOWED_TYPES;
                        
                        $config['file_name']  = $file_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('item_image')) {
                            $data = array();
                            $data['item_image_name'] = $file_name;
                            //CHECK FOR TINIFY IMAGES
                            if ($this->config->item('tinify_settings')->use_tinify=='Yes') {
                                $destination = FCPATH.ITEM_IMG_UPLOAD_PATH_URL.$file_name;
                                $source = base_url().ITEM_IMG_UPLOAD_PATH_URL.$file_name;
                                
                                
                                
                                $this->load->library('FCTinify');
                                $fct = new FCTinify();
                                //TINIFY IMAGE COMPRESSING
                                if ($this->config->item('tinify_settings')->compress=='Yes') {
                                    $result = $fct->imageCompress($source, $destination);
                                }
                                // TINIFY IMAGE THUMB CREATION
                                if ($this->config->item('tinify_settings')->thumb=='Yes') {
                                    $thumb_destination = FCPATH.ITEM_IMG_UPLOAD_THUMB_PATH_URL.$file_name;
                                    $fct->imageResize($source, $thumb_destination, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT, 'cover');
                                } else {    
                                    $this->create_thumbnail($config['upload_path'].$file_name, ITEM_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                                }
                                
                            } else {    
                                
                                $this->create_thumbnail($config['upload_path'].$file_name, ITEM_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                            }
                                                        
                            $this->base_model->update_operation($data, TBL_ITEMS, array('item_id'=>$item_id));
                        } else {
                            $msg .= '<br>'.strip_tags($this->upload->display_errors());
                            $status =1;
                        }
                    }
                }
                    
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_ITEMS_INDEX, REFRESH);
            }
        }
        
        //menus
        $menu_options = $this->base_model->get_menus_options('Active');
        
        // addons
        $addon_options = $this->base_model->get_addons_options('Active');
        
        $pagetitle = get_languageword('add_item');
        if (isset($_POST['edit_item'])) {
            $item_id = $this->input->post('item_id');
            if ($item_id > 0) {
                $pagetitle = get_languageword('edit_item');
                $record = $this->base_model->fetch_records_from(TBL_ITEMS, array('item_id' => $item_id));
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_ITEMS_INDEX);                
                }
                $this->data['record'] =    $record[0];
                
                
                //item addons
                $item_addons = $this->base_model->get_item_addons($item_id);
                $this->data['item_addons'] = $item_addons;
                
                
                //menus
                $menu_options = $this->base_model->get_menus_options();
                
                //addons
                $addon_options = $this->base_model->get_addons_options();
            } else {
                redirect(URL_ITEMS_INDEX);
            }
        }
        
        $this->data['menu_options']  = $menu_options;
        $this->data['addon_options'] = $addon_options;
    
        //Item type options
        $item_type_options = $this->base_model->item_type_options();
        $this->data['item_type_options'] = $item_type_options;
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "items";
        $this->data['content']          = PAGE_ADDEDIT_ITEM;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
    
    /**
     * Edit Item
     *
     * @return boolean
     **/ 
    function edit_item()
    {
        $this->load->model('items_model');
        
        if (isset($_POST['edit_item_save'])) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_ITEMS_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('item_name', get_languageword('item_name'), 'required|xss_clean');
            $this->form_validation->set_rules('item_cost', get_languageword('item_cost'), 'required|xss_clean');
            $this->form_validation->set_rules('item_description', get_languageword('item_description'), 'required|max_length[100]|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            $item_id = $this->input->post('item_id');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['menu_id']    = $this->input->post('menu_id');
                $data['item_name']     = $this->input->post('item_name');
                $data['item_cost']     = $this->input->post('item_cost');
                $data['item_type_id']     = $this->input->post('item_type');
                $data['item_description']= $this->input->post('item_description');
                $data['status']        = $this->input->post('status');
                $data['is_most_selling_item'] = $this->input->post('is_most_selling_item');
                
                $where['item_id'] = $this->input->post('item_id');
                if ($this->base_model->update_operation($data, TBL_ITEMS, $where)) {
                    $msg .= get_languageword('details_saved_successfully');
                    $status = 0;
                } else {
                    $msg .= get_languageword('details_not_saved');
                    $status = 1;
                }
                
                unset($data, $where);
                
                
                $addons=0;
                $existed_item_addons=array();
                //ITEM ADDONS
                if ($this->input->post('item_id')>0) {
                    $existed_item_addons = $this->base_model->get_item_addons($item_id);
                    
                    if (!empty($existed_item_addons) && ($existed_item_addons==$this->input->post('addons'))) {
                        $addons=0;
                    } else {
                        $addons=1;
                    }    
                }
                
                if ($addons==1) {
                    if (!empty($existed_item_addons)) {
                        $itadons=array();
                        $itemaddons = $this->base_model->fetch_records_from(TBL_ITEM_ADDONS, array('item_id'=>$item_id));
                        if (!empty($itemaddons)) {
                            foreach ($itemaddons as $i):
                                array_push($itadons, $i->item_addon_id);
                            endforeach;
                            
                            $this->base_model->delete_record(TBL_ITEM_ADDONS, 'item_addon_id', $itadons);
                        }    
                    }
                    
                    $addons_data = array();
                    $data = array();
                    $item_addons = $this->input->post('addons');
                    if (!empty($item_addons)) {
                        foreach ($item_addons as $i):
                            if ($i > 0) {
                                $data['item_id']  = $item_id;
                                $data['addon_id'] = $i;
                                array_push($addons_data, $data);
                                unset($data);
                            }
                        endforeach;
                        
                        if (!empty($addons_data)) {
                            $this->db->insert_batch(TBL_ITEM_ADDONS, $addons_data);
                            unset($addons_data);
                        }
                    }
                }
                
                
                
                //Upload ITEM IMAGE
                if ($item_id > 0 && count($_FILES) > 0) {
                    if ($_FILES['item_image']['name'] != '' && $_FILES['item_image']['error'] != 4) {
                        if ($this->input->post('item_id') > 0) {
                            $record = $this->base_model->fetch_records_from(TBL_ITEMS, array('item_id'=>$item_id));
                        
                            if (!empty($record)) {
                                $record = $record[0];
                                if ($record->item_image_name != '' && file_exists(ITEM_IMG_UPLOAD_PATH_URL.$record->item_image_name)) {
                                    unlink(ITEM_IMG_UPLOAD_PATH_URL.$record->item_image_name);
                                    unlink(ITEM_IMG_UPLOAD_THUMB_PATH_URL.$record->item_image_name);
                                }
                            }
                        }
                        
                        
                        $ext = pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION);                        
                        $file_name = 'item_'.$item_id.'.'.$ext;
                        $config['upload_path']         = ITEM_IMG_UPLOAD_PATH_URL;
                        $config['allowed_types']     = ALLOWED_TYPES;
                        
                        $config['file_name']  = $file_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        
                        if ($this->upload->do_upload('item_image')) {
                            $data = array();
                            $data['item_image_name'] = $file_name;
                            //CHECK FOR TINIFY IMAGES
                            if ($this->config->item('tinify_settings')->use_tinify=='Yes') {
                                
                                $destination = FCPATH.ITEM_IMG_UPLOAD_PATH_URL.$file_name;
                                
                                $source = base_url().ITEM_IMG_UPLOAD_PATH_URL.$file_name;
                                
                                
                                $this->load->library('FCTinify');
                                $fct = new FCTinify();
                                //TINIFY IMAGE COMPRESSING
                                if ($this->config->item('tinify_settings')->compress=='Yes') {
                                    $result = $fct->imageCompress($source, $destination);
                                }
                                // TINIFY IMAGE THUMB CREATION
                                if ($this->config->item('tinify_settings')->thumb=='Yes') {
                                    $thumb_destination = FCPATH.ITEM_IMG_UPLOAD_THUMB_PATH_URL.$file_name;
                                    $fct->imageResize($source, $thumb_destination, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT, 'cover');
                                } else {    
                                    $this->create_thumbnail($config['upload_path'].$file_name, ITEM_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                                }
                                
                            } else {    
                                
                                $this->create_thumbnail($config['upload_path'].$file_name, ITEM_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                            }
                                                        
                            $this->base_model->update_operation($data, TBL_ITEMS, array('item_id'=>$item_id));
                        } else {
                            $msg .= '<br>'.strip_tags($this->upload->display_errors());
                            $status =1;
                        }
                    }
                }
                    
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_ITEMS_INDEX, REFRESH);
            }
        } else if (isset($_POST['item_options_save'])) {
            $msg='';
            $status=0;
            
            $item_id = $this->input->post('item_id');
            $this->form_validation->set_rules('option_counts', get_languageword('options'), 'required|numeric');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                $option_count = $this->input->post('option_count');
                
                if ($this->items_model->addOptions($item_id, $option_count, $this->input->post())) {
                    $msg .= get_languageword('updated_successfully');
                    $status = 0;
                } else {
                    $msg .= get_languageword('not_updated');
                    $status = 1;
                }
                
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_ITEMS_INDEX);
            } else {
                $this->prepare_flashmessage(validation_errors(), 1);
                redirect(URL_ITEMS_INDEX);
            }
        } else if (isset($_POST['edit_item'])) {
            
            $pagetitle = get_languageword('edit_item');
            $item_id = $this->input->post('item_id');
            
            if ($item_id > 0) {
                $record = $this->base_model->fetch_records_from(TBL_ITEMS, array('item_id' => $item_id));
                
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_ITEMS_INDEX);                
                }
                $this->data['record'] =    $record[0];

                //item addons
                $item_addons = $this->base_model->get_item_addons($item_id);
                $this->data['item_addons'] = $item_addons;
                
                //menus
                $menu_options = $this->base_model->get_menus_options();
                $this->data['menu_options']  = $menu_options;
                
                //addons
                $addon_options = $this->base_model->get_addons_options();
                $this->data['addon_options'] = $addon_options;
                
                //Item type options
                $item_type_options = $this->base_model->item_type_options();
                $this->data['item_type_options'] = $item_type_options;
                
                //item options
                $item_options = prepare_dropdown(TBL_OPTIONS, 1, 'option_id', 'option_name', '', array('status'=>'Active'));
                $this->data['item_options']  = $item_options;
                
                $script_item_options = $this->base_model->script_options('Active');
                $this->data['script_item_options'] = $script_item_options;
                
                $this->data['item_selected_options'] = $this->items_model->get_item_options($item_id);
                
            } else {
                redirect(URL_ITEMS_INDEX);
            }
        } else {
            redirect(URL_ITEMS_INDEX);
        }
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "items";
        $this->data['activesubmenu'] = 'addedit_addon';
        $this->data['content']          = PAGE_EDIT_ITEM;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
}