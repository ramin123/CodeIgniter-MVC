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
 * @category  Auth
 * @package   Menorah Restaurant
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Auth Class
 * 
 * Authentication operations.
 *
 * @category  Auth
 * @package   Menorah Restaurant
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Auth extends MY_Controller
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
    | MODULE:           AUTH CONTROLLER
    | -----------------------------------------------------
    | This is Auth module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        
    }

    /**
     * REDIRECT RESPECTIVE USER PANEL
     *
     * @return boolean 
     **/ 
    function index()
    {
        if ($this->ion_auth->logged_in()) {
            
            if ($this->ion_auth->is_admin()) {
                redirect(URL_ADMIN_INDEX);
            } else if ($this->ion_auth->is_member()) {

                if (!empty($this->cart->contents())) {
                    redirect(URL_CART_INDEX);
                } else {
                    redirect(URL_MENU);
                }
            } else if ($this->ion_auth->is_kitchen_manager()) {
                redirect(URL_KITCHEN_MANAGER);
            } else if ($this->ion_auth->is_delivery_manager()) {
                redirect(URL_DELIVERY_MANAGER);
            } else {
                redirect(SITEURL);
            }
        } else {
            redirect(SITEURL);
        }
    }
    
    /**
     * LOGIN
     *
     * @return boolean 
     **/
    function login()
    {
        if ($this->ion_auth->logged_in()) {
            redirect(URL_AUTH_INDEX);
        }
            
        if (isset($_POST['login'])) {
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('email', get_languageword('email'), 'required|xss_clean');
            $this->form_validation->set_rules('password', get_languageword('password'), 'required|xss_clean');

            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                
                if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'))) {
                    $msg .= get_languageword('logged_in_successfully');
                    $status = 0;
                    
                    $this->prepare_flashmessage($msg, $status);
                    
                    redirect(URL_AUTH_INDEX);
                } else {
                    $msg .= $this->ion_auth->errors();
                    $status = 1;
                    
                    $this->session->set_userdata(array('loginup'=>TRUE));
                    
                    $this->prepare_flashmessage($msg, $status);
                    redirect(SITEURL);
                }
                
            }
        } else {
            
            redirect(SITEURL);
        }
    }
    
    /**
     * REGISTER
     *
     * @return boolean 
     **/
    function register()
    {
        if ($this->ion_auth->logged_in()) {
            redirect(SITEURL);
        }
        
        if (isset($_POST['register'])) {

           
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_WELCOME_INDEX);
            }
            
            $msg='';
            $status=0;
            
            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            
            $this->form_validation->set_rules('first_name', get_languageword('first_name'), 'required|xss_clean');
            $this->form_validation->set_rules('last_name', get_languageword('last_name'), 'required|xss_clean');
            $this->form_validation->set_rules('email', get_languageword('email'), 'required|is_unique['.$tables['users'].'.'.$identity_column.']|xss_clean');
            $this->form_validation->set_rules('phone', get_languageword('phone'), 'required|xss_clean');
            
            
            $this->form_validation->set_rules('password', get_languageword('password'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
            
            /*$this->form_validation->set_rules('password',get_languageword('password'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[confirm_password]');
			
            $this->form_validation->set_rules('confirm_password', get_languageword('confirm_password'), 'required'); */

            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                //check loyality points
                
                //refer points - when account activated
                
                $email        = strtolower($this->input->post('email'));
                $identity     = ($identity_column==='email') ? $email : $this->input->post('email');
                $password     = $this->input->post('password');
                $additional_data = array();
                
                //Prepare User related data
                $first_name = $this->input->post('first_name');
                $last_name  = $this->input->post('last_name');
                $username   = $first_name.' '.$last_name;

                $referral_code = $this->randomString(10);
                
                $additional_data = array(
                'username' => $username,
                'referral_code' => $referral_code,
                'first_name'     => $first_name,
                'last_name'      => $last_name,
                'phone'           => $this->input->post('phone'),
                'email'         => $this->input->post('email'),
                'registration_through'=>'portal',
                'registration_type'=>'normal',
                'created_datetime'=> date('Y-m-d H:i:s')
                );
                
                if ($this->input->post('referral_code') != '') {
                    $refer_by = $this->input->post('referral_code');
                    $refer_by_user = $this->base_model->get_query_result("select id from ".TBL_PREFIX.TBL_USERS." where referral_code='".$refer_by."' and active=1");
                    
                    if (!empty($refer_by_user)) {
                        $refer_by_user = $refer_by_user[0];
                        $additional_data['refer_by'] = $refer_by_user->id;
                        $additional_data['refer_by_code'] = $refer_by;
                    } else {

                        $msg .= " No user found with the referral code ".$referral_code;
                    }
                }
                
                $groups = array(2);
                
                $id = $this->ion_auth->register($identity, $password, $email, $additional_data, $groups);
                
                if ($id) {
                    $msg .= get_languageword($this->ion_auth->messages());
                    $status=0;
                    
                    $this->session->set_userdata(array('loginup'=>TRUE));
                } else {
                    $msg .= $this->ion_auth->errors();    
                    $status=1;
                    
                    $this->session->set_userdata(array('signup_popup'=>TRUE));
                }
                $this->prepare_flashmessage($msg, $status);
                redirect(SITEURL);

            } else {

                $this->session->set_userdata(array('signup_popup'=>TRUE));
                $status=1;
                $msg .= strip_tags(validation_errors());  
                $this->prepare_flashmessage($msg, $status);
                redirect(SITEURL);
            }
        } else {
            redirect(SITEURL);
        }
    }
    
    /**
     * 
     * Logout from application
     * 
     *
     * @param string $from_accnt 
     *
     * @return boolean
     */
    function logout($from_accnt='')
    {
        $logout = $this->ion_auth->logout();

        
        if ($from_accnt != '' && $from_accnt=='password') {
            $this->prepare_flashmessage(get_languageword('logged_out_successfully').'<br>'.get_languageword('password_changed_successfully'), 0);
        } else {
            $this->prepare_flashmessage(get_languageword('logged_out_successfully'), 0);
        }
        
        // redirect them to the login page
        redirect(SITEURL, REFRESH);
    }
    
    /**
     * FORGOT PASSWORD
     *
     * @return boolean 
     **/    
    function forgot_password()
    {
        if ($this->ion_auth->logged_in()) {
            redirect(SITEURL);
        }
        
        // setting validation rules by checking wheather identity is username or email
        if (isset($_POST['forgot_pwd'])) {
            if ($this->config->item('identity', 'ion_auth') == 'username') {
                $this->form_validation->set_rules('email', $this->lang->line('forgot_password_username_identity_label'), 'required|xss_clean');
            } else {
                $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email|xss_clean');
            }

            if ($this->form_validation->run() == TRUE) {
                
               
                if (DEMO) {
                    $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                    redirect(URL_WELCOME_INDEX);
                }
            
                // get identity from username or email
                if ($this->config->item('identity', 'ion_auth') == 'username') {
                    $identity = $this->ion_auth->where('username', strtolower($this->input->post('email')))->users()->row();
                } else {
                    $identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
                }
                
                $this->session->set_userdata(array('forgtup'=>TRUE));
                
                if (empty($identity)) {
                    if ($this->config->item('identity', 'ion_auth') == 'username') {
                        $this->prepare_flashmessage($this->ion_auth->set_message('forgot_password_username_not_found'), 1);
                        
                    } else {
                        $this->prepare_flashmessage($this->ion_auth->set_message('forgot_password_email_not_found'), 1);
                    }

                    $this->prepare_flashmessage($this->ion_auth->messages(), 1);
                    redirect(SITEURL);
                }

                // run the forgotten password method to email an activation code to the user

                $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth') });
                if ($forgotten) {
                    // if there were no errors
                    $this->prepare_flashmessage($this->ion_auth->messages(), 0);
                    redirect(SITEURL); //we should display a confirmation page here instead of the login page
                } else {
                    $this->prepare_flashmessage(strip_tags($this->ion_auth->errors()), 1);
                    redirect(SITEURL);
                }
            }
        } else {
            redirect(SITEURL);
        }
    }
    
    /**
     * 
     * RESET PASSWORD
     *
     * @param string $code 
     *
     * @return boolean
     */     
    function reset_password($code = NULL)
    {
        if (!$code) {
            show_404();
        }

        $code = str_replace('_', '-', $code);

        $user = $this->ion_auth->forgotten_password_check($code);
        
        
        if ($user) {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new_password', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required|xss_clean');

            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            if ($this->form_validation->run() == FALSE) {
                
                // display the form

                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? $this->prepare_message(validation_errors(), 1) : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                
                $this->data['new_password'] = array(
                'name' => 'new_password',
                'id'   => 'new_password',
                'class'  => 'form-control',
                'type' => 'password',
                // 'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                'placeholder'=> get_languageword('password'),
                'value'    => $this->form_validation->set_value('new_password')
                );
                $this->data['new_password_confirm'] = array(
                'name'    => 'new_confirm',
                'id'      => 'new_confirm',
                'class'  => 'form-control',
                'type'    => 'password',
                // 'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                'placeholder'=> get_languageword('confirm_password'),
                'value'    => $this->form_validation->set_value('new_confirm')
                );
                $this->data['user_id'] = array(
                'name'  => 'user_id',
                'id'    => 'user_id',
                'type'  => 'hidden',
                'value' => $user->id,
                );
                
                
                $this->data['activemenu'] = 'home';
                $this->data['css_js_files']  = array('form_validation');
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;
                $this->data['pagetitle'] = get_languageword('reset_password');
                $this->data['content'] = 'reset_password';
                $this->_render_page(getTemplate(), $this->data);
            } else {
                // do we have a valid request?
                //$this->_valid_csrf_nonce() === FALSE ||
                $posted_data = $this->input->post();
                if ($user->id != $posted_data['user_id']['value']) {
                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));

                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new_password'));

                    if ($change) {
                        
                        $this->session->set_userdata(array('loginup'=>TRUE));        
                        // if the password was successfully changed
                        $this->prepare_flashmessage($this->ion_auth->messages(), 0);
                        redirect(SITEURL, 'refresh');
                    } else {
                        $this->prepare_flashmessage($this->ion_auth->errors(), 1);
                        redirect(URL_RESET_PASSWORD.DS.$code);
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->prepare_flashmessage($this->ion_auth->errors(), 1);
            redirect(SITEURL, REFRESH);
        }
    }
    
     /**
     * ACTIVATE USER ACCOUNT
     *
     * @param       int    $id            Input int
     * @param       string $code          Input string
     * @param       string $refer_by_code Input string
     * @return      boolean
     */
    function activate($id, $code,$refer_by_code=NULL)
    {
        if (empty($id) || empty($code)) {
            $this->prepare_flashmessage(get_languageword('wrong_opeartion'), 1);
            $this->session->set_userdata(array('loginup'=>TRUE));
            redirect(SITEURL, REFRESH);
        }
        
        $user=getUserRec($id);
        $group = $this->ion_auth->get_users_groups($user->id)->result();
        
        if ($user->is_activated=='No' && $group[0]->id==2) {
            //loyality points
            $point_settings = $this->config->item('point_settings');
            if (!empty($point_settings) && $point_settings->points_enabled=='Yes' && $point_settings->reward_points_for_account_signup > 0) {
                $data = array();
                $data['user_id']             = $id;
                $data['points']                 = $point_settings->reward_points_for_account_signup;
                $data['transaction_type']     = 'Earned';
                $data['description']        = get_languageword('points_for_registration');
                $data['created_on'] = date('Y-m-d H:i:s');
                
                if ($this->base_model->insert_operation($data, TBL_USER_POINTS)) {
                    unset($data);
                    $data = array();
                    $data['user_points'] = $user->user_points + $point_settings->reward_points_for_account_signup;
                    $this->base_model->update_operation($data, TBL_USERS, array('id'=>$id));
                    unset($data);
                }
            }
            
            
            //refer system
            if (!empty($refer_by_code)) {
                $refer_by_user=$this->base_model->fetch_records_from(TBL_USERS, array('referral_code'=>$refer_by_code,'active'=>1));
                
                if (!empty($refer_by_user)) {
                    $refer_by_user = $refer_by_user[0];
                    
                    //check refer settings
                    //add points to both users(users+user_points)
                    //add referral_users table record
                    //account signup - loyality points
                    
                    $refer_settings = $this->config->item('referral_settings');
                    if (!empty($refer_settings) && $refer_settings->referral_enabled=='Yes') {
                        //referral users table
                        $data = array();
                        $data['refer_user_id']         = $id;
                        $data['refer_user_points']     = $refer_settings->points_for_referred_by_anyone;
                        $data['refer_by']             = $refer_by_user->id;
                        $data['refer_by_points']     = $refer_settings->points_for_refer_anyone;
                        $data['datetime'] = date('Y-m-d H:i:s');

                        if ($this->base_model->insert_operation($data, TBL_REFERRAL_USERS)) {
                            unset($data);
                            
                            //refer any one user_points table
                            $data = array();
                            $data['user_id'] = $refer_by_user->id;
                            $data['points']  = $refer_settings->points_for_refer_anyone;
                            $data['transaction_type']     = 'Earned';
                            $data['description']        = get_languageword('points_for_referred_user');
                            $data['created_on']     = date('Y-m-d H:i:s');
                            
                            if ($this->base_model->insert_operation($data, TBL_USER_POINTS)) {
                                unset($data);
                                //refer any one users table
                                $data = array();
                                $data['user_points'] = $refer_by_user->user_points + $refer_settings->points_for_refer_anyone;
                                $this->base_model->update_operation($data, TBL_USERS, array('id'=>$refer_by_user->id));
                                unset($data);
                            }
                            
                            
                            //refer by user_points table
                            $data = array();
                            $data['user_id'] = $id;
                            $data['points']  = $refer_settings->points_for_referred_by_anyone;
                            $data['transaction_type']     = 'Earned';
                            $data['description']        = get_languageword('points_for_referred_by_user');
                            $data['created_on']     = date('Y-m-d H:i:s');
                            if ($this->base_model->insert_operation($data, TBL_USER_POINTS)) {
                                unset($data);
                                $user=getUserRec($id);
                                //refer by users table
                                $data = array();
                                $data['user_points'] = $user->user_points + $refer_settings->points_for_referred_by_anyone;
                                $this->base_model->update_operation($data, TBL_USERS, array('id'=>$id));
                                unset($data);
                            }
                            
                        }
                    }
                }
            }
            
        }
            
        unset($data);
        
        $data = array();
        $data = array(
        'activation_code' => NULL,
        'active'          => 1,
        'is_activated' => 'Yes'
        );
        
        if ($this->db->update(TBL_USERS, $data, array('id'=>$id))) {
        
            $this->prepare_flashmessage(get_languageword('your_account_activated_successfully_please_login'), 0);
            $this->session->set_userdata(array('loginup'=>TRUE));
            redirect(SITEURL, REFRESH);
        
        } else {
            
            $this->prepare_flashmessage(get_languageword('account_not_activated_please_contact_administrator'), 1);
            $this->session->set_userdata(array('loginup'=>TRUE));
            redirect(SITEURL, REFRESH);
        }
        
    }
    
    /**
     * DE-ACTIVE USER ACCOUNT
     *
     * @param       int $id 
     * @return      boolean
     */      
    function deactivate($id = NULL)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $id = (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();
            $this->data['content'] = 'auth/deactivate_user';
            $this->_render_page('template/front-template', $this->data);
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            // redirect them back to the auth page
            redirect(SITEURL);
        }
    }
    
    /**
     * CSRF Token
     *
     * @return key 
     **/ 
    function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }
    
    /**
     * Valid csrf nonce
     *
     * @return boolean 
     **/ 
    function _valid_csrf_nonce()
    {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE 
            && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')
        ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * VALIDATION METHOD
     *
     * CHECKING DUPLICATE ACCOUNT
     *
     * @return boolean 
     **/ 
    public function check_duplicate_email()
    {
        $valid = $this->base_model->check_email($this->input->post('email'));
        if ($valid) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
    
    /**
     * VALIDATION METHOD
     * CHECKING REFERRAL USER
     *
     * @return boolean 
     **/     
    public function check_referral_code()
    {
        if ($this->input->post('referral_code') != '') {
            $valid = $this->base_model->check_referral_code($this->input->post('referral_code'));
            if ($valid) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            echo 'true';
        }
    }
}