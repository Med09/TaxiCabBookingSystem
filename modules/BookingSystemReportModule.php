<?php
class BookingSystemReportModule {
	private $description;
	private $title;
	private $pickup_location;
	public $subject;
	public $post_id;
	private $flight_number;
	private $flight_name;
	private $pickup_note;
	private $BookingSystem;
	function __construct($b)
	{
		
		$this->BookingSystem = $b;
		
	}
	public function get_report_title()
	{
		
	$title = "Booking: ".get_the_author_meta( 'display_name' , $this->author_id );
	$this->title = $title;
		return $title;
	}
	public function set_pickup_location($pickup_location)
	{
	$this->pickup_location = $pickup_location;
	return $this;
	}
	public function set_description($description)
	{
		$this->description = $description;
		return $this;
	}
	public function set_post_id($post_id)
	{
	$this->post_id = $post_id;
	return $this;
	}
	public function get_post_id()
	{
	return $post_id;	
	}
	public function set_title($title)
	{
		
	$this->title = $title;
	return $this;
	}
	public function get_report_description()
	{
		
$description = "
Booking ID : ".get_the_title($this->post_id)."
Name: ".get_the_author_meta( 'display_name' , $this->author_id )."
Phone: ".get_the_author_meta( 'user_login' , $this->author_id )."
Email: ".get_the_author_meta( 'user_email' , $this->author_id )."
Pickup Date/Time: ".$this->pickup_time."
Pickup Location: ".$this->pickup_location."
Dropoff Location: ".$this->dropoff_location."
Payment : ".$this->payment_type."
Vehicle : ".$this->vehicle."
Pickup Note : ".$this->pickup_note."
Flight Name : ".$this->flight_name."
Flight Number : ".$this->flight_number."
";





$this->description = $description;



		return $description;
	}
	
	
	public function set_subject($subject)
	{
	$this->subject = $subject;	
		
	}
	public function create_report($post_id)
	{

	 $this->set_post_id($post_id);		
     $post = get_post($post_id);
     $author_id = $post->post_author;
$meta = $this->BookingSystem->booking_post_type->get_meta_keys();
foreach($meta as $key)
{
$this->$key = get_post_meta($post_id,$key,true);	
	
}
$this->author_id = $author_id;

	 
	 $this->get_report_title();
	 $this->get_report_description();
	 return $this;
		
		
	}
	public function get_urlencoded_report()
	{
		return urlencode($this->get_report_description());	
	}
	public function get_pickup_time()
	{
	return $this->pickup_time;
	}
	public function get_pickup_location()
	{
	return $this->pickup_location;	
	}
	public function get_dropoff_location()
	{
	return $this->dropoff_location;	
	}
	public function set_carrier($carrier)
	{
	$this->carrier = $carrier;	
	return $this;
	}
	public function set_phone($phone)
	{
	$this->phone = $phone;	
	return $this;
	}

	
}
?>