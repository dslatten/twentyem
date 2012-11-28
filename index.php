<?php

get_header(); ?>

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