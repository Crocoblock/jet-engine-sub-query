<?php
namespace Jet_Engine_Sub_Query;

class Editor extends \Jet_Engine\Query_Builder\Query_Editor\Base_Query {

	/**
	 * Qery type ID
	 */
	public function get_id() {
		return Plugin::instance()->query_slug();
	}

	/**
	 * Qery type name
	 */
	public function get_name() {
		return Plugin::instance()->query_name();
	}

	/**
	 * Returns Vue component name for the Query editor for the current type.
	 * I
	 * @return [type] [description]
	 */
	public function editor_component_name() {
		return 'jet-' . Plugin::instance()->query_slug();
	}

	/**
	 * Returns Vue component template for the Query editor for the current type.
	 * I
	 * @return [type] [description]
	 */
	public function editor_component_template() {
		ob_start();
		?>
		<div class="jet-engine-edit-page__fields">
			<div class="cx-vui-collapse__heading">
				<h3 class="cx-vui-subtitle"><?php echo Plugin::instance()->query_name(); ?></h3>
			</div>
			<div class="cx-vui-panel">
				<cx-vui-component-wrapper
					:wrapper-css="[ 'fullwidth' ]"
					label="Note!"
					description="This query type is intented to work only with nested listings. It tries tp get the data from parent object property"
				/>
				<cx-vui-input
					label="<?php _e( 'Parent Object Property', 'jet-engine' ); ?>"
					description="<?php _e( 'Property name from prent listing item object to get data from.', 'jet-engine' ); ?>"
					:wrapper-css="[ 'equalwidth', 'has-macros' ]"
					size="fullwidth"
					v-model="query.prop"
				><jet-query-dynamic-args v-model="dynamicQuery.prop"></jet-query-dynamic-args></cx-vui-input>
				<cx-vui-component-wrapper
					:wrapper-css="[ 'fullwidth-control' ]"
				>
					<div class="cx-vui-inner-panel query-panel">
						<div class="cx-vui-component__label"><?php _e( 'Item Schema', 'jet-engine' ); ?></div>
						<div class="cx-vui-component__desc"><?php _e( 'Set up schema for the single item of Sub Query object. If Sub Query is array of string/numeric values - set single property to store value in. You need fill this data to get access to query object properties in the widgets/blocks settings', 'jet-engine' ); ?></div>
						<cx-vui-repeater
							button-label="<?php _e( 'Add new property', 'jet-engine' ); ?>"
							button-style="accent"
							button-size="mini"
							v-model="query.schema"
							@add-new-item="addNewField( $event, [], query.schema )"
						>
							<cx-vui-repeater-item
								v-for="( clause, index ) in query.schema"
								:collapsed="isCollapsed( clause )"
								:index="index"
								@clone-item="cloneField( $event, clause._id, query.schema )"
								@delete-item="deleteField( $event, clause._id, query.schema )"
								:key="clause._id"
							>
								<cx-vui-input
									label="<?php _e( 'Property Name', 'jet-engine' ); ?>"
									description="<?php _e( 'Set name of the property', 'jet-engine' ); ?>"
									:wrapper-css="[ 'equalwidth' ]"
									size="fullwidth"
									:value="query.schema[ index ].property"
									@input="setFieldProp( clause._id, 'property', $event, query.schema )"
								></cx-vui-input>
								<cx-vui-input
									label="<?php _e( 'Initial Object Property', 'jet-engine' ); ?>"
									description="<?php _e( 'Map initial object property to query item property. Leave empty to map automatically', 'jet-engine' ); ?>"
									:wrapper-css="[ 'equalwidth' ]"
									size="fullwidth"
									:value="query.schema[ index ].property_map"
									@input="setFieldProp( clause._id, 'property_map', $event, query.schema )"
								></cx-vui-input>
							</cx-vui-repeater-item>
						</cx-vui-repeater>
					</div>
				</cx-vui-component-wrapper>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Returns Vue component template for the Query editor for the current type.
	 * I
	 * @return [type] [description]
	 */
	public function editor_component_file() {
		return JET_ENGINE_SUB_QUERY_URL . 'assets/js/query-editor.js';
	}

}
