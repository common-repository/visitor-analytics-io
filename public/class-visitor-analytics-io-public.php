<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.visitor-analytics.io/
 * @since      1.0.0
 *
 * @package    Visitor_Analytics_IO
 * @subpackage Visitor_Analytics_IO/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Visitor_Analytics_IO
 * @subpackage Visitor_Analytics_IO/public
 * @author     Visitor Analytics <wordpress@visitor-analytics.io>
 */
class Visitor_Analytics_IO_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Visitor_Analytics_IO_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Visitor_Analytics_IO_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Visitor_Analytics_IO_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Visitor_Analytics_IO_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	}
    
    public function vafw_tracking_code() {
        $vap_options = json_decode(get_option('visitor_analytics_io'), true);
        if(isset($vap_options['trackingCode']) && ($vap_options['trackingCode'] != '' || $vap_options['trackingCode'] != null)){
            $tracking_code = $vap_options['trackingCode'];
        }else{
            $tracking_code = '';
        }
        echo $tracking_code;
    }

}
