<?php
if (!defined('ABSPATH')) {
	exit;
}


/**
*/
class VisitorAnalytics {

	/**
	*/
	public function __construct() {
		
	}

	/**
	*/
	public function init() {
		// 
		$this->init_admin();
		$this->enqueue_jquery();
    	$this->enqueue_tracking_script();
    	$this->enqueue_admin_styles();
		$this->enqueue_admin_js();
	}

	/**
	* add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $callback = '', string $icon_url = '', int|float $position = null ): string
	*/
	public function add_plugin_admin_menu() {
		// 
		add_menu_page(
			'TWIPLA', 	// page_title
			'TWIPLA', 	// menu_title
			'manage_options', 			// capability 
			'visitor-analytics-v2',		// $this->plugin_name, 		// menu_slug 
			array($this, 'display_plugin_setup_page'), // callback
			'/images/va-icon.svg', // VISITOR_ANALYTICS_IO_ADMIN_URL . '/images/va-icon.svg', // icon_url
			6	// position 
		);
	}
		
	/**
	*/
	public function display_plugin_setup_page() {
        include_once('partials/dashboard-iframe.php');
    }
	
	
	/**
	*/
	public function visitor_analytics_activation() {
		exit(wp_redirect(admin_url('options-general.php?page=visitor_analytics_settings')));
	}
	
	/**
	*/
	public function init_admin() {
		// register the setting to save the website id
		register_setting('visitor_analytics', 'visitor_analytics_site_id');
		register_setting('visitor_analytics', 'visitor_analytics_version');
		register_setting('visitor_analytics', 'visitor_analytics_migration_done');
		
		// register the settings page 
    	add_action('admin_menu', array( $this, 'create_nav_page'));
		
		// register the dashboad shortcut 
		// add_action('admin_menu', array( $this, 'add_plugin_admin_menu'));
	}
	
	/**
	*/
	public function create_nav_page() {
		add_options_page(
		  esc_html__( 'TWIPLA', 'visitoranalytics' ), 
		  esc_html__( 'TWIPLA', 'visitoranalytics' ), 
		  'manage_options',
		  'visitor_analytics_settings',
		  array($this,'admin_view')
		);
	}
		
	
	/**
	*/
	public static function admin_view() {
		// 
		require_once plugin_dir_path( __FILE__ ) . '/../admin/views/settings.php';
	}

	/**
	*/
	public static function visitor_analytics_script() {
		// 
		$visitor_analytics_site_id = esc_attr(get_option('visitor_analytics_site_id'));
		$is_admin = is_admin();

		// 
		$visitor_analytics_site_id = trim($visitor_analytics_site_id);
		if (!$visitor_analytics_site_id) {
			return;
		}
	
		// 
		if($is_admin) {
			return;
		}

		echo "<!-- START: VISA Tracking Code --><script>(function(v,i,s,a,t){v[t]=v[t]||function(){(v[t].v=v[t].v||[]).push(arguments)};if(!v._visaSettings){v._visaSettings={}}v._visaSettings[a]={v:'1.0',s:a,a:'1',t:t};var b=i.getElementsByTagName('body')[0];var p=i.createElement('script');p.defer=1;p.async=1;p.src=s+'?s='+a;b.appendChild(p)})(window,document,'//app-worker.visitor-analytics.io/main.js','".$visitor_analytics_site_id."','va')</script><!-- END: VISA Tracking Code -->";
	}
	
	/**
	*/
	private function enqueue_jquery() {
		// add jquery to the admin settings page 
		// add_action('wp_head', 'jquery');
	}
	
	/**
	*/
	private function enqueue_tracking_script() {
		// add_action('wp_head', array($this, 'visitor_analytics_script'));
		add_action('wp_footer', array($this, 'visitor_analytics_script'));
	}
	
	/**
	*/
    private function enqueue_admin_styles() {
        add_action('admin_enqueue_scripts', array($this, 'visitor_analytics_admin_styles'));
    }

	/**
	*/
    public static function visitor_analytics_admin_styles() {
        wp_register_style('visitor_analytics_custom_admin_style', plugins_url( '../admin/static/css/admin.css', __FILE__ ), array(), '20190701', 'all' );
        wp_enqueue_style('visitor_analytics_custom_admin_style' );
    }
	
	/**
	*/
    private function enqueue_admin_js() {
        add_action('admin_enqueue_scripts', array($this, 'visitor_analytics_admin_js'));
    }
	
	/**
	*/
	public function visitor_analytics_admin_js() {
		wp_enqueue_script('visitor_analytics_custom_admin_js', plugins_url( '../admin/static/js/jquery.js', __FILE__ ), array(), '20190701', 'all' );
	}

}

?>
