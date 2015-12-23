<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage InspireYourPeople.com 2016
 */
?>
<?php get_header(); ?>

	<main>

		<header class="archive-header">
			<h1 class="title">Search Results</h1>
		</header> <?php /* END .archive-header */ ?>

		<?php if ( have_posts() ) : ?>

			<section class="inner-container">
				<p><strong>You searched For:</strong> <?php echo get_search_query(); ?></p>
			</section>

			<ol class="archive-post-list inner-container">
				<?php while ( have_posts() ) : the_post(); ?>

		 			<li class="post clear-fix">

						<?php if ( get_post_meta( get_the_ID(), 'category_post_thumbnail', true ) ) : ?>
							<a class="post-teaser-image" href="<?php the_permalink() ?>">
								<img src="<?php echo bloginfo('template_directory') . get_post_meta( get_the_ID(), 'category_post_thumbnail', true ); ?>" alt="<?php the_title(); ?>" />
							</a>
						<?php endif; ?>

		 				<div class="post-info">
				 			<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

							<p class="post-excerpt"><?php echo get_the_excerpt(); ?></p>

							<p class="cta-btn"><a class="flat-btn" href="<?php echo get_permalink(); ?>">Read It!</a></p>
						</div> <?php /* END .post-info */ ?>

					</li>

				<?php endwhile; ?>
			</ol> <?php /* END .archive-post-list .inner-conatiner */ ?>

		<?php else : ?>

			<section class="inner-container error-404-lp">
				<h2>Nothing was found</h2>

				<p>Sorry, but no results were found from your search. Perhaps try searching again?</p>

				<?php get_search_form(); ?>
			</section>

		<?php endif; ?>

	</main>

<?php get_footer(); ?>