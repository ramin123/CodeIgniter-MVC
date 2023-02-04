<?php
/**
 * Menorah Restaurant-DIGISAMARITAN
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, DIGISAMARITAN
 *
 * @category  Cards
 * @package   Menorah Restaurant
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Cards Class
 * 
 * Admin can perform operations.
 *
 * @category  Cards
 * @package   Menorah Restaurant
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Cards extends MY_Controller
{

    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     Menorah Restaurant
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
    | MODULE:           CARDS CONTROLLER
    | -----------------------------------------------------
    | This is Cards module controller file.
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
            
            if (in_array($param1, array('delete', 'delete_selected', 'activate_selected', 'deactivate_selected')) && !empty($param2)) {
                if (DEMO) {
                    $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                    redirect(URL_CARDS_INDEX, REFRESH);
                }
                $msg='';
                $status=0;
                if ($param1 == "delete") {
                    $record = $this->base_model->fetch_records_from(TBL_CARD_IMAGES, array('card_image_id'=>$param2));
                    
                    if ($this->base_model->delete_record_new(TBL_CARD_IMAGES, array('card_image_id' => $param2))) {
                        if (!empty($record)) {
                            $record=$record[0];
                            if ($record->image_name != '' && file_exists(CARD_IMG_UPLOAD_PATH_URL.$record->image_name)) {
                                unlink(CARD_IMG_UPLOAD_PATH_URL.$record->image_name);
                                unlink(CARD_IMG_UPLOAD_THUMB_PATH_URL.$record->image_name);
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
                        $record = $this->base_model->fetch_records_from(TBL_CARD_IMAGES, array('card_image_id'=>$row));
                        
                        if (!empty($record)) {
                            $record=$record[0];
                            if ($record->image_name != '' && file_exists(CARD_IMG_UPLOAD_PATH_URL.$record->image_name)) {
                                unlink(CARD_IMG_UPLOAD_PATH_URL.$record->image_name);
                                unlink(CARD_IMG_UPLOAD_THUMB_PATH_URL.$record->image_name);
                            }
                        }
                    endforeach;
                    
                    if ($this->base_model->delete_record(TBL_CARD_IMAGES, 'card_image_id', $rows_to_be_deleted)) {
                        $msg .= get_languageword('selected_records_deleted_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deleted');
                        $status = 1;
                    }
                } else if ($param1 == "activate_selected") {
                    $rows_to_be_activated = explode(',', $param2);
                    
                    if ($this->base_model->changestatus_multiple_recs(TBL_CARD_IMAGES, array('status' => 'Active'), 'card_image_id', $rows_to_be_activated)) {
                        $msg .= get_languageword('selected_records_activated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_activated');
                    }
                } else if ($param1 == "deactivate_selected") {
                    $rows_to_be_deactivated = explode(',', $param2);
                    
                    if ($this->base_model->changestatus_multiple_recs(TBL_CARD_IMAGES, array('status' => 'Inactive'), 'card_image_id', $rows_to_be_deactivated)) {
                        $msg .= get_languageword('selected_records_deactivated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('record_not_deactivated');
                        $status = 1;
                    }
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_CARDS_INDEX);
            }
        }
        
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_CARDS_AJAX_GET_LIST,
        'disablesorting' => '0,4',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = ACTIVE_CARDS;
        
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('view_card_images');
        $this->data['content']         = PAGE_CARDS;
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

            $columns = array('tds.alt_text', 'tds.status');    
            
            $query     = "SELECT tds.* from ".TBL_PREFIX.TBL_CARD_IMAGES." tds WHERE card_image_id != ''";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('card_image_id'=>'desc'));
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    $image = IMG_DEFAULT;
                    if ($record->image_name != '' && file_exists(CARD_IMG_UPLOAD_PATH_URL.$record->image_name)) {
                        $image = CARD_IMG_PATH.$record->image_name;
                    }
                    
                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->card_image_id.'"> ';

                    $row[] = '<span><img src="'.$image.'" class="img-responsive center-block"/></span>';
                    
                    $row[] = '<span>'.$record->alt_text.'</span>';
                    
                    $checked = '';
                    $class = 'badge danger';
                    if ($record->status == 'Active') {
                        $checked = ' checked';
                        $class = 'badge success';    
                    }
                    $row[] = '<span class="'.$class.'">'.$record->status.'</span>';
                    
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_ADDEDIT_CARD);
                    $dta .= '<input type="hidden" name="card_image_id" value="'.$record->card_image_id.'">';
                    $dta .= '<button type="submit" name="edit_card" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    
                    $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->card_image_id.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';
                    
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
     * Add/Edit Card 
     *
     * @return boolean
     **/ 
    function addedit()
    {
        if (isset($_POST['addedit_card'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_CARDS_INDEX, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('alt_text', get_languageword('alternative_text'), 'xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            $card_image_id = $this->input->post('card_image_id');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                //Upload Add on image
                if (count($_FILES) > 0 && $_FILES['card_image']['name'] != '' && $_FILES['card_image']['error'] != 4) {
                    if ($this->input->post('card_image_id') > 0) {
                        $record = $this->base_model->fetch_records_from(TBL_CARD_IMAGES, array('card_image_id'=>$card_image_id));
                        
                        if (!empty($record)) {
                            $record = $record[0];
                            if ($record->image_name != '' && file_exists(CARD_IMG_UPLOAD_PATH_URL.$record->image_name)) {
                                unlink(CARD_IMG_UPLOAD_PATH_URL.$record->image_name);
                                unlink(CARD_IMG_UPLOAD_THUMB_PATH_URL.$record->image_name);
                            }
                        }
                    }
                        
                        
                    $ext = pathinfo($_FILES['card_image']['name'], PATHINFO_EXTENSION);
                    $file_name = 'card_'.rand(0, 999).'.'.$ext;
                    $config['upload_path']         = CARD_IMG_UPLOAD_PATH_URL;
                    $config['allowed_types']     = ALLOWED_TYPES;
                        
                    $config['file_name']  = $file_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('card_image')) {
                        $data['image_name'] = $file_name;
                        
                        if ($this->config->item('tinify_settings')->use_tinify=='Yes') {
                            
                            $destination = FCPATH.CARD_IMG_UPLOAD_PATH_URL.$file_name;                                
                            $source = base_url().CARD_IMG_UPLOAD_PATH_URL.$file_name;
                            $this->load->library('FCTinify');
                            $fct = new FCTinify();
                        
                            //TINIFY IMAGE COMPRESSING
                            if ($this->config->item('tinify_settings')->compress=='Yes') {
                                $result = $fct->imageCompress($source, $destination);                                
                            }    
                        
                            // TINIFY IMAGE THUMB CREATION
                            if ($this->config->item('tinify_settings')->thumb=='Yes') {
                                $thumb_destination = FCPATH.CARD_IMG_UPLOAD_THUMB_PATH_URL.$file_name;
                                $fct->imageResize($source, $thumb_destination, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT, 'cover');                                
                            } else {                                        
                                $this->create_thumbnail($config['upload_path'].$file_name, CARD_IMG_UPLOAD_THUMB_PATH_URL.$file_name, 200, 200);
                            }
                        } else {            
                    
                            $this->create_thumbnail($config['upload_path'].$file_name, CARD_IMG_UPLOAD_THUMB_PATH_URL.$file_name, 200, 200);
                        }        
                        
                        $data['alt_text'] = $this->input->post('alt_text');
                        $data['status']      = $this->input->post('status');
                            
                        if ($this->input->post('card_image_id') > 0) {
                            if ($this->base_model->update_operation($data, TBL_CARD_IMAGES, array('card_image_id'=>$card_image_id))) {
                                $msg .= get_languageword('details_saved_successfully');
                                $status = 0;
                            } else {
                                $msg .= get_languageword('details_not_saved');
                                $status = 1;
                            }
                        } else {
                            
                            if ($this->base_model->insert_operation($data, TBL_CARD_IMAGES)) {
                                $msg .= get_languageword('details_saved_successfully');
                                $status = 0;
                            } else {
                                $msg .= get_languageword('details_not_saved');
                                $status = 1;
                            }
                        }
                    } else {
                        $msg .= '<br>'.strip_tags($this->upload->display_errors());
                        $status =1;
                    }
                } else {
                    
                    if ($this->input->post('card_image_id') > 0) {
                        $record = $this->base_model->fetch_records_from(TBL_CARD_IMAGES, array('card_image_id' => $card_image_id));
                        
                        if (!empty($record)) {
                            $record=$record[0];
                            
                            if ($record->image_name != '' && file_exists(CARD_IMG_UPLOAD_PATH_URL.$record->image_name)) {
                                $data = array();
                                $data['alt_text'] = $this->input->post('alt_text');
                                $data['status']      = $this->input->post('status');
                                
                                if ($this->base_model->update_operation($data, TBL_CARD_IMAGES, array('card_image_id'=>$card_image_id))) {
                                    $msg .= get_languageword('details_saved_successfully');
                                    $status = 0;
                                } else {
                                    $msg .= get_languageword('details_not_saved');
                                    $status = 1;
                                }
                            }
                        }
                    }
                }
                unset($data);
                
                
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_CARDS_INDEX, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('add_card');
        
        if (isset($_POST['edit_card'])) {
            $card_image_id = $this->input->post('card_image_id');
            if ($card_image_id > 0) {
                $pagetitle = get_languageword('edit_card');
                $record = $this->base_model->fetch_records_from(TBL_CARD_IMAGES, array('card_image_id' => $card_image_id));
                
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('no_details_found'), 2);
                    redirect(URL_CARDS_INDEX);                
                }
                $this->data['record'] =    $record[0];
            } else {
                redirect(URL_CARDS_INDEX);
            }
        }
        
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = ACTIVE_CARDS;
        $this->data['content']          = PAGE_ADDEDIT_CARD;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
}