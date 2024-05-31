<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package   Bonus_Calculator
 * @subpackage Bonus_Calculator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package   Bonus_Calculator
 * @subpackage Bonus_Calculator/admin
 * @author     Your Name <email@example.com>
 */
class BC_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add settings page for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function add_settings_page() {
		add_options_page(
			'Bonus Calculator Settings',
			'Bonus Calculator Settings',
			'manage_options',
			'bonus_calculator_settings',
			array( $this, 'settings_page_content' )
		);
	}


	/**
	 * Register plugin settings.
	 *
	 * @since    1.0.0
	 */
	public function register_plugin_settings() {
		$settings = [ 
			'bc_deposit_amount', 'bc_bonus_amount', 'bc_bankroll', 'bc_bonus_message',
			'bc_bonus_error_message', 'bc_cta_text', 'bc_percentage', 'bc_wager',
			'bc_bonus_only', 'bc_bonus_deposit', 'bc_min_deposit', 'bc_min_odd', 'bc_max_bonus'
		];

		foreach ( $settings as $setting ) {
			register_setting( 'bonus_calculator_settings_group', $setting );
		}

		add_settings_section( 'bonus_calculator_settings_section', 'Bonus Calculator Strings', null, 'bonus_calculator_settings' );

		foreach ( $settings as $setting ) {
			add_settings_field( $setting, ucfirst( str_replace( [ 'bc_', '_' ], [ '', ' ' ], $setting ) ), array( $this, 'render_text_field' ), 'bonus_calculator_settings', 'bonus_calculator_settings_section', [ 'label_for' => $setting ] );
		}
	}

	public function render_text_field( $args ) {
		$option = get_option( $args['label_for'] );
		echo '<input type="text" name="' . esc_attr( $args['label_for'] ) . '" value="' . esc_attr( $option ) . '" />';
	}




	/**
	 * Get HTML template from plugin directory.
	 *
	 * @since    1.0.0
	 */
	public function settings_page_content() {
		$deposit_amount = get_option( 'deposit_amount', 'Montant du dépôt' );
		$bonus_amount = get_option( 'bonus_amount', 'Bonus' );
		$bankroll = get_option( 'bankroll', 'Bankroll' );
		$bonus_message = get_option( 'bonus_message', 'Vous devez parier {wageramount}€ avant de pouvoir retirer' );
		$cta_text = get_option( 'cta_text', 'Obtenir le bonus' );

		include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/bc-admin-display.php';
	}

	/**
	 * Register the custom post type for the bonus calculator.
	 *
	 * @since    1.0.0
	 */
	public function create_bonus_calculator_cpt() {
		$labels = array(
			'name' => _x( 'Bonus Calculators', 'Post Type General Name', 'textdomain' ),
			'singular_name' => _x( 'Bonus Calculator', 'Post Type Singular Name', 'textdomain' ),
			'menu_name' => __( 'Bonuses', 'textdomain' ),
			'all_items' => __( 'All Bonus Calculators', 'textdomain' ),
			'add_new_item' => __( 'Add New Bonus Calculator', 'textdomain' ),
			'add_new' => __( 'Add New', 'textdomain' ),
			'edit_item' => __( 'Edit Bonus Calculator', 'textdomain' ),
			'update_item' => __( 'Update Bonus Calculator', 'textdomain' ),
			'search_items' => __( 'Search Bonus Calculator', 'textdomain' ),
		);

		$args = array(
			'label' => __( 'Bonus Calculator', 'textdomain' ),
			'labels' => $labels,
			'supports' => array( 'title' ),
			'hierarchical' => false,
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => false,
			'can_export' => true,
			'has_archive' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'capability_type' => 'post',
			'show_in_rest' => true,
		);

		register_post_type( 'bonuscalculator', $args );
	}

	/**
	 * Register ACF field group for Bonus Calculator.
	 *
	 * @since    1.0.0
	 */
	public function register_bonus_calculator_fields() {
		acf_add_local_field_group( array(
			'key' => 'group_bonus_calculator',
			'title' => 'Bonus Calculator Fields',
			'fields' => array(
				array(
					'key' => 'field_percentage',
					'label' => 'Percentage',
					'name' => 'percentage',
					'type' => 'text',
				),
				array(
					'key' => 'field_wager',
					'label' => 'Wager',
					'name' => 'wager',
					'type' => 'text',
				),
				array(
					'key' => 'field_wager_type',
					'label' => 'Wager Type',
					'name' => 'wager_type',
					'type' => 'radio',
					'choices' => array(
						'bonusOnly' => 'Bonus Only',
						'bonusDeposit' => 'Bonus + Deposit',
					),
				),
				array(
					'key' => 'field_min_deposit',
					'label' => 'Minimum Deposit',
					'name' => 'min_deposit',
					'type' => 'number',
				),
				array(
					'key' => 'field_min_odd',
					'label' => 'Minimum Odd',
					'name' => 'min_odd',
					'type' => 'number',
				),
				array(
					'key' => 'field_max_bonus_amount',
					'label' => 'Maximum Bonus Amount',
					'name' => 'max_bonus_amount',
					'type' => 'number',
				),
				array(
					'key' => 'field_cta_link',
					'label' => 'CTA Link',
					'name' => 'cta_link',
					'type' => 'url',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'bonuscalculator',
					),
				),
			),
		) );
	}

	/**
	 * Add meta box for displaying shortcode in "Bonus Calculator" post type.
	 */
	function add_bonus_calculator_shortcode_meta_box() {
		add_meta_box(
			'bonus_calculator_shortcode_meta_box',
			'Bonus Calculator Shortcode',
			array( $this, 'display_bonus_calculator_shortcode_meta_box' ),
			'bonuscalculator',
			'side',
			'default'
		);
	}

	/**
	 * Display meta box content for shortcode in "Bonus Calculator" post type.
	 *
	 * @param WP_Post $post The current post object.
	 */
	function display_bonus_calculator_shortcode_meta_box( $post ) {
		$post_id = $post->ID;

		$shortcode = '[bonuscalculator id=' . esc_attr( $post_id ) . ']';

		echo '<p>Copy and paste the following shortcode into your content:</p>';
		echo '<input type="text" readonly="readonly" value="' . esc_attr( $shortcode ) . '" style="width: 100%;" />';
	}

}
