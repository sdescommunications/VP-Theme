<?php

/**
 * Abstract class for defining custom post types.
 *
 **/
abstract class CustomPostType{
	public
	$name           = 'custom_post_type',
	$plural_name    = 'Custom Posts',
	$singular_name  = 'Custom Post',
	$add_new_item   = 'Add New Custom Post',
	$edit_item      = 'Edit Custom Post',
	$new_item       = 'New Custom Post',
		$public         = True,  # I dunno...leave it true
		$use_title      = True,  # Title field
		$use_editor     = True,  # WYSIWYG editor, post content field
		$use_revisions  = True,  # Revisions on post content and titles
		$use_thumbnails = False, # Featured images
		$use_order      = False, # Wordpress built-in order meta data
		$use_metabox    = False, # Enable if you have custom fields to display in admin
		$use_shortcode  = False, # Auto generate a shortcode for the post type
		                         # (see also objectsToHTML and toHTML methods)
		$taxonomies     = array('post_tag'),
		$built_in       = False,

		# Optional default ordering for generic shortcode if not specified by user.
		$default_orderby = null,
		$default_order   = null;


	/**
	 * Wrapper for get_posts function, that predefines post_type for this
	 * custom post type.  Any options valid in get_posts can be passed as an
	 * option array.  Returns an array of objects.
	 **/
	public function get_objects($options=array()){

		$defaults = array(
			'numberposts'   => -1,
			'orderby'       => 'title',
			'order'         => 'ASC',
			'post_type'     => $this->options('name'),
			);
		$options = array_merge($defaults, $options);
		$objects = get_posts($options);
		return $objects;
	}


	/**
	 * Similar to get_objects, but returns array of key values mapping post
	 * title to id if available, otherwise it defaults to id=>id.
	 **/
	public function get_objects_as_options($options=array()){
		$objects = $this->get_objects($options);
		$opt     = array();
		foreach($objects as $o){
			switch(True){
				case $this->options('use_title'):
				$opt[$o->post_title] = $o->ID;
				break;
				default:
				$opt[$o->ID] = $o->ID;
				break;
			}
		}
		return $opt;
	}


	/**
	 * Return the instances values defined by $key.
	 **/
	public function options($key){
		$vars = get_object_vars($this);
		return $vars[$key];
	}


	/**
	 * Additional fields on a custom post type may be defined by overriding this
	 * method on an descendant object.
	 **/
	public function fields(){
		return array();
	}


	/**
	 * Using instance variables defined, returns an array defining what this
	 * custom post type supports.
	 **/
	public function supports(){
		#Default support array
		$supports = array();
		if ($this->options('use_title')){
			$supports[] = 'title';
		}
		if ($this->options('use_order')){
			$supports[] = 'page-attributes';
		}		
		if ($this->options('use_thumbnails')){		
			$supports[] = 'thumbnail';
		}		
		if ($this->options('use_editor')){
			$supports[] = 'editor';
		}
		if ($this->options('use_revisions')){
			$supports[] = 'revisions';
		}
		return $supports;
	}


	/**
	 * Creates labels array, defining names for admin panel.
	 **/
	public function labels(){
		return array(
			'name'          => __($this->options('plural_name')),
			'singular_name' => __($this->options('singular_name')),
			'add_new_item'  => __($this->options('add_new_item')),
			'edit_item'     => __($this->options('edit_item')),
			'new_item'      => __($this->options('new_item')),
			);
	}


	/**
	 * Creates metabox array for custom post type. Override method in
	 * descendants to add or modify metaboxes.
	 **/
	public function metabox(){
		if ($this->options('use_metabox')){
			return array(
				'id'       => $this->options('name').'_metabox',
				'title'    => __($this->options('singular_name').' Fields'),
				'page'     => $this->options('name'),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => $this->fields(),
				);
		}
		return null;
	}


	/**
	 * Registers metaboxes defined for custom post type.
	 **/
	public function register_metaboxes(){
		if ($this->options('use_metabox')){
			$metabox = $this->metabox();
			add_meta_box(
				$metabox['id'],
				$metabox['title'],
				'show_meta_boxes',
				$metabox['page'],
				$metabox['context'],
				$metabox['priority']
				);
		}
	}


	/**
	 * Registers the custom post type and any other ancillary actions that are
	 * required for the post to function properly.
	 **/
	public function register(){
		$registration = array(
			'labels'     => $this->labels(),
			'supports'   => $this->supports(),
			'public'     => $this->options('public'),
			'taxonomies' => $this->options('taxonomies'),
			'_builtin'   => $this->options('built_in')
			);

		if ($this->options('use_order')){
			$registration = array_merge($registration, array('hierarchical' => True,));
		}

		register_post_type($this->options('name'), $registration);

		if ($this->options('use_shortcode')){
			add_shortcode($this->options('name').'-list', array($this, 'shortcode'));
		}
	}


	/**
	 * Shortcode for this custom post type.  Can be overridden for descendants.
	 * Defaults to just outputting a list of objects outputted as defined by
	 * toHTML method.
	 **/
	public function shortcode($attr){
		$default = array(
			'type' => $this->options('name'),
			);
		if (is_array($attr)){
			$attr = array_merge($default, $attr);
		}else{
			$attr = $default;
		}
		return sc_object_list($attr);
	}


