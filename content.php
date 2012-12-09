<?php
/**
 * Content
 *
 * Displays the mid section, which includes the loop (i.e., the content), the
 * comments, and the sidebars.
 *
 * @package WordPress
 * @subpackage Twenty_Em
 * @since Twenty Em 0.1.0
 */
?>
	<div id="mid" class="layer">
		<div class="wrapper">
			<div class="row row-1">
				<div class="col section-1">
					<div id="primary">
						<div id="content">


<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
	<?php endwhile; ?>
<?php else : ?>
	<h1><?php _e( 'Not Found', 'twentyem' ); ?></h1>
	<p><?php _e( 'Sorry, but the requested content was not found.', 'twentyem' ); ?></p>
<?php endif; ?>

						</div><!-- #content -->
					</div><!-- #primary -->
				</div>
<?php get_sidebar(); ?>
				<div class="clear"></div>
			</div>
		</div>
	</div><!-- #mid -->
