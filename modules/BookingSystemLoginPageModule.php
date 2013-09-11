<?php
class BookingSystemLoginPageModule {
	private $BookingSystem;
	private $options;
	function __construct($b)
	{
		$this->BookingSystem = $b;
		add_action('BookingSystem_login_head',array(&$this,'login_head'));;

	}
	function login_head()
	{
		$this->print_logo();


	}
	public function print_logo()
	{
		
		$logo = $this->BookingSystem->options_module->get_option('taxi_logo');
		if(isset($logo) && !empty($logo))
		{
	
	
            echo "
    <style>
    body.login #login h1 a {
        background: url('" .$logo. "') no-repeat scroll center top transparent;
    
    }
    </style>
    ";
		}	
		
	}
	
}
?>