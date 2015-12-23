<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage InspireYourPeople.com 2016
 */
?>

<?php get_header(); ?>

<main>

	<?php

		while ( have_posts() ) :

			the_post();

			/* get_the_content() does not pass the content through the 'the_content'. This means that get_the_content() will not auto-embed videos or expand shortcodes, wrap with tags, etc. */
			print get_the_content();

		endwhile;

	?>

</main>

<?php get_footer(); ?>