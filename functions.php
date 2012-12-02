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
if ( defined( 'WP_DEBUG' ) && ( true == WP_DEBUG ) ) {
	include_once dirname( __FILE__ ) . '/inc/debug.php';
}



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
 * Returns a filterable head element.
 *
 * @since Twenty Em 0.1.0
 * @uses apply_filters() Calls the 'twentyem_filter_html_opening_tag' hook on the html opening tag.
 *
 * @param string $markup The markup style used in the document (polyglot|html|xhtml).
 * @return string Filtered html opening tag.
 */
function twentyem_get_head_element() {
	$elements = array();
	$wp_head = array();
	$html = array();

	// <meta charset="UTF-8" />
	$charset = get_bloginfo( 'charset' );
	if ( ! $charset ) {
		$charset = 'UTF-8';
	}
	$elements[] = apply_filters( 'twentyem_filter_meta_charset_element', '<meta charset="' . $charset . '" />' );

	// <title> wp_title() </title>
	$elements[] = apply_filters( 'twentyem_filter_title_element', '<title>' . wp_title( '&raquo;', false ) . '</title>' );

	// The HTML code that is echoed by wp_head().
	$wp_head = explode ( "\n", twentyem_get_wp_head() );

	function func( $value ) {
		return 	rtrim( $value, ' ' );
	}
	$wp_head = array_map( 'func', $wp_head );

	$elements = array_merge( $elements, $wp_head );

	// Remove empty lines.
	$elements = array_filter( $elements );

	$html = "<head>\n\t" . implode( "\n\t", $elements ) . "\n</head>";

	return apply_filters( 'twentyem_filter_head_element', $html );
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
 * Capture wp_head() output, filter it, and return it.
 *
 * This function executes wp_head() and returns its output as a string, instead
 * of sending it straight to the browser. This gives users complete control over
 * the <head> elements inserted by WP core and plugins.
 *
 * @since Twenty Em 0.1.0
 */
function twentyem_get_wp_head() {
	ob_start();
	wp_head();
	return apply_filters( 'twentyem_filter_wp_head', ob_get_clean() );
}

/**
 * Replaces single quotes (') with double quotes (") for head element attributes.
 *
 * This function is hooked onto twentyem_filter_wp_head so it can filter the
 * output of wp_head() and convert single quotes to double quotes. This ensures
 * that all elements in the <head> consistently use double quotes around
 * attribute values. This is for users who don't mind spending a few
 * milliseconds to achieve HTML source perfection, even though no one will
 * notice or care.
 *
 * @since Twenty Em 0.1.0
 *
 * @param string $html Raw HTML code consisting of head elements.
 * @return string Filtered HTML code.
 */
function twentyem_double_quote_head_attributes( $html ) {
	$regex = '/(?<= rel| name| type| media| href| title| content| id)=\'(.*?)\' +/i';
	$replacement = '="$1" ';
	$html = preg_replace( $regex, $replacement, $html );
	return $html;
}
add_filter( 'twentyem_filter_wp_head', 'twentyem_double_quote_head_attributes' );

/**
 * Tear down wp_head and rebuild it
 *
 * $wp_filter[hook][priority][callback][key][value]
 *
 * @since Twenty Em 0.1.0
 */
function twentyem_wp_head() {
//	foreach ( $GLOBALS['wp_filter']['wp_head'] as $priority => $callbacks ) {
//		foreach ( $callbacks as $callback => $keys ) {
//			remove_action( 'wp_head', $keys['function'], $priority );
//		}
//	}

	foreach ( $GLOBALS['wp_filter']['wp_head'] as $priority => $callbacks ) {
		foreach ( $callbacks as $callback => $keys ) {
			if (
				//$callback == 'wp_generator' ||
				//$callback == 'rsd_link' ||
				$callback == 'wlwmanifest_link'
			) {
				remove_action( 'wp_head', $callback, $priority );
			}
		}
	}
}
//add_action( 'wp_head', 'twentyem_wp_head', -10 );

/**
 * Returns a filterable body opening tag.
 *
 * @since Twenty Em 0.1.0
 * @uses apply_filters() Calls the 'twentyem_filter_body_opening_tag' hook on the body opening tag.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return string Filtered body opening tag.
 */
function twentyem_get_body_opening_tag( $class = '' ) {
	$classes = '';
	$body = '<body';

	if ( function_exists( 'get_body_class' ) ) {
		$classes = get_body_class( $class );
	}

	if ( ! empty( $classes ) ) {
		$body .= ' class="' . join( ' ', get_body_class( $class ) ) . '"';
	}

	$body .= '>';

	return apply_filters( 'twentyem_filter_body_opening_tag', $body );
}




