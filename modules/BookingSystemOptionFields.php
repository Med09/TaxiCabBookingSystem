<?php
//taxi_settings
class BookingSystemOptionFields {
	
private $googleClient;
private $options;
private $BookingSystem;
function __construct($b)
{
	$this->BookingSystem = $b;
	$this->options = $this->BookingSystem->options_module->get_options();
	$this->add_settings();

}
public function add_settings()
{
	/**
	 * @function
	 * <?php add_settings_field( $id, $title, $callback, $page, $section, $args ); ?>
	 * */ 
  add_settings_section('plugin_main', 'BrainTree API', array(&$this,'plugin_section_text'), 'plugin'); 
  add_settings_field('rate_per_mile', 'Rate Per Mile', array(&$this,'rate_per_mile'), 'plugin', 'plugin_main');
  add_settings_field('sms_phone', 'SMS Cellphone', array(&$this,'sms_phone'), 'plugin', 'plugin_main');
  add_settings_field('sms_carrier', 'SMS provider', array(&$this,'sms_carrier'), 'plugin', 'plugin_main');
  add_settings_field('plugin_text_input2', 'Logo', array(&$this,'plugin_input2'), 'plugin', 'plugin_main');
  add_settings_field('phone', 'Phone', array(&$this,'taxi_phone'), 'plugin', 'plugin_main');
  add_settings_field('merchant_id', 'Merchant ID', array(&$this,'merchant_id'), 'plugin', 'plugin_main');
  add_settings_field('public_key', 'Public Key', array(&$this,'public_key'), 'plugin', 'plugin_main');
  add_settings_field('private_key', 'Private Key', array(&$this,'private_key'), 'plugin', 'plugin_main');
  add_settings_field('enc_key', 'Encryption Key', array(&$this,'enc_key'),'plugin', 'plugin_main');	
  add_settings_section('google_settings', 'Google Calendar API', array(&$this,'google_section_text'), 'plugin');
  add_settings_field('google_oauth', 'Google OAuth', array(&$this,'google_oauth'), 'plugin','google_settings'); 
  add_settings_field('google_client_id', 'Client ID', array(&$this,'client_id'), 'plugin','google_settings');	
  add_settings_field('google_client_secret', 'Client Secret', array(&$this,'client_secret'), 'plugin','google_settings');	
  add_settings_field('google_developer_key', 'Developer Key', array(&$this,'developer_key'), 'plugin','google_settings');	
  add_settings_field('google_redirect', 'Google Redirect', array(&$this,'redirect'), 'plugin','google_settings');	
  add_settings_field('google_calendar', 'Google Calendar', array(&$this,'google_calendar'), 'plugin','google_settings');	
  
 /* add_settings_section('email_templates', 'Email Templates', array(&$this,'email_templates_text'), 'plugin'); 
  add_settings_field('confirmation_template', 'Confirmation Template', array(&$this,'confirmation_template'), 'plugin','email_templates'); 
*/
}
public function sms_carrier()
{
?>
   <select name="plugin_options[sms_carrier]" id="carrier">

  <?php echo '<option value="'. @$this->options['sms_carrier'].'" selected>'. @$this->options['sms_carrier'].'</option>';?>
   <option value="verizon">Verizon</option>
   <option value="tmobile">tmobile</option>
	 <option value="sprint">Sprint</option>
	 <option value="att">AT&amp;T</option>
	 <option value="virgin">Virgin Mobile</option>
  </select>
<?php
	
}
public function sms_phone()
{

  echo "<input id='sms_phone' class='normal-text code' name='plugin_options[sms_phone]' size='30' type='text' value='". @$this->options['sms_phone']."' />";
	
	
}
public function rate_per_mile()
{
  echo "<input id='rate_per_mile' class='normal-text code' name='plugin_options[rate_per_mile]' size='30' type='text' value='". @$this->options['rate_per_mile']."' />";
}

public function enc_key()
{
  echo "<input id='private_key' class='normal-text code' name='plugin_options[enc_key]' size='30' type='text' value='". @$this->options['enc_key']."' />";
}

public  function private_key()
{
  echo "<input id='private_key' class='normal-text code' name='plugin_options[private_key]' size='30' type='text' value='". @$this->options['private_key']."' />";
}
public function public_key()
{
  echo "<input id='public_key' class='normal-text code' name='plugin_options[public_key]' size='30' type='text' value='". @$this->options['public_key']."' />";
}
public function merchant_id()
{
  echo "<input id='m1' class='normal-text code' name='plugin_options[merchant_id]' size='30' type='text' value='". @$this->options['merchant_id']."' />";
}
public  function plugin_section_text()
{
  echo '<p>New input setting.</p>';
}

public function plugin_input1()
{
  $options = get_option('plugin_options');
  echo "<input id='plugin_input1' class='normal-text code' name='plugin_options[text_string3]' size='30' type='text' value='{$options['text_string3']}' />";
}


public function plugin_input2()
{
  
  echo "<input id='plugin_input2' class='normal-text code' name='plugin_options[taxi_logo]' size='30' type='text' value='". @$this->options['taxi_logo']."' />";
}
public function taxi_phone()
{
  
  echo "<input id='taxi_phone' class='normal-text code' name='plugin_options[phone]' size='30' type='text' value='". @$this->options['phone']."' />";
}

public function plugin_options_validate($input)
{
  return $input;
}

public function google_section_text()
{
  echo '<p>Google API Settings</p>';
}
public function client_id()
{
  
  echo "<input id='taxi_phone' class='normal-text code' name='plugin_options[google_client_id]' size='30' type='text' value='". @$this->options['google_client_id']."' />";
}
public function client_secret()
{
  
  echo "<input id='taxi_phone' class='normal-text code' name='plugin_options[google_client_secret]' size='30' type='text' value='". @$this->options['google_client_secret']."' />";
} 
public function redirect()
{ 
  echo "<input id='google_redirect' class='normal-text code' name='plugin_options[google_redirect]' size='30' type='text' value='". @$this->options['google_redirect']."' />";
}
public function developer_key()
{
  
  echo "<input id='taxi_phone' class='normal-text code' name='plugin_options[google_developer_key]' size='30' type='text' value='". @$this->options['google_developer_key']."' />";
}
public function google_calendar()
{
  
  echo "<input id='taxi_calendar' class='normal-text code' name='plugin_options[google_calendar]' size='30' type='text' value='". @$this->options['google_calendar']."' />";
}
public function google_oauth()
{


  echo "<a id='google_oauth' href='".@$this->BookingSystem->google_module->client->createAuthUrl()."' class='normal-text button' size='30' type='text'>oauth</a>";

}
public  function email_templates_text()
{
  echo '<p>Email Templates.</p>';
}
public function confirmation_template()
{
	
	  echo "<textarea id='confirmation_template' class='normal-text code' name='plugin_options[confirmation_template]' cols='100'>". @$this->options['confirmation_template']."</textarea>";

}
}

?>