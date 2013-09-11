<?php
include 'BookingSystemMetaBoxes.php';
class BookingPostType {
private $capabilities;
private $labels;
public $meta_boxes;
public $post_type = 'booking';
private $BookingSystem;
private $metas = array('pickup_time','pickup_location','dropoff_location','vehicle','payment_type','flight_name','flight_number','pickup_note');
function __construct($b)
{
	$this->BookingSystem = $b;
$this->capabilities = array('edit_post' => 'edit_booking', 'read_post' => 'read_booking', 'delete_post' => 'delete_booking', 'edit_posts' => 'edit_bookings', 'edit_others_posts' => 'edit_others_bookings', 'publish_posts' => 'publish_bookings', 'read_private_posts' => 'read_private_bookings', 'delete_posts' => 'delete_bookings','delete_published_posts' => 'delete_published_bookings', 'edit_published_posts' => 'edit_published_bookings');

$this->labels = array(
            'name' => _x('Bookings', $this->post_type),
            'singular_name' => _x('Booking', $this->post_type),
            'add_new' => _x('Add Booking', $this->post_type),
            'add_new_item' => _x('Add New booking', $this->post_type),
            'edit_item' => _x('Edit Booking', $this->post_type),
            'new_item' => _x('New Booking', $this->post_type),
            'view_item' => _x('View booking', $this->post_type),
            'search_items' => _x('Search bookings', $this->post_type),
            'not_found' => _x('No bookings found', $this->post_type),
            'not_found_in_trash' => _x('No bookings found in Trash', $this->post_type),
            'parent_item_colon' => _x('Parent booking:', $this->post_type),
            'menu_name' => _x('Bookings', $this->post_type)
        );	
	
			add_action('BookingSystem_init',array(&$this,'init'));
		   add_action('BookingSystem_admin_init',array(&$this,'admin_init'));
			add_action('BookingSystem_trash_to_publish',array(&$this,'trash_to_publish'));
			add_action('BookingSystem_publish_to_trash',array(&$this,'publish_to_trash'));
		   add_action('BookingSystem_before_delete_post',array(&$this,'before_delete_post'));
		   add_action('BookingSystem_save_post',array(&$this,'save_post'));

}
public function init()
{
		$this->create_custom_post_type();

//	return $this;
}
public function admin_init()
{

$this->meta_boxes = new BookingSystemMetaBoxes();
$this->meta_boxes->add_meta_boxes();
$this->meta_boxes->remove_meta_boxes();
	
//	return $this;
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
            'capability_type' => $this->post_type,
            'map_meta_cap' => true,
            'capabilities' => $this->capabilities
            
        );
        
        register_post_type($this->post_type, $args);
        	
	
}
public function get_meta_keys()
{
return $this->metas;	
	
}
public function get_labels()
{
return $this->labels;	
}
public function get_capabilities()
{
return $this->capabilities;	
}
public function get_post($post_id)
{
return get_post($post_id);
	
}
/**
 * Post_id 
 * Data
 * 
 * */
public function save_post($arr)
{

	extract($arr);
	$post = get_post($post_id);
	if (!wp_is_post_revision($post_id))
	{
  		   remove_action('BookingSystem_save_post',array(&$this,'save_post'));

$my_post = array(
      'ID'           => $post_id,
      'post_title' => time(),
      'post_status'=>'publish'
  );

  wp_update_post( $my_post );
  		   add_action('BookingSystem_save_post',array(&$this,'save_post'));

	}
  
	if($post->post_type == $this->post_type)
	{
		foreach($this->metas as $meta)
		{
			if(isset($data[$meta]))
			{
            update_post_meta( $post_id, $meta, $data[$meta] );
			}
        }
	    $this->BookingSystem->reporting_module->create_report($post_id);
     	$title = $this->BookingSystem->reporting_module->get_report_title();
	    $description = $this->BookingSystem->reporting_module->get_report_description();
		do_action('notify_dispatch',array('type'=>'save_post','subject'=>''.$title,'message'=> $description,'post_id'=>$post_id));

	}
	return false;
	
}

public function get_meta_values($post_id)
{
	$arr = array();
	foreach($this->metas as $meta)
		{
            $arr[$meta] = get_post_meta( $post_id, $meta, true);
        }
        return $arr;
	
}
public function is_booking($type)
{
if($type == $this->post_type)
{
return true;	
}
return false;	
}
public function before_delete_post($post_id)
{
	global $post_type;   

    if ( $this->is_booking($post_type) == false ) return;
    
    
    $this->BookingSystem->reporting_module->create_report($post_id);
	$title = $this->BookingSystem->reporting_module->get_report_title();
	$description = $this->BookingSystem->reporting_module->get_report_description();

	do_action('notify_dispatch',array('type'=>'cancelled','subject'=>'Cancelled '.$title,'message'=> $description,'post_id'=>$post_id));

}
public function trash_to_publish($post)
{
	if($this->is_booking($post->post_type) == false) return;
	$this->BookingSystem->reporting_module->create_report($post->ID);
	$title = $this->BookingSystem->reporting_module->get_report_title();
	$description = $this->BookingSystem->reporting_module->get_report_description();
	
	
		do_action('notify_dispatch',array('type'=>'trash_to_publish','subject'=>'Initiated '.$title,'message'=> $description,'post_id'=>$post->ID));


	
}
public function publish_to_trash($post)
{
	if($this->is_booking($post->post_type) == false) return;
	$this->BookingSystem->reporting_module->create_report($post->ID);
	$title = $this->BookingSystem->reporting_module->get_report_title();
	$description = $this->BookingSystem->reporting_module->get_report_description();
		do_action('notify_dispatch',array('type'=>'publish_to_trash','subject'=>'Suspended '.$title,'message'=> $description,'post_id'=>$post->ID));
	
//	do_action('notify_dispatch','publish_to_trash','Suspended '.$title, $description,$post->ID);
	//return $this;
}
public function delete_post($post)
{
		//do_action('notify_dispatch','delete_post',$post->ID);

//	return $this;
	
}
	
}


?>