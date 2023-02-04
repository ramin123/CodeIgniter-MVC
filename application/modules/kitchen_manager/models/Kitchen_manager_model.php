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
 * @category  Kitchenmanagermodel
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Kitchen_Manager_Model
 * 
 * Kitchen_Manager_Model operations.
 *
 * @category  Kitchenmanagermodel
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Kitchen_manager_model extends CI_Model {
	
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
    | MODULE:           Kitchen_Manager_Model
    | -----------------------------------------------------
    | This is Kitchen_Manager_Model file.
    | -----------------------------------------------------
     **/
	function __construct()
 {
		
		parent::__construct();
		$this->load->database();
	}
	
    /**
     *  
     * Fetch orders count
     *
     * @return int
     **/  
	function get_orders_count()
	{
		$user_id = $this->ion_auth->get_user_id();
		$query="select * from ".TBL_PREFIX.TBL_ORDERS." where km_id=".$user_id."";
		$orders = $this->db->query($query)->result();
	
		return count($orders);
	}
}