	/**
	 * Handles output for a list of objects, can be overridden for descendants.
	 * If you want to override how a list of objects are outputted, override
	 * this, if you just want to override how a single object is outputted, see
	 * the toHTML method.
	 **/
	public function objectsToHTML($objects, $css_classes){
		if (count($objects) < 1){ return '';}

		$class = get_custom_post_type($objects[0]->post_type);
		$class = new $class;

		ob_start();
		?>
		<ul class="<?php if($css_classes):?><?=$css_classes?><?php else:?><?=$class->options('name')?>-list<?php endif;?>">
			<?php foreach($objects as $o):?>
				<li>
					<?=$class->toHTML($o)?>
				</li>
			<?php endforeach;?>
		</ul>
		<?php
		$html = ob_get_clean();
		return $html;
	}

	public static function sc_object_list( $attrs, $args = array() ) {
		if ( ! is_array( $attrs ) ) {return '';}

		$default_args = array(
			'default_content' => null,
			'sort_func' => null,
			'objects_only' => false,
			'classname' => '',
			);

		// Make keys into variable names for merged $default_args/$args.
		extract( array_merge( $default_args, $args ) );

		// Set defaults and combine with passed arguments.
		$default_attrs = array(
			'type'    => null,
			'limit'   => -1,
			'join'    => 'or',
			'class'   => '',
			'orderby' => 'menu_order title',
			'meta_key' => null,
			'order'   => 'ASC',
			'offset'  => 0,
			'meta_query' => array(),
			);
		$params = array_merge( $default_attrs, $attrs );
		$classname = ( '' === $classname ) ? $params['type'] : $classname;

		$params['limit']  = intval( $params['limit'] );
		$params['offset'] = intval( $params['offset'] );

		// Verify inputs.
		if ( null === $params['type'] ) {
			return '<p class="error">No type defined for object list.</p>';
		}
		if ( ! in_array( strtoupper( $params['join'] ), array( 'AND', 'OR' ) ) ) {
			return '<p class="error">Invalid join type, must be one of "and" or "or".</p>';
		}
		if ( ! class_exists( $classname ) ) {
			return '<p class="error">Invalid post type or classname.</p>';
		}

		$class = new $classname;

		// Use post type specified ordering?
		if ( ! isset( $attrs['orderby'] ) && ! is_null( $class->default_orderby ) ) {
			$params['orderby'] = $class->orderby;
		}
		if ( ! isset( $attrs['order'] ) && ! is_null( $class->default_order ) ) {
			$params['order'] = $class->default_order;
		}

		// Get taxonomies and translation.
		$translate = array(
			'tags' => 'post_tag',
			'categories' => 'category',
			'org_groups' => 'org_groups',
			);
		$taxonomies = array_diff( array_keys( $attrs ), array_keys( $default_attrs ) );

		// Assemble taxonomy query.
		$tax_queries = array();
		$tax_queries['relation'] = strtoupper( $params['join'] );

		foreach ( $taxonomies as $tax ) {
			$terms = $params[ $tax ];
			$terms = trim( preg_replace( '/\s+/', ' ', $terms ) );
			$terms = explode( ' ', $terms );
			if ( '' === $terms[0] ) { continue; } // Skip empty taxonomies.

			if ( array_key_exists( $tax, $translate ) ) {
				$tax = $translate[ $tax ];
			}

			foreach ( $terms as $idx => $term ) {
				if ( in_array( strtolower( $term ), array( 'none', 'null', 'empty' ) ) ) {
					unset( $terms[ $idx ] );
					$terms[] = '';
				}
			}

			$tax_queries[] = array(
				'taxonomy' => $tax,
				'field' => 'slug',
				'terms' => array_unique( $terms ),
				);
		}

		// Perform query.
		$query_array = array(
			'tax_query'      => $tax_queries,
			'post_status'    => 'publish',
			'post_type'      => $params['type'],
			'posts_per_page' => $params['limit'],
			'orderby'        => $params['orderby'],
			'order'          => $params['order'],
			'offset'         => $params['offset'],
			'meta_query'     => $params['meta_query'],
			);

		$query = new \WP_Query( $query_array );

		global $post;
		$objects = array();
		while ( $query->have_posts() ) {
			$query->the_post();
			$objects[] = $post;
		}

		// Custom sort if applicable.
		if ( null !== $sort_func ) {
			usort( $objects, $sort_func );
		}

		wp_reset_postdata();

		if ( $objects_only ) {
			return $objects;
		}

		if ( count( $objects ) ) {
			$html = $class->objectsToHTML( $objects, $params['class'] );
		} else {
			if ( isset( $tax_queries['terms'] ) ) {
				$default_content .= '<!-- No results were returned for: ' . $tax_queries['taxonomy'] . '. Does this attribute need to be unset()? -->';
			}
			$html = $default_content;
		}
		return $html;
	}


	/**
	 * Outputs this item in HTML.  Can be overridden for descendants.
	 **/
	public function toHTML($object){
		$html = '<a href="'.get_permalink($object->ID).'">'.$object->post_title.'</a>';
		return $html;
	}
}


class Page extends CustomPostType {
	public
	$name           = 'page',
	$plural_name    = 'Pages',
	$singular_name  = 'Page',
	$add_new_item   = 'Add New Page',
	$edit_item      = 'Edit Page',
	$new_item       = 'New Page',
	$public         = true,
	$use_editor     = true,
	$use_thumbnails = False,
	$use_order      = true,
	$use_title      = true,
	$use_metabox    = true,
	$calculated_columns = array(), // Empty array to hide thumbnails.
	$built_in       = true;

