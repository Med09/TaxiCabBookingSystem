<?php
class BookingSystemRoleModule
{
    private $capabilites;
    private $roles = array('name' => 'booking_client', 'display_name' => 'Booking Client');
    private $display_name = 'Booking Client';
    private $BookingSystem;
    function __construct($b)
    {
        $this->BookingSystem = $b;
        add_action('BookingSystem_init', array(
            &$this,
            'init'
        ));
        add_action('BookingSystem_admin_init', array(
            &$this,
            'admin_init'
        ));
        // add_action('BookingSystem_add_roles',array(&$this,'add_roles'));
        
        
    }
    
    public function init()
    {
    }
    public function admin_init()
    {
        $this->add_roles();
        
    }
    private function add_roles()
    {
        foreach ($this->roles as $role => $value) {
            add_role($value['name'], $value['display_name']);
        }
        //return $this;
    }
    public function get_role_count()
    {
        return count($this->roles);
    }
    public function get_role($role)
    {
        foreach ($this->roles as $role) {
            if ($role['name'] == $role || $role['display_name'] == $role) {
                return $value;
            }
        }
        return false;
    }
    public function get_roles()
    {
        return $this->roles;
    }
    public function add_capabilities($capabilites)
    {
        $this->capabilities = $capabilites;
        
        $admin = get_role('administrator');
        $main  = get_role($this->role['name']);
        foreach ($this->capabilites as $capability => $role) {
            $admin->add_cap($role);
            $main->add_cap($role);
        }
        
    }
    
}

?>