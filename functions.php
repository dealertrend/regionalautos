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
		register_default_headers(
			array(
				'defaultlogo' => array(
					'url' => $this->theme_information[ 'ThemeURL' ] . '/images/regional-autos-logo-200x120.png',
					'thumbnail_url' => $this->theme_information[ 'ThemeURL' ] . '/images/regional-autos-logo-200x120.png',
					'description' => __( 'Default Logo', 'regionalautos' )
				)
			)
		);
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
		add_filter( 'genesis_header' , array( &$this , 'add_header_widget_area' ) );
		add_filter( 'genesis_footer_creds_text' , array( &$this , 'add_credits' ) );
		add_filter( 'genesis_footer_output' , array( &$this , 'add_footer_menu' ) );
	}

	function add_left_shadow() {
		echo '<div id="regionalautos-left-shadow"></div>';
	}

	function add_right_shadow() {
		echo '<div id="regionalautos-right-shadow"></div>';
	}

	function add_header_widget_area() {
		if( ! dynamic_sidebar( 'Header Left' ) ):
		endif;
		if( ! dynamic_sidebar( 'Header Right' ) ):
		endif;
	}

	function specify_theme_features() {
		add_filter( 'widget_text' , 'do_shortcode' );
		$before_widget = '<div id="%1$s" class="widget %2$s regionalautos-theme widget-area">';
		$after_widget = '</div>';
		$before_title = '<h4 class="widget-title">';
		$after_title = '</h4>';
		add_custom_background();
		add_theme_support(
			'genesis-custom-header',
			array(
				'width' => 960,
				'height' => 100,
				'header_image' => $this->theme_information[ 'ThemeURL' ] . '/images/regional-autos-logo-200x120.png'
			)
		);
		unregister_sidebar( 'header-right' );
		genesis_register_sidebar(
			array(
				'id' => 'regionalautos-header-left',
				'name' => 'Header Left',
				'description' => 'This is the left side of the header',
				'before_widget' => '<div id="%1$s" class="widget %2$s regionalautos-theme widget-area float-left">',
				'after_widget' => $after_widget,
				'before_title' => $before_title,
				'after_title' => $after_title
			)
		);
		genesis_register_sidebar(
			array(
				'regionalautos-header-right',
				'name' => 'Header Right',
				'description' => 'This is the right side of the header',
				'before_widget' => '<div id="%1$s" class="widget %2$s regionalautos-theme widget-area float-right">',
				'after_widget' => $after_widget,
				'before_title' => $before_title,
				'after_title' => $after_title
			)
		);
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
