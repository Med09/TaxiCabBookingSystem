<?php
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
i made this




than this!
require_once 'modules/BookingSystemSMS.php';
require_once 'postTypes/BookingPostType.php';
require_once 'modules/BookingSystemOptionsModule.php';
require_once 'modules/BookingSystemBrainTreeModule.php';
require_once 'modules/BookingSystemRoleModule.php';
require_once 'modules/BookingSystemUserModule.php';
require_once 'modules/BookingSystemMenuModule.php';
require_once 'modules/BookingSystemScriptModule.php';
require_once 'modules/BookingSystemLoginPageModule.php';
require_once 'modules/BookingSystemReportModule.php';
require_once 'modules/BookingSystemFilterModule.php';
require_once 'modules/BookingSystemGoogleModule.php';
require_once 'modules/BookingSystemResponseModule.php';
require_once 'modules/BookingSystemEmail.php';

class BookingSystem
{
    function __construct()
    {
        add_action('init', array(
            &$this,
            'init'
        ));
        add_action('admin_init', array(
            &$this,
            'admin_init'
        ));
        
        
        add_action('wp_enqueue_scripts', array(
            &$this,
            'wp_enqueue_scripts'
        ));
        add_action('wp_print_scripts', array(
            &$this,
            'wp_print_scripts'
        ), 1);        
        add_action('admin_enqueue_scripts', array(
            &$this,
            'admin_enqueue_scripts'
        ));
        add_action('admin_print_scripts', array(
            &$this,
            'admin_print_scripts'
        ));
        add_action('admin_print_styles', array(
            &$this,
            'admin_print_styles'
        ));
        
        add_action('login_enqueue_scripts', array(
            &$this,
            'login_enqueue_scripts'
        ));
        add_action('login_print_styles', array(
            &$this,
            'login_print_styles'
        ));
        
        add_action("login_head", array(
            &$this,
            'login_head'
        ));
        add_action('publish_to_trash', array(
            &$this,
            'publish_to_trash'
        ));
        add_action('trash_to_publish', array(
            &$this,
            'trash_to_publish'
        ));
        add_action('before_delete_post', array(
            &$this,
            'before_delete_post'
        ));
        
        
        add_action('admin_footer', array(
            &$this,
            'admin_footer'
        ));
        add_action('wp_footer', array(
            &$this,
            'wp_footer'
        ));
        add_action('login_enqueue_scripts', array(
            &$this,
            'login_enqueue_scripts'
        ));
        add_action('wp_before_admin_bar_render', array(
            &$this,
            'wp_before_admin_bar_render'
        ));
        add_action('admin_head', array(
            &$this,
            'admin_head'
        ));
        add_action('wp_ajax_existingcustomer', array(
            &$this,
            'wp_ajax_existingcustomer'
        ));
        add_action('wp_ajax_nopriv_existingcustomer', array(
            &$this,
            'wp_ajax_nopriv_existingcustomer'
        ));
        add_action('wp_ajax_newcustomer', array(
            &$this,
            'wp_ajax_newcustomer'
        ));
        add_action('wp_ajax_nopriv_newcustomer', array(
            &$this,
            'wp_ajax_nopriv_newcustomer'
        ));
        add_action('wp_ajax_prepay', array(
            &$this,
            'wp_ajax_prepay'
        ));
        add_action('wp_ajax_nopriv_prepay', array(
            &$this,
            'wp_ajax_nopriv_prepay'
        ));
        add_action('manage_booking_posts_custom_column', array(
            &$this,
            'manage_booking_posts_custom_column'
        ));
        add_action('admin_menu', array(
            &$this,
            'admin_menu'
        ), 999);
        add_action('load-profile.php', array(
            &$this,
            'disable_user_profile'
        ));
        add_action('save_post', array(
            &$this,
            'save_post'
        ));
        add_action('BookingSystem_notify_dispatch', array(
            &$this,
            'notify_dispatch'
        ));
        add_action('publish_post', array(
            &$this,
            'publish_post'
        ), 10, 2);
        
        
        
        
        
        
        
        ///creates the booking custom post type;
        $this->booking_post_type = new BookingPostType($this);
        ///loads the options module
                        $this->google_module = new BookingSystemGoogleModule($this);

        $this->options_module    = new BookingSystemOptionsModule($this);
        $this->roles_module      = new BookingSystemRoleModule($this);
        $this->user_module       = new BookingSystemUserModule($this);
        $this->menu_module       = new BookingSystemMenuModule($this);
        $this->script_module     = new BookingSystemScriptModule($this);
        $this->login_page_module = new BookingSystemLoginPageModule($this);
        $this->reporting_module  = new BookingSystemReportModule($this);
        $this->filter_module     = new BookingSystemFilterModule($this);
        $this->response_module  = new BookingSystemResponseModule($this);
        $this->sms_module       = new BookingSystemSMS($this);
        $this->email_module     = new BookingSystemEmail($this);
        $this->braintree_module = new BookingSystemBrainTreeModule($this);

        
    }
    public function init()
    {
        do_action('BookingSystem_init');
        
    }
    function publish_post($post_id, $post)
    {
        
        
    }
    public function admin_init()
    {
        do_action('BookingSystem_admin_init');
    }
    public function admin_menu()
    {
        do_action('BookingSystem_admin_menu');   
    }
    public function admin_head()
    {
        do_action('BookingSystem_admin_head');
        
        if (!current_user_can('administrator')) {
            
            
        }
        
    }
    public function wp_ajax_prepay()
    {
        
        $this->wp_ajax_nopriv_prepay();
    }
    public function wp_ajax_nopriv_prepay()
    {  
        do_action('BookingSystem_prepay', $_POST['data']);
       
    }
    public function wp_ajax_nopriv_existingcustomer()
    {
        $this->wp_ajax_existingcustomer();
    }
    
    
    
