<?php
/*
Plugin Name: LearnPress - Stripe Payment
Plugin URI: http://thimpress.com/learnpress
Description: Stripe payment gateway for LearnPress.
Author: ThimPress
Version: 3.1.0
Author URI: http://thimpress.com
Tags: learnpress, lms, add-on, stripe
Text Domain: learnpress-stripe
Domain Path: /languages/
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

define( 'LP_ADDON_STRIPE_PAYMENT_FILE', __FILE__ );
define( 'LP_ADDON_STRIPE_PAYMENT_VER', '3.1.0' );
define( 'LP_ADDON_STRIPE_PAYMENT_REQUIRE_VER', '3.1.0' );

/**
 * Class LP_Addon_Stripe_Payment_Preload
 */
class LP_Addon_Stripe_Payment_Preload {

	/**
	 * LP_Addon_Stripe_Payment_Preload constructor.
	 */
	public function __construct() {
		add_action( 'learn-press/ready', array( $this, 'load' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Load addon
	 */
	public function load() {
		LP_Addon::load( 'LP_Addon_Stripe_Payment', 'inc/load.php', __FILE__ );
		remove_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Admin notice
	 */
	public function admin_notices() {
		?>
        <div class="error">
            <p><?php echo wp_kses(
					sprintf(
						__( '<strong>%s</strong> addon version %s requires %s version %s or higher is <strong>installed</strong> and <strong>activated</strong>.', 'learnpress-stripe' ),
						__( 'LearnPress Stripe Payment', 'learnpress-stripe' ),
						LP_ADDON_STRIPE_PAYMENT_VER,
						sprintf( '<a href="%s" target="_blank"><strong>%s</strong></a>', admin_url( 'plugin-install.php?tab=search&type=term&s=learnpress' ), __( 'LearnPress', 'learnpress-stripe' ) ),
						LP_ADDON_STRIPE_PAYMENT_REQUIRE_VER
					),
					array(
						'a'      => array(
							'href'  => array(),
							'blank' => array()
						),
						'strong' => array()
					)
				); ?>
            </p>
        </div>
		<?php
	}
}

new LP_Addon_Stripe_Payment_Preload();