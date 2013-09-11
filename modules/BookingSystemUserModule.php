<?php
class BookingSystemUserModule {
private $user;
private $BookingSystem;
private $options;
public $logged_in_user;
	function __construct($b)
	{
		$this->BookingSystem = $b;
		add_action('BookingSystem_login_existing_customer',array(&$this,'login_existing_customer'),1);
				add_action('BookingSystem_login_new_customer',array(&$this,'login_new_customer'),1);

	}
	public function sign_on($cred = null)
	{
		
		if(isset($cred))
		{
			
			extract($cred);
		}else{
			
		extract($this->user);	
		}
		$creds                  = array();
        $creds['user_login']    = sanitize_text_field($phone);
        $creds['user_password'] = sanitize_text_field($pin);
        $creds['remember']      = true;
        $user                   = wp_signon($creds, false);

$this->logged_in_user = $user;
        return $user;
		
	}
	public function set_user($array)
	{
	extract($array);
	$this->set_first_name(@$firstname);
	$this->set_last_name(@$lastname);
	$this->set_user_email(@$email);
	$this->set_user_login(@$phone);
	$this->set_user_pass(@$pin);
	//$this->set_role(@$role);
	return $this;	
	}
	public function set_role($role)
	{
		$this->user['role'] = $role;
			return $this;
	}
	public function get_role()
	{
			return $this->user['role'];
	}
	public function set_first_name($first_name = null)
	{
		$this->user['first_name'] = $first_name;
			return $this;
	}
	public function get_first_name()
	{
		return $this->user['first_name'];
	}
	public function set_last_name($last_name = null)
	{
		$this->user['last_name'] = $last_name;
			return $this;
	}
	public function get_last_name()
	{
		return $this->useruser['last_name'];
	}
	public function set_user_login($user_login = null)
	{
		$this->user['user_login'] = $user_login;
			return $this;
	}
	public function get_user_login()
	{
		return $this->user['user_login'];
	}
	public function set_user_pass($pass = null)
	{
		$this->user['user_pass'] = $pass;
			return $this;
	}
	public function get_user_pass()
	{
		return $this->user['user_pass'];
	}
	public function set_user_email($email = null)
	{
	$this->user['user_email'] = $email;	
	return $this;
	}
	public function get_user_email()
	{
		return 	$this->user['user_email'];
	}
	public function sanitize(&$item1, $key)
	{
		    $item1[$key] = sanitize_text_field($item1[$key]);

		
	}
	public function insert_user()
	{

    array_walk($this->user,array($this,'sanitize'));
		
		 return wp_insert_user($this->user);
		
	}
	public function login_existing_customer($data)
	{
	   if (username_exists($data['phone'])) {
            
            $user = $this->sign_on($data);
        } else {
            
            echo $this->BookingSystem->response_module->error('Username does not exist');
            die();
        }       


        
           
        if (is_wp_error($user)) {
            if (isset($user->errors['existing_user_email'])) {
                echo $this->response_module->error('Email is already used');
                die();
            }
            echo $this->response_module->error('ERROR');
            
            die();
        }
        
        return true;
		
	}
		public function login_new_customer($data)
	{
	   if (username_exists($data['phone'])) {
            
                echo $this->BookingSystem->response_module->error('That phone number is already registered');
            
            die();
        } 
       $user = $this->set_user($data)->set_role('booking_client')->insert_user();
        
        if (is_wp_error($user)) {
            $this->response_module->error($user->get_error_message());
            die();
        }
        $this->sign_on($data);
        
        
        
        return true;
		
	}
	public function get_user_role($id = null)
	{
	     global $current_user;
        if (!$id)
            $id = $current_user->ID;
        if (is_user_logged_in()) {
            $user = new WP_User($id);
            if (!empty($user->roles) && is_array($user->roles)) {
                return $user->roles;
            }
        }
        return false;	
		
	}
	
}
?>