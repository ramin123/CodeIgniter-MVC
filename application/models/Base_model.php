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
 * @category  Basemodel
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */ 
if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Basemodel
 * 
 * Basemodel operations.
 *
 * @category  Basemodel
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Base_Model extends CI_Model  
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
    | MODULE:           BASE MODEL
    | -----------------------------------------------------
    | This is BASE MODEL file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
		parent::__construct();
		$this->load->model('crunchy_model');
    }

    /**
     * QUERY RUN METHOD
     * @param  [string] $query [description]
     * @return [array]        [description]
     */
	function run_query( $query )
	{
		$rs = $this->db->query( $query );
		return $rs or die ('Error:' . mysql_error());
	}


	/**
	 * [get_query_result description]
	 * @param  [string] $query [description]
	 * @return [array]        [description]
	 */
	function get_query_result( $query )
	{
		return($this->db->query($query)->result());
	}


	/**
	 * [get_query_row description]
	 * @param  [string] $query [description]
	 * @return [array]        [description]
	 */
    function get_query_row( $query )
    {
		return($this->db->query($query)->row());
    }


	/**
	 * [count_records description]
	 * @param  [type] $table     [description]
	 * @param  string $condition [description]
	 * @return [type]            [description]
	 */
	function count_records( $table, $condition = '' )
	{
		if( !(empty($condition)) )
		$this->db->where( $condition );
		$this->db->from( $this->db->dbprefix( $table ) );
		$reocrds = $this->db->count_all_results();
		//echo $this->db->last_query();
		
		return $reocrds;
	}


	/**
	 * [insert_operation description]
	 * @param  [type] $inputdata [description]
	 * @param  [type] $table     [description]
	 * @return [type]            [description]
	 */
    function insert_operation( $inputdata, $table)
    {
		$result  = $this->db->insert($this->db->dbprefix($table), $inputdata);
		return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }


	/**
	 * [insert_operation_id description]
	 * @param  [type] $inputdata [description]
	 * @param  [type] $table     [description]
	 * @param  string $email     [description]
	 * @return [type]            [description]
	 */
    function insert_operation_id($inputdata, $table, $email = '')
    {
        $result = $this->db->insert($this->db->dbprefix($table), $inputdata);
        return $this->db->insert_id();
    }


    /**
     * [update_operation description]
     * @param  [type] $inputdata [description]
     * @param  [type] $table     [description]
     * @param  [type] $where     [description]
     * @return [type]            [description]
     */
	function update_operation( $inputdata, $table, $where )
	{
		$result  = $this->db->update($this->db->dbprefix($table), $inputdata, $where);
		return $result;
	}


	/**
	 * [update_operation_in description]
	 * @param  [type] $inputdata [description]
	 * @param  [type] $table     [description]
	 * @param  [type] $column    [description]
	 * @param  [type] $values    [description]
	 * @return [type]            [description]
	 */
    function update_operation_in( $inputdata, $table, $column, $values )
    {
		$this->db->where_in($column, $values);
		$result  = $this->db->update($this->db->dbprefix($table), $inputdata);
		return $result;
    }


	/**
	 * [fetch_records_from description]
	 * @param  [type] $table     [description]
	 * @param  string $condition [description]
	 * @param  string $select    [description]
	 * @param  string $order_by  [description]
	 * @param  string $like      [description]
	 * @param  string $offset    [description]
	 * @param  string $perpage   [description]
	 * @return [type]            [description]
	 */
    function fetch_records_from( $table, $condition = '',$select = '*', $order_by = '', $like = '', $offset = '', $perpage = '' )
    {
		$this->db->start_cache();
			$this->db->select($select, FALSE);
			$this->db->from( $this->db->dbprefix( $table ) );
			if( !empty( $condition ) )
				$this->db->where( $condition );
			if( !empty( $like ) )
					$this->db->like( $like );
			if( !empty( $order_by ) )
				$this->db->order_by( $order_by );
		$this->db->stop_cache();
		$result = $this->db->get();
		$this->numrows = $this->db->affected_rows();
     
		if( $perpage != '' )
		$this->db->limit($perpage, $offset);
	
		$result = $this->db->get();
		
		$this->db->flush_cache();
		return $result->result();
    }


	/**
	 * [fetch_records_from_in description]
	 * @param  [type] $table    [description]
	 * @param  [type] $column   [description]
	 * @param  [type] $value    [description]
	 * @param  string $select   [description]
	 * @param  string $order_by [description]
	 * @param  string $like     [description]
	 * @return [type]           [description]
	 */
    function fetch_records_from_in($table, $column, $value, $select = '*', $order_by = '', $like = '')
    {
		$this->db->start_cache();
			$this->db->select($select, FALSE);
			$this->db->from( $this->db->dbprefix( $table ) );
			$this->db->where_in( $column, $value );
			if( !empty( $like ) )
					$this->db->like( $like );
			if( !empty( $order_by ) )
				$this->db->order_by( $order_by );
		$this->db->stop_cache();    
		$this->numrows = $this->db->count_all_results();
		
		$result = $this->db->get();
		$this->db->flush_cache();
		return $result->result();
    }


	/**
	 * [fetch_value description]
	 * @param  [type] $table  [description]
	 * @param  [type] $column [description]
	 * @param  [type] $where  [description]
	 * @return [type]         [description]
	 */
    function fetch_value($table, $column, $where)
    {
		$this->db->select($column, FALSE);
		$this->db->from( $this->db->dbprefix( $table ) );
		$this->db->where( $where );
		$this->db->limit(0, 1);
		$result = $this->db->get()->result();
		$str = '-';
		if(count($result))
		{
			foreach($result as $row)
			{
				$str = $row->$column;
			}
		}
		return $str;
    }


	/**
	 * [changestatus description]
	 * @param  [type] $table     [description]
	 * @param  [type] $inputdata [description]
	 * @param  [type] $where     [description]
	 * @return [type]            [description]
	 */
    function changestatus( $table, $inputdata, $where  )
    {
		$result = $this->db->update($this->db->dbprefix($table), $inputdata, $where);
		return $result;
    }


	/**
	 * [changestatus_multiple_recs description]
	 * @param  [type] $table     [description]
	 * @param  [type] $inputdata [description]
	 * @param  [type] $column    [description]
	 * @param  [type] $ids       [description]
	 * @return [type]            [description]
	 */
	function changestatus_multiple_recs( $table, $inputdata, $column, $ids )
	{
		$result = $this->db->where_in($column, $ids)->update($this->db->dbprefix($table), $inputdata);
		return $result;
	}


	/**
	 * [delete_record description]
	 * @param  [type] $table  [description]
	 * @param  [type] $column [description]
	 * @param  [type] $ids    [description]
	 * @return [type]         [description]
	 */
    function delete_record($table, $column, $ids)
    {	
		$this->db->where_in($column, $ids);
		$result = $this->db->delete( $table );
		return $result;
    }


	/**
	 * [delete_record_new description]
	 * @param  [type] $table     [description]
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
    function delete_record_new($table, $condition)
    {
		$this->db->where($condition);
		$result = $this->db->delete( $table );
		return $result;
    }


	/**
	 * [get_user_details description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
    function get_user_details($id)
    {
		$query = 'SELECT u.*,g.name group_name, g.id group_id FROM '.$this->db->dbprefix('users').' u INNER JOIN '.$this->db->dbprefix('users_groups').' ug ON u.id = ug.user_id INNER JOIN '.$this->db->dbprefix('groups').' g ON g.id = ug.group_id WHERE u.id = '.$id;
		return $this->db->query($query)->result();
    }

    /**
     * [_get_datatables_query description]
     * @param  [type] $table     [description]
     * @param  array  $condition [description]
     * @param  array  $columns   [description]
     * @param  array  $order     [description]
     * @return [type]            [description]
     */
	private function _get_datatables_query($table, $condition = array(), $columns = array(), $order = array())
	{		
		
		$this->db->start_cache();
		
		$this->db->select($columns);
		$this->db->from($table);
		$this->db->group_start();
		if(!empty($condition))
		{
			if(isset($condition['incondition']))
			{
				$this->db->where_in($condition['incondition']['name'], $condition['incondition']['hey_stack']);
				unset($condition['incondition']);
				$this->db->where( $condition );
			}
			else
			{
				$this->db->where( $condition );
			}
		}
		$this->db->group_end();
		
		if($_POST['search']['value'])
		$this->db->group_start();
			$i = 0;
			$column = array();			
			foreach ($columns as $item) 
			{
				if($_POST['search']['value'])
					($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
				$column[$i] = $item;
				$i++;
			}			
		if($_POST['search']['value'])
		$this->db->group_end();
	
		//Colums Searching Start
		$column_search = FALSE;
		$p = 0;
		foreach ($columns as $item) 
		{
			if(isset($_POST['columns'][$p]['search']['value']) && $_POST['columns'][$p]['search']['value'] != '') $column_search = TRUE;
			$p++;
		}
		if($column_search == TRUE)
		{
			$this->db->group_start();
			$p = 0;		
			foreach ($columns as $item) 
			{
			if(isset($_POST['columns'][$p]['search']['value']) && $_POST['columns'][$p]['search']['value'] != '')
			$this->db->where($item, $this->getStringBetween(urldecode($_POST['columns'][$p]['search']['value']), '^', '$'));
			$p++;
			}
			$this->db->group_end();
		}
		//Colums Searching End
	
		if(isset($_POST['order']))
		{
			if(isset($_POST['order'][0]))
			$this->db->order_by($column[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
		} 
		else if(count($order) > 0)
		{
			$order = $order;
			$this->db->order_by(key($order), $order[key($order)]);
		}		
		$this->db->stop_cache();	
	}


	/**
	 * [getStringBetween description]
	 * @param  [type] $str  [description]
	 * @param  [type] $from [description]
	 * @param  [type] $to   [description]
	 * @return [type]       [description]
	 */
	function getStringBetween($str,$from,$to)
	{
		$sub = substr($str, strpos($str, $from)+strlen($from), strlen($str));
		return substr($sub, 0, strpos($sub, $to));
	}


	/**
	 * [_get_datatables_customquery description]
	 * @param  [type] $query   [description]
	 * @param  array  $columns [description]
	 * @param  array  $order   [description]
	 * @return [type]          [description]
	 */
	private function _get_datatables_customquery($query, $columns = array(), $order = array())
	{	
		$i = 0;
		$column = array();
		$str = '';
		foreach ($columns as $item) 
		{
			if($_POST['search']['value'])
			($i===0) ? $str .= ' AND ('.$item . ' LIKE "%' . $_POST['search']['value'] . '%"' : $str .= ' OR '.$item . ' LIKE "%'.$_POST['search']['value'].'%"';
			$column[$i] = $item;
			$i++;
		}
		if($str != '')
			$str .= ')';
		
		//Colums Searching Start
		$column_search = FALSE;
		$p = 0;
		foreach ($columns as $item) 
		{
			if(isset($_POST['columns'][$p]['search']['value']) && $_POST['columns'][$p]['search']['value'] != '') $column_search = TRUE;
			$p++;
		}
		if($column_search == TRUE)
		{
			$p = 0;		
			foreach ($columns as $item) 
			{
			if(isset($_POST['columns'][$p]['search']['value']) && $_POST['columns'][$p]['search']['value'] != '')
				$str .= ' AND '.$item . ' = ' . $this->getStringBetween(urldecode($_POST['columns'][$p]['search']['value']), '^', '$');	
			$p++;
			}
		}
		//Colums Searching End
		
		 
		if(count($order) > 0)
		{
			$order = $order;
			$str .= ' ORDER BY tds.' . key($order) . ' ' . $order[key($order)];
		}
		elseif(isset($_POST['order']))
		{
			$str .= ' ORDER BY tds.' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'];
		}
		return 	$query . $str;	
	}


	/**
	 * [_get_datatables_customquery_new description]
	 * @param  [type] $query   [description]
	 * @param  array  $columns [description]
	 * @param  array  $order   [description]
	 * @return [type]          [description]
	 */
	private function _get_datatables_customquery_new($query, $columns = array(), $order = array())
	{	
		$i = 0;
		$column = array();
		$str = '';
		foreach ($columns as $item) 
		{
			if($_POST['search']['value'])
			($i===0) ? $str .= ' AND ('.$item . ' LIKE "%' . $_POST['search']['value'] . '%"' : $str .= ' OR '.$item . ' LIKE "%'.$_POST['search']['value'].'%"';
			$column[$i] = $item;
			$i++;
		}
		if($str != '')
			$str .= ')';
		
		//Colums Searching Start
		$column_search = FALSE;
		$p = 0;
		foreach ($columns as $item) 
		{
			if(isset($_POST['columns'][$p]['search']['value']) && $_POST['columns'][$p]['search']['value'] != '') $column_search = TRUE;
			$p++;
		}
		if($column_search == TRUE)
		{
			$p = 0;		
			foreach ($columns as $item) 
			{
			if(isset($_POST['columns'][$p]['search']['value']) && $_POST['columns'][$p]['search']['value'] != '')
				$str .= ' AND '.$item . ' = ' . $this->getStringBetween(urldecode($_POST['columns'][$p]['search']['value']), '^', '$');	
			$p++;
			}
		}
		//Colums Searching End


		if(count($order) > 0)
		{
			$order = $order;
			$str .= ' ORDER BY ' . key($order) . ' ' . $order[key($order)];
		}
		elseif(isset($_POST['order']))
		{
			$str .= ' ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'];
		}
		return 	$query . $str;	
	}


	/**
	 * [get_datatables description]
	 * @param  [type] $table     [description]
	 * @param  string $type      [description]
	 * @param  array  $condition [description]
	 * @param  array  $columns   [description]
	 * @param  array  $order     [description]
	 * @return [type]            [description]
	 */
	function get_datatables($table, $type = 'auto', $condition = array(), $columns = array(), $order = array())
	{
		
		if($type == 'custom')
		{
			$query_str = $this->_get_datatables_customquery($table, $columns, $order);
			
			$queryall = $this->db->query($query_str);
			$this->numrows = $this->db->affected_rows();
			if($_POST['length'] != -1)
			$query_str = $query_str . ' LIMIT '.$_POST['start'] .','. $_POST['length'];
		
			$query = $this->db->query($query_str);
		}
		else if($type == 'customnew')
		{
			$query_str = $this->_get_datatables_customquery_new($table, $columns, $order);
			//echo $query_str;die();
			$queryall = $this->db->query($query_str);
			$this->numrows = $this->db->affected_rows();
			if($_POST['length'] != -1)
			$query_str = $query_str . ' LIMIT '.$_POST['start'] .','. $_POST['length'];
		
			$query = $this->db->query($query_str);
		}
		else if($type == 'complex')
		{
			$this->_get_datatables_query_complex($table, $condition, $columns, $order);
			$queryall = $this->db->get();
			$this->numrows = $this->db->affected_rows();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			
		}
		else
		{
			$this->_get_datatables_query($table, $condition, $columns, $order);
			//neatPrint($columns);
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
		}		
		$this->db->flush_cache();
		
		return $query->result();
	}


	/**
	 * [count_filtered description]
	 * @param  [type] $table     [description]
	 * @param  string $type      [description]
	 * @param  array  $condition [description]
	 * @param  array  $columns   [description]
	 * @param  array  $order     [description]
	 * @return [type]            [description]
	 */
	function count_filtered($table, $type = 'auto', $condition = array(), $columns = array(), $order = array())
	{
		if($type == 'custom')
		{
			$query_str = $this->_get_datatables_customquery($table, $condition, $columns, $order);
			$query = $this->db->query($query_str)->result();
		}
		elseif($type == 'complex')
		{
			$this->_get_datatables_query_complex($table, $condition, $columns, $order);
			$query = $this->db->get();
		}
		else
		{
			$this->_get_datatables_query($table, $condition, $columns, $order);
			$query = $this->db->get();
		}
		
		
		//echo $this->db->last_query();
		return $query->num_rows();
	}


	/**
	 * [count_all description]
	 * @param  [type] $table     [description]
	 * @param  array  $condition [description]
	 * @param  string $type      [description]
	 * @return [type]            [description]
	 */
	public function count_all($table, $condition = array(),$type='')
	{
		if($type=='complex') 
							return 0;
		else 
		{
		$this->db->from($table);
		if(!empty($condition))
			$this->db->where( $condition );
		return $this->db->count_all_results();
		}
	}


	/**
	 * [fetch_records_from_query_object description]
	 * @param  [type] $query   [description]
	 * @param  string $offset  [description]
	 * @param  string $perpage [description]
	 * @return [type]          [description]
	 */
	function fetch_records_from_query_object($query, $offset = '', $perpage = '')
	{
		$resultset = $this->db->query( $query );
		$this->numrows = $resultset->num_rows();
		if( $perpage != '' )
			$query = $query . ' limit ' . $offset . ',' . $perpage;
		$resultsetlimit = $this->db->query( $query );
		return $resultsetlimit->result();
	}


	/**
	 * [get_page_about_us description]
	 * @return [type] [description]
	 */
    function get_page_about_us()
    {

		$pageAboutUs= $this->db->get_where($this->db->dbprefix('pages'), array('id' => '1'))->result();
		return $pageAboutUs;
    }	


	/**
	 * [get_page_how_it_works description]
	 * @return [type] [description]
	 */
	function get_page_how_it_works()
 {

		$pageHowItWorks = $this->db->get_where($this->db->dbprefix('pages'), array('id' => '2'))->result();
		return $pageHowItWorks;
	}


	/**
	 * [get_page_terms_and_conditions description]
	 * @return [type] [description]
	 */
	function get_page_terms_and_conditions()
 {

		$pageTermsAndCondtions = $this->db->get_where($this->db->dbprefix('pages'), array('id' => '3'))->result();
		return $pageTermsAndCondtions;
	}	


	/**
	 * [get_page_privacy_and_policy description]
	 * @return [type] [description]
	 */
    function get_page_privacy_and_policy()
    {

		$pagePrivachAndPolicy = $this->db->get_where($this->db->dbprefix('pages'), array('id' => '4'))->result();
		return $pagePrivachAndPolicy;
    }	


	/**
	 * [fetch_records description]
	 * @param  [type] $table      [description]
	 * @param  string $condition  [description]
	 * @param  string $select     [description]
	 * @param  string $order_by   [description]
	 * @param  string $order_type [description]
	 * @param  string $limit      [description]
	 * @return [type]             [description]
	 */
	function fetch_records( $table, $condition = '',$select = '*', $order_by = '',$order_type='asc',$limit='' )
	{		
		$this->db->select($select, FALSE);
		$this->db->from(  $table  );
		if( !empty( $condition ) )			
			$this->db->where( $condition );
		
		if( !empty( $order_by ) )			
			$this->db->order_by( $order_by, $order_type );				
		
		if(!empty( $limit) )			
			$this->db->limit( $limit );

		$result = $this->db->get();

		return $result->result();

	}


	/**
	 * [status_options description]
	 * @return [type] [description]
	 */
	function status_options()
	{
		$data = array();
		$status_options = array('Active'=>get_languageword('active'),
								'Inactive'=>get_languageword('inactive'));
		
		
		$script_status_options = '<option value="Active">'.get_languageword('active').'</option>';
		$script_status_options .= '<option value="Inactive">'.get_languageword('inactive').'</option>';
		
		array_push($data, $status_options, $script_status_options);
		return $data;
	}


	/**
	 * [get_cities_options description]
	 * @param  string $status [description]
	 * @return [type]         [description]
	 */
	function get_cities_options($status='')
	{
		$data = array();
		$cities_options = array();
		$script_cities_options = '';
		
		$cond = array();
		if($status != '')
			$cond = array('status'=>$status);
		
		$cities = $this->base_model->fetch_records_from(TBL_CITIES, $cond);
		if(!empty($cities))
		{
			$cities_options = array(''=>get_languageword('select'));
			$script_cities_options .= '<option value="">'.get_languageword('select').'</option>';
			foreach($cities as $city):
				$cities_options[$city->city_id] = $city->city_name;
				$script_cities_options .= '<option value="'.$city->city_name.'">'.$city->city_name.'</option>';
			endforeach;
		}
		
		array_push($data, $cities_options, $script_cities_options);
		return $data;
	}


	/**
	 * [get_service_cites_options description]
	 * @return [type] [description]
	 */
	function get_service_cites_options()
	{
		$cities_options = array();
		
		$cities = $this->crunchy_model->getServiceDeliveryCities();
		if(!empty($cities))
		{
			$cities_options = array(''=>get_languageword('select'));
			
			foreach($cities as $city):
				$cities_options[$city->city_id] = $city->city_name;
			endforeach;
		}
		
		return $cities_options;
	}


	/**
	 * [get_menus_options description]
	 * @param  string $status [description]
	 * @return [type]         [description]
	 */
	function get_menus_options($status='')
	{
		$menu_options = array();
		$cond = array();
		if($status != '')
			$cond = array('status'=>$status);
		
		$menus = $this->base_model->fetch_records_from(TBL_MENU, $cond);
		if(!empty($menus))
		{
			$menu_options = array(''=>get_languageword('select'));
			foreach($menus as $menu):
				$menu_options[$menu->menu_id] = $menu->menu_name;
			endforeach;
		}
			
		return $menu_options;
	}


	/**
	 * [script_menus_options description]
	 * @param  string $status [description]
	 * @return [type]         [description]
	 */
	function script_menus_options($status='')
	{
		$menu_options = '';
		$cond = array();
		if($status != '')
			$cond = array('status'=>$status);
		
		$menus = $this->base_model->fetch_records_from(TBL_MENU, $cond);
		if(!empty($menus))
		{
			$menu_options .= '<option value="">'.get_languageword('select').'</option>';
			foreach($menus as $menu):
				$menu_options .= '<option value="'.$menu->menu_id.'">'.$menu->menu_name.'</option>';
			endforeach;
		}
			
		return $menu_options;
	}


	/**
	 * [get_addons_options description]
	 * @param  string $status [description]
	 * @return [type]         [description]
	 */
	function get_addons_options($status='')
	{
		$addons_options = array();
		$cond = array();
		if($status != '')
			$cond = array('status'=>$status);
		
		$addons = $this->base_model->fetch_records_from(TBL_ADDONS, $cond);
		if(!empty($addons))
		{
			$addons_options = array(''=>'');
			foreach($addons as $addon):
				$addons_options[$addon->addon_id] = $addon->addon_name;
			endforeach;
		}
			
		return $addons_options;
	}


	/**
	 * [get_script_addons_options description]
	 * @param  string $status [description]
	 * @return [type]         [description]
	 */
	function get_script_addons_options($status='')
	{
		$addons_options = '';
		$cond = array();
		if($status != '')
			$cond = array('status'=>$status);
		
		$addons = $this->base_model->fetch_records_from(TBL_ADDONS, $cond);
		if(!empty($addons))
		{
			$addons_options .= '<option value="">'.get_languageword('select').'</option>';
			foreach($addons as $addon):
				$addons_options .= '<option value="'.$addon->addon_id.'">'.$addon->addon_name.'</option>';
			endforeach;
		}
			
		return $addons_options;
	}


	/**
	 * [item_type_options description]
	 * @return [type] [description]
	 */
	function item_type_options()
	{
		$item_type_options=array();
$item_types = $this->base_model->fetch_records_from(TBL_ITEM_TYPES);
if(!empty($item_types))		{			foreach($item_types as $item_type):				$item_type_options[$item_type->item_type_id] = $item_type->item_type;

endforeach;		
}		else
			$item_type_options = array(''=>get_languageword('no_item_types_available'));
		return $item_type_options;
	}


	/**
	 * [script_item_type_options description]
	 * @return [type] [description]
	 */
	function script_item_type_options()
	{
		$item_type_options = '';
$item_types = $this->base_model->fetch_records_from(TBL_ITEM_TYPES);				if(!empty($item_types))		{
			$item_type_options .= '<option value="">'.get_languageword('select').'</option>';
			foreach($item_types as $item_type):						$item_type_options .= '<option value="'.$item_type->item_type_id.'">'.$item_type->item_type.'</option>';

   endforeach;
}		else		{			$item_type_options .= '<option value="">'.get_languageword('no_item_types_available').'</option>';		
}	
		return $item_type_options;
	}


	/**
	 * [get_item_addons description]
	 * @param  [type] $item_id [description]
	 * @return [type]          [description]
	 */
	function get_item_addons($item_id)
	{
		if($item_id=='')
			return FALSE;
		
		$item_addons = array();
		$records = $this->base_model->fetch_records_from(TBL_ITEM_ADDONS, array('item_id'=>$item_id));
		if(!empty($records))
		{
			foreach($records as $record):
				array_push($item_addons, $record->addon_id);
			endforeach;
		}
		return $item_addons;
	}


	/**
	 * [script_options description]
	 * @param  string $status [description]
	 * @return [type]         [description]
	 */
	function script_options($status='')
	{
		$script_options='';
		
		$cond=array();
		if($status != '')
			$cond = array('status'=>$status);
		
		$options = $this->base_model->fetch_records_from(TBL_OPTIONS, $cond);
		if(!empty($options))
		{
			$script_options .= '<option value="">'.get_languageword('select').'</option>';
			foreach($options as $option):
				$script_options .= '<option value="'.$option->option_id.'">'.$option->option_name.'</option>';
			endforeach;
		}
		return $script_options;
	}


	/**
	 * [admin_delivery_codes description]
	 * @param  [type] $pincode [description]
	 * @return [type]          [description]
	 */
	function admin_delivery_codes($pincode)
	{
		$data = array();
		$pincode = $pincode;

		if(!empty($pincode)) 
		{
			$query 	= "SELECT pincode FROM ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." WHERE pincode LIKE '%".$pincode."%' and status='Active' ";
			$result = $this->base_model->get_query_result($query);
			foreach ($result as $res) {
				$data[] = $res->pincode;
			}
			return $data;
		}
		else
			return FALSE;
	}


	/**
	 * [check_pincode description]
	 * @param  [type] $pincode [description]
	 * @return [type]          [description]
	 */
	function check_pincode($pincode)
	{
		if(!empty($pincode)) 
		{
			$query 	= "SELECT pincode FROM ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." WHERE pincode='".$pincode."' and status='Active' ";
			$result = $this->base_model->get_query_result($query);
			if(!empty($result))
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}


	/**
	 * [check_email description]
	 * @param  [type] $email [description]
	 * @return [type]        [description]
	 */
	function check_email($email)
	{
		if(!empty($email)) 
		{
			$query 	= "SELECT * FROM ".TBL_PREFIX.TBL_USERS." WHERE email='".$email."'";
			$result = $this->base_model->get_query_result($query);
			if(empty($result))
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}


	/**
	 * [check_referral_code description]
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	function check_referral_code($code)
	{
		if(!empty($code)) 
		{
			$query 	= "SELECT * FROM ".TBL_PREFIX.TBL_USERS." WHERE referral_code='".$code."'";
			$result = $this->base_model->get_query_result($query);
			if(!empty($result))
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}


	/**
	 * [get_users_options description]
	 * @param  string $group_id [description]
	 * @return [type]           [description]
	 */
	function get_users_options($group_id='')
	{
		$users_options = array();
		
		$cond = "";
		if($group_id != '')
			$cond = " AND ug.group_id=".$group_id." ";
		
		$records = $this->base_model->get_query_result("SELECT u.id,u.username FROM ".TBL_PREFIX.TBL_USERS." u INNER JOIN ".TBL_PREFIX.TBL_USERS_GROUPS." ug ON u.id=ug.user_id WHERE u.active=1 ".$cond." ");
		if(!empty($records))
		{
			$users_options = array(''=>get_languageword('select'));
			
			foreach($records as $r):
				$users_options[$r->id] = $r->username;
			endforeach;
		}
		
		return $users_options;
	}


	/**
	 * [get_menu_categories_options description]
	 * @param  string $status [description]
	 * @return [type]         [description]
	 */
	function get_menu_categories_options($status='')
	{
		$options=array();
		
		$cond=array();
		if($status!='' && $status=='Active')
			$cond = array('status'=>'Active');
		
		$records = $this->base_model->fetch_records_from(TBL_MENU_CATEGORIES, $cond);
		
		if(!empty($records))
		{
			$options = array(''=>get_languageword('select'));
			foreach($records as $r):
			$options[$r->mc_id] = $r->category_name;
			endforeach;
		}
		else
		{
			$options = array(''=>get_languageword('no_options_available'));
		}
		
		return $options;
	}


	/**
	 * [get_categories_options description]
	 * @param  string $status [description]
	 * @return [type]         [description]
	 */
    function get_categories_options($status = '')
    {
        $options = array();
        $cond    = array();
        if ($status != '') {
            $cond = array(
                'status' => $status
            );
        }
        $categories = $this->base_model->fetch_records_from(TBL_FAQ_CATEGORIES, $cond);
        if (!empty($categories)) {

            foreach ($categories as $c) {
                $options[$c->fc_id] = $c->category;
            }
        } 
        return $options;
    }


	/**
	 * [get_cities description]
	 * @return [type] [description]
	 */
	function get_cities() 
 {
		
		$cities  = array();
		
		$records = $this->base_model->fetch_records_from(TBL_CITIES, array('status'=>'Active'));
		if (!empty($records)) :
			
			$cities = array(''=>get_languageword('select_city'));
			foreach ($records as $record ) :
			
				$cities[$record->city_id] = $record->city_name;
			endforeach;
			
		else :
			$cities = array(''=>get_languageword('no_cities_available'));
			
		endif;
		
		return $cities;
		
	}
	

	/**
	 * [get_orders_count description]
	 * @return [type] [description]
	 */
	function get_orders_count() 
 {

		$orders = $this->base_model->fetch_records_from(TBL_ORDERS);
		return count($orders);
	}


	/**
	 * [get_items_count description]
	 * @return [type] [description]
	 */
	function get_items_count() 
 {
		
		$items = $this->base_model->fetch_records_from(TBL_ITEMS);
		return count($items);
	}

	
	/**
	 * [get_delivered_orders_count description]
	 * @return [type] [description]
	 */
	function get_delivered_orders_count() 
 {

		$orders = $this->base_model->fetch_records_from(TBL_ORDERS, array('status'=>'delivered'));
		return count($orders);
	}
}
