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


	function count_up_check_main_theme_name() {
		$current_theme_slug = get_option('stylesheet'); // Slug of the current theme (child theme if used)
		$parent_theme_slug = get_option('template');    // Slug of the parent theme (if a child theme is used)

		//error_log( "current theme slug: " . $current_theme_slug );
		//error_log( "parent theme slug: " . $parent_theme_slug );

		if ( $current_theme_slug == 'pegasus' ) {
			return 'Pegasus';
		} elseif ( $current_theme_slug == 'pegasus-child' ) {
			return 'Pegasus Child';
		} else {
			return 'Not Pegasus';
		}
	}

	function pegasus_count_up_menu_item() {
		if ( count_up_check_main_theme_name() == 'Pegasus' || count_up_check_main_theme_name() == 'Pegasus Child' ) {
			//do nothing
		} else {
			//echo 'This is NOT the Pegasus theme';
			add_menu_page(
				"Count Up", // Page title
				"Count Up", // Menu title
				"manage_options", // Capability
				"pegasus_count_up_plugin_options", // Menu slug
				"pegasus_count_up_plugin_settings_page", // Callback function
				null, // Icon
				84 // Position in menu
			);
		}
	}
	add_action("admin_menu", "pegasus_count_up_menu_item");

	function pegasus_count_up_plugin_settings_page() { ?>
	    <div class="wrap pegasus-wrap">
			<h1>Counter Up Usage</h1>

			<div>
				<h5>Counter Up Usage 1:</h5>
				<style>
					pre {
						background-color: #f9f9f9;
						border: 1px solid #aaa;
						page-break-inside: avoid;
						font-family: monospace;
						font-size: 15px;
						line-height: 1.6;
						margin-bottom: 1.6em;
						max-width: 100%;
						overflow: auto;
						padding: 1em 1.5em;
						display: block;
						word-wrap: break-word;
					}

					input[type="text"].code {
						width: 100%;
					}
				</style>
				<pre >[counter_up number="83"]</pre>

				<input
					type="text"
					readonly
					value="<?php echo esc_html('[counter_up number="83"]'); ?>"
					class="regular-text code"
					id="my-shortcode"
					onClick="this.select();"
				>
			</div>

			<p style="color:red;">MAKE SURE YOU DO NOT HAVE ANY RETURNS OR <?php echo htmlspecialchars('<br>'); ?>'s IN YOUR SHORTCODES, OTHERWISE IT WILL NOT WORK CORRECTLY</p>

		</div>
	<?php
	}

	//function pegasus_countup_menu_item() {
		//add_menu_page("countup", "countup", "manage_options", "pegasus_countup_plugin_options", "pegasus_countup_plugin_settings_page", null, 99);

	//}
	//add_action("admin_menu", "pegasus_countup_menu_item");

	/*function pegasus_countup_plugin_settings_page() { ?>
	    <div class="wrap pegasus-wrap">
	    <h1>countup</h1>
			<p>Shortcode Usage: <pre>[counter_up number="83"] </pre></p>

		</div>
	<?php
	} */


	function pegasus_countup_plugin_styles() {
		//wp_enqueue_style( 'countup-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/countup.css', array(), null, 'all' );
		//wp_enqueue_style( 'slippery-slider-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/slippery-slider.css', array(), null, 'all' );
	}
	add_action( 'wp_enqueue_scripts', 'pegasus_countup_plugin_styles' );

	/**
	* Proper way to enqueue JS
	*/
	function pegasus_countup_plugin_js() {


		wp_register_script( 'waypoints-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/waypoints.js', array( 'jquery' ), null, 'all' );

		//wp_enqueue_script( 'images-loaded-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/imagesLoaded.js', array( 'jquery' ), null, true );

		wp_register_script( 'countup-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/countup.js', array( 'jquery' ), null, 'all' );
		wp_register_script( 'pegasus-countup-plugin-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/plugin.js', array( 'jquery' ), null, 'all' );

	} //end function
	add_action( 'wp_enqueue_scripts', 'pegasus_countup_plugin_js' );





	/*~~~~~~~~~~~~~~~~~~~~
		COUNTUP
	~~~~~~~~~~~~~~~~~~~~~*/
	// [counter_up number="90"]
	function pegasus_counter_up_func( $atts, $content = null ) {
		$output = '';
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

		wp_enqueue_script( 'waypoints-js' );
		wp_enqueue_script( 'countup-js' );
		wp_enqueue_script( 'pegasus-countup-plugin-js' );

		return $output;
	}
	add_shortcode( 'counter_up', 'pegasus_counter_up_func' );







