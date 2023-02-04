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
 * @category  Settings
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Settings Class
 * 
 * All can perform all Settings operations.
 *
 * @category  Settings
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Settings extends MY_Controller
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
    | MODULE:           SETTINGS CONTROLLER
    | -----------------------------------------------------
    | This is Settings module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

    /**
     * Fetch site settings record
     *
     * @return array
     **/ 
    function index()
    {
        redirect(URL_SITE_SETTINGS);
    }
    
    /**
     * Fetch site settings record
     *
     * @return array
     **/ 
    function site_settings()
    {
        if (isset($_POST['site_settings'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_SITE_SETTINGS);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('site_title', get_languageword('site_title'), 'trim|required|max_length[100]|xss_clean');
            
            
            
            $this->form_validation->set_rules('home_page_caption', get_languageword('home_page_caption'), 'trim|required|max_length[50]|xss_clean');
            $this->form_validation->set_rules('home_page_tagline', get_languageword('home_page_tagline'), 'trim|max_length[50]|xss_clean');
            
            $this->form_validation->set_rules('address', get_languageword('address'), 'trim|required|max_length[1000]|xss_clean');
            $this->form_validation->set_rules('city', get_languageword('city'), 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('state', get_languageword('state'), 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('country', get_languageword('country'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', get_languageword('pincode'), 'trim|required|max_length[20]|xss_clean');
            $this->form_validation->set_rules('latitude', get_languageword('latitude'), 'required|xss_clean');
            $this->form_validation->set_rules('longitude', get_languageword('longitude'), 'required|xss_clean');
            $this->form_validation->set_rules('ios_url', get_languageword('ios_url|xss_clean'));
            $this->form_validation->set_rules('android_url', get_languageword('android_url|xss_clean'));
            $this->form_validation->set_rules('phone', get_languageword('phone'), 'trim|required|max_length[30]|xss_clean');
            $this->form_validation->set_rules('land_line', get_languageword('land_line'), 'trim|required|max_length[30]|xss_clean');
            $this->form_validation->set_rules('fax', get_languageword('fax'), 'trim|max_length[50]|xss_clean');
            $this->form_validation->set_rules('portal_email', get_languageword('contact_email'), 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('site_country', get_languageword('site_country'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('currency_symbol', get_languageword('currency_symbol'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('from_time', get_languageword('from_time'), 'required|xss_clean');
            $this->form_validation->set_rules('to_time', get_languageword('to_time'), 'required|xss_clean');
            $this->form_validation->set_rules('design_by', get_languageword('design_by'), 'trim|required|xss_clean');

            $this->form_validation->set_rules('rights_reserved_content', get_languageword('rights_reserved_content'), 'trim|required|xss_clean');    

            $this->form_validation->set_rules('facebook_app_id', get_languageword('facebook_app_id'), 'required|xss_clean');    


            $this->form_validation->set_rules('facebook_app_secret', get_languageword('facebook_app_secret'), 'required|xss_clean');
            
            $this->form_validation->set_rules('google_client_id', get_languageword('google_client_id'), 'required|xss_clean');
            $this->form_validation->set_rules('google_client_secret', get_languageword('google_client_secret'), 'required|xss_clean');


            $this->form_validation->set_rules('contact_map_script', get_languageword('contact_map_script'), 'required');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['site_title'] = $this->input->post('site_title');
                
                
                
                $data['home_page_caption']     = $this->input->post('home_page_caption');
                $data['home_page_tagline']     = $this->input->post('home_page_tagline');
                
                
                
                $data['address']     = $this->input->post('address');
                $data['city']         = $this->input->post('city');
                $data['state']         = $this->input->post('state');
                $data['country']     = $this->input->post('country');
                $data['zip']         = $this->input->post('zip');
                $data['latitude']   = $this->input->post('latitude');
                $data['longitude']  = $this->input->post('longitude');
                
                $data['ios_url']       = $this->input->post('ios_url');
                $data['android_url'] = $this->input->post('android_url');
                
                $data['facebook_api'] = $this->input->post('facebook_api');
                $data['google_api']   = $this->input->post('google_api');
                
                $data['phone']         = $this->input->post('phone');
                $data['land_line']     = $this->input->post('land_line');
                $data['fax']         = $this->input->post('fax');
                $data['portal_email'] = $this->input->post('portal_email');
                
                $data['site_language']= $this->input->post('site_language');
                $data['site_country'] = $this->input->post('site_country');
                $data['time_zone']       = $this->input->post('time_zone');
                $data['currency']       = $this->input->post('currency');
                $data['currency_symbol'] = $this->input->post('currency_symbol');
                
                $data['country_code'] = $this->input->post('country_code');
                
                $data['from_time']       = $this->input->post('from_time');
                $data['to_time']       = $this->input->post('to_time');
                
                if ($this->input->post('sms_notifications')=='on') {
                    $data['sms_notifications']       = 'Yes';
                } else {
                    $data['sms_notifications']       = 'No';
                }    
            
            
                if ($this->input->post('fcm_push_notifications')=='on') {
                    $data['fcm_push_notifications']= 'Yes';
                } else {
                    $data['fcm_push_notifications']= 'No';
                }    
                
                
                $data['design_by']            = $this->input->post('design_by');
                $data['rights_reserved_content'] = $this->input->post('rights_reserved_content');
                
                $data['date_format']       = $this->input->post('date_format');
                
                $payment_methods = $this->input->post('payment_methods');
                if (!empty($payment_methods)) {
                    $payment_methods = implode(',', $payment_methods);
                    $data['payment_methods'] = $payment_methods;
                } else {
                    $data['payment_methods'] = NULL;
                }
                
                $data['facebook_app_id']      = $this->input->post('facebook_app_id');
                $data['facebook_app_secret'] = $this->input->post('facebook_app_secret');
                
                $data['google_client_id']      = $this->input->post('google_client_id');
                $data['google_client_secret']= $this->input->post('google_client_secret');
                

                $data['contact_map_script'] = $this->input->post('contact_map_script');
                
                $where = array('id'=>1);
                if ($this->base_model->update_operation($data, TBL_SITE_SETTINGS, $where)) {
                    unset($data);
                    $msg  .= get_languageword('details_updated_successfully');
                    $status= 0;
                    
                    //Upload Site Logo
                    if (count($_FILES) > 0) {
                        if ($_FILES['site_logo']['name'] != '' && $_FILES['site_logo']['error'] != 4) {
                            $record = $this->base_model->fetch_records_from('site_settings');
                            
                            if (!empty($record)) {
                                $record = $record[0];
                                if ($record->site_logo != '' && file_exists(LOGO_IMG_UPLOAD_PATH_URL.$record->site_logo)) {
                                    unlink(LOGO_IMG_UPLOAD_PATH_URL.$record->site_logo);
                                    unlink(LOGO_IMG_UPLOAD_THUMB_PATH_URL.$record->site_logo);
                                }
                            }
                            
                            $ext = pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION);
                            $file_name = 'site_logo.'. $ext;
                            $config['upload_path']         = LOGO_IMG_UPLOAD_PATH_URL;
                            $config['allowed_types']     = 'jpg|jpeg|png|svg|JPG|JPEG|PNG';
                            $config['max_size']          = 5120;//5 MB


                            $config['file_name']  = $file_name;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('site_logo')) {
                                
                                $data = array();
                                $data['site_logo'] = $file_name;
                                
                                
                                
                                // TINIFY IMAGE COMPRESSING & THUMB
                                if ($this->config->item('tinify_settings')->use_tinify=='Yes') {
                                
                                
                                    $destination = FCPATH.LOGO_IMG_UPLOAD_PATH_URL.$file_name;
                                    $source = base_url().LOGO_IMG_UPLOAD_PATH_URL.$file_name;
                                
                                    $this->load->library('FCTinify');
                                    $fct = new FCTinify();
                                
                                    //TINIFY IMAGE COMPRESSING
                                    if ($this->config->item('tinify_settings')->compress=='Yes') {
                                        $result = $fct->imageCompress($source, $destination);
                                    }
                                
                                    // TINIFY IMAGE THUMB CREATION
                                    if ($this->config->item('tinify_settings')->thumb=='Yes') {
                                        $thumb_destination = FCPATH.LOGO_IMG_UPLOAD_THUMB_PATH_URL.$file_name;
                                        $fct->imageResize($source, $thumb_destination, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT, 'cover');
                                    } else {    
                                        $this->create_thumbnail($config['upload_path'].$file_name, LOGO_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                                    }
                                
                                
                                } else {
                                    
                                    $this->create_thumbnail($config['upload_path'].$file_name, LOGO_IMG_UPLOAD_THUMB_PATH_URL.$file_name, 200, 200);
                                }
                                
                            } else {
                                $msg .= '<br>'.strip_tags($this->upload->display_errors());
                                $status =1;
                                
                            }
                        }
                        
                        
                        if ($_FILES['second_site_logo']['name'] != '' && $_FILES['second_site_logo']['error'] != 4) {
                            $record = $this->base_model->fetch_records_from('site_settings');
                            
                            if (!empty($record)) {
                                
                                $record = $record[0];
                                if ($record->second_site_logo != '' && file_exists(LOGO_IMG_UPLOAD_PATH_URL.$record->second_site_logo)) {
                                    unlink(LOGO_IMG_UPLOAD_PATH_URL.$record->second_site_logo);
                                    unlink(LOGO_IMG_UPLOAD_THUMB_PATH_URL.$record->second_site_logo);
                                }
                            }
                            
                            $ext = pathinfo($_FILES['second_site_logo']['name'], PATHINFO_EXTENSION);
                            $file_name = 'second_site_logo.'. $ext;
                            $config['upload_path']         = LOGO_IMG_UPLOAD_PATH_URL;
                            $config['allowed_types']     = 'jpg|jpeg|png|svg|JPG|JPEG|PNG';
                            
                            $config['file_name']  = $file_name;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('second_site_logo')) {
                                
                                $data = array();
                                $data['second_site_logo'] = $file_name;
                                
                                
                                // TINIFY IMAGE COMPRESSING & THUMB
                                if ($this->config->item('tinify_settings')->use_tinify=='Yes') {
                                
                                
                                    $destination = FCPATH.LOGO_IMG_UPLOAD_PATH_URL.$file_name;
                                    $source = base_url().LOGO_IMG_UPLOAD_PATH_URL.$file_name;
                                
                                    $this->load->library('FCTinify');
                                    $fct = new FCTinify();
                                
                                    //TINIFY IMAGE COMPRESSING
                                    if ($this->config->item('tinify_settings')->compress=='Yes') {
                                        $result = $fct->imageCompress($source, $destination);
                                    }
                                
                                    // TINIFY IMAGE THUMB CREATION
                                    if ($this->config->item('tinify_settings')->thumb=='Yes') {
                                        $thumb_destination = FCPATH.LOGO_IMG_UPLOAD_THUMB_PATH_URL.$file_name;
                                        $fct->imageResize($source, $thumb_destination, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT, 'cover');
                                    } else {    
                                        $this->create_thumbnail($config['upload_path'].$file_name, LOGO_IMG_UPLOAD_THUMB_PATH_URL.$file_name, THUMB_IMG_WIDTH, THUMB_IMG_HEIGHT);
                                    }
                                
                                
                                } else {
                                
                                    $this->create_thumbnail($config['upload_path'].$file_name, LOGO_IMG_UPLOAD_THUMB_PATH_URL.$file_name, 200, 200);
                                }
                                
                            } else {
                                $msg .= '<br>'.strip_tags($this->upload->display_errors());
                                $status =1;
                                
                            }
                        }
                        
                        
                        if ($_FILES['fevicon']['name'] != '' && $_FILES['fevicon']['error'] != 4) {
                            $record = $this->base_model->fetch_records_from('site_settings');
                            
                            if (!empty($record)) {
                                $record = $record[0];
                                
                                if ($record->fevicon != '' && file_exists(FEVICON_IMG_UPLOAD_PATH_URL.$record->fevicon)) {
                                    unlink(FEVICON_IMG_UPLOAD_PATH_URL.$record->fevicon);
                                }
                            }
                            
                            $ext = pathinfo($_FILES['fevicon']['name'], PATHINFO_EXTENSION);
                            $file_name1 = 'fevicon.'. $ext;
                            $config['upload_path']         = FEVICON_IMG_UPLOAD_PATH_URL;
                            $config['allowed_types']     = 'ico';
                            
                            $config['file_name']  = $file_name1;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('fevicon')) {
                                $data['fevicon'] = $file_name1;
                                
                            } else {
                                $msg .= '<br>'.strip_tags($this->upload->display_errors());
                                $status =1;
                            }
                        }
                        
                        
                        
                        
                        
                        //HOME PAGE IMAGE
                        if ($_FILES['home_page_img']['name'] != '' && $_FILES['home_page_img']['error'] != 4) {
                            $record = $this->base_model->fetch_records_from('site_settings');
                            
                            if (!empty($record)) {
                                $record = $record[0];
                                if ($record->home_page_img != '' && file_exists(HOME_PAGE_IMG_UPLOAD_PATH_URL.$record->home_page_img)) {
                                    unlink(HOME_PAGE_IMG_UPLOAD_PATH_URL.$record->home_page_img);
                                }
                            }
                            
                            $ext = pathinfo($_FILES['home_page_img']['name'], PATHINFO_EXTENSION);
                            $file_name = 'home_page_img.'. $ext;
                            $config['upload_path']         = HOME_PAGE_IMG_UPLOAD_PATH_URL;
                            
                            
                            //
                            $config['min_width']  = 1980;
                            $config['min_height'] = 448;
                            
                            $config['max_width']  = 2000;
                            $config['max_height'] = 1500;
                            //
                            
                            $config['allowed_types']     = 'jpg|jpeg|png|JPG|JPEG|PNG';
                            
                            $config['file_name']  = $file_name;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('home_page_img')) {
                                
                                $data = array();
                                $data['home_page_img'] = $file_name;
                                
                                // TINIFY IMAGE COMPRESSING & THUMB
                                if ($this->config->item('tinify_settings')->use_tinify=='Yes') {
                                
                                    $destination = FCPATH.HOME_PAGE_IMG_UPLOAD_PATH_URL.$file_name;
                                    $source = base_url().HOME_PAGE_IMG_UPLOAD_PATH_URL.$file_name;
                                    
                                    $this->load->library('FCTinify');
                                    $fct = new FCTinify();
                                    
                                    //TINIFY IMAGE COMPRESSING
                                    if ($this->config->item('tinify_settings')->compress=='Yes') {
                                        $result = $fct->imageCompress($source, $destination);
                                    }
                                } 
                            } else {
                                $msg .= '<br>'.strip_tags($this->upload->display_errors());
                                $status =1;
                            }
                        }
                        
                        
                        if (!empty($data)) {
                            $this->base_model->update_operation($data, TBL_SITE_SETTINGS, $where);
                        }
                    }
                } else {
                    $msg   .= get_languageword('details_not_updated');
                    $status = 1;
                }
                
                
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_SITE_SETTINGS, REFRESH);
            }
        }
        
        $record = array();
        $record = $this->base_model->fetch_records_from(TBL_SITE_SETTINGS);
        if (!empty($record)) { 
            $record = $record[0];
        }
        
        //Language Options
        $lang_opts = get_language_opts();
        $this->data['lang_opts']       = $lang_opts;
        
        //Language Options
        $currency_opts = get_currency_opts();
        $this->data['currency_opts'] = $currency_opts;
        
        
        // TIME ZONES
        $time_zone_options = array();
        $time_zones = $this->base_model->fetch_records_from('calendar_timezones');
        if (!empty($time_zones)) {
            foreach($time_zones as $row):
                $time_zone_options[$row->TimeZone] = $row->TimeZone.'('.$row->UTC_offset.')';
            endforeach;
        }
        $this->data['time_zone_options'] = $time_zone_options;
        
        $this->data['record']          = $record;
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = get_languageword('site_settings');
        
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = 'site_settings';
        
        $this->data['content']          = PAGE_SITE_SETTINGS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * Paypal Settings 
     *
     * @return page
     **/
    function paypal_settings()
    {
        if (isset($_POST['paypal_settings'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_PAYPAL_SETTINGS);
            }
            
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules(
                'PayPalEnvironmentProduction', 
                get_languageword('paypal_environment_production'), 
                'required|xss_clean'
            );
            $this->form_validation->set_rules(
                'PayPalEnvironmentSandbox', 
                get_languageword('paypal_environment_sandbox'), 
                'required|xss_clean'
            );
            $this->form_validation->set_rules(
                'merchantName', 
                get_languageword('merchant_name'), 
                'required|xss_clean'
            );
            $this->form_validation->set_rules(
                'merchantPrivacyPolicyURL', 
                get_languageword('merchant_privacy_policy_url'), 
                'required|xss_clean'
            );
            $this->form_validation->set_rules(
                'merchantUserAgreementURL', 
                get_languageword('merchant_user_agreement_url'), 
                'required|xss_clean'
            );
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['PayPalEnvironmentProduction'] = $this->input->post('PayPalEnvironmentProduction');
                $data['PayPalEnvironmentSandbox']     = $this->input->post('PayPalEnvironmentSandbox');
                $data['merchantName']     = $this->input->post('merchantName');
                $data['merchantPrivacyPolicyURL']         = $this->input->post('merchantPrivacyPolicyURL');
                $data['merchantUserAgreementURL']         = $this->input->post('merchantUserAgreementURL');
                
                
                $data['paypal_email'] = $this->input->post('paypal_email');
                
                $data['currency']       = $this->input->post('currency');
                $data['account_type'] = $this->input->post('account_type');
                $data['status']         = $this->input->post('status');
                
                $where = array('id'=>1);
                
                if ($this->base_model->update_operation($data, TBL_PAYPAL_SETTINGS, $where)) {
                    unset($data);
                    $msg  .= get_languageword('details_updated_successfully');
                    $status= 0;
                } else {
                    $msg   .= get_languageword('details_not_updated');
                    $status = 1;
                }
                
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_PAYPAL_SETTINGS, REFRESH);
            }
        }
        
        $record = array();
        $record =$this->base_model->fetch_records_from(TBL_PAYPAL_SETTINGS);
        if (!empty($record)) { 
            $record = $record[0];
        }
        
        //Currency Options
        $currency_options  = get_currency_opts();
        $this->data['currency_options']     = $currency_options;

        $this->data['record']          = $record;
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = get_languageword('paypal_settings');
        
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = 'paypal_settings';
        
        $this->data['content']          = PAGE_PAYPAL_SETTINGS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Email Settings 
     *
     * @return page
     **/
    function email_settings()
    {
        if (isset($_POST['email_settings'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_EMAIL_SETTINGS);
            }
            
            $msg='';
            $status=0;
            
            if ($this->input->post('mail_config')=='webmail') {
                $this->form_validation->set_rules(
                    'smtp_host', get_languageword('smtp_host'), 'required|xss_clean'
                );
                $this->form_validation->set_rules('smtp_port', get_languageword('smtp_port'), 'required|xss_clean');
                $this->form_validation->set_rules('smtp_user', get_languageword('smtp_user'), 'required|xss_clean');
                $this->form_validation->set_rules('smtp_password', get_languageword('smtp_password'), 'required|xss_clean');
            } else if ($this->input->post('mail_config')=='mandrill') {
                $this->form_validation->set_rules('api_key', get_languageword('api_key'), 'required|xss_clean');
            }
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['smtp_host']      = $this->input->post('smtp_host');
                $data['smtp_port']      = $this->input->post('smtp_port');
                $data['smtp_user']      = $this->input->post('smtp_user');
                $data['smtp_password']  = $this->input->post('smtp_password');
                $data['api_key']        = $this->input->post('api_key');
                $data['mail_config']    = $this->input->post('mail_config');
                
                $where = array('id'=>1);
                if ($this->base_model->update_operation($data, TBL_EMAIL_SETTINGS, $where)) {
                    unset($data);
                    $msg  .= get_languageword('details_updated_successfully');
                    $status= 0;
                } else {
                    $msg   .= get_languageword('details_not_updated');
                    $status = 1;
                }
                
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_EMAIL_SETTINGS, REFRESH);
            }
        }
        
        $record = array();
        $record =$this->base_model->fetch_records_from(TBL_EMAIL_SETTINGS);
        if (!empty($record)) { 
            $record = $record[0];
        }
        
        $this->data['record']          = $record;
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = get_languageword('email_settings');
        
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = 'email_settings';
        
        
        $this->data['content']          = PAGE_EMAIL_SETTINGS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * SMS Gateways 
     *
     * @return page
     **/
    function sms_gateways()
    {
        $records = array();
        $records = $this->base_model->fetch_records_from(TBL_SMS_GATEWAYS);
        $this->data['records']          = $records;
        $this->data['css_js_files']  = array('data_tables');
        $this->data['pagetitle']     = get_languageword('sms_gateways');
        
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = 'sms_gateways';
        
        $this->data['content']          = PAGE_SMS_GATEWAYS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * MAKE default SMS Gateway
     *
     * @return boolean
     **/
    function makedefault()
    {
        $msg='';
        $status=0;
        
        if (isset($_POST['sms_gateway'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_SMS_GATEWAYS);
            }
            
            $details = $this->base_model->fetch_records_from(TBL_SMS_GATEWAYS);
            
            if (!empty($details)) {
                
                $this->db->query('UPDATE '.TBL_PREFIX.TBL_SMS_GATEWAYS.' SET is_default="No"');
                
                $sms_gateway_id = $this->input->post('sms_gateway_id');
                
                if ($sms_gateway_id > 0) {
                    if ($this->db->query('UPDATE '.TBL_PREFIX.TBL_SMS_GATEWAYS.' SET is_default="Yes" WHERE sms_gateway_id = '.$sms_gateway_id)) {
                        $msg .= get_languageword('updated_successfully');
                        $status = 0;
                    } else {
                        $msg .= get_languageword('not_updated');
                        $status = 1;
                    }
                } else {
                    $msg .= get_languageword('invalid_updated');
                    $status = 1;
                }
            }
        }
        
        if ($msg != '') {
            $this->prepare_flashmessage($msg, $status);
        }
        redirect(URL_SMS_GATEWAYS, REFRESH);        
    }
    
    
    /**
     * UPDATE SMS FIEDL VALUES
     *
     * @return boolean
     **/
    function update_sms_field_values()
    {        
        $msg='';
        $status=0;
        
        if (isset($_POST['edit_sms_gateway'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_SMS_GATEWAYS);
            }
            
            $sms_gateway_id = $this->input->post('sms_gateway_id');
            
            if ($sms_gateway_id > 0) {
                $sms_gateway_details = $this->base_model->fetch_records_from(TBL_SETTINGS_FIELDS, array('sms_gateway_id'=>$sms_gateway_id));
                
                $sms_gateways = $this->base_model->fetch_records_from(
                    TBL_SMS_GATEWAYS, array('sms_gateway_id'=>$sms_gateway_id)
                );
                 
                if (empty($sms_gateway_details) || empty($sms_gateways)) {
                    $msg .= get_languageword('record_not_found');
                    $status=1;
                    
                    $this->prepare_flashmessage($msg, $status);
                    redirect(URL_SMS_GATEWAYS, REFRESH);
                } else {
                    $this->data['sms_gateway_details']= $sms_gateway_details;
                    
                    $this->data['activemenu']      = "master_settings";
                    $this->data['actv_submenu']  = 'sms_gateways';
        
                    $this->data['pagetitle']   = $sms_gateways[0]->sms_gateway_name; 
                    $this->data['content'] = PAGE_SMS_UPDATE_FIELD_VALUES;
                    $this->_render_page(TEMPLATE_ADMIN, $this->data);
                }
            } else {
                redirect(URL_SMS_GATEWAYS);
            }
            
        } else if (isset($_POST['update_sms_gateway'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_SMS_GATEWAYS);
            }
            
            $field_values  = $this->input->post();
            
            foreach ($field_values as $field_id => $val) {
                $fld_id = explode('_', $field_id);
                
                if (is_array($fld_id) && isset($fld_id[1])) {
                    
                    $data  = array();
                    $data  = array(
                    'field_output_value' => $val,
                    'updated' => date('Y-m-d H:i:s'));
                    $where = array('field_id' => $fld_id[1]);
                    $this->base_model->update_operation($data, TBL_SETTINGS_FIELDS, $where);
                    unset($data, $where);
                }
            }    
            $msg .= get_languageword('details_updated_successfully');
            $status=0;
            
            $this->prepare_flashmessage($msg, $status);
            redirect(URL_SMS_GATEWAYS, REFRESH);    
        } else {
            redirect(URL_SMS_GATEWAYS);
        }
    }
    
    
    
    /**
     * PUSH Notification Settings
     *
     * @return boolean
     **/
    function push_notifications()
    {
        if (isset($_POST['push_notification_settings'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_PUSH_NOTIFICATION_SETTINGS);
            }
            
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules(
                'one_signal_server_api_key', get_languageword('one_signal_server_api_key'), 'required|xss_clean'
            );
            $this->form_validation->set_rules('one_signal_app_id', get_languageword('one_signal_app_id'), 'required|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                
                $data = array();
                $data['one_signal_server_api_key'] = $this->input->post('one_signal_server_api_key');
                $data['one_signal_app_id']            = $this->input->post('one_signal_app_id');
                
                $where = array('id'=>1);
                
                if ($this->base_model->update_operation($data, TBL_SITE_SETTINGS, $where)) {
                    unset($data);
                    $msg  .= get_languageword('details_updated_successfully');
                    $status= 0;
                } else {
                    $msg   .= get_languageword('details_not_updated');
                    $status = 1;
                }
                
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_PUSH_NOTIFICATION_SETTINGS, REFRESH);
            }
        }
        
        $record = array();
        $record =$this->base_model->fetch_records_from(TBL_SITE_SETTINGS);
        if (!empty($record)) { 
            $record = $record[0];
        }
        
        $this->data['record']          = $record;
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = get_languageword('push_notification_settings');
        
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = 'push_notification';
        
        $this->data['content']          = PAGE_PUSH_NOTIFICATION_SETTINGS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * EMAIL TEMPLATES
     *
     * @return array
     **/
    function email_templates()
    {
        if (isset($_POST['edit_template'])) {
            
            $id = $this->input->post('id');
            
            if ($id > 0) {
                $template    = $this->base_model->fetch_records_from(TBL_EMAIL_TEMPLATES, array('id'=>$id));
                
                if (!empty($template)) {
                    $this->data['record']               = $template[0];
                    $this->data['css_js_files']         = array('ckeditor');
                    $this->data['edit_email_template']  = TRUE;
                    $this->data['pagetitle']            = get_languageword('edit_email_template');
                    $this->data['activemenu']           = "master_settings";
                    $this->data['actv_submenu']         = 'email_templates';
                
                    $this->data['content']              = PAGE_EDIT_EMAIL_TEMPLATE;
                } else {
                    redirect(URL_EMAIL_TEMPLATES);
                }
            } else {
                redirect(URL_EMAIL_TEMPLATES);
            }
        } else if (isset($_POST['update_email_template'])) {
            $msg='';
            $status=0;
            
            $id = $this->input->post('id');
            
            if ($id > 0) {
                
                $this->form_validation->set_rules('subject', get_languageword('subject'), 'required|xss_clean');
                $this->form_validation->set_rules('email_template', get_languageword('email_template'), 'required|xss_clean');
            
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                
                if ($this->form_validation->run()==TRUE) {
                    
                    if (DEMO) {
                        $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                        redirect(URL_EMAIL_TEMPLATES);
                    }
            
                    $data = array();
                    $data['subject']         = $this->input->post('subject');
                    $data['email_template'] = $this->input->post('email_template');
                    
                    $where = array('id'=>$id);
                    if ($this->base_model->update_operation($data, TBL_EMAIL_TEMPLATES, $where)) {
                        unset($data);
                        $msg  .= get_languageword('details_updated_successfully');
                        $status= 0;
                    } else {
                        $msg   .= get_languageword('details_not_updated');
                        $status = 1;
                    }
                    
                    $this->prepare_flashmessage($msg, $status);
                    redirect(URL_EMAIL_TEMPLATES, REFRESH);
                }
            } else {
                redirect(URL_EMAIL_TEMPLATES);
            }
        } else {
            $records = array();
            $records = $this->base_model->fetch_records_from(TBL_EMAIL_TEMPLATES);
            $this->data['records']          = $records;
            $this->data['css_js_files']  = array('data_tables');
            $this->data['pagetitle']     = get_languageword('email_templates');
            
            $this->data['activemenu']      = "master_settings";
            $this->data['actv_submenu'] = 'email_templates';
            
            
            $this->data['content']          = PAGE_EMAIL_TEMPLATES;
        }
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * SMS TEMPLATES
     *
     * @return array
     **/
    function sms_templates()
    {
        if (isset($_POST['edit_template'])) {
            
            $sms_template_id = $this->input->post('sms_template_id');
            
            if ($sms_template_id > 0) {
                
                $template    = $this->base_model->fetch_records_from(TBL_SMS_TEMPLATES, array('sms_template_id'=>$sms_template_id));
                
                if (!empty($template)) {
                    
                    $this->data['record']               = $template[0];
                    $this->data['css_js_files']         = array('ckeditor');
                    $this->data['edit_email_template']  = TRUE;
                    $this->data['pagetitle']            = get_languageword('edit_sms_template');
                    
                    $this->data['activemenu']           = "master_settings";
                    $this->data['actv_submenu']         = 'sms_templates';
        
                    $this->data['content']              = PAGE_EDIT_SMS_TEMPLATE;
                } else {
                    redirect(URL_SMS_TEMPLATES);
                }
            } else {
                redirect(URL_SMS_TEMPLATES);
            }
            
        } else if (isset($_POST['update_sms_template'])) {
            
            $msg='';
            $status=0;
            
            $sms_template_id = $this->input->post('sms_template_id');
            
            if ($sms_template_id > 0) {
                
                $this->form_validation->set_rules('subject', get_languageword('subject'), 'required|xss_clean');
                $this->form_validation->set_rules('sms_template', get_languageword('sms_template'), 'required|xss_clean');
            
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                
                if ($this->form_validation->run()==TRUE) {
                    
                    if (DEMO) {
                        $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                        redirect(URL_SMS_TEMPLATES);
                    }
                    
                    $data = array();
                    $data['subject']       = $this->input->post('subject');
                    $data['sms_template'] = $this->input->post('sms_template');
                    
                    $where = array('sms_template_id'=>$sms_template_id);
                    if ($this->base_model->update_operation($data, TBL_SMS_TEMPLATES, $where)) {
                        unset($data);
                        $msg  .= get_languageword('details_updated_successfully');
                        $status= 0;
                    } else {
                        $msg   .= get_languageword('details_not_updated');
                        $status = 1;
                    }
                    
                    $this->prepare_flashmessage($msg, $status);
                    redirect(URL_SMS_TEMPLATES, REFRESH);
                }
            } else {
                redirect(URL_SMS_TEMPLATES);
            }
        } else {
            $records = array();
            $records = $this->base_model->fetch_records_from(TBL_SMS_TEMPLATES);
            $this->data['records']          = $records;
            $this->data['css_js_files']  = array('data_tables');
            $this->data['pagetitle']     = get_languageword('sms_templates');
            
            $this->data['activemenu']      = "master_settings";
            $this->data['actv_submenu']  = 'sms_templates';
            
            $this->data['content']          = PAGE_SMS_TEMPLATES;
        }
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * Social Network Settings
     *
     * @return array
     **/ 
    function social_networks()
    {
        if (isset($_POST['social_networks'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_SOCIAL_NETWORKS);
            }
            
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules(
                'facebook', get_languageword('facebook'), 'xss_clean'
            );
            $this->form_validation->set_rules(
                'twitter', get_languageword('twitter'), 'xss_clean'
            );
            $this->form_validation->set_rules(
                'google_plus', get_languageword('google_plus'), 'xss_clean'
            );
            $this->form_validation->set_rules(
                'linked_in', get_languageword('linked_in'), 'xss_clean'
            );
            $this->form_validation->set_rules(
                'instagram', get_languageword('instagram'), 'xss_clean'
            );
            $this->form_validation->set_rules(
                'pinterest', get_languageword('pinterest'), 'xss_clean'
            );
            $this->form_validation->set_rules(
                'tumblr', get_languageword('tumblr'), 'xss_clean'
            );
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['facebook']           = $this->input->post('facebook');
                $data['twitter']            = $this->input->post('twitter');
                $data['google_plus']        = $this->input->post('google_plus');
                $data['linked_in']          = $this->input->post('linked_in');
                $data['instagram']          = $this->input->post('instagram');
                $data['pinterest']          = $this->input->post('pinterest');
                $data['tumblr']             = $this->input->post('tumblr');
                
                $where = array('id'=>1);
                
                if ($this->base_model->update_operation($data, TBL_SOCIAL_NETWORKS, $where)) {
                    unset($data);
                    $msg  .= get_languageword('details_updated_successfully');
                    $status= 0;
                } else {
                    $msg   .= get_languageword('details_not_updated');
                    $status = 1;
                }
                
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_SOCIAL_NETWORKS, REFRESH);
            }
        }
        
        $record = array();
        $record =$this->base_model->fetch_records_from(TBL_SOCIAL_NETWORKS);
        if (!empty($record)) { 
            $record = $record[0];
        }
        
        $this->data['record']          = $record;
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = get_languageword('social_networks');
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = 'social_networks';
        
        
        $this->data['content']          = PAGE_SOCIAL_NETWORKS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * Change Language
     * @param  [string] $language [description]
     * @return [boolean]           [description]
     */
    function change_language($language = NULL)
    {        
        
        $check_lang_strings_existence = $this->base_model->fetch_records_from('languagewords', array('phrase_for' => 'web'), $language);
        
        
        if (count($check_lang_strings_existence) > 0) {
            
            $data = array();
            $data['site_language'] = $language;
            
            $where=array();
            $where['id']=1;
            if ($this->base_model->update_operation($data, 'site_settings', $where)) {
                unset($data, $where);
                
                $this->prepare_flashmessage(get_languageword('language_successfully_changed_to').' '.ucwords($language), 0);

            } else {

                $this->prepare_flashmessage(get_languageword('language_not_changed_to').' '.ucwords($language), 1);
            }
            
            redirect(URL_ADMIN_INDEX);

        } else {

            $this->prepare_flashmessage(get_languageword('please_update').' '.ucwords($language).' '.get_languageword('language_strings'), 2);
            redirect(URL_LANGUAGE_INDEX);
        }    
    }
    
    
    
    /**
     * PUSHER SETTINGS
     *
     * @return boolean
     **/ 
    function pusher_notifications()
    {
        if (isset($_POST['pusher_notification_settings'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_PUSHER_NOTIFICATION_SETTINGS);
            }
            
            $msg='';
            $status=0;
            
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('pusher_app_id', get_languageword('APP_ID'), 'required|xss_clean');
            $this->form_validation->set_rules('pusher_key', get_languageword('KEY'), 'required|xss_clean');
            $this->form_validation->set_rules('pusher_secret', get_languageword('SECRET'), 'required|xss_clean');
                                                        
            if ($this->form_validation->run()==TRUE) {
                
                $update_data['pusher_app_id']      = $this->input->post('pusher_app_id');
                $update_data['pusher_key']         = $this->input->post('pusher_key');
                $update_data['pusher_secret']      = $this->input->post('pusher_secret');
                
                $where = array('id'=>1);
                if ($this->base_model->update_operation($update_data, TBL_SITE_SETTINGS, $where)) {
                    unset($update_data);
                    $msg  .= get_languageword('details_updated_successfully');
                    $status= 0;
                } else {
                    $msg   .= get_languageword('details_not_updated');
                    $status = 1;
                }
                
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_PUSHER_NOTIFICATION_SETTINGS);
            }
        }
        $record = array();
        $record =$this->base_model->fetch_records_from(TBL_SITE_SETTINGS);
        if (!empty($record)) { 
            $record = $record[0];
        }
        
        $this->data['record']          = $record;
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = get_languageword('pusher_notification_settings');
        
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = 'pusher_notification';
        
        $this->data['content']          = PAGE_PUSHER_NOTIFICATION;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * APP Settings
     *
     * @return page
     **/ 
    function app_settings()
    {
        $this->data['pagetitle']     = get_languageword('app_settings');
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = 'app_settings';
        $this->data['content']          = PAGE_APP_SETTINGS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    
    /**
     * TINIFY SETTINGS
     *
     * @return page
     **/ 
    function tinify_settings()
    {
        if (isset($_POST['tinify_settings'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_TINIFY_SETTINGS);
            }
            
            $msg='';
            $status=0;
            $update_data=array();
            
            if ($this->input->post('use_tinify')==1) {
                $update_data['use_tinify']     = 'Yes';
            } else { 
                $update_data['use_tinify']     = 'No';
            }    
        
        
        
            if ($update_data['use_tinify']=='Yes') {
                
                $update_data['API_Key']         = $this->input->post('API_Key');
            
                if ($this->input->post('compress')==1) {
                    $update_data['compress']     = 'Yes';
                } else {
                    $update_data['compress']     = 'No';
                }    
        
        
                if ($this->input->post('thumb')==1) {
                    $update_data['thumb']     = 'Yes';
                } else {
                    $update_data['thumb']     = 'No';
                }    
        
            
            } else {
                
                $update_data['API_Key']  = NULL;
                $update_data['compress'] = NULL;
                $update_data['thumb']    = NULL;
                
            }
            
            $where = array('id'=>1);
            if ($this->base_model->update_operation($update_data, TBL_TINIFY_SETTINGS, $where)) {
                unset($update_data);
                $msg  .= get_languageword('details_updated_successfully');
                $status= 0;
            } else {
                $msg   .= get_languageword('details_not_updated');
                $status = 1;
            }
            
            $this->prepare_flashmessage($msg, $status);
            redirect(URL_TINIFY_SETTINGS);
        }
        
        $record = array();
        $record =$this->base_model->fetch_records_from(TBL_TINIFY_SETTINGS);
        if (!empty($record)) { 
            $record = $record[0];
        }
        
        $this->data['record']          = $record;
        
        
        $imgs_count=0;
        
        if ($record->API_Key!='') {
            //TINIFY
            $this->load->library('FCTinify');
            $fct = new FCTinify();
            $imgs_count = $fct->tinifyCompressionCount();
        }
        
        $this->data['imgs_count']     = $imgs_count;
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = get_languageword('tinify_settings');
        
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = 'tinify_settings';
        
        $this->data['content']          = 'tinify_settings';
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * SEO SETTINGS
     *
     * @return page
     **/ 
    function seo_settings()
    {
        if (isset($_POST['seo_settings'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_SEO_SETTINGS);
            }
            
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules(
                'meta_keyword', 
                get_languageword('meta_keyword'), 
                'xss_clean'
            );
            $this->form_validation->set_rules(
                'meta_description', 
                get_languageword('meta_description'), 
                'xss_clean'
            );
            $this->form_validation->set_rules(
                'google_analytics', 
                get_languageword('google_analytics'), 
                'xss_clean'
            );
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['meta_keyword']         = $this->input->post('meta_keyword');
                $data['meta_description']     = $this->input->post('meta_description');
                $data['google_analytics']     = $this->input->post('google_analytics');
                
                $where = array('id'=>1);
                
                if ($this->base_model->update_operation($data, TBL_SEO_SETTINGS, $where)) {
                    unset($data);
                    $msg  .= get_languageword('details_updated_successfully');
                    $status= 0;
                } else {
                    $msg   .= get_languageword('details_not_updated');
                    $status = 1;
                }
                
                $this->prepare_flashmessage($msg, $status);
                redirect(URL_SEO_SETTINGS, REFRESH);
            }
        }
        
        $record = array();
        $record =$this->base_model->fetch_records_from(TBL_SEO_SETTINGS);
        if (!empty($record)) { 
            $record = $record[0];
        }
        
        
        $this->data['record']          = $record;
        $this->data['pagetitle']     = get_languageword('seo_settings');
        $this->data['activemenu']      = "master_settings";
        $this->data['actv_submenu']  = 'seo_settings';
        $this->data['content']          = 'seo_settings';
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
}