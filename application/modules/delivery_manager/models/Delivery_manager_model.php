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
 * @category  Deliverymanagermodel
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Delivery_manager_model
 * 
 * Delivery_manager_model operations.
 *
 * @category  Deliverymanagermodel
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Delivery_manager_model extends CI_Model {
	
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
    | MODULE:           Delivery_Manager_Model
    | -----------------------------------------------------
    | This is Delivery_Manager_Model file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        
        parent::__construct();
        $this->load->database();
    }
	
    /**
     * GET ORDERS COUNT 
     * 
     *
     * @return int
     **/ 
	function get_orders_count()
	{
		$user_id = $this->ion_auth->get_user_id();
		$query="select * from ".TBL_PREFIX.TBL_ORDERS." where dm_id=".$user_id."";
		$orders = $this->db->query($query)->result();
		return count($orders);
	}
}