	public function fields() {
		$prefix = $this->options( 'name' ).'_';
		return array(
			array(
				'name'  => 'Side Column',
				'descr' => 'Show content in column to the right or left of the page (e.g., menuPanels).',
				'id'    => $prefix.'sidecolumn',
				'type'  => 'editor',
				),
			);
	}
}

class Alert extends CustomPostType {
	public
	$name           = 'alert',
	$plural_name    = 'Alerts',
	$singular_name  = 'Alert',
	$add_new_item   = 'Add New Alert',
	$edit_item      = 'Edit Alert',
	$new_item       = 'New Alert',
		$public         = true,  // I dunno...leave it true
		$use_title      = true,  // Title field
		$use_editor     = true,  // WYSIWYG editor, post content field
		$use_revisions  = true,  // Revisions on post content and titles
		$use_thumbnails = false,  // Featured images
		$use_order      = false, // Wordpress built-in order meta data
		$use_metabox    = true,  // Enable if you have custom fields to display in admin
		$use_shortcode  = true,  // Auto generate a shortcode for the post type
		                         // (see also objectsToHTML and toHTML methods).
		$taxonomies     = array( 'post_tag' ),
		$menu_icon      = 'dashicons-warning',
		$built_in       = false,
		// Optional default ordering for generic shortcode if not specified by user.
		$default_orderby = null,
		$default_order   = null,
		// Interface Columns/Fields
		$calculated_columns = array(), // Empty array to hide thumbnails.
		$sc_interface_fields = false;

		public function fields() {
			$prefix = $this->options( 'name' ).'_';
			return array(
				array(
					'name' => 'Unplanned Alert',
					'desc' => 'If checked, show the alert as red instead of yellow.',
					'id' => $prefix.'is_unplanned',
					'type' => 'checkbox',
					'choices' => array(
						'Unplanned alert.' => $prefix.'is_unplanned',
						),
					'custom_column_order' => 400,
					),
				array(
					'name' => 'Sitewide Alert',
					'desc' => 'Show alert across the entire site.',
					'id' => $prefix.'is_sitewide',
					'type' => 'checkbox',
					'choices' => array(
						'Sitewide alert.' => $prefix.'is_sitewide',
						),
					'custom_column_order' => 300,
					),
				array(
					'name' => 'Start Date',
					'desc' => 'The first day the alert should appear.',
					'id' => $prefix.'start_date',
					'type' => 'text',
					'custom_column_order' => 100,
					),
				array(
					'name' => 'End Date',
					'desc' => 'The last day the alert should appear.',
					'id' => $prefix.'end_date',
					'type' => 'text',
					'custom_column_order' => 200,
					),
				array(
					'name' => 'URL',
					'desc' => 'Add a link for this alert.',
					'id' => $prefix.'url',
					'type' => 'text',
					'default' => 'http://',
					),
				);
		}

		public function custom_column_echo_data( $column, $post_id ) {
			$prefix = $this->options( 'name' ) . '_';
			switch ( $column ) {
				case $prefix.'is_unplanned':
				case $prefix.'is_sitewide':
				$data = get_post_meta( $post_id, $column, true );
				$checked = ( '' !== $data ) ? 'Yes' : '&mdash;';
				echo wp_kses_data( "{$checked}" );
				break;
				default:
				parent::custom_column_echo_data( $column, $post_id );
				break;
			}
		}

