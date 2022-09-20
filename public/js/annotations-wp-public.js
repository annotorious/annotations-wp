(function( $ ) {
	'use strict';

	if(jQuery('.annotations-wp-container').length) {
		jQuery('.annotations-wp-container').each(function() {

			const type = jQuery(this).data('type')
			const id = jQuery(this).data('id')
			const json = jQuery(this).data('json')

			if(type === 'image') {
				
				let annotoriousInstance = Annotorious.init({
					image: document.getElementById(`annotorious-${id}`),
					fragmentUnit : 'percent'
				});
				annotoriousInstance.setAnnotations(json);

			}

			if(type === 'text') {

				let recogitoInstance = Recogito.init({
					content: document.getElementById(`recogito-${id}`)
				});
				recogitoInstance.setAnnotations(json);
			}
		})
	}

})( jQuery );
