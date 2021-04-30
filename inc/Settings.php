<?php

namespace OneClickLogo;

/**
 * Handle settings page class
 */
class Settings {
    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'add_settings_for_plugin' ) );
        $plugin_file = OCL_BASE_NAME;
        add_action( 'admin_enqueue_scripts', array( $this, 'ocl_admin_assets' ) );
        add_filter( "plugin_action_links_{$plugin_file}", array( $this, 'add_settings_links' ) );
    }

    /**
     * Enqueuing admin assets.
     *
     * @return void
     */
    public function ocl_admin_assets() {
        wp_enqueue_media();
        wp_enqueue_script(
            'ocl-media-js',
            OCL_ASSETS . '/js/media.js',
            array(
				'jquery',
            ),
            OCL_VERSION,
            true
        );

        wp_enqueue_style( 'ocl-main-style', OCL_ASSETS . '/css/style.css', array(), OCL_VERSION );
    }
    /**
     * Add settings page for the plugin
     *
     * @return void
     */
    public function add_settings_for_plugin() {
        register_setting(
            'media',
            'ocl_url',
            array( 'sanitize_callback' => 'esc_url' )
        );

        add_settings_section(
            'ocl_settings_section',
            __( 'One Click Logo Settings', 'one-click-logo' ),
            array( $this, 'add_settings_section' ),
            'media'
        );

        add_settings_field(
            'ocl_url',
            __( 'Enter logo url', 'one-click-logo' ),
            array( $this, 'display_url_field' ),
            'media',
            'ocl_settings_section'
        );
    }

    /**
     * Display setting section
     *
     * @return void
     */
    public function add_settings_section() {
        printf(
            "<p class='description'>%s</p>",
            __( 'Please add an image url and you are good to go. Image dimension 150 x 150 pixel will be the best fit for logo', 'one-click-logo' )
        );
    }

    /**
     * Display form field
     *
     * @return void
     */
    public function display_url_field() {
        $url = get_option( 'ocl_url' );

        printf(
            "<input class='regular-text ocl_upload_image' type='text' name='%s' id='%s' value='%s' placeholder='%s' /> %s <button id='%s' style='height: 30px' class='page-title-action'>Upload Image</button>",
            esc_attr( 'ocl_url' ),
            esc_attr( 'ocl_url' ),
            esc_attr( esc_url( $url ) ),
            esc_html__( 'Enter logo URL', 'one-click-logo' ),
            esc_html__( 'or', 'one-click-logo' ),
            esc_attr( 'ocl_upload_image' )
        );
        if ( $url ) {
            printf( "<div class='ocl-logo-image-wrap'><img id='ocl-logo-image' class='ocl-logo-image' src ='%s' /></div>", esc_url_raw( $url ) );
        }
    }

    /**
     * Add settings links
     *
     * @param  array $links  all predefined links.
     *
     * @return mixed
     */
    public function add_settings_links( array $links ) {
        $settings_links = sprintf( "<a href='options-media.php#ocl_url'>%s</a>", __( 'Settings', 'one-click-logo' ) );
        $settings_links = wp_kses(
            $settings_links,
            array(
                'a' => array(
                    'href' => array(),
                ),
            )
        );
        array_push( $links, $settings_links );

        return $links;
    }
}
