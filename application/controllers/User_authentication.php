<?php 
/**
 * Restaurant-Conquerors Market
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, Conquerors Market
 *
 * @category  Userauthentication
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter User_authentication Class
 * 
 * Userauthentication.
 *
 * @category  Userauthentication
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class User_authentication extends MY_Controller
{
    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     RESTAURANT
    | -----------------------------------------------------
    | AUTHOR:           CONQUERORS MARKET
    | -----------------------------------------------------
    | EMAIL:            conquerorsmarket@gmail.com
    | -----------------------------------------------------
    | COPYRIGHTS:       RESERVED BY CONQUERORS MARKET
    | -----------------------------------------------------      
    | http://codecanyon.net/user/conquerorsmarket
    | http://conquerorstech.net/
    | -----------------------------------------------------
    |
    | MODULE:           User_authentication CONTROLLER
    | -----------------------------------------------------
    | This is User_authentication module controller file.
    | -----------------------------------------------------
     **/
    function __construct() 
    {
        parent::__construct();
        // Load user model
        $this->load->model('user');
    }
    
    /**
     * Google signup
     *
     * @return boolean
     **/
    public function index() 
    {
        // Include the google api php libraries
        include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
        include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
        
        // Google Project API Credentials
        $clientId = $this->config->item('site_settings')->google_client_id;
        $clientSecret = $this->config->item('site_settings')->google_client_secret;
        $redirectUrl = base_url().'user_authentication/';
        // echo $clientId; die();
        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to Menorah Restaurant');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setScopes('email');
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_REQUEST['code'])) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');
        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }

        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();

            if (!empty($userProfile)) {

                /* check whether user is already registered or not
                // if not registered save the details in database 
                // else directly login him */
                
                
                // Preparing data for database insertion
                $userData['name'] = $userProfile['name'];
                $userData['oauth_provider'] = 'google';
                $userData['first_name'] = $userProfile['given_name'];
                $userData['last_name'] = $userProfile['family_name'];
                $userData['email'] = $userProfile['email'];

                if (isset($userProfile['gender']))
                $userData['gender'] = $userProfile['gender'];

              
                $userData['profile_url'] = $userProfile['link'];
                $userData['picture_url'] = $userProfile['picture'];
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                if (!empty($userID)) {
                   
                    $password   = random_string('alnum', 5);
                    if ($this->ion_auth->login($userProfile['email'], $password, 1, TRUE)) {
                    
                        $this->prepare_flashmessage('Logged in Successfully', 0);
                    
                        if ($this->ion_auth->is_member()) {
                            redirect(SITEURL, REFRESH);
                        } else {
                            redirect(SITEURL, REFRESH); 
                        }
                    } else {
                        $this->prepare_flashmessage($this->ion_auth->errors(), 1);
                        $this->session->set_userdata('login_error', 'yes');
                    
                        $this->session->set_userdata(array('loginup'=>TRUE));
                        redirect(SITEURL, REFRESH);  

                    }
                    //
                                      
                } else {
                    $this->prepare_flashmessage("Unable to login", 1);
                    $this->session->set_userdata('login_error', 'yes');
                   
                    $this->session->set_userdata(array('loginup'=>TRUE));
                    redirect(SITEURL, REFRESH);
                    
                }
               
                
            } else {
                // if not data is there 
                $this->prepare_flashmessage("Unable to login", 1);
                $this->session->set_userdata('login_error', 'yes');
                
                $this->session->set_userdata(array('loginup'=>TRUE));
                    redirect(SITEURL, REFRESH);
                
            }
            
        } else {
            $this->prepare_flashmessage("Unable to login", 1);
            $this->session->set_userdata('login_error', 'yes');
            
            $this->session->set_userdata(array('loginup'=>TRUE));
            redirect(SITEURL, REFRESH);
        }
        redirect(SITEURL);
    }
    
    /**
     * Logout
     *
     * @return boolean
     **/ 
    public function logout() 
    {
        
        $this->session->unset_userdata('token');
        $this->session->unset_userdata('userData');
        $this->session->sess_destroy();
        redirect('/user_authentication');
    }
}
