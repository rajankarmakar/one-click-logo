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
        add_filter( "plugin_action_links_{$plugin_file}", array( $this, 'add_settings_links' ) );
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
            __( 'Please add an image url and you are good to go. Image dimension 150 x 150 pixel will be the best fit for logo', 'we-subscription-form' )
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
            "<input class='regular-text' type='text' name='%s' id='%s' value='%s'",
            esc_attr( 'ocl_url' ),
            esc_attr( 'ocl_url' ),
            esc_attr( esc_url( $url ) )
        );
    }

    /**
     * Add settings links
     *
     * @param  array $links  all predefined links.
     *
     * @return mixed
     */
    public function add_settings_links( array $links ) {
        $settings_links = "<a href='options-media.php#ocl_url'>Settings</a>";
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
