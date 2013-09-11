<?php
//taxi_booking_metaboxes
//add_meta_box( $id, $title, $callback, $post_type, $context, $priority, $callback_args );

class WPChain {
	public $id = null;
	public $title = null;
	public $callback = null;
	public $post_type = null;
	public $context = null;
	public $priority = null;
	public $callback_args = null;
	function id($id)
	{
	$this->id = $id;
	return $this;
	}
	function title($title)
	{
	$this->title = $title;	
		return $this;
	}
	function callback($callback)
	{
		
		$this->callback($callback);
	return $this;
	}
	function post_type($post_type)
	{
	$this->post_type;
	return $this;
	}
	function context($context)
	{
	$this->context = $context;	
		return $this;
	}
	function priority($priority)
	{
	$this->priority = $priority;	
	return $this;
	}
	function callback_args($callback_args)
	{
	$this->callback_args = callback_args;
	return $this;
	}
	function add_meta_box( $id = null, $title  = null, $callback  = null, $post_type  = null, $context  = null, $priority  = null, $callback_args  = null )
	{
		add_meta_box( $this->id, $this->title, $this->callback, $this->post_type, $this->context, $this->priority, $this->callback_args );
		
	}
	function remove_meta_box()
	{
	//<?php remove_meta_box( $id, $page, $context ); 
	remove_meta_box( $this->id, $this->page, $this->context ); 
	
	}
}

class BookingSystemMetaBoxes
{
	public function remove_meta_boxes()
	{

   	remove_meta_box( 'wpseo_meta', 'booking', 'normal' ); 

	remove_meta_box( 'submitdiv', 'booking', 'side' ); 

	}
    public function add_meta_boxes()
    {
    	//add_meta_box( $id, $title, $callback, $post_type, $context, $priority, $callback_args );
/*$chain = new WPChain();
$chain->id('booking_events')->title('Pickup/Dropoff')->callback(array(&$this,'events'))->post_type('booking')->context('side')->priority('high')->add_meta_box();
$chain->id('google_maps')->title('Google Maps')->callback(array(&$this,'google_maps'))->post_type('booking')->context('normal')->priority('high')->add_meta_box();
$chain->id('booking_save')->title('Save')->callback(array(&$this,'booking_save'))->post_type('booking')->context('side')->priority('high')->add_meta_box();
$chain->id('taxi_logo')->title('Company')->callback(array(&$this,'taxi_logo'))->post_type('booking')->context('side')->priority('high')->add_meta_box();
$chain->id('taxi_payment')->title('Payment')->callback(array(&$this,'taxi_logo'))->post_type('booking')->context('side')->priority('high')->add_meta_box();
$chain->id('taxi_vehicle')->title('Vehicle')->callback(array(&$this,'taxi_vehicle'))->post_type('booking')->context('side')->priority('high')->add_meta_box();
*/

       add_meta_box('booking_events', 'Pickup/Dropoff', array(
            &$this,
            'booking_events'
        ), 'booking', 'side', 'high');
        add_meta_box('google_maps', 'Google Maps', array(
            &$this,
            'google_maps'
        ), 'booking', 'normal', 'high');
        add_meta_box('booking_save', 'Save', array(
            &$this,
            'booking_save'
        ), 'booking', 'side', 'high');
        add_meta_box('taxi_logo', 'Company', array(
            &$this,
            'taxi_logo'
        ), 'booking', 'side', 'high');

        
     /*  add_meta_box('taxi_vehicle', 'Vehicle', array(
            &$this,
            'taxi_vehicle'
        ), 'booking', 'side', 'high');
       */ 
    }
    public function google_maps()
    {
        require_once ROOTPATH.'views/meta.googlemaps.php';
                      
    }
   public function booking_events()
    {
        global $post;
    $pickup = get_post_meta($post->ID, 'pickup_location', true);
    $dropoff = get_post_meta($post->ID, 'dropoff_location', true);
    $time = get_post_meta($post->ID, 'pickup_time', true);
    $vehicle = get_post_meta($post->ID, 'vehicle', true);
    $payment = get_post_meta($post->ID, 'payment_type', true);
    $flight_number = get_post_meta($post->ID, 'flight_number', true);
 $flight_name = get_post_meta($post->ID, 'flight_name', true);
 $pickup_note = get_post_meta($post->ID, 'pickup_note', true);
        include ROOTPATH.'views/meta.events.php';
        
        
    }
   public function booking_save()
    {
        global $post_ID;
        global $post;
            
            include(ROOTPATH.'/views/meta.save.php');
            
        
        
        
        
    }
   public function taxi_logo()
    {
        $options = get_option('plugin_options');
        include ROOTPATH.'views/meta.logo.php';
        
        
    }
   public function taxi_notes()
    {
      // require_once ROOTPATH.'views/meta.notes.php';
        
    }
       public function taxi_vehicle()
    {
        //require_once 'views/meta.vehicle.php';
        
    }
    
    
}
?>