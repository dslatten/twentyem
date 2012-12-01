<?php
/**
 * Twenty Em debugging functions
 *
 * Twenty Em's functions.php file includes this file, if WordPress debugging 
 * mode is enabled (i.e., if WP_DEBUG is defined as true in wp-config.php).
 *
 * @package WordPress
 * @subpackage Twenty_Em
 * @since Twenty Em 0.1.0
 */

/**
 * Dump $wp_filters for debugging purposes
 *
 * Modified from:
 * "Inside WordPress Actions And Filters" by Gennady Kovshenin
 * http://wp.smashingmagazine.com/2012/02/16/inside-wordpress-actions-filters/
 *
 * $wp_filter[hook][priority][callback][key][value]
 *
 * <?php twentyem_dump_wp_filter(); ?>
 *
 * @since Twenty Em 0.1.0
 *
 * @param string $hook The hook we want to dump.
 */
function twentyem_dump_wp_filter() {
		echo '<ul>';

		foreach ( $GLOBALS['wp_filter'] as $tag => $priority_sets ) {
			echo '<li style="margin-top:2em;"><strong>' . $tag . '</strong><ul>';

			foreach ( $priority_sets as $priority => $idxs ) {
				echo '<li>' . $priority . '<ul>';

				foreach ( $idxs as $idx => $callback ) {
					if ( gettype( $callback['function'] ) == 'object' ) {
						$function = '{ closure }';
					}
					else if ( is_array( $callback['function'] ) ) {
						$function = '<pre>' . print_r( $callback['function'][0], true );
						$function .= ':: ' . print_r( $callback['function'][1], true );
						$function .= '</pre>';
					}
					else {
						$function = $callback['function'];
					}
					echo '<li>' . $function . ' ( <i>' . $callback['accepted_args'] . ' arg</i> )</li>';
				}
				echo '</ul></li>';
			}
			echo '</ul></li>';
		}
		echo '</ul>';
}
add_action( 'wp_footer', 'twentyem_dump_wp_filter' );
