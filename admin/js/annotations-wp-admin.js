(function( $ ) {
	'use strict';

	if(window.acf) {
		/**
			ANNOTORIOUS
		*/

		let annotoriousInstance = false;

		acf.addAction('ready_field/name=image_content', () => {
			var field = acf.getField('field_630cde184e36e');
			if(field.val() && field.val() !== "") {
				fetch(`/wp-json/wp/v2/media/${field.val()}`, {
        	headers : {
	          'X-WP-Nonce' : window.annotations_wp.nonce,
	          'Content-Type' : 'application/json'
	        }
				}).then(resp => resp.json()).then(response => {
					jQuery('#annotorious-annotations').html(`<img id="annotorious-image" class="annotorious-image" src="${response.source_url}" />`);
					initalizeAnnotorious();
					if(jQuery('#annotorious-annotations-input').val() !== "") {
						const annotation_object = JSON.parse(jQuery('#annotorious-annotations-input').val());
						annotoriousInstance.setAnnotations(annotation_object);
					}
				})
			}
		})

		// Listen for button to copy content
		jQuery(document).on('click', '#annotorious-copy-image-button', () => {
			var field = acf.getField('field_630cde184e36e');
			if(jQuery('#annotorious-annotations').text() !== "") {
				if(confirm("You will overwrite your existing annotations. Are you sure?")) {
					fetch(`/wp-json/wp/v2/media/${field.val()}`, {
	        	headers : {
		          'X-WP-Nonce' : window.annotations_wp.nonce,
		          'Content-Type' : 'application/json'
		        }
					}).then(resp => resp.json()).then(response => {
						jQuery('#annotorious-annotations').html(`<img id="annotorious-image" class="annotorious-image" src="${response.guid.rendered}" />`);
						initalizeAnnotorious();
					});
				}
			} else {
				fetch(`/wp-json/wp/v2/media/${field.val()}`, {
        	headers : {
	          'X-WP-Nonce' : window.annotations_wp.nonce,
	          'Content-Type' : 'application/json'
	        }
				}).then(resp => resp.json()).then(response => {
					jQuery('#annotorious-annotations').html(`<img id="annotorious-image" class="annotorious-image" src="${response.guid.rendered}" />`);
					initalizeAnnotorious();
				});
			}
		})

		function initalizeAnnotorious() {
			annotoriousInstance = Annotorious.init({
				image: document.getElementById('annotorious-image'),
				fragmentUnit : 'percent'
			});

			annotoriousInstance.on('createAnnotation', function(annotation) {
				const annotations = annotoriousInstance.getAnnotations()
				if(annotations.length > 0) {
					jQuery('#annotorious-annotations-input').val(JSON.stringify(annotations));
				}
			});
		}


		/**
			RECOGITO
		*/

		let currentTextHolder = false;
		let recogitoInstance = false;

		// Initialize and set events for Recogito
		recogitoInstance = Recogito.init({
			content: document.getElementById('recogito-annotations') // ID or DOM element
		});

		recogitoInstance.on('createAnnotation', function(annotation) {
			const annotations = recogitoInstance.getAnnotations()
			if(annotations.length > 0) {
				jQuery('#recogito-annotations-input').val(JSON.stringify(annotations));
			}
		});

		// Initialize text on load
		acf.addAction('ready_field/name=text_content', () => {
			var field = acf.getField('field_630cddd04e36d');
			if(jQuery('#recogito-annotations-input').val() !== "" && field.val() && field.val() !== "") {
				jQuery('#recogito-annotations').html(field.val())
				setAnnotations();
			}
		})

		// Listen for button to copy content
		jQuery(document).on('click', '#recogito-copy-text-button', () => {
			var field = acf.getField('field_630cddd04e36d');
			if(jQuery('#recogito-annotations').text() !== "") {
				if(confirm("You will overwrite your existing annotations. Are you sure?")) {
					jQuery('#recogito-annotations').html(field.val())
				}
			} else {
				jQuery('#recogito-annotations').html(field.val())
			}
		})

		function setAnnotations() {
			if(recogitoInstance) {
				if(jQuery('#recogito-annotations-input').val() !== "") {
					const annotation_object = JSON.parse(jQuery('#recogito-annotations-input').val());
					recogitoInstance.setAnnotations(annotation_object);
				}
			}
		}
	}

})( jQuery );
