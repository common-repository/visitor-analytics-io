<?php
/**
 * Plugin Name: TWIPLA
 * Description: The Website Intelligence Platform. - Unlock Your Website’s True Potential! Goodbye Awkward Analytics. Welcome Website Intelligence.

URL: https://www.twipla.com.io/en/ © TWIPLA
 * Author: TWIPLA
 * Author URI: https://www.twipla.com/
 * Version: 1.3.0
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain: visitor-analytics
 *
 */

if(!defined('ABSPATH')) {
	exit;
}

// add initialization action 
add_action('plugins_loaded', 'VisitorAnalytics_plugin_init');

// 
register_activation_hook(__FILE__, 'visitor_analytics_activation');
function visitor_analytics_activation() {
	// exit(wp_redirect(admin_url('/wp-admin/options-general.php?page=visitor_analytics_settings')));
	// exit(wp_redirect('options-general.php?page=visitor_analytics_settings'));
}

// do not auto-update user on updates
add_filter('auto_plugin_update_send_email', '__return_false');

/**
*/
function VisitorAnalytics_plugin_init() {

	if (!class_exists('WP_VisitorAnalytics')):

		class WP_VisitorAnalytics {
			/**
			 * @var Const Plugin Version Number
			 */
			const VERSION = '1.1.0';

			/**
			 * @var Singleton The reference the *Singleton* instance of this class
			 */
			private static $instance;
			
			/**
			 * Returns the *Singleton* instance of this class.
			 *
			 * @return Singleton The *Singleton* instance.
			 */
			public static function get_instance() {
				if ( null === self::$instance ) {
					self::$instance = new self();
				}
				return self::$instance;
			}

			private function __clone() {}

			public function __wakeup() {}

			/**
			 * Protected constructor to prevent creating a new instance of the
			 * *Singleton* via the `new` operator from outside of this class.
			 */
			private function __construct() {
				add_action('admin_init', array($this, 'install'));
				$this->init();
				// redirect now
				//$this->redirectToTheSettingsPage();
				add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [ $this, 'add_action_links' ] );
				add_filter( 'plugin_row_meta', [ $this, 'add_row_meta' ], 10, 4 );
			}

			/**
			 * Init the plugin after plugins_loaded so environment variables are set.
			 *
			 * @since 1.0.0
			 */
			public function init() {
				require_once( dirname( __FILE__ ) . '/includes/class-visitoranalytics.php' );
				// derive class 
				$VisitorAnalytics = new VisitorAnalytics();
				$VisitorAnalytics->init();
				// redirect to the settings page 
				// wp_redirect('options-general.php?page=visitor_analytics_settings');
				// exit; // wp_redirect does not exit()
			}
			
			/**
			*/
			public function redirectToTheSettingsPage() {
				//
				exit(wp_redirect('options-general.php?page=visitor_analytics_settings'));
			}

			/**
			 * Updates the plugin version in db
			 *
			 * @since 1.0.0
			 */
			public function update_plugin_version() {
				delete_option('visitor_analytics_version');
				update_option('visitor_analytics_version', self::VERSION);
			}

			/**
			 * Handles upgrade routines.
			 *
			 * @since 1.0.0
			 */
			public function install() {
				if(!is_plugin_active(plugin_basename( __FILE__ ))) {
					return;
				}

				if(( self::VERSION !== get_option('visitor_analytics_version'))) {
					$this->update_plugin_version();
				}
			}

			/**
			 * Adds plugin action links.
			 *
			 * @since 1.2.0
			 */
			public function add_action_links( $links ) {
				$plugin_links = array(
					'<a href="https://www.twipla.com/en/pricing">Get Premium TWIPLA</a>',
					'<a href="' . admin_url( "options-general.php?page=visitor_analytics_settings" ) . '">Settings</a>',
					'<a href="https://www.twipla.com/en/support/all-about-features">Support</a>',
				);
				return array_merge( $links, $plugin_links );
			}

			/**
			 * Adds plugin row meta.
			 *
			 * @since 1.2.0
			 */
			public function add_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
				$plugin_links = [];
				if ( strpos( $plugin_file, basename(__FILE__) ) ) {
					$plugin_links = array(
						'<a target="_blank" href="https://app.twipla.com/register?voucher=WP_UNLIMITED30">Get 30 Days of FREE Premium TWIPLA Now!</a>',
					);
				}
				
				return array_merge( $plugin_meta, $plugin_links );
			}
		}

		WP_VisitorAnalytics::get_instance();
	endif;
}
