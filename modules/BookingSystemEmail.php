<?php
class BookingSystemEmail {
private $BookingSystem;
private $subject;
private $description;
private $email;


function __construct($b)
{
	$this->BookingSystem = $b;
		add_action('notify_dispatch',array(&$this,'notify_dispatch'));
		add_action('payment_made',array(&$this,'payment_made'));

	
}
public function payment_made($data)
{
$this->set_subject("Payment Made");
$this->set_message($data['message']);



       global $current_user;
      get_currentuserinfo();

      $this->set_email($current_user->user_email);


$this->send_email_to_admin();	

$this->send_email_to_customer();
	
}
function notify_dispatch($data)
{
		extract($data);

$post_id = $data['post_id'];
$post = get_post($post_id);
$author_id = $post->post_author;


	$this->set_message($message);
	$this->set_subject($subject);
	$this->set_email(get_the_author_meta('email',$author_id));
$this->send_email_to_admin();

$flight_number = get_post_meta( $post_id, 'flight_number', true ); 
if(!empty($flight_number))
{
$this->load_email_template('airport');	
}else{
$this->load_email_template('citytocity');	
}
$this->send_email_to_customer();	


	
}
function set_email($email)
{
	
$this->email = $email;	
}
public function set_subject($subject)
{
	$this->subject = $subject;
	
}
public function set_message($message)
{
	
	$this->message = nl2br($message);
}
public function get_headers()
{
	$admin_email = get_option('admin_email'); 
$headers = "From: " . strip_tags($admin_email) . "\r\n";
$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";	
	return $headers;
}
public function load_email_template($template)
{
    ob_start();
    $message = $this->message;
    include(ROOTPATH.'/emails/'.$template.'.php');
    $this->message =  ob_get_clean();	
	
}
public function send_email_to_customer()
{


mail($this->email, $this->subject, $this->message,$this->get_headers());	
}
function send_email_to_admin()
{
$admin_email = get_option('admin_email'); 
mail($admin_email, $this->subject, $this->message,$this->get_headers());	
}
}
?>