		public function shortcode( $attr ) {
			$prefix = $this->options( 'name' ).'_';
			$default_attrs = array(
				'type' => $this->options( 'name' ),
				'orderby' => 'meta_value_datetime',
				'meta_key' => $prefix.'start_date',
				'order' => 'ASC',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => $prefix.'start_date',
						'value' => date( 'Y-m-d', time() ),
						'compare' => '<=',
						),
					array(
						'key' => $prefix.'end_date',
					'value' => date( 'Y-m-d', strtotime( '-1 day' ) ), // Datetime is stored as 24 hours before it should expire.
					'compare' => '>',
					),
					),
				'show_all' => false,
				);
			if ( is_array( $attr ) ) {
				$attr = array_merge( $default_attrs, $attr );
			} else {
				$attr = $default_attrs;
			}
			$attr['show_all'] = filter_var( $attr['show_all'], FILTER_VALIDATE_BOOLEAN );
			if ( ! $attr['show_all'] ) {
				array_push( $attr['meta_query'],
					array(
						'key' => $prefix.'is_sitewide',
					// Remember that Checkbox list values are serialized.
					// See: //wordpress.org/support/topic/meta_query-doesnt-find-value-if-custom-field-value-is-serialized#post-2106580 .
						'value' => serialize( strval( $prefix.'is_sitewide' ) ),
						'compare' => 'LIKE',
						)
					);
			}
			// Unset custom attributes.
			unset( $attr['show_all'] );
			$args = array( 'classname' => __CLASS__ );
			return parent::sc_object_list( $attr, $args );
		}

		/**
		 * Return an array of only the metadata fields used to create a render context.
		 * @param WP_Post $alert The alert whose metadata should be retrieved.
		 * @return Array The fields to pass into get_render_context.
		 */
		private static function get_render_metadata( $alert ) {
			$metadata_fields = array();
			$metadata_fields['alert_is_unplanned'] = get_post_meta( $alert->ID, 'alert_is_unplanned', true );
			$metadata_fields['alert_url'] = esc_attr( get_post_meta( $alert->ID, 'alert_url', true ) );
			return $metadata_fields;
		}

		/**
		 * Generate a render context for an alert, given its WP_Post object and an array of its metadata fields.
		 * Expected fields:
		 * $alert - post_content, post_title 
		 * $metadata_fields - alert_is_unplanned, alert_url
		 * @param WP_Post $alert The post object to be displayed.
		 * @param Array   $metadata_fields The metadata fields associated with this alert.
		 */
		public static function get_render_context( $alert, $metadata_fields ) {

			$alert_css_classes = ( $metadata_fields['alert_is_unplanned'] )
			? 'card-danger' : 'card-info';
			
			$alert_url = ($metadata_fields['alert_url'] == 'http://') ? null : $metadata_fields['alert_url'];
			$alert_message = wpautop($alert->post_content);

			$alert_title = $alert->post_title;

			return array(
				'css_classes' => $alert_css_classes,
				'title' => $alert_title,
				'message' => $alert_message,
				'url' => $alert_url, 
				);
		}

		public function objectsToHTML( $objects, $css_classes ) {
			if ( count( $objects ) < 1 ) { return (WP_DEBUG) ? '<!-- No objects were provided to objectsToHTML. -->' : '';}
			$context['css_classes'] = ( $css_classes ) ? $css_classes : $this->options( 'name' ).'-list';

			foreach ( $objects as $alert ) {
				$metadata_fields = static::get_render_metadata( $alert );
				$context['alert_contexts'][] = static::get_render_context( $alert, $metadata_fields );
			}
			return static::render_objects_to_html( $context );
		}

		/**
		 * Render HTML for a collection of alerts.
		 */
		protected static function render_objects_to_html( $context ) {
			ob_start();
			?>
			<span class="<?= $context['css_classes'] ?>">
				<?php foreach ( $context['alert_contexts'] as $alert ) :
				echo static::render_to_html( $alert );
				endforeach; ?>
			</span>
			<?php
			
			return ob_get_clean();
		}

		/**
		 * Render HTML for a single alert.
		 */
		protected static function render_to_html( $context ) {
			ob_start();			 
			
			?>
			<div class="card card-inverse <?= $context['css_classes'] ?>">
				<div class="container card-block">
					<?= (!empty($context['url'])) ? '<a href="<?= $context["url"] ?>' : NULL ?>
					<h2><?= $context['title'] ?></h2>
					<?= $context['message'] ?>
					<?= (!empty($context['url'])) ? '</a>' : NULL ?>
				</div>
			</a>
		</div>
		<div class="clearfix"></div>
		<?php

		return ob_get_clean();
	}
}

class Staff extends CustomPostType {
	public
	$name           = 'staff',
	$plural_name    = 'Staff',
	$singular_name  = 'Staff',
	$add_new_item   = 'Add New Staff',
	$edit_item      = 'Edit Staff',
	$new_item       = 'New Staff',
		$public         = true,  // I dunno...leave it true
		$use_title      = true,  // Title field
		$use_editor     = true,  // WYSIWYG editor, post content field
		$use_revisions  = true,  // Revisions on post content and titles
		$use_thumbnails = true,  // Featured images
		$use_order      = true, // Wordpress built-in order meta data
		$use_metabox    = true, // Enable if you have custom fields to display in admin
		$use_shortcode  = true, // Auto generate a shortcode for the post type
		                         // (see also objectsToHTML and toHTML methods).
		$taxonomies     = array( 'post_tag', 'org_groups' ),
		$menu_icon      = 'dashicons-groups',
		$built_in       = false,
		// Optional default ordering for generic shortcode if not specified by user.
		$default_orderby = null,
		$default_order   = null,
		$sc_interface_fields = array(
			array(
				'name' => 'Header',
				'id' => 'header',
				'help_text' => 'Show a header for above the staff list.',
				'type' => 'text',
				'default' => 'Staff List',
				),
			array(
				'name' => 'Collapse',
				'id' => 'collapse',
				'help_text' => 'Add a "[Read More] link for long "Details" sections.',
				'type' => 'dropdown',
				'choices' => array(
					array( 'value' => 'false', 'name' => "Don't show [Read More] link." ),
					array( 'value' => 'true', 'name' => 'Show [Read More] link.' ),
					),
				),
			);

		public function fields() {
			$prefix = $this->options( 'name' ).'_';
			return array(
				array(
					'name' => 'Position Title',
					'descr' => '',
					'id' => $prefix.'position_title',
					'type' => 'text',
					),
				array(
					'name' => 'Email',
					'descr' => '',
					'id' => $prefix.'email',
					'type' => 'text',
					),
				array(
					'name' => 'Phone',
					'descr' => '',
					'id' => $prefix.'phone',
					'type' => 'text',
					),
				);
		}

		public function metabox() {
			if ( $this->options( 'use_metabox' ) ) {
				return array(
					'id'       => 'custom_'.$this->options( 'name' ).'_metabox',
					'title'    => __( $this->options( 'singular_name' ).' Fields' ),
					'page'     => $this->options( 'name' ),
					'context'  => 'after_title',
					'priority' => 'high',
					'fields'   => $this->fields(),
					);
			}
			return null;
		}

		public function register_metaboxes() {
			// Move and Rename the Featured Image Metabox.
			remove_meta_box( 'postimagediv', $this->name, 'side' );
			add_meta_box('postimagediv', __( "{$this->singular_name} Image" ),
				'post_thumbnail_meta_box', $this->name, 'after_title', 'high');

			add_action( 'edit_form_after_title', 'do_meta_boxes_after_title' );

			parent::register_metaboxes();
		}

