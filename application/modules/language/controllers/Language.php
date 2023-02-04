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
 * @category  LANGUAGE
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter LANGUAGE Class
 * 
 * LANGUAGE CRUD operations.
 *
 * @category  LANGUAGE
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Language extends MY_Controller
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
    | MODULE:           LANGUAGE CONTROLLER
    | -----------------------------------------------------
    | This is LANGUAGE module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }
    
    
    /**
     * List languages
     * @param  string $param1 [description]
     * @param  string $param2 [description]
     * @return [string]         [description]
     */
    function index($param1 = "", $param2 = "")
    {
        /***
        * 
         * Delete Operation - Start 
        ***/
        $param1 = ($this->input->post('param1')) ? $this->input->post('param1') : $param1;
        $param2 = ($this->input->post('param2')) ? $this->input->post('param2') : $param2;
        
        if (in_array($param1, array('delete')) && !empty($param2)) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_LANGUAGE_INDEX, REFRESH);
            }
            
            if ($param1 == "delete" && $param2 != '') {
                if ($this->base_model->delete_record_new('language_codes', array('language' => $param2))) {
                    $this->load->dbforge();
                    $this->dbforge->drop_column(TBL_LANGUAGEWORDS, $param2);
                    
                    $this->prepare_flashmessage(get_languageword('Record_Deleted_Successfully'), 0);
                } else {
                    $this->prepare_flashmessage(get_languageword('Record_Not_Deleted'), 1);
                }
            }
            redirect(URL_LANGUAGE_INDEX);
        }
        
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_LANGUAGE_AJAX_GET_LANGUAGE_LIST,
        'disablesorting' => '-1',
        );

        $this->data['css_js_files']     = array('data_tables');
        $this->data['activemenu']         = "language";
        $this->data['actv_submenu']     = "languages";
        $this->data['pagetitle']         = get_languageword('view_languages');
        $this->data['content']             = 'index';
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Fetch Language records
     *
     * @return array
     **/ 
    function ajax_get_language_list()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            //columns to be visible in table header
            $columns = array('tds.column_name','c.code');

            $query  = "SELECT distinct(tds.column_name),c.code FROM information_schema.columns tds,cr_language_codes c WHERE table_name='".TBL_PREFIX."languagewords' AND tds.column_name!= 'lang_id' AND tds.column_name!= 'phrase_for' AND tds.column_name!= 'lang_key' AND c.language=tds.column_name "; 
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array());
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $str = "";
                    $row = array();

                    
                    $row[] = $no;
                    
                    $row[] = ucwords($record->column_name);
                    
                    $row[] = $record->code;
                    
                    $str='';
                    
                    
                    if ($record->column_name != "english") {
                        
                        $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->column_name.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';                        
                    }
                    $str .= '<div class="digiCrud">
									<a class="btn btn-info btn-xs" href="'.URL_LANGUAGE_ADDLANGUEGEPHRASES.'/'.$record->column_name.'">
										<i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="'.get_languageword('Add_Language_Words').'"></i>
									</a>
								</div>';
                    
                    
                    
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
     * Check duplicate language
     *
     * @return boolean
     **/ 
    function checkduplicatelanguage()
    {
        $ret = clean_text(strtolower($this->input->post('title')));        
        if (!$this->db->field_exists($ret, $this->db->dbprefix('languagewords'))) {
            return TRUE;
        } else {
            $this->form_validation->set_message('checkduplicatelanguage', get_languageword('language_already_exists'));
            return FALSE;
        }
    }
    
     /**
      * Add Language
      *
      * @return boolean
      **/ 
    function addlanguage()
    {
        if ($this->input->post('add_language')) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_LANGUAGE_INDEX, REFRESH);
            }
                
            $this->form_validation->set_rules('title', get_languageword('language'), 'trim|required|callback_checkduplicatelanguage|xss_clean');
            $this->form_validation->set_rules('language_code', get_languageword('language_code'), 'trim|required|xss_clean');
            
            
            if ($this->form_validation->run()!=FALSE) {
                $language = clean_text(strtolower($this->input->post('title')));
                $this->load->dbforge();    
                if ($this->input->post('id') == '' ) {
                    $fields = array(
                    $language => array(
                    'type' => 'LONGTEXT',
                    'COLLATE' => 'utf8_general_ci',
                    )
                    );
                    $this->dbforge->add_column(TBL_LANGUAGEWORDS, $fields);
                    
                    $data  = array();
                    $data['language'] = $language;
                    $data['code']       = $this->input->post('language_code');
                    $this->base_model->insert_operation($data, 'language_codes');
                    unset($data);
                    
                    $this->prepare_flashmessage(get_languageword('MSG_LANGUAGE_ADDED'), 0);                    
                } else {
                    $fields = array(
                    $id => array(
                     'name' => $language,
                     'type' => 'LONGTEXT',
                    ),
                    );
                    $this->dbforge->modify_column(TBL_LANGUAGEWORDS, $fields);
                    $this->prepare_flashmessage(get_languageword('MSG_LANGUAGE_UPDATED'), 0);                    
                }    

                redirect(URL_LANGUAGE_INDEX);                
            } else {
                $this->data['message'] = prepare_message(validation_errors(), 1);
            }
        }

        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['activemenu']      = 'language';
        $this->data['actv_submenu']  = 'languages';
        $this->data['pagetitle']      = get_languageword('add_language');
        $this->data['content']          = 'addlanguage';
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Fetch Phrases records
     *
     * @return array
     **/ 
    function phrases()
    {
        
        /***
        * 
         * Delete Operation - Start 
        ***/
        $param1 = $this->input->post('param1');
        $param2 = $this->input->post('param2');

        if (in_array($param1, array('delete', 'delete_selected')) && !empty($param2)) {

            if (DEMO) {

                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_LANGUAGE_PHRASES, REFRESH);
            }

            if ($param1 == "delete") {

                if ($this->base_model->delete_record_new('languagewords', array('lang_id' => $param2))) {

                    $this->prepare_flashmessage(get_languageword('record_deleted_successfully'), 0);

                } else {

                    $this->prepare_flashmessage(get_languageword('record_not_deleted'), 1);
                }

            } else if ($param1 == "delete_selected") {

                $rows_to_be_deleted = explode(',', $param2);
                if ($this->base_model->delete_record('languagewords', 'lang_id', $rows_to_be_deleted)) {

                    $this->prepare_flashmessage(get_languageword('selected_records_deleted_successfully'), 0);

                } else {

                    $this->prepare_flashmessage(get_languageword('record_not_deleted'), 1);
                }
            }
            redirect(URL_LANGUAGE_PHRASES);
        }
        /***
        * 
         * Delete Operation - End 
        ***/
        
        $this->data['ajaxrequest'] = array(
        'url' => URL_LANGUAGE_AJAX_GET_PHRASE_LIST,
        'disablesorting' => '0,4',
        );
        
        $this->data['css_js_files']     = array('data_tables');
        $this->data['activemenu']         = "language";
        $this->data['actv_submenu']     = "phrases";
        $this->data['pagetitle']         = get_languageword('phrases');
        $this->data['content']             = 'phrases';
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
     /**
      * Fetch phrases records
      *
      * @return array
      **/ 
    function ajax_get_phrase_list()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            //columns to be visible in table header
            $columns = array('tds.lang_id', 'tds.lang_id', 'tds.phrase_for', 'tds.lang_key', 'tds.english');

            $query  = "SELECT tds.* FROM ".TBL_PREFIX."languagewords tds WHERE tds.lang_id != '' "; 


            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array());

            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();


                    $row[] = '<input type="checkbox" name="check_rows[]" class="check_rows" value="'.$record->lang_id.'"> ';

                    $row[] = $record->phrase_for;
                    $row[] = $record->lang_key;
                    $row[] = $record->english;

                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_LANGUAGE_ADDEDIT_PHRASE);
                    $dta .= '<input type="hidden" name="lang_id" value="'.$record->lang_id.'">';
                    $dta .= '<button type="submit" name="edit_phrase" class="'.CLASS_EDIT_BTN.'"><i class="'.CLASS_ICON_EDIT.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    
                    $str .= '<a data-toggle="modal" data-target="#commonModal" title="'.get_languageword('delete').'" class="'.CLASS_DELETE_BTN.'" onclick="set_fields(\'delete\', \''.$record->lang_id.'\');"><i class="'.CLASS_ICON_DELETE.'" ></i> </a>';

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
     * Delete Language
     *
     * @return array
     **/ 
    function deletelanguage()
    {
        if (DEMO) {
            $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
            redirect(URL_LANGUAGE_INDEX, REFRESH);
        }
        
        if (isset($_POST['delete_language'])) {
            $id = $this->input->post('column_name');
            $this->load->dbforge();
            $this->dbforge->drop_column(TBL_LANGUAGEWORDS, urldecode($id));

            $this->prepare_flashmessage(get_languageword('MSG_LANGUAGE_DELETED'), 0);
        }
        redirect(URL_LANGUAGE_INDEX);
    }
    
    /**
     * Add/Edit Phrase
     *
     * @return boolean
     **/ 
    function addedit_phrase() 
    {
        $details = $this->db->list_fields('languagewords');
        
        //Check for Form Submission
        if (isset($_POST['addedit_phrase'])) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_LANGUAGE_PHRASES, REFRESH);
            }
            

            
            $id = ($this->input->post('id')) ? $this->input->post('id') : '';
            
            $lang_key = $this->input->post('lang_key');
            
            //Form Validations
            $parameters = 'lang_key' . '||' . 'languagewords' . '||' . $id;
            
            $this->form_validation->set_rules('lang_key', get_languageword('lang_key'), 'required|callback_unique_field['.$parameters.']|xss_clean');
            
            
            $this->form_validation->set_rules('english', get_languageword('english'), 'trim|required|xss_clean');

            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            //If Valid input given else errors will be shown in form
            if ($this->form_validation->run() == TRUE) {

                $submit_type = $this->input->post('submit_btn');

                $inputdata['phrase_for'] = $this->input->post('phrase_for');
                $inputdata['lang_key']      = clean_text($this->input->post('lang_key'));

                if (!empty($details)) {

                    foreach ($details as $key => $value) {

                        if ($value != 'lang_id' && $value != 'phrase_for' && $value != 'lang_key') {

                              $inputdata[$value] = $this->input->post($value);
                            
                        }
                    }
                }

                if (!empty($id)) {

                    //Update Record
                    if ($this->base_model->update_operation($inputdata, 'languagewords', array('lang_id' => $id))) {

                        $flash_msg         = get_languageword('Record_Updated_Successfully');
                        $flash_msg_type = 0;//Success

                    } else {

                        $flash_msg         = get_languageword('Record_Not_Updated');
                        $flash_msg_type = 1;//Failure
                    }

                } else {

                    //Insert Record
                    if ($this->base_model->insert_operation($inputdata, 'languagewords')) {

                        $flash_msg         = get_languageword('Record_Added_Successfully');
                        $flash_msg_type = 0;//Success

                    } else {

                        $flash_msg         = get_languageword('Record_Not_Added');
                        $flash_msg_type = 1;//Failure
                    }
                }

                $this->prepare_flashmessage($flash_msg, $flash_msg_type);
                redirect(URL_LANGUAGE_PHRASES);
            }            
        }

        $pagetitle = get_languageword('add_phrase');
        //Edit Form
        if (isset($_POST['edit_phrase'])) {
            $lang_id = $this->input->post('lang_id');
            if ($lang_id > 0) {
                $pagetitle = get_languageword('edit_phrase');
                
                $record = $this->base_model->fetch_records_from('languagewords', array('lang_id' => $lang_id));
                if (empty($record)) {
                    $this->prepare_flashmessage(get_languageword('No_Details_Found'), 2);
                    redirect(URL_LANGUAGE_PHRASES);                
                }
                $this->data['record'] =    $record[0];
            }
        }


        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = "language";
        $this->data['actv_submenu']  = 'phrases';
        $this->data['details']          = $details;
        $this->data['content']          = 'addedit_phrase';
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
 

    /**
     * 
     * Check for unique field
     * 
     * 
     * 
     *
     * @param  string $field_val 
     * @param  string $second_parameter 
     * @return boolean
     */     
    public function unique_field($field_val, $second_parameter)
    {
        $phrase_for = $this->input->post('phrase_for');

        list($field_name, $table_name, $whr) = explode('||', $second_parameter);

        $where = array($field_name => $field_val,'phrase_for'=>$phrase_for);

        if (!empty($whr)) {
            $where['lang_id!='] = $whr;
        }

        $is_exist = $this->base_model->fetch_records_from($table_name, $where);

        if (count($is_exist) > 0) {
            $this->form_validation->set_message('_unique_field', get_languageword('the').' '.get_languageword(humanize($field_name)).' '.get_languageword('_already_exists'));
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * View Phrase Details
     * @param  int $id [description]
     * @return [array]     [description]
     */
    function view_phrase_details($id = "")
    {
        if (empty($id)) {

            $this->prepare_flashmessage(get_languageword('No_Details_Found'), 2);
            redirect(URL_LANGUAGE_PHRASES);
        }


        $record_details = $this->base_model->fetch_records_from_in('languagewords', 'lang_id', $id);

        if (empty($record_details)) {

            $this->prepare_flashmessage(get_languageword('No_Details_Found'), 2);
            redirect(URL_LANGUAGE_PHRASES);
        }

        $this->data['record']             = $record_details;
        $this->data['details']             = $this->db->list_fields('languagewords');
        $this->data['activemenu']         = "language";
        $this->data['actv_submenu']     = "phrases";
        $this->data['pagetitle']         = get_languageword('View_Phrase_Details');
        $this->data['content']             = "view_phrase_details";

        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
   
     /**
      * 
      * This function fecilitate to enter language words
      * 
      * @param string $language 
      *                          
      * @return void
      */ 
    function addlanguagephrases($language='')
    {
        if ($this->input->post()) {
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_LANGUAGE_INDEX, REFRESH);
            }            
    
            // $language = ($this->input->post('id')) ? $this->input->post('id') : $language;
            
            $words = $this->input->post('word');
            
            $id = ($this->input->post('id')) ? $this->input->post('id') : $language;
            
            foreach ($words as $key => $val) {
                
                if (!empty($key) && is_numeric($key) && !empty($val)) {
                    $this->base_model->update_operation(array($id => $val), 'languagewords', array('lang_id' => $key));
                }
            }
            $this->prepare_flashmessage(get_languageword('success_phrases_updated_successfuly'), 0);
            redirect(URL_LANGUAGE_INDEX);
        }
        
        if (empty($language)) {
            $this->prepare_flashmessage(get_languageword('please_select_language'), 1);
            redirect(URL_LANGUAGE_INDEX);
            
        } else {
            $query  = "SELECT tds.column_name FROM information_schema.columns tds WHERE table_name='".TBL_PREFIX."languagewords' AND tds.column_name='".$language."' "; 
            
            $record = $this->db->query($query)->result();
            
            if (empty($record)) {
                $this->prepare_flashmessage(get_languageword('Invalid Operation'), 1);
                redirect(URL_LANGUAGE_INDEX);
            }
        }

        $this->data['activemenu']      = 'language';
        $this->data['actv_submenu']  = 'languages';
        $this->data['pagetitle']      = get_languageword('add_phrases');
        $this->data['id']              = $language;
        $this->data['languagewords'] = $this->base_model->fetch_records_from('languagewords', array(), '*', 'lang_key');
        $this->data['content'] = 'addlanguagephrases';   
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }


    function addlanguageUsingGoogleTranslate()
    {
        $from_lan = 'en';
        $to_lan = 'ru';
        $text = 'I love you';
        $apiKey = "AIzaSyCq8SczsOWA_pWVlK7s3SzMKJ29biInW-U";
        $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text) . '&source=en&target=fr';

          $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);                 
    $responseDecoded = json_decode($response, true);
    curl_close($handle);

    echo 'Source: ' . $text . '<br>';
    echo 'Translation: ' . $responseDecoded['data']['translations'][0]['translatedText'];

    }
    
}