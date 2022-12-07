<?php
namespace Jet_Engine_Sub_Query;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Main file
 */
class Plugin {

	/**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {

			self::$instance = new self();

		}

		return self::$instance;

	}

	public function query_name() {
		return 'Sub Query';
	}

	public function query_slug() {
		return 'sub-query';
	}

	/**
	 * Initialize plugin parts
	 *
	 * @return void
	 */
	public function on_init() {
		add_action( 'jet-engine/query-builder/query-editor/register', [ $this, 'register_editor_component' ] );
		add_action( 'jet-engine/query-builder/queries/register', [ $this, 'register_query' ] );
	}

	/**
	 * Register editor componenet for the query builder
	 *
	 * @param  [type] $manager [description]
	 * @return [type]          [description]
	 */
	public function register_editor_component( $manager ) {
		require_once JET_ENGINE_SUB_QUERY_PATH . 'includes/editor.php';
		$manager->register_type( new Editor() );
	}

	/**
	 * Regsiter query class
	 *
	 * @param  [type] $manager [description]
	 * @return [type]          [description]
	 */
	public function register_query( $manager ) {

		$class = __NAMESPACE__ . '\Query';

		if ( ! class_exists( $class ) ) {
			require_once JET_ENGINE_SUB_QUERY_PATH . 'includes/query.php';
		}

		$manager::register_query( $this->query_slug(), $class );

	}

	/**
	 * Plugin constructor.
	 */
	private function __construct() {

		if ( ! function_exists( 'jet_engine' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'on_init' ), 0 );

	}

}

Plugin::instance();
