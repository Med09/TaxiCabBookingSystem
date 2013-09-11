<?php
class BookingSystemMenuModule {
	private $BookingSystem;
	private $options;
	        function __construct($b)
	        {
	        	$this->BookingSystem = $b;
	        	   add_action('BookingSystem_init',array(&$this,'init'));
    add_action('BookingSystem_admin_init',array(&$this,'admin_init'),2);
        add_action('BookingSystem_admin_menu',array(&$this,'admin_menu'),2);
	        	
	        }
	        function init()
	        {
	        	
	        	
	        }
	        function admin_init()
	        {
	        	
	        	
	        }
	        function admin_menu()
	        {
	        	$role = $this->BookingSystem->user_module->get_user_role();

  
        $this->BookingSystem->menu_module->booking_client_menu();

        	  add_submenu_page('edit.php?post_type=booking', 'Settings ', _x('Settings Page', 'booking'), 'manage_options', 'settings-page', array(
            &$this,
            'add_settings_page'
        ));
}
	
	        	public function add_settings_page()
	{
		global $post_ID;
        global $post;
        include ROOTPATH.'views/settings.php';	
		
	}
	       public function booking_client_menu()
	        {
	    $this->remove_page('jetpack','JetPack','manage_options');
        $this->remove_page('profile.php',null,'manage_options');
        $this->remove_page('index.php',null,'manage_options');
	        	
	        }
	        function remove_page($page, $class = null, $role)
	        {
	        
	        	remove_menu_page($page);
           
	        	
	        return true;	
	        }
	        
	        
}
        
?>