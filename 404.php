<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage InspireYourPeople.com 2016
 */
?>

<?php get_header(); ?>

	<main class="error-404-lp">

		<header class="archive-header">
			<h1 class="title">404</h1>
		</header> <?php /* END .archive-header */ ?>

		<section class="inner-container">
			<h2 class="page-title">Oops! That page can't be found.</h2>
			<p>It looks like nothing was found at this address. Maybe try a search below?</p>

			<?php get_search_form(); ?>
		</section>

	</main>

<?php get_footer(); ?>