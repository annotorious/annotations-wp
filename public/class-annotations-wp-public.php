<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://victortemprano.com
 * @since      1.0.0
 *
 * @package    Annotations_Wp
 * @subpackage Annotations_Wp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Annotations_Wp
 * @subpackage Annotations_Wp/public
 * @author     Victor Temprano <victor@mapster.me>
 */
class Annotations_Wp_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Annotations_Wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Annotations_Wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/annotations-wp-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
	}

	/**
	 * Register shortcode
	 *
	 * @since    1.0.0
	 */
	public function annotations_wp_register_shortcodes() {
		add_shortcode( 'annotation_display', array( $this, 'annotations_wp_display_shortcode') );
	}

	/**
	 * Add shortcode to Document content
	 *
	 * @since    1.0.0
	 */
	public function annotation_document_output_shortcode( $content ) {
		if( is_singular('annotation-document') ) {
			$output_shortcode = do_shortcode( '[annotation_display id="' . get_the_ID() . '"]' );
			$output_shortcode .= $content;
			return $output_shortcode;
		} else {
			return $content;
		}
	}


	/**
	 * Map shortcode logic
	 *
	 * @since    1.0.0
	 */
	public function annotations_wp_display_shortcode( $atts ) {

		if(isset($atts['id'])) {
			$post_id = $atts['id'];

			$document_type = get_field('document_type', $post_id);
			$editing = get_field('allow_editing', $post_id);
			$language = get_field('language', $post_id);
			if($document_type == 'image') {
				wp_enqueue_style( 'annotorious-css', plugin_dir_url( __FILE__ ) . '../admin/css/vendor/annotorious.min.css', array(), $this->version, 'all' );
				wp_enqueue_script( 'annotorious-js', plugin_dir_url( __FILE__ ) . '../admin/js/vendor/annotorious.min.js', array( 'jquery' ), $this->version, true );
				wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/annotations-wp-public.js', array( 'annotorious-js' ), $this->version, false );
				$image = get_field('image_content', $post_id);
				$json = get_post_meta($post_id, 'annotorious_annotation_object', true);

				return "
					<div class='annotations-wp-container' data-id='" . $post_id . "' data-type='" . $document_type . "' data-json='" . $json . "' data-editing='" .  ($editing ? "true" : "false") . "' data-language='" . $language . "'>
						<img id='annotorious-" . $post_id . "' src='" . $image . "' />
					</div>
				";

			} else {
				wp_enqueue_style( 'recogito-css', plugin_dir_url( __FILE__ ) . '../admin/css/vendor/recogito.min.css', array(), $this->version, 'all' );
				wp_enqueue_script( 'recogito-js', plugin_dir_url( __FILE__ ) . '../admin/js/vendor/recogito.min.js', array( 'jquery' ), $this->version, true );
				wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/annotations-wp-public.js', array( 'recogito-js' ), $this->version, false );
				$content = get_field('text_content', $post_id);
				$json = get_post_meta($post_id, 'recogito_annotation_object', true);

				return "
					<div class='annotations-wp-container' data-id='" . $post_id . "' data-type='" . $document_type . "' data-json='" . $json . "' data-editing='" . ($editing ? "true" : "false") . "' data-language='" . $language . "'>
						<div id='recogito-" . $post_id . "'>" . $content . "</div>
					</div>
				";

			}
		}
	}

}
