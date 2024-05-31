<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package   Bonus_Calculator
 * @subpackage Bonus_Calculator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package   Bonus_Calculator
 * @subpackage Bonus_Calculator/public
 * @author     Your Name <email@example.com>
 */
class BC_Public {

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

		add_shortcode( 'bonuscalculator', array( $this, 'bonus_calculator_shortcode' ) );
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
		 * defined in BC_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The BC_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bc-public.css', array(), $this->version, 'all' );

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
		 * defined in BC_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The BC_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

	}

	function bonus_calculator_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'id' => 0,
		), $atts, 'bonuscalculator' );

		if ( ! $atts['id'] ) {
			return 'Invalid bonus ID.';
		}

		$settings = [ 
			'bc_deposit_amount' => 'Montant du dépôt',
			'bc_bonus_amount' => 'Bonus',
			'bc_bankroll' => 'Bankroll',
			'bc_bonus_message' => 'Vous devez parier {wageramount}€ avant de pouvoir retirer',
			'bc_bonus_error_message' => 'Déposez {amountneeded} de plus pour profiter du bonus.',
			'bc_cta_text' => 'Obtenir le bonus',
			'bc_percentage' => 'Pourcentage',
			'bc_wager' => 'Wager',
			'bc_bonus_only' => 'Bonus',
			'bc_bonus_deposit' => 'Bonus + Dépôt',
			'bc_min_deposit' => 'Dépôt Min.',
			'bc_min_odd' => 'Cote Min.',
			'bc_max_bonus' => 'Bonus Max.'
		];

		foreach ( $settings as $option => $default ) {
			${str_replace( 'bc_', '', $option )} = get_option( $option, $default );
		}

		echo var_dump( get_field( 'percentage', $atts['id'] ) );

		$bonusData = array(
			'percentage' => get_field( 'percentage', $atts['id'] ),
			'wager' => get_field( 'wager', $atts['id'] ),
			'wagerType' => get_field( 'wager_type', $atts['id'] ),
			'minDeposit' => get_field( 'min_deposit', $atts['id'] ),
			'minOdd' => get_field( 'min_odd', $atts['id'] ),
			'maxBonus' => get_field( 'max_bonus_amount', $atts['id'] ),
			'ctaLink' => get_field( 'cta_link', $atts['id'] ),
		);

		ob_start();
		include plugin_dir_path( __FILE__ ) . 'partials/bc-public-display.php';
		return ob_get_clean();
	}
}