		public function shortcode( $attr ) {
			$prefix = $this->options( 'name' ).'_';
			$default_attrs = array(
				'type' => $this->options( 'name' ),
				'header' => $this->options( 'plural_name' ) . ' List',
				'css_classes' => '',
				'collapse' => false,
				);
			if ( is_array( $attr ) ) {
				$attr = array_merge( $default_attrs, $attr );
			} else {
				$attr = $default_attrs;
			}

			$context['header'] = $attr['header'];
			$context['css_classes'] = ( $attr['css_classes'] ) ? $attr['css_classes'] : $this->options( 'name' ).'-list';
			$context['collapse'] = filter_var( $attr['collapse'], FILTER_VALIDATE_BOOLEAN );
			unset( $attr['header'] );
			unset( $attr['css_classes'] );
			unset( $attr['collapse'] );
			$args = array( 'classname' => __CLASS__, 'objects_only' => true );
			$objects = parent::sc_object_list( $attr, $args );

			$context['objects'] = $objects;
			return static::render_objects_to_html( $context );
		}

		public function objectsToHTML( $objects, $css_classes ) {
			if ( count( $objects ) < 1 ) { return (WP_DEBUG) ? '<!-- No objects were provided to objectsToHTML. -->' : '';}
			$context['css_classes'] = ( $css_classes ) ? $css_classes : $this->options( 'name' ).'-list';
			$context['archiveUrl'] = '';
			$context['objects'] = $objects;
			return static::render_objects_to_html( $context );
		}

		protected function render_objects_to_html( $context ) {
			ob_start();
			?>
			<?php if ( $context['collapse'] ) : ?>
				<script type="text/javascript">
					$(function(){
						var collapsedSize = 60;
						$(".staff-details").each(function() {
							var h = this.scrollHeight;
							var div = $(this);
							if (h > 30) {
								div.css("height", collapsedSize);
								div.after("<a class=\"staff-more\" href=\"\">[Read More]</a>");
								var link = div.next();
								link.click(function(e) {
									e.stopPropagation();
									e.preventDefault();
									if (link.text() != "[Collapse]") {
										link.text("[Collapse]");
										div.animate({ "height": h });
									} else {
										div.animate({ "height": collapsedSize });
										link.text("[Read More]");
									}
								});
							}
						});
					});
				</script>
			<?php endif;
			if ( $context['header'] ) : ?>
			<div class="staff-role"><?= $context['header'] ?></div>
		<?php endif; ?>
		<span class="<?= $context['css_classes'] ?>">
			<?php foreach ( $context['objects'] as $o ) : ?>
				<?= static::toHTML( $o ) ?>
				<div class="hr-blank"></div>
			<?php endforeach;?>
		</span>
		<?php

		return ob_get_clean();
	}

	public function toHTML( $post_object ) {
		$context['Post_ID'] = $post_object->ID;
		$thumbnailUrl = get_stylesheet_directory_uri() . '/images/blank.png';
		$context['thumbnail']
		= has_post_thumbnail( $post_object )
		? get_the_post_thumbnail( $post_object, 'post-thumbnail', array( 'class' => 'img-fluid' ) )
		: "<img src='".$thumbnailUrl."' alt='thumb' class='img-fluid'>";
		$context['title'] = get_the_title( $post_object );
		$context['staff_position_title'] = get_post_meta( $post_object->ID, 'staff_position_title', true );
		$context['staff_phone'] = get_post_meta( $post_object->ID, 'staff_phone', true );
		$context['staff_email'] = get_post_meta( $post_object->ID, 'staff_email', true );
		$context['content'] = wpautop($post_object->post_content);
		return static::render_to_html( $context );
	}

	protected function render_to_html( $context ) {
		ob_start();
		?>
		<div class="staff">
			<?= $context['thumbnail'] ?>
			<div class="staff-content">
				<h3 class="staff-name"><a href="<?= get_permalink($context['Post_ID']) ?>"><?= $context['title'] ?></a></h3>
				<h4 class="staff-title"><?= $context['staff_position_title'] ?></h4>
				<h5 class="staff-phone"><?= $context['staff_phone'] ?></h5>
				<h5 class="staff-email">
					<a href="mailto:<?= $context['staff_email'] ?>"><?= $context['staff_email'] ?></a>
				</h5>
				<div class="staff-details"><?= $context['content'] ?></div>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}
}

function do_meta_boxes_after_title( $post ) {
	do_meta_boxes( get_current_screen(), 'after_title', $post ); // Output meta boxes for the 'after_title' context.
}

class Department extends CustomPostType{
	public
	$name           = 'department',
	$plural_name    = 'Departments',
	$singular_name  = 'Department',
	$add_new_item   = 'Add Department',
	$edit_item      = 'Edit Department',
	$new_item       = 'New Department',
		$public         = True,  # I dunno...leave it true
		$use_title      = True,  # Title field
		$use_editor     = True,  # WYSIWYG editor, post content field
		$use_revisions  = True,  # Revisions on post content and titles
		$use_thumbnails = True, # Featured images
		$use_order      = False, # Wordpress built-in order meta data
		$use_metabox    = True, # Enable if you have custom fields to display in admin
		$use_shortcode  = False, # Auto generate a shortcode for the post type
		                         # (see also objectsToHTML and toHTML methods)
		$taxonomies     = array(''),
		$built_in       = false,

		# Optional default ordering for generic shortcode if not specified by user.
		$default_orderby = null,
		$default_order   = null;

