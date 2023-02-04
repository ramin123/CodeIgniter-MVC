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
 * @category  Offers
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Offers Class
 * 
 * Offers CRUD Operations.
 *
 * @category  Offers
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Offers extends MY_Controller
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
    | MODULE:           OFFERS CONTROLLER
    | -----------------------------------------------------
    | This is Offers module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

    /**
     * Fetch offers
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
                    redirect(URL_OFFERS_INDEX, REFRESH);
                }
                $msg='';
                $status=0;
                if ($param1 == "delete") {
                    if ($this->base_model->delete_record_new(TBL_OFFERS, array('offer_id'=>$param2))) {
                        $this->base_model->delete_record_new(TBL_OFFER_PRODUCTS, array('offer_id'=>$param2));
                        
                        $msg .= get_languageword('record_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status =1;
                    }
                } else if ($param1 == "delete_selected") {
                    $rows_to_be_deleted = explode(',', $param2);
                    if ($this->base_model->delete_record(TBL_OFFERS, 'offer_id', $rows_to_be_deleted)) {
                        $this->base_model->delete_record(TBL_OFFER_PRODUCTS, 'offer_id', $rows_to_be_deleted);
                        
                        $msg .= get_languageword('selected_records_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status = 1;
                    }
                } else if ($param1 == "activate_selected") {
                    $rows_to_be_activated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_OFFERS, array('status' => 'Active'), 'offer_id', $rows_to_be_activated)) {
                        $msg .= get_languageword('selected_records_activated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_activated');
                    }

                } else if ($param1 == "deactivate_selected") {
                    $rows_to_be_deactivated = explode(',', $param2);
                    if ($this->base_model->changestatus_multiple_recs(TBL_OFFERS, array('status' => 'Inactive'), 'offer_id', $rows_to_be_deactivated)) {
                        $msg .= get_languageword('selected_records_deactivated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deactivated');
                        $status = 1;
                    }
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_OFFERS_INDEX);
            }
        }
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_OFFERS_AJAX_GET_LIST,
        'disablesorting' => '0,7',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = "offers";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_offers');
        $this->data['content']         = PAGE_OFFERS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Fetch offers
     *
     * @return array
     **/
    function ajax_get_list()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('tds.offer_name','tds.offer_cost','tds.offer_start_date','tds.offer_valid_date','tds.offer_conditions','tds.no_of_products','tds.status');    
            
            $query     = "SELECT tds.* from ".TBL_PREFIX.TBL_OFFERS." tds WHERE offer_id != ''";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('offer_id'=>'desc'));
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->offer_id.'"> ';

                    $row[] = '<span>'.$record->offer_name.'</span>';
                    $row[] = '<span>'.$record->offer_cost.'</span>';
                    $row[] = '<span>'.get_date($record->offer_start_date).'</span>';
                    $row[] = '<span>'.get_date($record->offer_valid_date).'</span>';
                    $row[] = '<span>'.$record->no_of_products.'</span>';
                    
                    
                    
                    $checked = '';
                    $class = 'badge danger';
                    if ($record->status == 'Active') {
                        $checked = ' checked';
                        $class = 'badge success';    
                    }
                    $row[] = '<span class="'.$class.'">'.$record->status.'</span>';
                    
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_EDIT_OFFER);
                    $dta .= '<input type="hidden" name="offer_id" value="'.$record->offer_id.'">';
                    $dta .= '<button type="submit" name="edit_offer" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    
                    $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->offer_id.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';
                    
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
     * Add offer
     *
     * @return boolean
     **/
    function add_offer()
    {
        if (isset($_POST['add_offer'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_OFFERS_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('offer_name', get_languageword('offer_name'), 'required|xss_clean');
            $this->form_validation->set_rules('offer_cost', get_languageword('offer_cost'), 'required|xss_clean');
            $this->form_validation->set_rules('offer_start_date', get_languageword('offer_start_date'), 'required|xss_clean');
            $this->form_validation->set_rules('offer_valid_date', get_languageword('offer_valid_date'), 'required|xss_clean');
            
            $this->form_validation->set_rules('offer_conditions', get_languageword('offer_conditions'), 'required|max_length[100]|xss_clean');

            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['offer_name']          = $this->input->post('offer_name');
                $data['offer_cost']             = $this->input->post('offer_cost');
                $data['offer_start_date']     = date('Y-m-d', strtotime($this->input->post('offer_start_date')));
                $data['offer_valid_date']     = date('Y-m-d', strtotime($this->input->post('offer_valid_date')));
                $data['offer_conditions']     = $this->input->post('offer_conditions');
                
                $data['date_of_offer_created']= date('Y-m-d H:i:s');
                $data['status']     = $this->input->post('status');
                
                $data['product_id'] = $this->randomString(16);
                
                $offer_id = $this->base_model->insert_operation_id($data, TBL_OFFERS);
                if ($offer_id) {
                    $msg .= get_languageword('details_saved_successfully');
                    $status = 0;
                } else {
                    $msg .= get_languageword('details_not_saved');
                    $status = 1;
                }
                unset($data, $where);
                
                
                //Upload Offer Image
                if ($offer_id > 0 && count($_FILES) > 0) {
                    if ($_FILES['offer_image_name']['name'] != '' && $_FILES['offer_image_name']['error'] != 4) {
                        $ext = pathinfo($_FILES['offer_image_name']['name'], PATHINFO_EXTENSION);
                        $file_name = 'offer_'.$offer_id.'.'.$ext;
                        $config['upload_path']         = OFFER_IMG_UPLOAD_PATH_URL;
                        $config['allowed_types']     = ALLOWED_TYPES;
                        
                        $config['file_name']  = $file_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('offer_image_name')) {
                            $data = array();
                            $data['offer_image_name'] = $file_name;
                            //CHECK FOR TINIFY IMAGES
                            if ($this->config->item('tinify_settings')->use_tinify=='Yes') { 
                                $destination = FCPATH.OFFER_IMG_UPLOAD_PATH_URL.$file_name;
                                $source = base_url().OFFER_IMG_UPLOAD_PATH_URL.$file_name;
                                
                                $this->load->library('FCTinify');
                                $fct = new FCTinify();
                                //TINIFY IMAGE COMPRESSING
                                if ($this->config->item('tinify_settings')->compress=='Yes') {
                                    $result = $fct->imageCompress($source, $destination);
                                }
                                // TINIFY IMAGE THUMB CREATION
                                if ($this->config->item('tinify_settings')->thumb=='Yes') {
                                    $thumb_destination = FCPATH.OFFER_IMG_UPLOAD_THUMB_PATH_URL.$file_name;
                                    $fct->imageResize($source, $thumb_destination, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT, 'cover');
                                } else {    
                                    $this->create_thumbnail($config['upload_path'].$file_name, OFFER_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                                }
                                
                            } else {    
                                
                                $this->create_thumbnail($config['upload_path'].$file_name, OFFER_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                            }
                            
                            
                            $this->base_model->update_operation($data, TBL_OFFERS, array('offer_id'=>$offer_id));
                        } else {
                            $msg .= '<br>'.strip_tags($this->upload->display_errors());
                            $status =1;
                        }
                    }
                }
                unset($data);
                //Offer Products
                $no_of_products  = $this->input->post('product_count');
                
                if ($no_of_products > 1) {
                    $batch_data = array();
                    for ($i = 1; $i < $no_of_products; $i++) {
                        $data['offer_id']    = $offer_id;
                        $data['menu_name']   = $this->input->post('menu' . $i);
                        $data['menu_id']     = $this->input->post('menu_id' . $i);
                        $data['item_name']   = $this->input->post('item_name' . $i);
                        $data['item_id']     = $this->input->post('item_id' . $i);
                        $data['quantity']    = $this->input->post('quantity' . $i);
                        array_push($batch_data, $data);
                    }

                    if ($this->db->insert_batch(TBL_PREFIX.TBL_OFFER_PRODUCTS, $batch_data)) {
                        $offer_data=array();
                        $offer_data['no_of_products'] = $no_of_products - 1;
                        $this->base_model->update_operation($offer_data, TBL_OFFERS, array('offer_id'=>$offer_id));
                    } else {
                        $msg .= '<br>'.'Offer Products Details not Saved';
                        $status = 1;
                    }
                    unset($batch_data, $data, $offer_data);
                }
                
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_OFFERS_INDEX, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('add_offer');
        
        $this->data['categories']   = prepare_dropdown(TBL_MENU, 1, 'menu_id', 'menu_name', '', array('status' => 'Active'));
        
        $this->data['css_js_files']  = array('form_validation','datepicker');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "offers";
        $this->data['content']          = PAGE_ADD_OFFER;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Get items
     *
     * @return array
     **/
    function get_items()
    {
        if ($this->input->post('menu_id')) {
            $items = '';
            $menu_id = $this->input->post('menu_id');
            if ($menu_id > 0) {
                $records = $this->base_model->fetch_records_from(TBL_ITEMS, array('menu_id'=>$menu_id,'status'=>'Active'));
                
                if (!empty($records)) {
                    $items .= '<option value="">'.get_languageword('select').'</option>';
                    foreach ($records as $record):
                        $items .= '<option value="'.$record->item_id.'">'.$record->item_name.'</option>';
                    endforeach;
                } else {
                    $items .= '<option value="">'.get_languageword('no_items_available').'</option>';
                }
                
                echo $items;
            } else {
                return 0;
            }
        } else {
            echo 999;
        }
    }
    
    /**
     * Edit offer
     *
     * @return boolean
     **/
    function edit_offer()
    {
        if (isset($_POST['update_offer'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_OFFERS_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('offer_name', get_languageword('offer_name'), 'required|xss_clean');
            $this->form_validation->set_rules('offer_cost', get_languageword('offer_cost'), 'required|xss_clean');
            $this->form_validation->set_rules('offer_start_date', get_languageword('offer_start_date'), 'required|xss_clean');
            $this->form_validation->set_rules('offer_valid_date', get_languageword('offer_valid_date'), 'required|xss_clean');
            
            $this->form_validation->set_rules('offer_conditions', get_languageword('offer_conditions'), 'required|max_length[100]|xss_clean');

            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            $offer_id = $this->input->post('offer_id');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['offer_name']          = $this->input->post('offer_name');
                $data['offer_cost']             = $this->input->post('offer_cost');
                $data['offer_start_date']     = date('Y-m-d', strtotime($this->input->post('offer_start_date')));
                $data['offer_valid_date']     = date('Y-m-d', strtotime($this->input->post('offer_valid_date')));
                $data['offer_conditions']     = $this->input->post('offer_conditions');
                
                $data['date_of_offer_created']= date('Y-m-d H:i:s');
                $data['status']     = $this->input->post('status');
                
                if ($this->base_model->update_operation($data, TBL_OFFERS, array('offer_id'=>$offer_id))) {
                    $msg .= get_languageword('details_saved_successfully');
                    $status = 0;
                } else {
                    $msg .= get_languageword('details_not_saved');
                    $status = 1;
                }
                unset($data, $where);
                
                
                //Upload Offer Image
                if ($offer_id > 0 && count($_FILES) > 0) {
                    
                    if ($_FILES['offer_image_name']['name'] != '' && $_FILES['offer_image_name']['error'] != 4) {
                        
                        if ($this->input->post('offer_id') > 0) {
                            $record = $this->base_model->fetch_records_from(TBL_OFFERS, array('offer_id'=>$offer_id));
                        
                            if (!empty($record)) {
                                $record = $record[0];
                                if ($record->offer_image_name != '' && file_exists(OFFER_IMG_UPLOAD_PATH_URL.$record->offer_image_name)) {
                                    unlink(OFFER_IMG_UPLOAD_PATH_URL.$record->offer_image_name);
                                    unlink(OFFER_IMG_UPLOAD_THUMB_PATH_URL.$record->offer_image_name);
                                }
                            }
                        }
                        
                        $ext = pathinfo($_FILES['offer_image_name']['name'], PATHINFO_EXTENSION);
                        $file_name = 'offer_'.$offer_id.'.'.$ext;
                        $config['upload_path']         = OFFER_IMG_UPLOAD_PATH_URL;
                        $config['allowed_types']     = ALLOWED_TYPES;
                        
                        $config['file_name']  = $file_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('offer_image_name')) {
                            $data = array();
                            $data['offer_image_name'] = $file_name;
                            //CHECK FOR TINIFY IMAGES
                            if ($this->config->item('tinify_settings')->use_tinify=='Yes') {
                                $destination = FCPATH.OFFER_IMG_UPLOAD_PATH_URL.$file_name;
                                $source = base_url().OFFER_IMG_UPLOAD_PATH_URL.$file_name;
                                
                                $this->load->library('FCTinify');
                                $fct = new FCTinify();
                                //TINIFY IMAGE COMPRESSING
                                if ($this->config->item('tinify_settings')->compress=='Yes') {
                                    $result = $fct->imageCompress($source, $destination);
                                }
                                // TINIFY IMAGE THUMB CREATION
                                if ($this->config->item('tinify_settings')->thumb=='Yes') {
                                    $thumb_destination = FCPATH.OFFER_IMG_UPLOAD_THUMB_PATH_URL.$file_name;
                                    $fct->imageResize($source, $thumb_destination, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT, 'cover');
                                } else {    
                                    $this->create_thumbnail($config['upload_path'].$file_name, OFFER_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                                }
                                
                            } else {    
                                
                                $this->create_thumbnail($config['upload_path'].$file_name, OFFER_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                            }
                                                        
                            $this->base_model->update_operation($data, TBL_OFFERS, array('offer_id'=>$offer_id));
                        } else {
                            $msg .= '<br>'.strip_tags($this->upload->display_errors());
                            $status =1;
                        }
                    }
                }
                unset($data);
                
                
                
                //Offer Products
                $no_of_products  = $this->input->post('product_count');
                
                if ($no_of_products > 1) {
                    $offer_items = $this->base_model->fetch_records_from(TBL_OFFER_PRODUCTS, array('offer_id'=>$offer_id));
            
                    if (!empty($offer_items)) {
                        $where['offer_id'] = $offer_id;
                        $this->base_model->delete_record_new(TBL_OFFER_PRODUCTS, $where);
                    }
                    
                    $batch_data = array();
                    for ($i = 1; $i < $no_of_products; $i++) {
                        $data['offer_id']    = $offer_id;
                        $data['menu_name']   = $this->input->post('menu' . $i);
                        $data['menu_id']     = $this->input->post('menu_id' . $i);
                        $data['item_name']   = $this->input->post('item_name' . $i);
                        $data['item_id']     = $this->input->post('item_id' . $i);
                        $data['quantity']    = $this->input->post('quantity' . $i);
                        array_push($batch_data, $data);
                    }

                    if ($this->db->insert_batch(TBL_PREFIX.TBL_OFFER_PRODUCTS, $batch_data)) {
                        $offer_data=array();
                        $offer_data['no_of_products'] = $no_of_products - 1;
                        $this->base_model->update_operation($offer_data, TBL_OFFERS, array('offer_id'=>$offer_id));
                    } else {
                        $msg .= '<br>'.'Offer Products Details not Saved';
                        $status = 1;
                    }
                    unset($batch_data, $data, $offer_data);
                }
                
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_OFFERS_INDEX, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('edit_offer');
        
        if (isset($_POST['edit_offer'])) {
            $offer_id = $this->input->post('offer_id');
            if ($offer_id > 0) {
                $record = $this->base_model->fetch_records_from(TBL_OFFERS, array('offer_id' => $offer_id));
                
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_OFFERS_INDEX);                
                }
                $this->data['record'] =    $record[0];
                
                $this->data['offerProducts'] = $this->base_model->fetch_records_from(TBL_OFFER_PRODUCTS, array('offer_id' => $offer_id));
                
                $this->data['categories']   = prepare_dropdown(TBL_MENU, 1, 'menu_id', 'menu_name', '', array('status' => 'Active'));
            } else {
                redirect(URL_OFFERS_INDEX);
            }
        } else {
            redirect(URL_OFFERS_INDEX);
        }
        
        
        $this->data['css_js_files'] = array('form_validation','datepicker');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "offers";
        $this->data['content']          = PAGE_EDIT_OFFER;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
}