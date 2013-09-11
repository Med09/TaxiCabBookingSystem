<?php
class BookingPostType {
	
function __construct()
{
$this->capabilities = array('edit_post' => 'edit_booking', 'read_post' => 'read_booking', 'delete_post' => 'delete_booking', 'edit_posts' => 'edit_bookings', 'edit_others_posts' => 'edit_others_bookings', 'publish_posts' => 'publish_bookings', 'read_private_posts' => 'read_private_bookings', 'delete_posts' => 'delete_bookings','delete_published_posts' => 'delete_published_bookings', 'edit_published_posts' => 'edit_published_bookings');

$this->labels = array(
            'name' => _x('Bookings', 'booking'),
            'singular_name' => _x('Booking', 'booking'),
            'add_new' => _x('Add Booking', 'booking'),
            'add_new_item' => _x('Add New booking', 'booking'),
            'edit_item' => _x('Edit Booking', 'booking'),
            'new_item' => _x('New Booking', 'booking'),
            'view_item' => _x('View booking', 'booking'),
            'search_items' => _x('Search bookings', 'booking'),
            'not_found' => _x('No bookings found', 'booking'),
            'not_found_in_trash' => _x('No bookings found in Trash', 'booking'),
            'parent_item_colon' => _x('Parent booking:', 'booking'),
            'menu_name' => _x('Bookings', 'booking')
        );	
	
	
}
public function create_custom_post_type()
{

        
        $args = array(
            'labels' => $this->labels,
            'hierarchical' => true,
            'supports' => false,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'booking',
            'map_meta_cap' => true,
            'capabilities' => $this->capabilities
            
        );
        
        register_post_type('booking', $args);
        	
	
}
public function save_post()
{
	
	
}
public function trash_to_publish()
{
	
	
}
public function publish_to_trash()
{
	
}
public function delete_post()
{
	
	
}
	
}
?>