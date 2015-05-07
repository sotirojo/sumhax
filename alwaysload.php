<?php
/* Loads all files for all viewed pages */

define( 'ABSPATH', dirname(__FILE__) . '/' );

/* If not installed, install
 *
 */

if(file_exists(ABSPATH . "/install.me")) {
	require(ABSPATH . "/install.php");
	die;
}

error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );

if ( file_exists( ABSPATH . 'config.php') ) {
	require_once( ABSPATH . 'config.php' );
} elseif ( file_exists( dirname(ABSPATH) . '/config.php' ) && ! file_exists( dirname(ABSPATH) . '/settings.php' ) ) {
	require_once( dirname(ABSPATH) . '/config.php' );
} else {
	define( 'INC', 'includes' );
	require_once( ABSPATH . INC . '/load.php' );

	// Standardize $_SERVER variables across setups.
	wp_fix_server_vars();

	require_once( ABSPATH . WPINC . '/functions.php' );

	$path = wp_guess_url() . '/admin/setup-config.php';

	/*
	 * We're going to redirect to setup-config.php. While this shouldn't result
	 * in an infinite loop, that's a silly thing to assume, don't you think? If
	 * we're traveling in circles, our last-ditch effort is "Need more help?"
	 */
	if ( false === strpos( $_SERVER['REQUEST_URI'], 'setup-config' ) ) {
		header( 'Location: ' . $path );
		exit;
	}

	define( 'WP_CONTENT_DIR', ABSPATH . 'content' );
	require_once( ABSPATH . WPINC . '/version.php' );

	wp_check_php_mysql_versions();
	wp_load_translations_early();

	// Die with an error message
	$die  = __( "There doesn't seem to be a <code>config.php</code> file. I need this before we can get started." ) . '</p>';
	$die .= '<p>' . __( "Need more help? <a href='https://codex.wordpress.org/Editing_config.php'>We got it</a>." ) . '</p>';
	$die .= '<p>' . __( "You can create a <code>config.php</code> file through a web interface, but this doesn't work for all server setups. The safest way is to manually create the file." ) . '</p>';
	$die .= '<p><a href="' . $path . '" class="button button-large">' . __( "Create a Configuration File" ) . '</a>';

	wp_die( $die, __( 'WordPress &rsaquo; Error' ) );
}
