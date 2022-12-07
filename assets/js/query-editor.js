(function( $ ) {

	'use strict';

	Vue.component( 'jet-sub-query', {
		template: '#jet-sub-query',
		mixins: [
			window.JetQueryWatcherMixin,
			window.JetQueryRepeaterMixin,
		],
		props: [ 'value', 'dynamic-value' ],
		data: function() {
			return {
				query: {},
				dynamicQuery: {},
			};
		},
		created: function() {

			this.query        = { ...this.value };
			this.dynamicQuery = { ...this.dynamicValue };

			this.presetArgs();

		},
		methods: {
			presetArgs: function() {
				if ( ! this.query.schema ) {
					this.$set( this.query, 'schema', [] );
				}
			},
		}
	} );

})( jQuery );
