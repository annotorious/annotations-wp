<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://victortemprano.com
 * @since      1.0.0
 *
 * @package    Annotations_Wp
 * @subpackage Annotations_Wp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Annotations_Wp
 * @subpackage Annotations_Wp/admin
 * @author     Victor Temprano <victor@mapster.me>
 */
class Annotations_Wp_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * ACF loading and integration
	 *
	 * @since    1.0.0
	 */
	public function wp_annotations_load_acf() {
		if ( ! class_exists( 'ACF' ) ) {
			include_once( plugin_dir_path( __FILE__ ) . '../includes/acf/acf.php' );
			add_filter('acf/settings/url', 'my_acf_settings_url');
			function my_acf_settings_url( $url ) {
			    return plugin_dir_url( __FILE__ ) . '../includes/acf/';
			}
			if(!MAPSTER_LOCAL_TESTING) {
				add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
				function my_acf_settings_show_admin( $show_admin ) {
					if(is_plugin_active('advanced-custom-fields/acf.php') || is_plugin_active('advanced-custom-fields-pro/acf.php') ) {
						return true;
					} else {
				    return false;
					}
				}
			}
		}
		if(!MAPSTER_LOCAL_TESTING) {
			include_once( plugin_dir_path( __FILE__ ) . '../admin/includes/acf-document-fields.php' );
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'annotorious-css', plugin_dir_url( __FILE__ ) . 'css/vendor/annotorious.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'recogito-css', plugin_dir_url( __FILE__ ) . 'css/vendor/recogito.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/annotations-wp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'annotorious-js', plugin_dir_url( __FILE__ ) . 'js/vendor/annotorious.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'recogito-js', plugin_dir_url( __FILE__ ) . 'js/vendor/recogito.min.js', array( 'annotorious-js' ), $this->version, true );

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/annotations-wp-admin.js', array( 'recogito-js' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'annotations_wp', array(
	    'nonce' => wp_create_nonce( 'wp_rest' )
		));
		wp_enqueue_script( $this->plugin_name );

	}

	/**
	 * Registers Recogito custom post types
	 *
	 * @since    1.0.0
	 */
	public function register_recogito_post_types() {

		register_post_type('annotation-document',
				array(
						'labels' => array(
								'name' => "Documents",
								'menu_name' => "Documents",
								'singular_name' => "Document",
								'add_new' => "Add New",
								'add_new_item' => "Add New Document",
								'edit' => "Edit",
								'edit_item' => "Edit Document",
								'new_item' => "New Document",
								'view' => "View",
								'view_item' => "View Document",
								'search_items' => "Search Documents",
								'not_found' => "No Documents Found",
								'not_found_in_trash' => 'No Documents found in Trash',
								'parent' => "Parent Document",
						),
						'menu_icon' => "dashicons-media-document",
						'public' => true,
						"publicly_queryable"  => true,
						'exclude_from_search' => false,
						'show_in_rest' => true,
						'menu_position' => 15,
						'rewrite' => 'document',
						'supports' => array('title'),
						// 'taxonomies' => array('wp-map-category'),
						'has_archive' => true,
				)
		);

	}

	/**
	 * Create backend menu
	 *
	 * @since    1.0.0
	 */
	public function recogito_settings_menu()
	{
			add_submenu_page('options-general.php', 'Annotation Settings', 'Annotation Settings', 'manage_options', 'annotation-settings', function () {
					include 'partials/annotations-wp-settings-page.php';
			});
	}


	/**
	 * Disable gutenberg for custom post types
	 *
	 * @since    1.0.0
	 */
	function recogito_disable_gutenberg($current_status, $post_type) {
		if($post_type == 'annotation-document') {
			$current_status = false;
		}

		return $current_status;
	}

	/**
	 * Add Recogito metabox for document editing
	 *
	 * @since    1.0.0
	 */
	public function add_recogito_metabox() {
		add_meta_box( 'recogito-document-annotate', 'Annotate Text', 'recogito_text_metabox',
				'annotation-document', 'normal', 'high',
				array(
						'__block_editor_compatible_meta_box' => true,
				)
		);
		function recogito_text_metabox() {
			global $post;
			$recogito_annotation_object = get_post_meta($post->ID, 'recogito_annotation_object', true);
			echo "
				<div><input id='recogito-annotations-input' type='hidden' name='recogito_annotation_object' value='" . $recogito_annotation_object . "' /></div>
			";
    	wp_nonce_field( plugin_basename( __FILE__ ), 'recogito_annotation_nonce' );
		}

		add_meta_box( 'annotorious-image-annotate', 'Annotate Image', 'annotorious_image_metabox',
				'annotation-document', 'normal', 'high',
				array(
						'__block_editor_compatible_meta_box' => true,
				)
		);
		function annotorious_image_metabox() {
			global $post;
			$annotorious_annotation_object = get_post_meta($post->ID, 'annotorious_annotation_object', true);
			echo "
				<div><input id='annotorious-annotations-input' type='hidden' name='annotorious_annotation_object' value='" . $annotorious_annotation_object . "' /></div>
			";
    	wp_nonce_field( plugin_basename( __FILE__ ), 'annotorious_annotation_nonce' );
		}
	}

	/**
	 * Save custom post meta for Annotorious object
	 *
	 * @since    1.0.0
	 */
	function annotorious_save_custom_field($post_ID) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

    if ( ! current_user_can( 'edit_post', $post_ID ) )
      return;

    if ( ! isset( $_POST['annotorious_annotation_nonce'] ) || ! wp_verify_nonce( $_POST['annotorious_annotation_nonce'], plugin_basename( __FILE__ ) ) )
      return;

    if ('annotation-document' != get_post_type($post_ID))
      return;

    $annotation_object =  $_POST['annotorious_annotation_object'];
    update_post_meta( $post_ID, 'annotorious_annotation_object', $annotation_object);
	}

	/**
	 * Save custom post meta for Recogito object
	 *
	 * @since    1.0.0
	 */
	function recogito_save_custom_field($post_ID) {

    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

    // First we need to check if the current user is authorised to do this action.
    if ( ! current_user_can( 'edit_post', $post_ID ) )
      return;

    // Secondly we need to check if the user intended to change this value.
    if ( ! isset( $_POST['recogito_annotation_nonce'] ) || ! wp_verify_nonce( $_POST['recogito_annotation_nonce'], plugin_basename( __FILE__ ) ) )
      return;

    // Thirdly check the post type
    if ('annotation-document' != get_post_type($post_ID))
      return;

    $annotation_object =  $_POST['recogito_annotation_object'];
    update_post_meta( $post_ID, 'recogito_annotation_object', $annotation_object);
	}
}
