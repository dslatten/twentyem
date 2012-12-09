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
//	include_once dirname( __FILE__ ) . '/inc/debug.php';
}



/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640;
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
 * @uses apply_filters() Calls the 'twentyem_filter_html_opening_tag_conditionals' hook, to allow HTML5 Boilerplate-style <html> tags.
 *
 * @param string $class Optional CSS classes to add to the <html> tag (no-js).
 * @param string $markup The markup style used in the document (polyglot|html|xhtml).
 * @param string $xmlns The xmlns attribute value (http://www.w3.org/1999/xhtml).
 * @return string Filtered html opening tag.
 */
function twentyem_get_html_opening_tag( $class = 'no-js', $markup = 'polyglot', $xmlns = 'http://www.w3.org/1999/xhtml' ) {
	$attributes = array();
	$language = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'language' ) : false;
	$html = array();
	$is_conditional = false;
	$before = '';
	$after = '';
	$conditionals = array(
		array(
			'condition' => 'if IE 6',
			'class' => 'ie6',
			'revealed' => false
		),
		array(
			'condition' => 'if IE 7',
			'class' => 'ie7',
			'revealed' => false
		),
		array(
			'condition' => 'if IE 8',
			'class' => 'ie8',
			'revealed' => false
		),
		array(
			'condition' => 'if gt IE 8',
			'class' => '',
			'revealed' => true
		)
	);
	$conditionals = apply_filters( 'twentyem_filter_html_opening_tag_conditionals', $conditionals );

	$i = 0;
	if ( is_array( $conditionals ) && $conditionals ) {
		foreach ( $conditionals as $conditional ) {
			if ( is_array( $conditional ) && ! empty( $conditional['condition'] ) ) {
				$is_conditional = true;
				$i += 1;
			}
		}
	}

	do {
		if ( $is_conditional ) {
			$conditional = array_shift( $conditionals );

			$before = '<!--[' . $conditional['condition'] . ']>';
			if ( $conditional['revealed'] ) {
				$before .= '<!-->' . "\n";
			}

			if ( $is_conditional ) {
				$after = '<![endif]-->';
				if ( $conditional['revealed'] ) {
					$after =  "\n" . '<!--' . $after;
				}
			}
		}

		if ( $class || ! empty( $conditional['class'] ) ) {
			if ( $class && ! empty( $conditional['class'] ) ) {
				$attributes[] = 'class="' . $class . ' ' . $conditional['class'] . '"';
			} elseif ( $class ) {
				$attributes[] = 'class="' . $class . '"';
			} else {
				$attributes[] = 'class="' . $conditional['class'] . '"';
			}
		}

		if ( $markup == 'polyglot' || $markup == 'xhtml' ) {
			$attributes[] = 'xmlns="' . $xmlns . '"';
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

		if ( function_exists( 'is_rtl' ) && is_rtl() ) {
			$attributes[] = 'dir="rtl"';
		}

		$html[] = $before . '<html ' . implode( ' ', $attributes ) . '>' . $after;

		$attributes = array();
		$i -= 1;

	} while ( $i > 0 );

	$html = implode ( "\n", $html );

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

	// <meta name="viewport" />
	$elements[] = apply_filters( 'twentyem_filter_title_element', '<meta name="viewport" content="width=device-width, initial-scale=1" />' );

	// The HTML code that is echoed by wp_head().
	$wp_head_code = twentyem_get_wp_head();

	// If wp_head() returned HTML code, filter it and put each line into our array.
	if ( $wp_head_code != '' ) {
		$wp_head_code = apply_filters( 'twentyem_filter_wp_head', $wp_head_code );
		$wp_head = explode ( "\n", $wp_head_code );
	}

	// Combine Twenty Em's <head> elements with wp_head() HTML code. 
	$elements = array_merge( $elements, $wp_head );

	// Filter or sort the lines of code that make up our <head> section.
	$elements = apply_filters( 'twentyem_filter_head_elements', $elements );

	$html = "<head>\n\t" . implode( "\n\t", $elements ) . "\n</head>";

	return apply_filters( 'twentyem_filter_head_element', $html );
}



function twentyem_sort_head_elements( $elements ) {
	$sorted = array(
		'charset' => array(),
		'title' => array(),
		'description' => array(),
		'keywords' => array(),
		'robots' => array(),
		'meta' => array(),
		'canonical' => array(),
		'prev' => array(),
		'next' => array(),
		'link' => array(),
		'style' => array(),
		'other' => array()
	);
	$style_open = false;

	// Make sure no lines end with spaces.
	$elements = preg_replace( '/\s$/', '', $elements );
	$elements = preg_replace( '/^\t+(?=<)/', '', $elements );

	// Remove empty lines.
	$elements = array_filter( $elements );

	foreach ( $elements as $line => $code ) {
		if ( preg_match( '/<meta/i', $code ) ) {
			if ( preg_match( '/charset/i', $code ) ) {
				$sorted['charset'][] = $code;
			} elseif ( preg_match( '/description/i', $code ) ) {
				$sorted['description'][] = $code;
			} elseif ( preg_match( '/keywords/i', $code ) ) {
				$sorted['keywords'][] = $code;
			} elseif ( preg_match( '/robots/i', $code ) ) {
				$sorted['robots'][] = $code;
			} else {
				$sorted['meta'][] = $code;
			}
		} elseif ( preg_match( '/<title>.*<\/title>/i', $code ) ) {
			$sorted['title'][] = $code;
		} elseif ( preg_match( '/<link/i', $code ) ) {
			if ( preg_match( '/canonical/i', $code ) ) {
				$sorted['canonical'][] = $code;
			} elseif ( preg_match( '/prev/i', $code ) ) {
				$sorted['prev'][] = $code;
			} elseif ( preg_match( '/next/i', $code ) ) {
				$sorted['next'][] = $code;
			} elseif ( preg_match( '/stylesheet/i', $code ) ) {
				$sorted['style'][] = $code;
			} else {
				$sorted['link'][] = $code;
			}
		} elseif ( preg_match( '/<style/i', $code ) ) {
			if ( preg_match( '/<style.*<\/style>/i', $code ) ) {
				$sorted['style'][] = $code;
			} else {
				$sorted['style'][] = $code;
				$style_open = true;
			}
		} elseif ( $style_open ) {
			if ( preg_match( '/<\/style>/i', $code ) ) {
				$sorted['style'][] = $code;
				$style_open = false;
			} else {
				$sorted['style'][] = $code;
			}
		} else {
			$sorted['other'][] = $code;
		}
	}

	foreach ( $sorted as $section => $lines ) {
		foreach ( $lines as $line ) {
			$new_elements[] = $line;
		}
	}

	return $new_elements;
}

add_filter( 'twentyem_filter_head_elements', 'twentyem_sort_head_elements' );



/**
 * Capture wp_head() output and return it.
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
	return ob_get_clean();
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
	$regex = '/ +(rel|name|type|media|href|src|title|content|id)=\'(.*?)\'(?=.*>)/i';
	$replacement = ' $1="$2"';
	$html = preg_replace( $regex, $replacement, $html );
	return $html;
}

add_filter( 'twentyem_filter_wp_head', 'twentyem_double_quote_head_attributes' );



/**
 * Strips HTML comments from a (maybe) multi-line string.
 *
 * Strips all HTML comments EXCEPT for IE conditional comments. For example, the
 * following comments would be preserved:
 *     <!--[if IE 7]><link rel="stylesheet" href="ie7.css" /><![endif]-->
 *     <!--[if !IE]><!--><link rel="stylesheet" href="not-ie.css" /><!--<![endif]-->
 *
 * @since Twenty Em 0.1.0
 *
 * @param string $html raw HTML code.
 * @return string HTML code with comments removed.
 */
function twentyem_strip_html_comments( $html ) {
	$regex = '/<!--[^\[<>].*?(?<!!)-->/s';
	$replacement = '';
	$html = preg_replace( $regex, $replacement, $html );
	return $html;
}

add_filter( 'twentyem_filter_wp_head', 'twentyem_strip_html_comments' );



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







remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
remove_action( 'wp_head', 'wp_generator' );



function twentyem_scripts_styles() {
	wp_enqueue_style( 'twentyem-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'twentyem_scripts_styles' );











 