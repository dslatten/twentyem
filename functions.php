<?php
/**
 * Twenty Em functions and definitions
 *
 * Sets up the theme and provides some helper functions.
 *
 * @package WordPress
 * @subpackage Twenty_Em
 * @since Twenty Em 0.1.0
 */

/*
For reference:

add_filter( $tag, $function_to_add, $priority, $accepted_args );
remove_filter( $tag, $function_to_remove, $priority, $accepted_args );
apply_filters( $tag, $value, $var ... );

add_action( $tag, $function_to_add, $priority, $accepted_args );
remove_action( $tag, $function_to_remove, $priority, $accepted_args );
do_action( $tag, $arg_a, $arg_b, $etc );

*/


// If WordPress debugging mode is enabled, load Twenty Em's debugging functions.
//if ( defined( 'WP_DEBUG' ) && ( true == WP_DEBUG ) ) {
//	include_once dirname( __FILE__ ) . '/inc/debug.php';
//}



/**
 * Returns a filterable doctype element.
 *
 * @since Twenty Em 0.1.0
 * @uses apply_filters() Calls the 'twentyem_filter_doctype_element' hook on the doctype element.
 *
 * @return string Filtered doctype element.
 */
function twentyem_get_doctype_element() {
	return apply_filters( 'twentyem_filter_doctype_element', '<!DOCTYPE html>' );
}

/**
 * Returns a filterable html opening tag.
 *
 * In polyglot markup (i.e., HTML-Compatible XHTML), the <html> tag should
 * contain both the "lang" and "xml:lang" attributes
 * ({@link http://www.w3.org/TR/html-polyglot/#language-attributes}), as well as
 * the "xmlns" attribute
 * ({@link http://www.w3.org/TR/html-polyglot/#element-level-namespaces}).
 * Twenty Em uses the following function to generate an opening html tag that is
 * valid in html, xhtml, and polyglot markup.
 *
 * @since Twenty Em 0.1.0
 * @uses apply_filters() Calls the 'twentyem_filter_html_opening_tag' hook on the html opening tag.
 *
 * @param string $markup The markup style used in the document (polyglot|html|xhtml).
 * @return string Filtered html opening tag.
 */
function twentyem_get_html_opening_tag( $markup = 'polyglot' ) {
	$attributes = array();
	$language = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'language' ) : false;
	$html = '';

	if ( function_exists( 'is_rtl' ) && is_rtl() ) {
		$attributes[] = 'dir="rtl"';
	}

	if ( $markup == 'polyglot' || $markup == 'xhtml' ) {
		$attributes[] = 'xmlns="http://www.w3.org/1999/xhtml"';
	}
	
	if ( $language ) {
		if ( $markup == 'polyglot' ) {
			$attributes[] = "lang=\"$language\" xml:lang=\"$language\"";
		}

		if ( $markup == 'html' ) {
			$attributes[] = "lang=\"$language\"";
		}

		if ( $markup == 'xhtml' ) {
			$attributes[] = "xml:lang=\"$language\"";
		}
	}

	$html = '<html ' . implode( ' ', $attributes ) . '>';
	return apply_filters( 'twentyem_filter_html_opening_tag', $html );
}

/**
 * Customizes the title, depending on the current view.
 *
 * @since Twenty Em 0.1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function twentyem_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	if ( is_home() || is_front_page() ) {
		$site_title = get_bloginfo( 'name' );
		if ( $site_title || ( '0' == $site_title ) ) {
			$title .= $site_title;
		}
		$site_description = get_bloginfo( 'description' );
		if ( $site_description || ( '0' == $site_description ) ) {
			$title .= " $sep " . $site_description;
		}
	}

	// Add a page number to prevent duplicate titles caused by pagination.
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= $sep . sprintf( __( 'Page %s', 'twentyem' ), max( $paged, $page ) );
	}

	// Remove leading or trailing separators (incl. spaces) added by wp_title().
	$regex = '/^\s+' . preg_quote( $sep, '/' ) . '\s+|\s+' . preg_quote( $sep, '/' ) . '\s+$/';
	$title = preg_replace( $regex, '', $title );

	return $title;
}
add_filter( 'wp_title', 'twentyem_wp_title', 10, 2 );

/**
 * Tear down wp_head and rebuild it
 *
 * $wp_filter[hook][priority][callback][key][value]
 *
 * remove_action( $tag, $function_to_remove, $priority, $accepted_args );
 *
 * @since Twenty Em 0.1.0
 */
function twentyem_wp_head() {
	foreach ( $GLOBALS['wp_filter']['wp_head'] as $priority => $callbacks ) {
		foreach ( $callbacks as $callback => $keys ) {
			remove_action( 'wp_head', $keys['function'], $priority );
		}
	}
}
//add_action( 'wp_head', 'twentyem_wp_head', -10 );