		public function fields() {			

			$prefix = $this->options( 'name' ).'_';

			return array(
				array(
					'name'  => 'Director Name',
					'descr' => '',
					'id'    => $prefix.'directorname',
					'type'  => 'text',
					),
				array(
					'name'  => 'Phone',
					'descr' => '',
					'id'    => $prefix.'phone',
					'type'  => 'text',
					),
				array(
					'name'  => 'Fax',
					'descr' => '',
					'id'    => $prefix.'fax',
					'type'  => 'text',
					),
				array(
					'name'  => 'Email',
					'descr' => '',
					'id'    => $prefix.'email',
					'type'  => 'text',
					),
				array(
					'name'  => 'Location',
					'descr' => '',
					'id'    => $prefix.'loc',
					'type'  => 'text',
					),
				array(
					'name'  => 'Map Link',
					'descr' => '',
					'id'    => $prefix.'map',
					'type'  => 'text',
					),
				array(
					'name'  => 'Primary Website URL',
					'descr' => '',
					'id'    => $prefix.'primary_url',
					'type'  => 'text',
					),
				);
		}

		public function toHTML( ) {				

			$args = array(
				'post_type' => array('department'),
				'orderby' => 'title',
				'order'   => 'ASC',
				);
			$object = new WP_Query($args);			
			
			$prefix     = 'department_';
			$pre 		= 'dep_';

			ob_start();
			
			if ( $object->have_posts() ) :
				while ( $object->have_posts() ) : $object->the_post();

			$post_id    = $object->post->ID;

			$image_url 	= has_post_thumbnail( $post_id ) ?
			wp_get_attachment_image_src( get_post_thumbnail_id( $post_id )) : null;

			if ( $image_url ) {
				$image_url = $image_url[0];
			}

			$dir_name = get_post_meta( $post_id, $prefix.'directorname', true );
			$phone = get_post_meta( $post_id, $prefix.'phone', true );
			$fax = get_post_meta( $post_id, $prefix.'fax', true );
			$email = get_post_meta( $post_id, $prefix.'email', true );
			$loc = get_post_meta( $post_id, $prefix.'loc', true );
			$map = get_post_meta( $post_id, $prefix.'map', true );
			$purl = get_post_meta( $post_id, $prefix.'primary_url', true );
			$fb = get_post_meta( $post_id, $pre.'facebook', true );
			$twitter = get_post_meta( $post_id, $pre.'twitter', true );

			?>	


			<div class="row dept" id="<?= $post_id ?>">
				<div class="col-sm-2">
					<img src="<?= $image_url ?>" class="img-fluid">
				</div>
				<div class="col-sm-10">
					<h2><a href="<?= get_permalink($post_id) ?>"><?= the_title() ?></a></h2>
					<h3 class="muted"><?= $dir_name ?></h3>

					<table class="table table-hover">
						<tbody>
							<?php if(!empty($phone)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-phone"><span class="sr-only">Phone</span></i></th>
								<td><?= $phone ?></td>
							</tr>									
							<?php  } ?>
							<?php if(!empty($fax)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-fax"><span class="sr-only">Fax</span></i></th>
								<td><?= $fax ?></td>
							</tr>
							<?php  } ?>
							<?php if(!empty($email)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-envelope"><span class="sr-only">Email</span></i></th>
								<td><a href="mailto:<?= $email ?>"><?= $email ?></a></td>
							</tr>
							<?php  } ?>
							<?php if(!empty($map) && !empty($loc)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-map-marker"><span class="sr-only">Location</span></i></th>
								<td><a href="<?= $map ?>"><?= $loc ?></a></td>
							</tr>
							<?php  } ?>
							<?php if(!empty($fb)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-link"><span class="sr-only">Website</span></i></th>
								<td><a href="<?= $purl ?>"><?= $purl ?></a></td>
							</tr>
							<?php  } ?>
							<?php if(!empty($fb)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-facebook-official"><span class="sr-only">Facebook</span></i></th>
								<td><a href="<?= $fb ?>">Facebook</a></td>
							</tr>
							<?php  } ?>
							<?php if(!empty($twitter)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-twitter"><span class="sr-only">Twitter</span></i></th>
								<td><a href="<?= $twitter ?>">Twitter</a></td>
							</tr>
							<?php  } ?>
						</tbody>
					</table>

				</div>
			</div> 

			<?php endwhile; wp_reset_postdata(); ?>
			<!-- show pagination here -->
			<?php else : ?>
			<!-- show 404 error here -->
			<?php endif; ?>


			<?php 
			return ob_get_clean();
		}

		public function toHTMLMENU ( ) {
			$args = array(
				'post_type' => array('department'),
				'orderby' => 'title',
				'order'   => 'ASC',
				);
			$object = new WP_Query($args);
			ob_start();
			?>

			<div class="menu">					
				<div class="menu-header">
					Page Navigation
				</div>
				<ul class="list-group menu-right list-unstyled">

					<?php
					if ( $object->have_posts() ) :
						while ( $object->have_posts() ) : $object->the_post();
					?>
					<li><a class="list-group-item" href="#<?= $object->post->ID ?>"><?= the_title() ?></a></li>

					<?php endwhile; wp_reset_postdata(); ?>
					<!-- show pagination here -->
					<?php else : ?>
						<!-- show 404 error here -->
					<?php endif; ?>

				</ul>
			</div>

			<?php
			return ob_get_clean();
		}
}

