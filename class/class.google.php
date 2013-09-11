<?php
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_CalendarService.php';


class booking_google_client
{
public  $client;
public  $calendar;
public  $options;
function __construct()
{
$this->options = get_option('plugin_options');
$this->client = new Google_Client();
$this->client->setApplicationName('Google+ PHP Starter Application');
// Visit https://code.google.com/apis/console?api=plus to generate your
// client id, client secret, and to register your redirect uri.
/*$this->client->setClientId('901119750716.apps.googleusercontent.com');
$this->client->setClientSecret('u0a_gXeGGQ4uDiONIu60SmU3');
$this->client->setRedirectUri('http://taxicab.rankdevelopment.com');
$this->client->setDeveloperKey('AIzaSyBzDpxdRKsnvyIkYpTyaPC0-CDyPiwIiqM');
$this->calendar = new Google_CalendarService($this->client);*/
$this->client->setClientId($this->options['google_client_id']);
$this->client->setClientSecret($this->options['google_client_secret']);
$this->client->setRedirectUri(get_site_url());
$this->client->setDeveloperKey($this->options['google_developer_key']);
$this->calendar = new Google_CalendarService($this->client);


if (get_option('google_oauth')) {
    $call = get_option('google_oauth');
    
$this->client->setAccessToken($call);
}




}

public  function get_client()
{
}
	
	
}





?>