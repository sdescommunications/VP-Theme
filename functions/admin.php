<?php

if ( is_login() ) {
	add_action( 'login_head', 'login_scripts', 0 );
}

/**
 * Prints out additional login scripts, called by the login_head action
 *
 * @return void
 * @author Jared Lang
 * */
function login_scripts() {
	ob_start();?>
	<link rel="stylesheet" href="<?php echo THEME_CSS_URL; ?>/admin.css" type="text/css" media="screen" charset="utf-8">
	<?php
	$out = ob_get_clean();
	print $out;
}


/**
 * Called on admin init, initialize admin theme here.
 *
 * @return void
 * @author Jared Lang
 * */
function init_theme_options() {
	register_setting( THEME_OPTIONS_GROUP, THEME_OPTIONS_NAME, 'theme_options_sanitize' );
}


/**
 * Registers the theme options page with wordpress' admin.
 *
 * @return void
 * @author Jared Lang
 * */
function create_utility_pages() {
	add_utility_page(
		__( THEME_OPTIONS_PAGE_TITLE ),
		__( THEME_OPTIONS_PAGE_TITLE ),
		'edit_theme_options',
		'theme-options',
		'theme_options_page',
		'dashicons-admin-generic'
	);
	add_utility_page(
		__( 'Help' ),
		__( 'Help' ),
		'edit_posts',
		'theme-help',
		'theme_help_page',
		'dashicons-editor-help'
	);
}


/**
 * Outputs theme help page
 *
 * @return void
 * @author Jared Lang
 * */
function theme_help_page() {
	include THEME_INCLUDES_DIR . '/theme-help.php';
}


/**
 * Outputs the theme options page html
 *
 * @return void
 * @author Jared Lang
 * */
function theme_options_page() {
	include THEME_INCLUDES_DIR . '/theme-options.php';
}


/**
 * Stub, processing on theme options input
 *
 * @return void
 * @author Jared Lang
 * */
function theme_options_sanitize( $input ) {
	return $input;
}


/**
 * Modifies the default stylesheets associated with the TinyMCE editor.
 *
 * @return string
 * @author Jared Lang
 * */
function editor_styles( $css ) {
	$css   = array_map( 'trim', explode( ',', $css ) );
	$css   = implode( ',', $css );
	return $css;
}
add_filter( 'mce_css', 'editor_styles' );


/**
 * Edits second row of buttons in tinyMCE editor. Removing/adding actions
 *
 * @return array
 * @author Jared Lang
 * */
function editor_format_options( $row ) {
	$found = array_search( 'underline', $row );
	if ( False !== $found ) {
		unset( $row[$found] );
	}
	return $row;
}
add_filter( 'mce_buttons_2', 'editor_format_options' );


/**
 * Remove paragraph tag from excerpts
 * */
remove_filter( 'the_excerpt', 'wpautop' );


/**
 * Enqueue the scripts and css necessary for the WP Media Uploader on
 * all admin pages
 * */
function enqueue_wpmedia_throughout_admin() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'enqueue_wpmedia_throughout_admin' );


/**
 * Add 'iconOrThumb' value to js-based attachment objects (for wp.media)
 * */
function add_icon_or_thumb_to_attachmentjs( $response, $attachment, $meta ) {
	$response['iconOrThumb'] = wp_attachment_is_image( $attachment->ID ) ? $response['sizes']['thumbnail']['url'] : $response['icon'];
	return $response;
}
add_filter( 'wp_prepare_attachment_for_js', 'add_icon_or_thumb_to_attachmentjs', 10, 3 );

?>