class News extends CustomPostType {
	public
	$name           = 'news',
	$plural_name    = 'News',
	$singular_name  = 'News',
	$add_new_item   = 'Add New News',
	$edit_item      = 'Edit News',
	$new_item       = 'New News',
		$public         = true,  // I dunno...leave it true
		$use_title      = true,  // Title field
		$use_editor     = true,  // WYSIWYG editor, post content field
		$use_revisions  = true,  // Revisions on post content and titles
		$use_thumbnails = true,  // Featured images
		$use_order      = true, // Wordpress built-in order meta data
		$use_metabox    = true, // Enable if you have custom fields to display in admin
		$use_shortcode  = true, // Auto generate a shortcode for the post type
		                         // (see also objectsToHTML and toHTML methods).
		$taxonomies     = array( 'post_tag', 'categories' ),
		$menu_icon      = 'dashicons-admin-site',
		$built_in       = false,
		// Optional default ordering for generic shortcode if not specified by user.
		$default_orderby = null,
		$default_order   = null,
		// Interface Columns/Fields
		// $calculated_columns = array(),
		$sc_interface_fields = array();

		public function fields() {
			$prefix = $this->options( 'name' ).'_';
			return array(
				array(
					'name' => 'Strapline',
					'descr' => '',
					'id' => $prefix.'strapline',
					'type' => 'text',
					),
				array(
					'name' => 'URL',
					'descr' => '',
					'id' => $prefix.'url',
					'type' => 'text',
					'default' => 'http://',
					),
				
				);
		}

		public function toHTMLHOME() {	

			$prefix = 'news_';			

			$args = array(
				'post_type' => array('news'),
				'orderby' => 'title',
				'order'   => 'ASC',
				'posts_per_page' => '3',
				);
			$object = new WP_Query($args);			

			ob_start();
			
			if ( $object->have_posts() ) :
				while ( $object->have_posts() ) : $object->the_post();

			$image_url = has_post_thumbnail( $object->post->ID ) ?
			wp_get_attachment_image_src( get_post_thumbnail_id( $object->post->ID )) : null;

			if ( $image_url ) {
				$image_url = $image_url[0];
			}

			$strapline = get_post_meta( $object->post->ID, $prefix.'strapline', true );
			$url = get_post_meta( $object->post->ID, $prefix.'url', true );
			

			?>

			<div class="media">
				<img class="d-flex mr-3 float-left" src="<?= $image_url ?>" width="75px" alt="Generic placeholder image">
				<div class="media-body">
					<h4><a href="<?= get_permalink($post_id) ?>"><?= the_title() ?></a></h4>
					<h5><?= $strapline ?></h5>
				</div>
			</div>

			<?php endwhile; wp_reset_postdata(); ?>
			<a class="btn btn-dark float-right mt-3" href="news">More News</a>
			<!-- show pagination here -->
			<?php else : ?>
			<!-- show 404 error here -->
			<?php endif; ?>


			<?php 
			return ob_get_clean();
		}

		public function toHTMLFULL(){
			$args = array(
				'post_type' => array('news'),
				'orderby' => 'title',
				'order'   => 'ASC',
				);
			$object = new WP_Query($args);			
			
			$prefix     = 'news_';

			ob_start();
			
			if ( $object->have_posts() ) :
				while ( $object->have_posts() ) : $object->the_post();

			$image_url 	= has_post_thumbnail( $object->post->ID ) ?
			wp_get_attachment_image_src( get_post_thumbnail_id( $object->post->ID )) : null;

			if ( $image_url ) {
				$image_url = $image_url[0];
			}

			$strapline = get_post_meta( $object->post->ID, $prefix.'strapline', true );
			$url = get_post_meta( $object->post->ID, $prefix.'url', true );

			?>	

			<div class="news" id="<?= $object->post->ID ?>">
				<img src="<?= $image_url ?>" class="img-fluid">
				<div class="news-content">
					<h2 class="news-title">
						<?php
							 if(!empty($url)){
							 	echo '<a href="' . $url . '">'. get_the_title() . '</a>';
							 } else{
							 	echo get_the_title();
							 }
						 ?>							
					</h2>
					<h3 class="news-strapline"><?= $strapline ?></h3>
					<p class="datestamp">Posted <?= get_the_date( 'l, F j, Y @ g:i A', $object->post->ID ) ?></p>
					<div class="news-summary">
						<?= get_the_excerpt($object->post->ID) ?>					
						<p><a class="" href="<?= get_permalink() ?>">Read More >></a></p>
					</div>
					
						
				</div>
			</div>
			

			<?php endwhile; wp_reset_postdata(); ?>
			<!-- show pagination here -->
			<?php else : ?>
			<!-- show 404 error here -->
			<?php endif; ?>


			<?php 
			return ob_get_clean();
		}

		public function toHTMLMENU(){
			$args = array(
				'post_type' => array('news'),
				'orderby' => 'title',
				'order'   => 'ASC',
				);
			$object = new WP_Query($args);
			ob_start();
			?>

			<div class="menu">					
				<div class="menu-header">
					Page Navigation
				</div>
				<ul class="list-group menu-right list-unstyled">

					<?php
					if ( $object->have_posts() ) :
						while ( $object->have_posts() ) : $object->the_post();
					?>
					<li><a class="list-group-item" href="#<?= $object->post->ID ?>"><?= the_title() ?></a></li>

					<?php endwhile; wp_reset_postdata(); ?>
					<!-- show pagination here -->
					<?php else : ?>
						<!-- show 404 error here -->
					<?php endif; ?>

				</ul>
			</div>

			<?php
			return ob_get_clean();
		}
}

