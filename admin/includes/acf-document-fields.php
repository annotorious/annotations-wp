<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
'key' => 'group_630cdd935a689',
'title' => 'WP Annotate',
'fields' => array(
array(
'key' => 'field_630cdda04e36c',
'label' => 'Document Type',
'name' => 'document_type',
'type' => 'select',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '55',
  'class' => '',
  'id' => '',
),
'choices' => array(
  'image' => 'Image',
  'text' => 'Text',
),
'default_value' => 'image',
'allow_null' => 0,
'multiple' => 0,
'ui' => 0,
'return_format' => 'value',
'ajax' => 0,
'placeholder' => '',
),
array(
'key' => 'field_630cddd04e36d',
'label' => 'Text Content',
'name' => 'text_content',
'type' => 'wysiwyg',
'instructions' => 'Please enter your text content to be annotated below. Be aware that you will have to redo your annotations if you change this text later!',
'required' => 0,
'conditional_logic' => array(
  array(
    array(
      'field' => 'field_630cdda04e36c',
      'operator' => '==',
      'value' => 'text',
    ),
  ),
),
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => '',
'tabs' => 'all',
'toolbar' => 'full',
'media_upload' => 0,
'delay' => 0,
),
array(
'key' => 'field_630cde184e36e',
'label' => 'Image Content',
'name' => 'image_content',
'type' => 'image',
'instructions' => 'Upload or select your image here.',
'required' => 0,
'conditional_logic' => array(
  array(
    array(
      'field' => 'field_630cdda04e36c',
      'operator' => '==',
      'value' => 'image',
    ),
  ),
),
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'return_format' => 'url',
'preview_size' => 'thumbnail',
'library' => 'all',
'min_width' => '',
'min_height' => '',
'min_size' => '',
'max_width' => '',
'max_height' => '',
'max_size' => '',
'mime_types' => '',
),
array(
'key' => 'field_630cde93415db',
'label' => 'Image Annotation',
'name' => '',
'type' => 'tab',
'instructions' => '',
'required' => 0,
'conditional_logic' => array(
  array(
    array(
      'field' => 'field_630cdda04e36c',
      'operator' => '==',
      'value' => 'image',
    ),
  ),
),
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'placement' => 'top',
'endpoint' => 0,
),
array(
'key' => 'field_630cdfbff3c61',
'label' => 'Instructions',
'name' => '',
'type' => 'message',
'instructions' => '',
'required' => 0,
'conditional_logic' => array(
  array(
    array(
      'field' => 'field_630cde184e36e',
      'operator' => '==empty',
    ),
  ),
),
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'message' => 'You will be able to add annotations to your image after you attach it above.',
'new_lines' => 'wpautop',
'esc_html' => 0,
),
array(
'key' => 'field_630cdef3415dc',
'label' => 'Annotorious',
'name' => '',
'type' => 'message',
'instructions' => '',
'required' => 0,
'conditional_logic' => array(
  array(
    array(
      'field' => 'field_630cde184e36e',
      'operator' => '!=empty',
    ),
  ),
),
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'message' => 'Drag and select areas to add your image annotations.

<div id="annotorious-annotations"></div>',
'new_lines' => 'wpautop',
'esc_html' => 0,
),
array(
'key' => 'field_630ce061280e9',
'label' => 'Text Annotation',
'name' => '',
'type' => 'tab',
'instructions' => '',
'required' => 0,
'conditional_logic' => array(
  array(
    array(
      'field' => 'field_630cdda04e36c',
      'operator' => '==',
      'value' => 'text',
    ),
  ),
),
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'placement' => 'top',
'endpoint' => 1,
),
array(
'key' => 'field_630ce0a0280eb',
'label' => 'Recogito',
'name' => '',
'type' => 'message',
'instructions' => '',
'required' => 0,
'conditional_logic' => array(
  array(
    array(
      'field' => 'field_630cddd04e36d',
      'operator' => '!=empty',
    ),
  ),
),
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'message' => 'Press the button below to copy over the text from your content area once you are finished entering it in. Please be aware that Recogito is not able to handle text updates easily, so make sure your text is fully entered before pressing the button!
<hr />
<div id="recogito-annotations"></div>
<div id="recogito-copy-text-button" class="button button-small">Copy Text</div>',
'new_lines' => 'wpautop',
'esc_html' => 0,
),
),
'location' => array(
array(
array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'annotation-document',
),
),
),
'menu_order' => 0,
'position' => 'acf_after_title',
'style' => 'default',
'label_placement' => 'top',
'instruction_placement' => 'label',
'hide_on_screen' => '',
'active' => true,
'description' => '',
));

endif;		
?>
