<?php
include ROOTPATH.'/lib/Braintree.php';
/**
 * @library Braintree
 * */

class BookingSystemBrainTreeModule {
	static $__instance;
	public $creditCard = array();
	public $amount = '0.00';
	public $customer;
	private $options = array('merchant_id','public_key','private_key');
	
function __construct($b)
{
	add_action('BookingSystem_prepay',array(&$this,'BookingSystem_prepay'));
	$this->BookingSystem = $b;
	
	$options = get_option('plugin_options');
	
	if(is_array($options)){
	foreach($options as $option)
	{
	if(!isset($options[$option]))
	{
		return false;
	}
	}
	}
	
Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId($options['merchant_id']);
Braintree_Configuration::publicKey($options['public_key']);
Braintree_Configuration::privateKey($options['private_key']);	

}
function BookingSystem_prepay($data)
{
		
		$data = $data;

if(in_array('', $data) == true)
{
$this->BookingSystem->response_module->error('Found empty fields');
die();	
}


global $current_user;
      get_currentuserinfo();
      
      
      
	$credit_card = array('number' => $data['creditCard'],'cvv'=>$data['cvv'],'expirationMonth' => $data['expirationMonth'],'expirationYear' => $data['expirationYear']);
	$options = array('storeInVault' => true);
	$customer = array('firstName'=>ucfirst($current_user->user_firstname),'lastName'=>ucfirst($current_user->user_lastname),'id' => $current_user->ID);
	$amount = array('amount'=>$data['amount']);
	
$r = $this->setCreditCard($credit_card)
	->setAmount($amount)
	->setOptions($options)
	->setCustomer(array('customer'=>$customer))
	->execute();




$this->BookingSystem->response_module->success($r);
die();


	
}
function setCreditCard($cc)
{
		$this->creditCard['creditCard'] = $cc;
		return $this;
}
function setCustomer($customer)
{
	$this->customer = $customer;
	return $this;
}
function setOptions($options)
{
	$this->options['options'] = $options;
	return $this;
}
function setAmount($amount)
{
$this->amount = $amount;
return $this;
}
function load()
{
  
        if(self::$__instance == NULL) self::$__instance = new bookingBraintree;
        return self::$__instance;
    	
}
function execute()
{
	///array('number' => '5105105105105100','expirationMonth' => '05','expirationYear' => '14')
	




	$arr = array_merge($this->amount,$this->customer,$this->creditCard,$this->options);
	
	$collection = Braintree_Transaction::search(array(
  Braintree_TransactionSearch::customerId()->is($arr['customer']['id']),
));
if($collection->maximumCount() > 0)
{

$result = Braintree_Transaction::sale(
  array(
    'customerId' => $arr['customer']['id'],
    'amount' => $arr['amount']
  )
);
if ($result->success) {
echo json_encode(array('type'=>'success','response'=>'payment amount: '.$arr['amount'].' Your transaction id : '.$result->transaction->id));
	do_action('payment_made',array('message'=>'payment amount: '.$arr['amount'].' transaction id : '.$result->transaction->id));

}elseif ($result->transaction) 
{
	echo json_encode(array('type'=>'error','response'=>$result->message));

} else {
	echo json_encode(array('type'=>'error','response'=>$result->message));

	
}
}else{

$result = Braintree_Transaction::sale($arr);

if ($result->success) {
	do_action('payment_made',array('message'=>'payment amount: '.$arr['amount'].' transaction id : '.$result->transaction->id));
	
echo json_encode(array('type'=>'success','response'=>'Payment Amount : '.$arr['amount'].'Your transaction id : '.$result->transaction->id));
}elseif ($result->transaction) 
{
	echo json_encode(array('type'=>'error','response'=>$result->message));

} else {
	echo json_encode(array('type'=>'error','response'=>$result->message));

	
}



	
}
	
}
			
}
		






?>