    public function wp_ajax_existingcustomer()
    {
    	$data = $_REQUEST['data'];
        do_action('BookingSystem_login_existing_customer',$data);
        
        
        $post    = array(
            'post_status' => 'publish',
            'post_title' => time(),
            'post_type' => 'booking' 
        );
     

        $post['post_author'] = $this->user_module->logged_in_user->data->ID;
        
        $booking_id = wp_insert_post($post);
        do_action('BookingSystem_save_post', array('post_id' => $booking_id,'data' => $data));
        
        
        do_action('BookingSystem_ajax_response',array('type'=>'success','message'=>$this->reporting_module->get_report_description()));
        //echo $this->response_module->success($this->reporting_module->get_report_description());
        
        die();
    }
    
    public function wp_ajax_nopriv_newcustomer()
    {
        
        $this->wp_ajax_newcustomer();
    }
    
    public function wp_ajax_newcustomer()
    {
        
        $data = $_REQUEST["data"];

        
        
                do_action('BookingSystem_login_new_customer',$data);


                
        $post = array(
            'post_status' => 'publish',
            'post_title' => time(),
            'post_type' => 'booking' //You may want to insert a regular post, page, link, a menu item or some custom post type
        );
   
        $post['post_author'] =  $this->user_module->logged_in_user->data->ID;
        $booking_id          = wp_insert_post($post);
        do_action('BookingSystem_save_post', array(
            'post_id' => $booking_id,
            'data' => $data
        ));
        
        do_action('BookingSystem_ajax_response',array('type'=>'success','message'=>$this->reporting_module->get_report_description()));
        ///echo $this->response_module->success($this->reporting_module->get_report_description());
        die();       
    }
    public function admin_footer()
    {
        
        $this->add_modals();
    }
    public function wp_footer()
    {
        $this->add_modals();
        
    }
    public function add_modals()
    {
        
        require_once ROOTPATH . 'views/modals.php';
        
    }
    
    public function is_booking($post)
    {
        if ($post == $this->booking_post_type->post_type) {
            return true;
        }
        return false;
    }
    
