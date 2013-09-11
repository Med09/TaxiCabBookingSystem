<?php
require_once ROOTPATH . 'src/Google_Client.php';
require_once ROOTPATH . 'src/contrib/Google_CalendarService.php';
class BookingSystemGoogleModule
{
	public $active = true;
    private $author;
    private $pickup_location;
    private $description;
    public $google_client;
    private $calendar;
    private $event_id;
    private $title;
    private $BookingSystem;
    public $client;
    private $options = array('google_client_id', 'google_client_secret', 'google_developer_key');
    
    function __construct($b)
    {
    	       $this->client = new Google_Client();

        $this->BookingSystem = $b;

            add_action('notify_dispatch', array(
                &$this,
                'notify_dispatch'
            ));
        
        
        $options      = get_option('plugin_options');
  

        $this->client->setApplicationName('Google+ PHP Starter Application');

        
        
        // Visit https://code.google.com/apis/console?api=plus to generate your
        // client id, client secret, and to register your redirect uri.
        /*$this->client->setClientId('901119750716.apps.googleusercontent.com');
        $this->client->setClientSecret('u0a_gXeGGQ4uDiONIu60SmU3');
        $this->client->setRedirectUri('http://taxicab.rankdevelopment.com');
        $this->client->setDeveloperKey('AIzaSyBzDpxdRKsnvyIkYpTyaPC0-CDyPiwIiqM');
        $this->calendar = new Google_CalendarService($this->client);*/
        $this->client->setClientId($options['google_client_id']);
        $this->client->setClientSecret($options['google_client_secret']);
        $this->client->setRedirectUri(get_site_url());
        $this->client->setDeveloperKey($options['google_developer_key']);
        $this->calendar_service = new Google_CalendarService($this->client);
        
        
        if (get_option('google_oauth')) {
            $call = get_option('google_oauth');
            
            $this->client->setAccessToken($call);
        }
        
        
        
        
        
if (isset($_GET['logout'])) {
    unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
    $this->client->authenticate($_GET['code']);
    add_option('google_oauth', $this->client->getAccessToken());
    //$_SESSION['token'] = $client->getAccessToken();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (get_option('google_oauth')) {
    $call = get_option('google_oauth');
    
  $this->client->setAccessToken($call);
}
        
        
    }
    
    public function notify_dispatch($data)
    {
        extract($data);
        $calendar = $this->BookingSystem->options_module->get_option('google_calendar');
        $post     = get_post($post_id);
        $this->set_author($post->author);
        $this->set_pickup_location(get_post_meta($post_id, 'pickup_location', true));
        $this->set_pickup_time(get_post_meta($post_id, 'pickup_time', true));
        
        $this->set_description($message);
        $this->set_title($subject);
        $this->set_calendar($calendar);
        $event_id = get_post_meta($post_id, 'eventid', false);
        $this->set_event_id($event_id);
        
        switch ($type) {
            case 'save_post':
                if ($event_id) {
                    $this->delete_event();
                    
                }
                $event = $this->create_event();
                $event = $this->insert_event($calendar, $event);
                update_post_meta($post_id, 'eventid', $event['id']);
                break;
            case 'trash_to_publish':
                $event = $this->create_event();
                $event = $this->insert_event($calendar, $event);
                update_post_meta($post_id, 'eventid', $event['id']);
                
                
                break;
            case 'cancelled':
                if ($event_id) {
                    $this->delete_event();
                    
                }
                break;
            case 'publish_to_trash':
                if ($event_id) {
                    $this->delete_event();
                    
                }
                break;
            case '':
                break;
                
                
        }
        
    }
    function set_author($author)
    {
        $this->author = $author;
        return $this;
    }
    function set_pickup_location($pickup_location)
    {
        $this->pickup_location = $pickup_location;
        return $this;
    }
    function set_pickup_time($pickup_time)
    {
        $this->pickup_time = $pickup_time;
        return $this;
    }
    function set_description($description)
    {
        
        $this->description = $description;
        return $this;
    }
    function set_title($title)
    {
        $this->title = $title;
        return $this;
    }
    function set_calendar($calendar)
    {
        $this->calendar = $calendar;
        return $this;
    }
    public function set_event_id($id)
    {
        $this->event_id = $id;
        return $this;
    }
    public function get_event_id()
    {
        return $this->event_id;
    }
    function delete_event($id = null)
    {
        if (isset($id)) {
            $this->event_id = $id;
        }
        
        
        try {
            @$this->calendar_service->events->delete($this->calendar, $this->event_id);
            
        }
        catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        
        
        
        return true;
    }
    public function rfc($timestamp)
    {
        
        if (!$timestamp) {
            $timestamp = time();
        }
        $t    = strtotime($timestamp);
        $date = date('Y-m-d\TH:i:s', $t);
        
        $date .= '-04:00';
        $matches = array();
        
        /* if (preg_match('/^([\-+])(\d{2})(\d{2})$/', date('O', $timestamp), $matches)) {
        $date .= $matches[1].$matches[2].':'.$matches[3];
        } else {
        $date .= 'Z';
        }*/
        return $date;
        
    }
    public function create_event($author = null, $pickup_location = null, $description = null)
    {
        ///rfc    
        if (isset($author)) {
            $this->author = $author;
        }
        if (isset($pickup_location)) {
            $this->pickup_location = $pickup_location;
        }
        if (isset($description)) {
            $this->description = $description;
        }
        
        
        $event = new Google_Event();
        $event->setSummary($this->title);
        $event->setLocation($this->pickup_location);
        $event->setDescription($this->description);
        $start = new Google_EventDateTime();
        $start->setDateTime($this->rfc($this->pickup_time));
        $event->setStart($start);
        $end = new Google_EventDateTime();
        $end->setDateTime($this->rfc($this->pickup_time));
        $event->setEnd($end);
        return $event;
    }
    function insert_event($calendar = null, $event = null)
    {
        if (isset($calendar)) {
            $this->calendar = $calendar;
        }
        if (isset($event)) {
            $this->event = $event;
        }
        
        
        $this->created_event = $this->calendar_service->events->insert($this->calendar, $this->event);
        $this->set_event_id($this->created_event['id']);
        return $this->created_event;
    }
    
    /*
    $val = booking_helper::get_meta_value($post_id,'eventid');
    if(isset($val) && $val != false)
    {
    @$google_client->calendar->events->delete(taxi_booking::$options['google_calendar'], $val); 
    booking_helper::update_meta_value($post_id, 'eventid',  false);
    
    }
    $createdEvent       =  $google_client->calendar->events->insert(taxi_booking::$options['google_calendar'], $event); //Returns array not an objec
    
    
    booking_helper::update_meta_value($post_id, 'eventid',  $createdEvent['id']);
    
    
    */
    
    
    
}
?>