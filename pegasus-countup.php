<?php
/*
Plugin Name: Pegasus Countup Plugin
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: This allows you to create numbers that count up, starting at 0, and end at a set number on your website with just a shortcode.
Version:     1.0
Author:      Jim O'Brien
Author URI:  https://visionquestdevelopment.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

	/**
	 * Silence is golden; exit if accessed directly
	 */
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	function pegasus_countup_menu_item() {
		add_menu_page("countup", "countup", "manage_options", "pegasus_countup_plugin_options", "pegasus_countup_plugin_settings_page", null, 99);
		
	}
	add_action("admin_menu", "pegasus_countup_menu_item");

	function pegasus_countup_plugin_settings_page() { ?>
	    <div class="wrap pegasus-wrap">
	    <h1>countup</h1>			
			<p>Shortcode Usage: <pre>[counter_up number="83"] </pre></p>	
			
		</div>
	<?php
	}

	
	function pegasus_countup_plugin_styles() {
		//wp_enqueue_style( 'countup-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/countup.css', array(), null, 'all' );
		//wp_enqueue_style( 'slippery-slider-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/slippery-slider.css', array(), null, 'all' );
	}
	add_action( 'wp_enqueue_scripts', 'pegasus_countup_plugin_styles' );
	
	/**
	* Proper way to enqueue JS 
	*/
	function pegasus_countup_plugin_js() {
		
		
		wp_enqueue_script( 'waypoints-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/waypoints.js', array( 'jquery' ), null, true );
		
		//wp_enqueue_script( 'images-loaded-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/imagesLoaded.js', array( 'jquery' ), null, true );
		
		wp_enqueue_script( 'countup-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/countup.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'pegasus-countup-plugin-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/plugin.js', array( 'jquery' ), null, true );
		
	} //end function
	add_action( 'wp_enqueue_scripts', 'pegasus_countup_plugin_js' );
	

		
		
		
	/*~~~~~~~~~~~~~~~~~~~~
		COUNTUP
	~~~~~~~~~~~~~~~~~~~~~*/
	// [counter_up number="90"] 
	function pegasus_counter_up_func( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'number' => '',
			'container' => '',
			'class' => '',
		), $atts );
	
		$container_chk = "{$a['container']}";
		if($container_chk ) { 
			$output .= "<{$a['container']} class='counter {$a['class']}'>{$a['number']}</{$a['container']}>"; 
		}else{
			$output .= "<div class='counter {$a['class']}'>{$a['number']}</div>";
		}
		
		return $output; 
	}
	add_shortcode( 'counter_up', 'pegasus_counter_up_func' );
	
	
	
	
	
	
	
	