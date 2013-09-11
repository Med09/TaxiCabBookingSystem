<?php
class BookingSystemScriptModule
{
	private $options;
	private $BookingSystem;
	public $isActive;
	function __construct($b)
	{
	
		$this->BookingSystem = $b;
		add_action('BookingSystem_admin_enqueue_scripts',array(&$this,'admin_enqueue_scripts'));
		//add_action('BookingSystem_admin_enqueue_styles',array(&$this,'admin_enqueue_styles'));
		
		add_action('BookingSystem_admin_print_scripts',array(&$this,'admin_print_scripts'));
		add_action('BookingSystem_admin_print_styles',array(&$this,'admin_print_styles'));
		
		add_action('BookingSystem_login_enqueue_scripts',array(&$this,'login_enqueue_scripts'));
		add_action('BookingSystem_login_print_styles',array(&$this,'login_print_styles'));
		
	    add_action('BookingSystem_wp_enqueue_scripts',array(&$this,'wp_enqueue_scripts'));
		add_action('BookingSystem_wp_print_scripts',array(&$this,'wp_print_scripts'));
	
	
	
	return true;
		
	}
    public function admin_enqueue_scripts()
    {
      
        wp_enqueue_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places', array(
            'jquery'
        ));
                wp_enqueue_script('complete', BOOKINGSYSTEM_ROOT.'js/geocomplete.js?' . time(), array('googlemaps','jquery'));

        
        
          wp_enqueue_script('bookingjs', BOOKINGSYSTEM_ROOT.'js/script.js?' .time(), array(
            'jquery','complete','googlemaps'
        ),'',false);
        wp_enqueue_script('braintree', 'https://js.braintreegateway.com/v1/braintree.js', array(
            'jquery'
        ));
        wp_enqueue_script('jquery-ui-timepicker', BOOKINGSYSTEM_ROOT."js/timepicker.js", array(
            'jquery',
            'jquery-ui-datepicker'
        ));
        wp_enqueue_script('jquery-ui-datepicker', 'jquery-ui-datepicker', array(
            'jquery'
        ));
         wp_enqueue_script('poshy', BOOKINGSYSTEM_ROOT.'tooltip/jquery.poshytip.min.js', array(
            'jquery'
        ));
        
        wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
        wp_enqueue_style('taxi-style', BOOKINGSYSTEM_ROOT.'css/style.css?' . time());
        wp_enqueue_style('poshy-style', BOOKINGSYSTEM_ROOT.'tooltip/tip-yellow/tip-yellow.css');
       wp_enqueue_script('leanModal', BOOKINGSYSTEM_ROOT.'js/modal.js', array(
            'jquery'
        ));
        
        return $this;
    }
    public function wp_enqueue_scripts()
    {
        wp_enqueue_script('script1', BOOKINGSYSTEM_ROOT.'js/script.js?' . time(), array(
           'jquery'
        ));
         wp_enqueue_script('poshy', BOOKINGSYSTEM_ROOT.'tooltip/jquery.poshytip.min.js', array(
            'jquery'
        ));
        
         wp_enqueue_script('leanModal', BOOKINGSYSTEM_ROOT.'js/modal.js', array(
            'jquery'
        ));
        
     
        wp_enqueue_script('complete', BOOKINGSYSTEM_ROOT.'js/geocomplete.js?' . time(), array('jquery' ));
    
        wp_enqueue_script('braintree', 'https://js.braintreegateway.com/v1/braintree.js', array(
            'jquery'
        ));
        wp_enqueue_script('jquery-ui-timepicker', BOOKINGSYSTEM_ROOT."js/timepicker.js", array(
            'jquery',
            'jquery-ui-datepicker'
        ));
        wp_enqueue_script('jquery-ui-datepicker', 'jquery-ui-datepicker', array(
            'jquery'
        ));
        wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
        wp_enqueue_style('taxi-style', BOOKINGSYSTEM_ROOT.'css/style.css?' . time());
        wp_enqueue_style('poshy-style', BOOKINGSYSTEM_ROOT.'tooltip/tip-yellow/tip-yellow.css');
        return $this;
    }
    public  function admin_print_scripts()
    {
if(wp_script_is('jquery') == false) {
	wp_enqueue_script('jquery');
}

    if (function_exists('wp_enqueue_media')) {
        wp_enqueue_media();
    } else {
        wp_enqueue_style('thickbox');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
    }
    	return $this;
    }
    public function wp_print_scripts()
    {
    	?>
<script type="text/javascript">
var ajaxurl = '<?= admin_url('admin-ajax.php'); ?>';
var booking_rate_per_mile = "<?=@$this->BookingSystem->options_module->get_option('rate_per_mile')?>";
</script>
<?php
    }
   public  function admin_print_styles()
    {
        wp_enqueue_style('thickbox');	
        	if(!current_user_can('administrator'))//not and admin
{
        ?>
        
        <style>
        .update_nag{display:none !important}
        #update-nag, .update-nag {display:none;}
    ul.subsubsub li a span.count{display:none !important;}     
        </style>
        <?php
        
        
        }
        
    }
    public function login_enqueue_scripts()
    {
    	?>
    	    <link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo TAXIROOT. '/css/style-login.css'; ?>" type="text/css" media="all" />
    	<?php
    	return $this;
    }
    public function login_print_scripts()
    {
    	return $this;
    }
    
    public function login_print_styles()
    {
    	
    	return $this;
    }
    
    
    
    
}
?>
