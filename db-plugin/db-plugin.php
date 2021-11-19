<?php
/*
* Plugin Name: DB Plugin
* Description: A short example custom DB Plugin
* Version: 1.0
* Author: Viktor Kono
* Author URI: https://codex.wordpress.org/
* Text Domain: dbplugin
* Domain Path: /lang
*/

/*
 * Add translate
 */
add_action( 'plugins_loaded', function(){
    load_plugin_textdomain( 'dbplugin', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
} );

if(is_admin()) {

    define( 'PREFIX_DB', 'db_plugin' );

    // Include hooks
    include plugin_dir_path( WP_PLUGIN_DIR ) . '/plugins/db-plugin/includes/hooks.php';

    // Include actions
    include plugin_dir_path( WP_PLUGIN_DIR ) . '/plugins/db-plugin/includes/actions.php';

}