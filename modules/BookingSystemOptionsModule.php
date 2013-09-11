<?php
include 'BookingSystemOptionFields.php';
class BookingSystemOptionsModule 
{
	public $optionFields;
	public $options;
	public $group;
	public $name;
	private $BookingSystem;
	function __construct($b)
	{
		global $google_client;
		$this->BookingSystem = $b;
		$this->google_client = $google_client;
		$this->options = get_option('plugin_options',false);
		add_action('BookingSystem_init',array(&$this,'init'));
		add_action('BookingSystem_admin_init',array(&$this,'admin_init'),1);
		add_action('BookingSystem_admin_menu',array(&$this,'admin_menu'),1);
	}
	function init()
	{

		
	}
	function admin_init()
	{
    $this->register_options('plugin_options','plugin_options');
    $this->setup_option_fields($this->options,$this->google_client);
    return $this;
	}
	public function admin_menu()
	{
	
	  
        
	
	
	
	}

	function set_options()
	{
		
	}
	function get_options()
	{
		return $this->options;
	}
	function get_option($key)
	{
		if(isset($this->options[$key]))
		{
		return $this->options[$key];
		}
		return false;
	}
	function register_options($group,$name)
	{
		$this->group = $group;
		$this->name = $name;
	   register_setting( $group, $name); 

	}
	private function setup_option_fields($options,$library)
	{
		$this->option_fields = new BookingSystemOptionFields($this->BookingSystem);
		return $this;
	}
	
	
}
?>