<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Em
 * @since Twenty Em 0.1.0
 */
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
	<?php endwhile; ?>
<?php else : ?>
	<h1><?php _e( 'Not Found', 'twentyem' ); ?></h1>
	<p><?php _e( 'Sorry, but the requested content was not found.', 'twentyem' ); ?></p>
<?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>