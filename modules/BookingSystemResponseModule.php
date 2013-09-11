<?php
class BookingSystemResponseModule {
	private $BookingSystem;
function __construct($b)
{
	
	$this->BookingSystem = $b;
	add_action('BookingSystem_ajax_success',array(&$this,'ajax_success'),999);
	add_action('BookingSystem_ajax_error',array(&$this,'ajax_error'),999);
	add_action('BookingSystem_ajax_response',array(&$this,'ajax_response'),999);

}
public function ajax_response($data)
{
	switch($data['type'])
	{
			case 'error':
								$this->ajax_error($data['message']);

				break;
			case 'success':
				$this->ajax_success($data['message']);
				break;
		
	}
	
}
public function ajax_success($message)
{
	$arr['type'] = "success";
	$arr['response'] = rawurlencode(strip_tags($message));
echo json_encode($arr);	
die();
}
public function ajax_error($message)
{
	$arr['type'] = "error";
	$arr['response'] = rawurlencode(strip_tags($message));
echo  json_encode($arr);
die();
}
	
}
?>