    public function disable_user_profile()
    {
        if (is_admin()) {
            
            $user = wp_get_current_user();
            
            if (2 == $user->ID)
                wp_die('You are not allowed to edit the user profile on this demo.');
            
        }
        
    }
    
    
    public function wp_before_admin_bar_render()
    {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo'); // Remove the WordPress logo
        $wp_admin_bar->remove_menu('about'); // Remove the about WordPress link
        $wp_admin_bar->remove_menu('wporg'); // Remove the WordPress.org link
        $wp_admin_bar->remove_menu('documentation'); // Remove the WordPress documentation link
        $wp_admin_bar->remove_menu('support-forums'); // Remove the support forums link
        $wp_admin_bar->remove_menu('feedback'); // Remove the feedback link
        $wp_admin_bar->remove_menu('site-name'); // Remove the site name menu
        $wp_admin_bar->remove_menu('view-site'); // Remove the view site link
        $wp_admin_bar->remove_menu('updates'); // Remove the updates link
        $wp_admin_bar->remove_menu('comments'); // Remove the comments link
        $wp_admin_bar->remove_menu('new-content'); // Remove the content link
        $wp_admin_bar->remove_menu('w3tc'); // If you use w3 total cache remove the performance link
        //  $wp_admin_bar->remove_menu('my-account');       // Remove the user details tab    
        
    }
    public function new_booking($post_id)
    {
        $calendar            = $this->options_module->get_option('google_calendar');
        $post                = $this->booking_post_type->get_post($post_id);
        $booking_meta_values = $this->booking_post_type->get_meta_values($post_id);
        $this->reporting_module->create_report($post_id, $booking_meta_values);
        $title           = $this->reporting_module->get_report_title();
        $description     = $this->reporting_module->get_report_description();
        $pickup_location = $this->reporting_module->get_pickup_location();
        $pickup_time     = $this->reporting_module->get_pickup_time();
        
        $eventid = get_post_meta($post_id, 'eventid', false);
        if ($eventid) {
            $this->google_module->set_calendar($calendar);
            $this->google_module->set_event_id($eventid);
            $deleted = $this->google_module->delete_event();
            if ($deleted) {
                update_post_meta($post_id, 'eventid', false);
            }
        }
        $this->google_module->set_title($title);
        $this->google_module->set_description($description);
        $this->google_module->set_pickup_location($pickup_location);
        $this->google_module->set_pickup_time($pickup_time);
        $event = $this->google_module->create_event();
        $this->google_module->insert_event($calendar, $event);
        update_post_meta($post_id, 'eventid', $this->google_module->get_event_id());
        
        return $this->reporting_module;
    }
    public function save_post($post_id)
    {
        
        if (!isset($_POST['post_type']) || 'booking' != $_POST['post_type']) {
            return;
        }
        $data = isset($_POST['data']) ? $_POST['data'] : $_POST;
        
        
        do_action('BookingSystem_save_post', array(
            'post_id' => $post_id,
            'data' => $data
        ));
        
        
        //$saved = $this->booking_post_type->save_post($post_id,$data);
        //if($saved == false) {return false;}
        
        //$this->new_booking($post_id);
        
        
        
        
    }
    public function manage_booking_posts_custom_column($name)
    {
        global $post;
        
        switch ($name) {
            case 'contact':
                $author_id    = $post->post_author;
                $display_name = get_the_author_meta('display_name', $author_id);
                $phone        = get_the_author_meta('user_login', $author_id);
                $email        = get_the_author_meta('user_email', $author_id);
?>
<table class="booking-contact">
<tr><td><a><?= $display_name; ?></a></d></tr>
<tr><td><a><?= $phone; ?></a></d></tr>
<tr><td><a><?= $email; ?></a></td></tr>
</table>

<?php
                
                break;
            case 'payment_type':
                echo get_post_meta($post->ID, 'payment_type', true);
                
                break;
            case 'vehicle':
                echo get_post_meta($post->ID, 'vehicle', true);
                
                break;
            case 'pickup_location':
                echo get_post_meta($post->ID, 'pickup_location', true);
                break;
            case 'dropoff_location':
                echo get_post_meta($post->ID, 'dropoff_location', true);
                break;
            case 'pickup_time':
                echo get_post_meta($post->ID, 'pickup_time', true);
                break;
                
                
                
        }
        
    }
    public function publish_to_trash($post)
    {
        
        do_action('BookingSystem_publish_to_trash', $post);
        
    }
    public function trash_to_publish($post)
    {
        do_action('BookingSystem_trash_to_publish', $post);
        
    }
    public function before_delete_post($post_id)
    {

        do_action('BookingSystem_before_delete_post', $post_id);    
    }
    public function admin_enqueue_scripts()
    {
        do_action('BookingSystem_admin_enqueue_scripts');
        
        
        
    }
    public function admin_print_scripts()
    {
        do_action('BookingSystem_admin_print_scripts');
        
        
        
    }
    public function admin_print_styles()
    {
        do_action('BookingSystem_admin_print_styles');
        
        
        
        
        //    $this->script_module->admin_print_styles();
        
        
    }
    
    
    public function wp_enqueue_scripts()
    {
        do_action('BookingSystem_wp_enqueue_scripts');
    }
    public function wp_print_scripts()
    {
        do_action('BookingSystem_wp_print_scripts');
    }
    
