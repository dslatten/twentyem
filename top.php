<?php
/**
 * Top
 *
 * Displays the top section, which includes the site logo and the top 
 * navigation menu.
 *
 * @package WordPress
 * @subpackage Twenty_Em
 * @since Twenty Em 0.1.0
 */
?>
	<div id="top" class="layer">
		<div class="wrapper">
			<div class="row row-1">
				<div class="col section-1">
					<div id="logo">
						<a href="/"><b><?php bloginfo( 'name' ); ?></b><span id="logo-img"></span></a>
					</div><!-- #logo -->
				</div>
				<div class="col section-2">
					<div id="nav">
<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
					</div><!-- #nav -->
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div><!-- #top -->
