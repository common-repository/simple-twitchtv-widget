<?php
	/**
	 * Plugin Name: Simple Twitch.TV Widget
	 * Description: Plugin to show when a user is online. Go to the "Settings" menu, and select "STTW Twitch Options." You can change the widget settings there, to be displayed when you activate it!
	 * Version: 1.0
	 * Author: Judah Wright
	 * Author URI: http://thosetechguys.org/judah-wright/
	 */

	 // Exit if accessed directly
	if (!defined('ABSPATH')) {
		exit;
	}

	if ( ! defined( 'WOVAX_APP_URL' ) ) {
		define('STTW_URL', plugins_url()."/simple_twitchtv_widget");
	}
	if ( ! defined( 'WOVAX_APP_DIR' ) ) {
		define('STTW_DIR', plugin_dir_path(__FILE__));
	}

	 // Runs when plugin is activated
	register_activation_hook(__FILE__,'sttw_twitch_install');

	// Runs on plugin deactivation
	register_deactivation_hook( __FILE__, 'sttw_twitch_remove' );

	function sttw_twitch_install() {
		// Creates new database field
		add_option("sttw_twitch_users", '', '', 'yes');
		add_option("sttw_twitch_number", '', '', 'yes');
	}

	function sttw_twitch_remove() {
		// Deletes the database field
		delete_option('sttw_twitch_users');
		delete_option('sttw_twitch_number');
	}


	add_action('admin_menu', 'Add_STTW_Twitch_options');
	function Add_STTW_Twitch_options() {
		add_options_page('STTW Twitch Options', 'STTW Twitch Options', 'manage_options', 'sttw_twitch_options','STTW_Twitch_options');
	}
	function STTW_Twitch_options() {
		include 'settings.php';
	}

	class STTW_Twitch_Widget extends WP_Widget {
		function STTW_Twitch_Widget() {
			$widget_ops = array('classname' => 'STTW_Twitch_Widget', 'description' => 'Displays a users Twitch.TV Status' );
			$this->WP_Widget('STTW_Twitch_Widget', 'Simple Twitch.TV Widget', $widget_ops);
		}

		function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
			$title = $instance['title'];
			?>
	  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
	<?php
	  }

	  function update($new_instance, $old_instance) {
	    $instance = $old_instance;
	    $instance['title'] = $new_instance['title'];
	    return $instance;
	  }

	  function widget($args, $instance) {
	    extract($args, EXTR_SKIP);

	    echo $before_widget;
	    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

	    if (!empty($title))
	      echo $before_title . $title . $after_title;;

	    // WIDGET CODE GOES HERE
			include 'widget.php';

	    echo $after_widget;
	  }

	}
	add_action( 'widgets_init', create_function('', 'return register_widget("STTW_Twitch_Widget");') );?>
