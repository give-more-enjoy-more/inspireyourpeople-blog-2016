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

<?php
	/* Pull in the generic global functions needed for this page. */
	require_once('resources/includes/global-functions.php'); ?>

<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<main itemscope itemtype="http://schema.org/Article">

		<div class="article-padding">

			<article itemprop="articleBody">

				<header>

					<?php if ( get_post_meta( get_the_ID(), 'engaging_header_image', true ) ) : ?>
						<img class="engaging-header-image" src="<?php echo bloginfo('template_directory') . get_post_meta( get_the_ID(), 'engaging_header_image', true ); ?>" alt="<?php the_title(); ?>" />
					<?php endif; ?>

				</header>

				<div class="article-content">

					<?php the_content(); ?>

				</div> <?php /* END .article-content */ ?>

			</article>

		</div> <?php /* END .article-padding */ ?>

	</main>

<?php endwhile; ?>

<?php get_footer(); ?>