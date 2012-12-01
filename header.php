<?php
/**
 * Header
 *
 * Displays everything from the doctype declaration to the <body> tag.
 *
 * @package WordPress
 * @subpackage Twenty_Em
 * @since Twenty Em 0.1.0
 */
?>
<?php echo twentyem_get_doctype_element(); // <!DOCTYPE html> ?>

<?php echo twentyem_get_html_opening_tag(); // <html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US"> ?>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title(); ?></title>
<?php wp_head(); ?>
</head>
<?php echo twentyem_get_body_opening_tag(); // <body class="get_body_class()"> ?>

