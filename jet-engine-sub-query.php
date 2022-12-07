<?php
/**
 * Plugin Name: JetEngine - Sub Query query type
 * Plugin URI:
 * Description: Sub Query query type addon.
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:
 * Text Domain: jet-engine-dynamic-tables-module
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

define( 'JET_ENGINE_SUB_QUERY_VERSION', '1.0.4' );

define( 'JET_ENGINE_SUB_QUERY__FILE__', __FILE__ );
define( 'JET_ENGINE_SUB_QUERY_PLUGIN_BASE', plugin_basename( JET_ENGINE_SUB_QUERY__FILE__ ) );
define( 'JET_ENGINE_SUB_QUERY_PATH', plugin_dir_path( JET_ENGINE_SUB_QUERY__FILE__ ) );
define( 'JET_ENGINE_SUB_QUERY_URL', plugins_url( '/', JET_ENGINE_SUB_QUERY__FILE__ ) );

add_action( 'plugins_loaded', 'jet_engine_sub_query_init' );

function jet_engine_sub_query_init() {
	require JET_ENGINE_SUB_QUERY_PATH . 'includes/plugin.php';
}
