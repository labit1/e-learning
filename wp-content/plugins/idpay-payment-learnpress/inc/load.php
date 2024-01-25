<?php
/**
 * Plugin load class.
 *
 * @author   IDPay
 * @package  LearnPress/IDPay/Classes
 * @version  1.1.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Addon_IDPay_Payment' ) ) {
	/**
	 * Class LP_Addon_IDPay_Payment
	 */
	class LP_Addon_IDPay_Payment extends LP_Addon {

		/**
		 * @var string
		 */
		public $version = LP_ADDON_IDPAY_PAYMENT_VER;

		/**
		 * @var string
		 */
		public $require_version = LP_ADDON_IDPAY_PAYMENT_REQUIRE_VER;

		/**
		 * LP_Addon_IDPay_Payment constructor.
		 */
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Define Learnpress IDPay payment constants.
		 *
		 */
		protected function _define_constants() {
			define( 'LP_ADDON_IDPAY_PAYMENT_PATH', dirname( LP_ADDON_IDPAY_PAYMENT_FILE ) );
			define( 'LP_ADDON_IDPAY_PAYMENT_INC', LP_ADDON_IDPAY_PAYMENT_PATH . '/inc/' );
			define( 'LP_ADDON_IDPAY_PAYMENT_URL', plugin_dir_url( LP_ADDON_IDPAY_PAYMENT_FILE ) );
			define( 'LP_ADDON_IDPAY_PAYMENT_TEMPLATE', LP_ADDON_IDPAY_PAYMENT_PATH . '/templates/' );
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 */
		protected function _includes() {
			include_once LP_ADDON_IDPAY_PAYMENT_INC . 'class-lp-gateway-idpay.php';
		}

		/**
		 * Init hooks.
		 */
		protected function _init_hooks() {
			// add payment gateway class
			add_filter( 'learn_press_payment_method', array( $this, 'add_payment' ) );
			add_filter( 'learn-press/payment-methods', array( $this, 'add_payment' ) );
		}

		/**
		 * Enqueue assets.
		 *
		 */
		protected function _enqueue_assets() {
			return;
			
			if (LP()->settings->get( 'learn_press_idpay.enable' ) == 'yes' ) {
				$user = learn_press_get_current_user();

				learn_press_assets()->enqueue_script( 'learn-press-idpay-payment', $this->get_plugin_url( 'assets/js/script.js' ), array() );
				learn_press_assets()->enqueue_style( 'learn-press-idpay', $this->get_plugin_url( 'assets/css/style.css' ), array() );

				$data = array(
					'plugin_url'  => plugins_url( '', LP_ADDON_IDPAY_PAYMENT_FILE )
				);
				wp_localize_script( 'learn-press-idpay', 'learn_press_idpay_info', $data );
			}
		}

		/**
		 * Add IDPay to payment system.
		 *
		 * @param $methods
		 *
		 * @return mixed
		 */
		public function add_payment( $methods ) {
			$methods['idpay'] = 'LP_Gateway_IDPay';

			return $methods;
		}

		/**
		 * Plugin links.
		 *
		 * @return array
		 */
		public function plugin_links() {
			$links[] = '<a href="' . admin_url( 'admin.php?page=learn-press-settings&tab=payments&section=idpay' ) . '">' . __( 'Settings', 'learnpress-idpay' ) . '</a>';

			return $links;
		}
	}
}