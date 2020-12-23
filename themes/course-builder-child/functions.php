<?php




function thim_child_enqueue_styles() {

    if ( is_multisite() ) {
        wp_enqueue_style( 'thim-child-style', get_stylesheet_uri(), array('fontawesome','bootstrap','ionicons','magnific-popup','owl-carousel') );
    } else {
        wp_enqueue_style( 'thim-parent-style', get_template_directory_uri() . '/style.css', array('fontawesome','bootstrap','ionicons','magnific-popup','owl-carousel') );
    }
}

add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 1000 );

/*We commented out include custom-functions.php in the parent theme's functions.php. 
This was necessary because the parent theme "included" files instead of using WP_Enqueue_Scripts
Search "ROBERT" in parent's functions.php if you need to change this back. Original custom-functions.php is not changed*/

include 'custom-functions.php';
