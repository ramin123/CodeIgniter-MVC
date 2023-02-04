<?php
/**
 * Menorah Restaurant-DIGIMSAMARITAN
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, DIGIMSAMARITAN
 *
 * @category  Adminmodel
 * @package   Menorah Restaurant
 * @author    DIGIMSAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGIMSAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Admin Model
 * 
 * Admin Model operations.
 *
 * @category  Adminmodel
 * @package   Menorah Restaurant
 * @author    DIGIMSAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGIMSAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Admin_model extends CI_Model
{
    
    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     Menorah Restaurant
    | -----------------------------------------------------
    | AUTHOR:           DIGIMSAMARITAN
    | -----------------------------------------------------
    | EMAIL:            digisamaritan@gmail.com
    | -----------------------------------------------------
    | COPYRIGHTS:       RESERVED BY DIGIMSAMARITAN
    | -----------------------------------------------------      
    | http://codecanyon.net/user/digisamaritan
    | http://conquerorstech.net/
    | -----------------------------------------------------
    |
    | MODULE:           Admin_model Model
    | -----------------------------------------------------
    | This is Admin_model Model file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Fetch records count of modules
     *
     * @return array
     **/ 
    function get_modules_count()
    {
        $data = array();
        
        $query="select * from ".TBL_PREFIX.TBL_MENU." ";
        $menus = $this->db->query($query)->result();
        $data['menu_count'] = count($menus);
        
        $query="select * from ".TBL_PREFIX.TBL_ITEMS." ";
        $items = $this->db->query($query)->result();
        $data['items_count'] = count($items);
        
        
        $query="select * from ".TBL_PREFIX.TBL_ADDONS." ";
        $addons = $this->db->query($query)->result();
        $data['addons_count'] = count($addons);
        
        $query="select * from ".TBL_PREFIX.TBL_OPTIONS." ";
        $options = $this->db->query($query)->result();
        $data['options_count'] = count($options);
        
        
        $query="select * from ".TBL_PREFIX.TBL_OFFERS." ";
        $offers = $this->db->query($query)->result();
        $data['offers_count'] = count($offers);
        
        
        $query="select u.id from ".TBL_PREFIX.TBL_USERS." u inner join ".TBL_PREFIX.TBL_USERS_GROUPS." ug on u.id=ug.user_id where ug.group_id=2";
        $users = $this->db->query($query)->result();
        $data['users_count'] = count($users);
        
        
        $query="select * from ".TBL_PREFIX.TBL_ORDERS." where status='new'";
        $orders = $this->db->query($query)->result();
        $data['orders_count'] = count($orders);
        
        
        return $data;
    }
}