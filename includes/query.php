<?php
namespace Jet_Engine_Sub_Query;

class Query extends \Jet_Engine\Query_Builder\Queries\Base_Query {

	public function get_items() {
		return $this->_get_items();
	}

	/**
	 * Returns queries items
	 *
	 * @return [type] [description]
	 */
	public function _get_items() {

		$result = array();
		$prop   = ! empty( $this->final_query['prop'] ) ? $this->final_query['prop'] : false;

		if ( ! $prop ) {
			return $result;
		}

		$current_object = jet_engine()->listings->data->get_current_object();

		$prop = trim( $prop, '/' );
		$path = '';

		if ( strpos( $prop , '/' ) ) {
			$path_array = explode( '/', $prop );
			$prop       = array_shift( $path_array );
			$path       = implode( '/' , $path_array );
		}

		if ( ! $current_object || ! isset( $current_object->$prop ) ) {
			return $result;
		}

		if ( $path ) {
			$result = jet_engine_get_child( $current_object->$prop, $path );
		} else {
			$result = $current_object->$prop;
		}

		if ( is_object( $result ) ) {
			$result = ( array ) $result;
		}

		if ( ! is_array( $result ) ) {
			return array();
		}

		array_walk( $result, function( &$item, $index ) {

			if ( is_object( $item ) ) {
				$item = ( array ) $item;
			}

			$prepared = array();

			if ( ! empty( $this->final_query['schema'] ) ) {
				foreach( $this->final_query['schema'] as $row ) {
					if ( ! is_array( $item ) ) {
						$new_item[ $row['property'] ] = $item;
					} else {
						$search_prop = ! empty( $row['property_map'] ) ? $row['property_map'] : $row['property'];
						$new_item[ $row['property'] ] = isset( $item[ $search_prop ] ) ? $item[ $search_prop ] : '';
					}
				}
			}

			$new_item['_item_ID'] = $index;

			$item = (object) $new_item;
		} );

		return $result;

	}

	public function get_current_items_page() {
		return 1;
	}

	/**
	 * Returns total found items count
	 *
	 * @return [type] [description]
	 */
	public function get_items_total_count() {

		$items = $this->get_items();
		$result = count( $items );

		return count( $items );

	}

	/**
	 * Returns count of the items visible per single listing grid loop/page
	 * @return [type] [description]
	 */
	public function get_items_per_page() {
		return 0;

	}

	/**
	 * Returns queried items count per page
	 *
	 * @return [type] [description]
	 */
	public function get_items_page_count() {
		return $this->get_items_total_count();
	}

	/**
	 * Returns queried items pages count
	 *
	 * @return [type] [description]
	 */
	public function get_items_pages_count() {
		return 1;
	}

	public function set_filtered_prop( $prop = '', $value = null ) {
		// Filtering of sub queries are not supported
		return false;
	}

	/**
	 * Get fields list are available for the current instance of this query
	 *
	 * @return [type] [description]
	 */
	public function get_instance_fields() {

		if ( ! empty( $this->_instance_fields ) ) {
			return $this->_instance_fields;
		}

		$result = array();
		$args = $this->query;

		if ( ! empty( $args['schema'] ) ) {
			foreach ( $args['schema'] as $row ) {
				if ( ! empty( $row['property'] ) ) {
					$result[ $row['property'] ] = $row['property'];
				}
			}
		}

		$this->_instance_fields = $result;

		return $result;

	}

}