    public function login_enqueue_scripts()
    {
        
        do_action('BookingSystem_login_enqueue_scripts');
        
    }
    public function login_print_styles()
    {
        do_action('BookingSystem_login_print_styles');
        
    }
    public function login_head()
    {
        
        
        
        do_action('BookingSystem_login_head');
        
        
        
    }
    
    
    
    
    
    public static function activate()
    {
        
    }
    public static function deactivate()
    {
        
    }
    public static function uninstall()
    {
        
    }
    
}

$m = new BookingSystem();



















if (isset($_GET['logout'])) {
    unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
    $google_client->client->authenticate($_GET['code']);
    add_option('google_oauth', $google_client->client->getAccessToken());
    //$_SESSION['token'] = $client->getAccessToken();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (get_option('google_oauth')) {
    $call = get_option('google_oauth');
    
    //  $client->setAccessToken($call);
}
/*
if ($client->getAccessToken()) {
$calList = $cal->calendarList->listCalendarList();
// print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";






//$_SESSION['token'] = $client->getAccessToken();
} else {
//$authUrl = $client->createAuthUrl();
//print "<a class='login' href='$authUrl'>Connect Me!</a>";
}
*/


add_filter('login_errors', create_function('$a', "return null;"));



class Password_Reset_Removed
{
    
    function __construct()
    {
        //add_filter( 'show_password_fields', array( $this, 'disable' ) );
        // add_filter( 'allow_password_reset', array( $this, 'disable' ) );
        ///add_filter( 'gettext',              array( $this, 'remove' ) );
    }
    
    function disable()
    {
        if (is_admin()) {
            $userdata = wp_get_current_user();
            $user     = new WP_User($userdata->ID);
            if (!empty($user->roles) && is_array($user->roles) && $user->roles[0] == 'administrator')
                return true;
        }
        return false;
    }
    
    function remove($text)
    {
        return str_replace(array(
            'Lost your password?',
            'Lost your password'
        ), '', trim($text, '?'));
    }
}

$pass_reset_removed = new Password_Reset_Removed();



global $pagenow;
if ($pagenow === 'wp-login.php') {
    add_filter('gettext', 'user_email_login_text', 20, 3);
    function user_email_login_text($translated_text, $text, $domain)
    {
        
        if ($text === 'Username') {
            $translated_text = 'Phone';
        }
        if ($text === 'Password') {
            $translated_text = 'PIN';
        }
        if ($text === 'New password') {
            $translated_text = 'New PIN';
        }
        if ($text === 'Confirm new password') {
            $translated_text = 'Confirm new PIN';
        }
        if ($text === 'Username or E-mail:') {
            $translated_text = 'Phone or E-mail:';
        }
        if ($text === 'Your password has been reset.') {
            $translated_text = 'Your pin has been reset.';
        }
        
        
        return $translated_text;
    }
}




function custom_password_form()
{
    global $post;
    
    $password_protected_text = get_post_meta($post->ID, 'passwordtext', true);
    if ($password_protected_text == '') {
        $password_protected_text = 'This post is password protected. To view it please enter your password below:';
    }
    
    $label  = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
    $output = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">
        <p>' . $password_protected_text . '</p>
        <p><label for="' . $label . '">' . __("Password:") . ' <input name="post_password" id="' . $label . '" type="password" size="20" /></label> <input type="submit" name="Submit" value="' . esc_attr__("Submit") . '" /></p>
    </form>';
    return $output;
}
add_filter('the_password_form', 'custom_password_form');
