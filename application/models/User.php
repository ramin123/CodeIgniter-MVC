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
 * @category  Usermodel
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */  
if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Basemodel
 * 
 * Usermodel operations.
 *
 * @category  Usermodel
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class User extends CI_Model
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
    | MODULE:           USER MODEL
    | -----------------------------------------------------
    | This is USER MODEL file.
    | -----------------------------------------------------
     **/
	function __construct() 
	{
		$this->tableName = 'users';
		$this->primaryKey = 'id';
		// $this->load->helper(array('url','language','date','string'));
	}

	/**
	 * [checkUser description]
	 * @param  array $data [description]
	 * @return [type]       [description]
	 */
	public function checkUser($data = array())
	{
		$this->db->select($this->primaryKey);
		$this->db->from($this->db->dbprefix($this->tableName));
		$this->db->where(array('email'=>$data['email']));
		$prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();
		
		if($prevCheck > 0)
		{
			$prevResult = $prevQuery->row_array();
			$userID = $prevResult['id'];
		}
		else
		{
			$referral_code = $this->randomString(10);
			
			$username 	= $data['name'];
			$password 	= random_string('alnum', 5);
			$email 		= $data['email']; 
			$additional_data = array(
					'first_name' 			=> $data['first_name'],
					'last_name'  			=> $data['last_name'],
					'username'				=> $data['first_name'].' '.$data['last_name'],
					'phone'  			    => '',
					'referral_code' 		=> $referral_code,
					'registration_through'	=> 'portal',
					'registration_type'  	=> $data['oauth_provider'],
					'created_datetime'  	=> date('Y-m-d H:i:s')
					);
			$group = array(2);
			$registered_by = $data['oauth_provider'];
			
			$userID = $this->ion_auth->register($username, $password, $email, $additional_data, $group, $registered_by);
		}
		return $userID?$userID:FALSE;
 }
	

	/**
	 * [randomString description]
	 * @param  integer $length [description]
	 * @return [type]          [description]
	 */
	function randomString($length = 6)
	{
		$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'0123456789';

		$str = '';

		$max = strlen($chars) - 1;


		for ($i=0; $i < $length; $i++)

		  $str .= $chars[rand(0, $max)];

		return $str;
 }
}
