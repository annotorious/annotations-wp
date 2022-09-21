(function( $ ) {
	'use strict';

	if(jQuery('.annotations-wp-container').length) {
		jQuery('.annotations-wp-container').each(function() {

			const type = jQuery(this).data('type')
			const id = jQuery(this).data('id')
			const json = jQuery(this).data('json')
			const editing = jQuery(this).data('editing')
			const language = jQuery(this).data('language')
			console.log(editing, language)

			if(type === 'image') {

				let annotoriousInstance = Annotorious.init({
					image: document.getElementById(`annotorious-${id}`),
					fragmentUnit : 'percent',
					readOnly : !editing,
					locale : language
				});
				annotoriousInstance.setAnnotations(json);

			}

			if(type === 'text') {

				let recogitoInstance = Recogito.init({
					content: document.getElementById(`recogito-${id}`),
					readOnly : !editing,
					locale : language
				});
				recogitoInstance.setAnnotations(json);
			}
		})
	}

})( jQuery );
