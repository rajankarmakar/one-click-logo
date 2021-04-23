<?php

namespace OneClickLogo;

/**
 * Handle the login page logo
 */
class Addlogo {
    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'login_enqueue_scripts', array( $this, 'change_logo' ) );
    }

    /**
     * Change logo for the login page
     *
     * @return void
     */
    public function change_logo() {
        $logo_url = get_option( 'ocl_url' );

        if ( ! empty( $logo_url ) ) {
            ?>
            <style type="text/css">
                #login h1 a, .login h1 a {
                    background-image: url(<?php echo esc_url( $logo_url ); ?> );
                    height: 150px;
                    width: 150px;
                    background-size: 150px;
                    background-repeat: no-repeat;
                    border-radius: 50%;
                }
            </style>
            <?php
        }
    }
}
