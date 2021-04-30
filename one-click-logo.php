<?php
/**
 * Plugin Name:       One Click Logo
 * Description:       Change logo of the login page with a single click.
 * Version:           1.1.3
 * Requires at least: 5.6
 * Requires PHP:      5.6
 * Author:            Rajan Karmaker
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain:       one-click-logo
 * Domain Path:       /languages/
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

if ( ! class_exists( 'One_Click_Logo' ) ) {
    /**
     * Plugin main class
     */
    final class One_Click_Logo {
        /**
         * Plugin version
         *
         * @var string version
         */
        const version = '1.1.3';

        /**
         * Class constructor
         */
        private function __construct() {
            register_activation_hook( __FILE__, array( $this, 'activate' ) );

            add_action( 'init', array( $this, 'ocl_load_text_domain' ) );

            $this->define_constants();

            add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
        }

        /**
         * Load plugins
         *
         * @return void
         */
        public function init_plugin() {
            if ( is_admin() ) {
                new OneClickLogo\Settings();
            }

            new OneClickLogo\Addlogo();
        }

        /**
         * Load plugin textdomain
         *
         * @return void
         */
        public function ocl_load_text_domain() {
            load_plugin_textdomain( 'one-click-logo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        /**
         * Define all necessary constants
         *
         * @return void
         */
        public function define_constants() {
            define( 'OCL_VERSION', self::version );
            define( 'OCL_BASE_NAME', plugin_basename( __FILE__ ) );
            define( 'OCL_PATH', __DIR__ );
            define( 'OCL_FILE', __FILE__ );
            define( 'OCL_URL', plugins_url( '', OCL_FILE ) );
            define( 'OCL_ASSETS', OCL_URL . '/assets' );
        }

        /**
         * Save plugin version and install time to db
         *
         * @return void
         */
        public function activate() {
            $installed = get_option( 'ocl_installed' );

            if ( ! $installed ) {
                update_option( 'ocl_installed', time() );
            }

            update_option( 'ocl_version', OCL_VERSION );
        }

        /**
         * Initialize a singleton instance
         *
         * @return object \One_Click_Logo
         */
        public static function init() {
            static $instance = false;

            if ( ! $instance ) {
                $instance = new self();
            }

            return $instance;
        }
    }
}

/**
 * Initialize the plugin
 *
 * @return object \One_Click_Logo
 */
function ocl_one_click_logo_boot() {
    return One_Click_Logo::init();
}

// Start the plugin
ocl_one_click_logo_boot();
