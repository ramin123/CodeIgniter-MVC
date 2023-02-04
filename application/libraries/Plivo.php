<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * CodeIgniter Plivo Library
 *
 * A CodeIgniter library to interact with Plivo
 *
 * @package         CodeIgniter
 * @category        Libraries
 * @author          Gordon Murray, Murrion Software
 * @link            https://github.com/murrion/codeigniter-plivo-library
 * @link            http://murrion.ie
 * @license         http://www.opensource.org/licenses/mit-license.html
 */
class Plivo
{

    protected $auth_id;
    protected $auth_token;
    protected $end_point;
    protected $api_version;

    public function __construct()
    {
        $this->_ci = & get_instance();

        /*
         * Load config items
         */
		 /*
        $this->_ci->load->config('plivo');

        $this->auth_id = $this->_ci->config->item('AUTH_ID');

        $this->auth_token = $this->_ci->config->item('AUTH_TOKEN');

        $this->api_version = $this->_ci->config->item('API_VERSION');

        $this->end_point = $this->_ci->config->item('END_POINT');
		*/
		$this->_ci->load->database();
		$query = 'SELECT * FROM '.$this->_ci->db->dbprefix('system_settings_fields').' sst INNER JOIN '.$this->_ci->db->dbprefix('sms_gate_ways').' ssf ON sst.sms_gateway_id = ssf.sms_gateway_id WHERE ssf.sms_gateway_name = "Plivo" ORDER BY field_name';
		$gateway_details = $this->_ci->base_model->fetch_records_from_query_object( $query );
		//echo "<pre>";
		//print_r($gateway_details); die();
		if(count($gateway_details) > 0) {
			foreach($gateway_details as $selectedgateway) {
				switch($selectedgateway->field_key)
				{
					case 'AUTH_ID':
						$this->auth_id = $selectedgateway->field_output_value;
					break;
					case 'AUTH_TOKEN':
						$this->auth_token = $selectedgateway->field_output_value;
					break;
					case 'API_VERSION':
						$this->api_version = $selectedgateway->field_output_value;
					break;
					case 'END_POINT':
						$this->end_point = $selectedgateway->field_output_value;
					break;
				}						
			}
		}
		/*echo $this->auth_id;
		echo $this->auth_token;
		echo $this->api_version;
		echo $this->end_point; 
		die();*/
    }

		
		//echo $this->auth_token;
		//echo $this->api_version;
		//echo $this->end_point; 
		//die();
    /**
     * Perform a lookup for available number groups
     * @link http://plivo.com/docs/api/numbers/availablenumbergroup/
     * @param string $iso
     * @return type
     */
    public function available_number_group($iso = 'IE')
    {
        $url = $this->api_version . '/Account/' . $this->auth_id . '/AvailableNumberGroup/';

        $data = array(
            'country_iso' => $iso,
            'number_type' => 'local', // local, national, tollfree
            //'prefix' => '', // area code, max 5 digits
            //'region' => '',
            //'services' => 'voice,sms',
            'limit' => '20',
            'offset' => '0'
        );

        return $this->request($url, 'GET', $data);
    }

    /**
     * Perform a look up for available numbers in a group
     * @link http://plivo.com/docs/api/numbers/availablenumbergroup/#number_search
     * @param int $group_id
     * @return type 
     */
    public function available_numbers($group_id)
    {
        $url = $this->api_version . '/Account/' . $this->auth_id . '/AvailableNumberGroup/' . $group_id . '/';

        $data = array(
            'quantity' => '20', //The quantity of numbers that are to be ordered from the number group.
                //'app_id' => 'local' // The id of the application that you want assigned to the Number. If this is not provided, then it is assigned to the default application of the Account.
        );

        return $this->request($url, 'POST', $data);
    }

    /**
     * Perform a look up about your account
     * @link http://plivo.com/docs/api/account/
     * @return type 
     */
    public function account()
    {
        $url = $this->api_version . '/Account/' . $this->auth_id . '/';

        return $this->request($url, 'GET');
    }

    /**
     * Send an SMS message
     * @param array $sms_data
     * @return type 
     */
    public function send_sms($sms_data)
    {
        $url = $this->api_version . '/Account/' . $this->auth_id . '/Message/';

        return $this->request($url, 'POST', $sms_data);
    }

    /**
     * Make an outbound call 
     * @link http://plivo.com/docs/api/call/#outbound
     */
    public function outbound_call($call_data)
    {
        $url = $this->api_version . '/Account/' . $this->auth_id . '/Call/';

        return $this->request($url, 'POST', $call_data);
    }

    /**
     * Make a Request 
     * @param type $path
     * @param type $method
     * @param type $vars
     */
    public function request($path, $method = "GET", $vars = array())
    {

        $encoded = "";
        foreach ($vars AS $key => $value)
            $encoded .= "$key=" . urlencode($value) . "&";
        $encoded = substr($encoded, 0, -1);

        /*
         * Create the full URL
         */
        $url = $this->end_point . '/' . $path;

        /*
         * if GET and vars, append them
         */
        if ($method == "GET")
            $url .= (FALSE === strpos($path, '?') ? "?" : "&") . $encoded;

        /*
         * initialize a new curl object
         */
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

        switch (strtoupper($method))
        {
            case "GET":
                curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
                break;
            case "POST":
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($vars));
                break;
        }

        // send credentials
        curl_setopt($curl, CURLOPT_USERPWD, $pwd = "{$this->auth_id}:{$this->auth_token}");

        // initiate the request
        $json_response = curl_exec($curl);

        // get result code
        $response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        return array($response_code, $json_response);
    }

}

/* End of file Plivo.php */