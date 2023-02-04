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
 * @category  My404
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter 404 Class
 * 
 * 404 operations.
 *
 * @category  My404
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class My404 extends MY_Controller
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
    | MODULE:           AUTH CONTROLLER
    | -----------------------------------------------------
    | This is Auth module controller file.
    | -----------------------------------------------------
     **/
	function __construct()
 {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->library(array('ion_auth','form_validation'));
	}
	
	/**
     * [index description]
     * @return [type] [description]
     */
	function index() 
 { 
    	$this->data['pagetitle'] 	= '404 Page Not Found';
    	$this->data['content'] 		= 'error_404';
    	$this->_render_page(getTemplate(), $this->data);
 } 
}
