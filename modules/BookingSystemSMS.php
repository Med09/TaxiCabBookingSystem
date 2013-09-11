<?php
class BookingSystemSMS {
     static $__instance;
	public $carrier;
	public $phone;
	public $message;
	private $BookingSystem;
	private $options;
	public $isActive = true;
	function __construct($b)
	{
		$this->BookingSystem = $b;
		add_action('notify_dispatch',array(&$this,'notify_dispatch'));
		return true;
		
	}
	
function load()
{
	/*
   if(self::$__instance == NULL) self::$__instance = new BookingSystemSMS;
        return self::$__instance;
        */
	
}
function notify_dispatch($data)
{
	extract($data);

$carrier = $this->BookingSystem->options_module->get_option('sms_carrier');
$phone = $this->BookingSystem->options_module->get_option('sms_phone');
if(!empty($carrier) && !empty($phone)){
	$this->set_message($message);
	$this->set_subject($subject);
	$this->set_carrier($carrier);
	$this->set_phone($phone);
$this->execute();	
}
	
	
}
function set_message($message)
{
$this->message = $message;	
return $this;	
}
function set_carrier($carrier)
{
$this->carrier = $carrier;	
return $this;
}
function set_phone($phone)
{
$this->phone = $phone;
return $this;
}
function set_subject($subject)
{
$this->subject = $subject;
return $this;
	
}
function execute()
{
if(!isset($this->carrier))
{
echo "carrier not set";
}
$extension;
switch($this->carrier)
{
	case "verizon":
		$extension = "@vtext.com";
		break;
	case "tmobile":
		$extension = "@tomomail.net";
		break;
	case "sprint":
		$extension = "@messaging.sprintpcs.com";
		break;
	case "att":
		$extension = "@txt.att.net";
		break;
}
	$send_to = $this->phone.$extension;
	
	
	
//mail($send_to, $this->subject, $this->message);

}


	
}
?>