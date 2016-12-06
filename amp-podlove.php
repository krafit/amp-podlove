<?php
	/*
	 Plugin Name: AMP for Podlove
	 Description: Adds AMP support to Podcasts powered by the Podlove Publisher.
	 Plugin URI: https://presswerk.net/plugins/
	 Text Domain: amp-podlove
	 Version: 0.1
	 Tags: amp, podlove, podcast
	 Author: PressWerk
	 Author URI: https://presswerk.net
	 License: GPLv2 or later
	 License URI: http://www.gnu.org/licenses/gpl-2.0.html

	 AMP Podlove is free software: you can redistribute it and/or modify
	 it under the terms of the GNU General Public License as published by
	 the Free Software Foundation, either version 2 of the License, or
	 any later version.

	 AMP Podlove is distributed in the hope that it will be useful,
	 but WITHOUT ANY WARRANTY; without even the implied warranty of
	 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	 GNU General Public License for more details.
 
	 You should have received a copy of the GNU General Public License
	 along with AMP Podlove. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
	 */


	function pw_podlove_amp() {
	    add_post_type_support( 'podcast', AMP_QUERY_VAR );
	}

	add_action( 'amp_init', 'pw_podlove_amp' );


	/**
	 * Checks on activation, if the AMP plugin is acitiavted
	 * and returns an admin notice, if it's not activated
	 **/
	register_activation_hook( __FILE__, 'pw_podlove_amp_on_activation' );
	function pw_podlove_amp_on_activation() {
		if ( ! is_plugin_active( 'amp/amp.php' ) ) {
			update_option( 'podlove_amp_needs_amp_notice', 1 );
		}
	}

	add_action( 'admin_init', 'podlove_amp_needs_amp_notice_deferred' );
	function podlove_amp_needs_amp_notice_deferred(){
		if( ! get_option( 'podlove_amp_needs_amp_notice' ) )
			return;

		delete_option( 'podlove_amp_needs_amp_notice' );
		add_action( 'admin_notices', 'podlove_amp_needs_amp_notice' );
	}

	function podlove_amp_needs_amp_notice() {
		?>
			<div class="notice notice-warning is-dismissible">
				<p><?php _e( 'The AMP plugin needs to be active in order for AMP for Podlove to run.', 'amp-podlove' ); ?></p>
			</div>
		<?php
	}

	

	

	add_action( 'plugins_loaded', 'pw_podlove_amp_plugins_loaded' );
	function pw_podlove_amp_plugins_loaded() {
		load_plugin_textdomain( 'amp-podlove', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
	}