class FAQ extends CustomPostType {
	public
	$name           = 'faq',
	$plural_name    = 'FAQs',
	$singular_name  = 'FAQ',
	$add_new_item   = 'Add New FAQ',
	$edit_item      = 'Edit FAQ',
	$new_item       = 'New FAQ',
	$public         = true,  // I dunno...leave it true
	$use_title      = true,  // Title field
	$use_editor     = true,  // WYSIWYG editor, post content field
	$use_revisions  = true,  // Revisions on post content and titles
	$use_thumbnails = false,  // Featured images
	$use_order      = true, // Wordpress built-in order meta data
	$use_metabox    = false, // Enable if you have custom fields to display in admin
	$use_shortcode  = true, // Auto generate a shortcode for the post type
	                         // (see also objectsToHTML and toHTML methods).
	$taxonomies     = array( 'org_groups' ),
	$menu_icon      = 'dashicons-editor-help',
	$built_in       = false,
	// Optional default ordering for generic shortcode if not specified by user.
	$default_orderby = null,
	$default_order   = null,
	$sc_interface_fields = array();

	public function shortcode( $attr ) {
		$prefix = $this->options( 'name' ).'_';
		$default_attrs = array(
			'type' => $this->options( 'name' ),
			);
		if ( is_array( $attr ) ) {
			$attr = array_merge( $default_attrs, $attr );
		} else {
			$attr = $default_attrs;
		}

		$args = array( 'classname' => __CLASS__, 'objects_only' => true );
		$objects = parent::sc_object_list( $attr, $args );			

		$context['objects'] = $objects;

		return static::render_objects_to_html( $context );
	}

	public function objectsToHTML( $objects, $css_classes ) {
		if ( count( $objects ) < 1 ) { return (WP_DEBUG) ? '<!-- No objects were provided to objectsToHTML. -->' : '';}
		$context['objects'] = $objects;
		return static::render_objects_to_html( $context );
	}

	protected function render_objects_to_html( $context ) {
		ob_start();

		?>
		<div id="accordion" role="tablist" aria-multiselectable="true">
			<?php foreach ( $context['objects'] as $o ) : ?>
				<?= static::toHTML( $o ) ?>
				<div class="hr-blank"></div>
			<?php endforeach;?>
		</div>
		<?php

		return ob_get_clean();
	}

	public function toHTML( $post_object ) {
		$context['Post_ID'] = $post_object->ID;
		$context['title'] = get_the_title( $post_object );
		$context['content'] = wpautop($post_object->post_content);
		return static::render_to_html( $context );
	}

	protected function render_to_html( $context ) {
		ob_start();
		?>
		<div class="card">
			<div class="card-header" role="tab" id="heading-<?= $context['Post_ID'] ?>">
				<h5 class="mb-0">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $context['Post_ID'] ?>" aria-expanded="true" aria-controls="collapse-<?= $context['Post_ID'] ?>">
						<?= $context['title'] ?> <span class="float-xs-right"><i class="fa fa-angle-double-down"></i></span>
					</a>
				</h5>
			</div>
			<div id="collapse-<?= $context['Post_ID'] ?>" class="collapse" role="tabpanel" aria-labelledby="heading-<?= $context['Post_ID'] ?>">
				<div class="card-block">
					<?= $context['content'] ?>	
				</div>
			</div>
		</div>

		<?php

		return ob_get_clean();
	}
}

class Contact extends CustomPostType {
	public
	$name           = 'contact',
	$plural_name    = 'Contact',
	$singular_name  = 'Contact',
	$add_new_item   = 'Add New Contact',
	$edit_item      = 'Edit Contact',
	$new_item       = 'New Contact',
		$public         = true,  // I dunno...leave it true
		$use_title      = true,  // Title field
		$use_editor     = false,  // WYSIWYG editor, post content field
		$use_revisions  = true,  // Revisions on post content and titles
		$use_thumbnails = false,  // Featured images
		$use_order      = false, // Wordpress built-in order meta data
		$use_metabox    = true, // Enable if you have custom fields to display in admin
		$use_shortcode  = false, // Auto generate a shortcode for the post type
		                         // (see also objectsToHTML and toHTML methods).
		$taxonomies     = array(),
		$menu_icon      = 'dashicons-phone',
		$built_in       = false,
		// Optional default ordering for generic shortcode if not specified by user.
		$default_orderby = null,
		$default_order   = null,

		$calculated_columns = array(), // Calculate values within custom_column_echo_data.
		$sc_interface_fields = null; // Fields for shortcodebase interface (false hides from list, null shows only the default fields).
		
		public function fields() {
			$prefix = $this->options( 'name' ).'_';
			return array(
				array(
					'name' => 'Hours',
					'descr' => 'ex: Mon-Fri: 8am - 5pm',
					'id' => $prefix.'Hours',
					'type' => 'text',
					),
				array(
					'name' => 'Phone',
					'descr' => '',
					'id' => $prefix.'phone',
					'type' => 'text',
					),
				array(
					'name' => 'Fax',
					'descr' => '',
					'id' => $prefix.'fax',
					'type' => 'text',
					),
				array(
					'name' => 'Email',
					'descr' => '',
					'id' => $prefix.'email',
					'type' => 'text',
					),
				array(
					'name' => 'Building',
					'descr' => '',
					'id' => $prefix.'building',
					'type' => 'text',
					),
				array(
					'name' => 'Room Number',
					'descr' => '',
					'id' => $prefix.'room',
					'type' => 'text',
					),
				array(
					'name' => 'UCF Map ID',
					'descr' => '',
					'id' => $prefix.'map_id',
					'type' => 'text',
					),
				);
		}
	}

?>
