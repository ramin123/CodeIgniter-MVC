<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Clickatell Class
 *
 * @package		Clickatell
 * @subpackage	Libraries
 * @category	SMS Gateway
 * @author		Zachie du Bruyn
 */
class Clickatell
{
    const ERR_NONE              = 0;
    const ERR_AUTH_FAIL         = 1;
    const ERR_SEND_MESSAGE_FAIL = 2;
    const ERR_SESSION_EXPIRED   = 3;
    const ERR_PING_FAIL         = 4;
    const ERR_CALL_FAIL         = 5;

    // public vars
    public $error = SELF::ERR_NONE;
    public $error_message = '';
	
    // private vars
    private $ci;
    private $session_id = FALSE;
	
	private $username = '';
	private $password = '';
	private $api_id   = '';
	private $from_no = '';
	
    const BASEURL = "http://api.clickatell.com";

    /**
     * Class constructor - loads CodeIgnighter and Configs
     */
    public function __construct()
    {
        $this->ci =& get_instance();
        
		$this->ci->load->database();
		//echo "IN Lib";
		$query = 'SELECT sf.* FROM `cr_system_settings_fields` sf INNER JOIN `cr_sms_gate_ways` sst ON sf.sms_gateway_id = sst.sms_gateway_id WHERE sst.sms_gateway_name = "Cliakatell" ORDER BY field_name';		
		$gateway_details = $this->ci->base_model->fetch_records_from_query_object( $query );
		//echo "<pre>";
		//print_r($gateway_details); 
		if(count($gateway_details) > 0) {
			foreach($gateway_details as $selectedgateway) {
				switch($selectedgateway->field_key)
				{
					case 'User_Name':
						$this->username = $selectedgateway->field_output_value;
					break;
					case 'Password':
						$this->password = $selectedgateway->field_output_value;
					break;
					case 'API_Id':
						$this->api_id = $selectedgateway->field_output_value;
					break;
					case 'From_No':
						$this->from_no = $selectedgateway->field_output_value;
					break;
				}						
			}
		}
		/*echo $this->username;
		echo $this->password;
		echo $this->api_id;
		echo $this->from_no;
		die();*/
		
		/*
		$this->ci->config->load('clickatell');		
        $this->username = $this->ci->config->item('clickatell_username');
        $this->password = $this->ci->config->item('clickatell_password');
        $this->api_id   = $this->ci->config->item('clickatell_api_id');
        $this->from_no   = $this->ci->config->item('clickatell_from_no');
		*/
    }

    /**
     * Method for Authentication with Clickatell
     *
     * @return string $session_id
     */
    public function authenticate()
    {
        $url = self::BASEURL.'/http/auth?user='.$this->username
             . '&password='.$this->password.'&api_id='.$this->api_id;

        $result = $this->_do_api_call($url);
        $result = explode(':',$result);

        if ($result[0] == 'OK')
        {
        	echo "Ok";
            $this->session_id = trim($result[1]);
            return $this->session_id;
        }
        else
        {
        	echo "FAIL";
            $this->error = self::ERR_AUTH_FAIL;
            $this->error_message = $result[0];
            return FALSE;
        }
    }

    /**
     * Method to send a text message to number
     *
     * @access  public
     * @param   string $to
     * @param   string $message
     * @return  message_id
     */
    public function send_message($to, $message)
    {
        if ($this->session_id == FALSE)
        {
        	echo "ses";
            $this->authenticate();
        }

        if ($this->error == self::ERR_NONE)
        {
        	echo "Good";
            $message = urlencode($message);
            $url = self::BASEURL.'/http/sendmsg?session_id='.$this->session_id
                . '&to='.$to.'&text='.$message.'&from='.$this->from_no.'&mo=1';

            $result = $this->_do_api_call($url);
			print_r($result);
            $result = explode(':',$result);

            if ($result[0] == 'ID')
            {
                $api_message_id = $result[1];
                return $api_message_id;
            }
            else
            {
                $this->error = self::ERR_SEND_MESSAGE_FAIL;
                $this->error_message = $result[1];
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    
    
    public function get_balance()
    {
        if ($this->session_id == FALSE)
        {
            $this->authenticate();
        }

        if ($this->error == self::ERR_NONE)
        {
            $url = self::BASEURL.'/http/getbalance?session_id='.$this->session_id;
            
            $result = $this->_do_api_call($url);
            $result = explode(':',$result);
            
            if ($result[0] == 'Credit')
            {
                return (float)$result[1];
            }
            else
            {
                $this->error = self::ERR_CALL_FAIL;
                $this->error_message = $result[1];
                return FALSE;
            }
        }       
    }
    
    /**
     * Method to send a ping to keep session live
     *
     * @access  public
     * @return  bool $success
     */
    public function ping()
    {
        if ($this->session_id == FALSE)
        {
            $this->authenticate();
        }

        if ($this->error == self::ERR_NONE)
        {
            $url = self::BASEURL.'/http/ping?session_id='.$this->session_id;
            
            $result = $this->_do_api_call($url);
            $result = explode(':',$result);
            
            if ($result[0] == 'OK')
            {
                return TRUE;
            }
            else
            {
                $this->error = self::ERR_PING_FAIL;
                $this->error_message = $result[1];
                return FALSE;
            }
        }
    }
    
    
    /**
     * Method to call HTTP url - to be expanded
     *
     * @param   string $url
     * @return  string response
     */
    private function _do_api_call($url)
    {
        $result = file($url);
		if($result === FALSE) //If 'file' funciton failed to open file for some reason
		{
			$curl_handle=curl_init();
			curl_setopt($curl_handle, CURLOPT_URL,$url);
			curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Cliakatell');
			$result = curl_exec($curl_handle);
			curl_close($curl_handle);
		}
        $result2 = implode("\n",$result);
		if($result2 !== NULL)
		$result = $result2;
        return $result;
    }
}

/* End of file Clickatell.php */
/* Location: ./application/libraries/Clickatell.php */