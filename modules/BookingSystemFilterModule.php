<?php
class BookingSystemFilterModule {
	private $BookingSystem;
	private $options;
	function __construct($b)
	{
		$this->BookingSystem = $b;
    add_action('BookingSystem_init',array(&$this,'init'));
    add_action('BookingSystem_admin_init',array(&$this,'admin_init'));
	add_filter( 'wpseo_use_page_analysis', '__return_false' );
    add_filter('screen_options_show_screen', array(&$this,'remove_screen_options_tab'));
    add_filter('contextual_help', array(&$this,'remove_help_tabs'), 999, 3);
    add_filter( 'plugin_row_meta', array(&$this,'add_meta_links'), 10, 2 );
    add_filter('user_contactmethods',array(&$this,'adjust_contact_method'),10,1);
    add_filter( 'allow_password_reset', array(&$this,'disable_reset_lost_password'));
    add_filter( 'admin_footer_text', array(&$this,'wpse_edit_text') );
	add_filter('parse_query', array(&$this,'useronly'));
	add_filter('manage_booking_posts_columns', array(&$this,'my_columns'));
	add_filter('gettext', array(&$this,'change_publish_button'), 10, 2);
	add_filter('post_updated_messages', array(&$this,'filter_booking'));
	add_filter( 'login_headerurl', array(&$this,'custom_login_header_url'));
	add_filter('login_errors', create_function('$a', "return null;"));

}
public function init()
{
	
	
	
}
public function admin_init()
{
	add_filter('login_redirect', array(&$this,'dashboard_redirect')); 	

	
	
}
public function dashboard_redirect($url, $request, $user) {

             $url = 'wp-admin/edit.php?post_type=booking';
        
        return $url;
    
}

	
public function custom_login_header_url($url) {
return get_site_url();
}



function filter_booking($message)
{
    global $post, $post_ID;
    
    
    $messages['Booking'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => sprintf(__('Contact updated. <a href="%s">View Contact</a>'), esc_url(get_permalink($post_ID))),
        2 => __('Custom field updated.'),
        3 => __('Custom field deleted.'),
        4 => __('Contact updated.'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf(__('Contact restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6 => sprintf(__('Contact published. <a href="%s">View Contact</a>'), esc_url(get_permalink($post_ID))),
        7 => __('Contact saved.'),
        8 => sprintf(__('Contact submitted. <a target="_blank" href="%s">Preview Contact</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        9 => sprintf(__('Contact scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Contact</a>'), 
        // translators: Publish box date format, see http://php.net/date
            date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
        10 => sprintf(__('Contact draft updated. <a target="_blank" href="%s">Preview Contact</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID))))
    );
    
    return $messages;
}





public function change_publish_button($translation, $text)
{
    global $post_type;
    if ($post_type == 'booking') {
        if ($text == _x('Publish','booking'))
            return _x('Set Booking', 'booking');
        
        if ($text == _x('Update','booking'))
            return _x('Update Booking', 'booking');
    }
    return $translation;
}





	
		  public  function wpse_edit_text($content)
    {
        return "<a href='http://rankexecutives.com'/>Built by RankExecutives</a>";
	
    }


public function useronly($wp_query)
{
    if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/edit.php') !== false) {
        if (!current_user_can('manage_options')) {
            
            $user_id = get_current_user_id();
            
            $wp_query->set('author', $user_id);
        }
    }
}
function my_columns($columns)
{
    $columns['contact']  = 'Contact';
    $columns['payment_type']  = 'Payment Type';
   $columns['vehicle']  = 'Vehicle'; 
    $columns['pickup_location']  = 'Pickup Location';
    $columns['dropoff_location'] = 'Dropoff Location';
    $columns['pickup_time']      = 'Pickup Date/Time';
        $columns['title']      = 'Booking ID';

    return $columns;
}


	public function disable_reset_lost_password()
	{
		
		return true;
	}
	

	function adjust_contact_method( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
    unset($contactmethods['new_password']);

  return $contactmethods;
}
	public function remove_screen_options_tab()
	{
		return false;
	}
	public function remove_help_tabs($old_help, $screen_id, $screen)
	{
    $screen->remove_help_tabs();
    return $old_help;
	}
	public function add_meta_links( $links, $file ) 
	{
 
	$plugin = plugin_basename(__FILE__);
 
	// create link
	if ( $file == $plugin ) {
	
	
	
		return array_merge(
		array(
			'settings' => '<a href="' . get_bloginfo( 'wpurl' ) . '/wp-admin/edit.php?post_type=booking&page=settings-page">Settings</a>'
		),
		$links
	);
	
	
	}
	return $links;
 
}
	
	
	
}

?>