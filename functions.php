<?php

namespace WordPress\Themes\Genesis\RegionalAutos;

class Theme {

	private $genesis_engine = NULL; 

	public $theme_information = array();

	function __construct() {
		$this->configure_theme();
		$i_can_haz_engine = $this->start_genesis_framework();
		if( $i_can_haz_engine === true ) {
			$this->specify_theme_features();
			$this->create_filters();
		}
	}

	function configure_theme() {
		$this->theme_information[ 'ThemePath' ] = dirname( __FILE__ );
		$this->theme_information[ 'ThemeURL' ] = get_bloginfo( 'stylesheet_directory' );
		$this->genesis_engine = TEMPLATEPATH . '/lib/init.php';

		$this->setup_administration_area();
	}

	function setup_administration_area() {
		add_action( 'admin_menu' , array( &$this, 'add_menu_item' ) );
		$this->register_defaults();
	}

	function add_menu_item() {
		add_theme_page(
			'Regional Autos: Theme Options',
			'Theme Options',
			'edit_theme_options',
			'regionalautos-theme-options',
			array( &$this , 'options_page' )
		);
	}

	function options_page() {
		include( $this->theme_information[ 'ThemePath' ] . '/options.php' );
	}

	function register_defaults() {
	}

	function start_genesis_framework() {
		if( file_exists ( $this->genesis_engine ) ) {
			require_once( $this->genesis_engine );
			return true;
		} else {
			$this->failed_to_start();
			return false;
		}
	}

	function failed_to_start() {
		add_action( 'admin_notices' , array( &$this , 'could_not_find_genesis' ) );
		add_action( 'init' , array( &$this, 'deactivate_theme' ) );
	}

	function could_not_find_genesis() {
		echo '<div id="message" class="error">';
		echo '<p>Unable to locate the Genesis Framework!</p>';
		echo '</div>';
		echo '<div id="message" class="error">';
		echo '<p id="message" class="error">Deactivating Regional Autos.</p>';
		echo '</div>';
	}

	function deactivate_theme() {
		switch_theme( WP_DEFAULT_THEME , WP_DEFAULT_THEME );
	}

	function create_filters() {
		add_filter( 'genesis_before_header' , array( &$this , 'add_left_shadow' ) );
		add_filter( 'genesis_after_footer' , array( &$this , 'add_right_shadow' ) );
		add_filter( 'genesis_footer_creds_text' , array( &$this , 'add_credits' ) );
		add_filter( 'genesis_footer_output' , array( &$this , 'add_footer_menu' ) );
	}

	function add_left_shadow() {
		echo '<div id="regionalautos-left-shadow"></div>';
	}

	function add_right_shadow() {
		echo '<div id="regionalautos-right-shadow"></div>';
	}

	function specify_theme_features() {
		add_filter( 'widget_text' , 'do_shortcode' );
	}

	function add_credits( $credits ) {
		$credits = '[footer_copyright] &bull; Regional Autos Theme by <a href="http://www.dealertrend.com" title="DealerTrend, Inc." target="_blank">DealerTrend, Inc.</a> &bull; Built on the [footer_genesis_link]';

		return $credits;
	}

	function add_footer_menu( $instance ) {
		$menu = wp_nav_menu( array( 'menu' => 'Footer Menu' , 'theme_location' => 'footer-menu' ) );

		return $instance . $menu;
	}

}

global $RegionalAutos;

$RegionalAutos = new Theme();

?>
