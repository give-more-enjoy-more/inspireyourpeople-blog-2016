<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage InspireYourPeople.com 2016
 */
?>
<?php get_header(); ?>

	<main>

		<?php if ( have_posts() ) : ?>

			<header class="archive-header">
				<h1 class="title"><?php single_cat_title(); ?></h1>
			</header> <?php /* END .archive-header */ ?>

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

							<?php
								/* Initialize variables */
								$post_id = get_the_ID();
							
								/* Brand specific form title and subtitle. */
								switch($post_id):
								
									/* Monthly Calendars */
									case 10:
										$cta_button_copy = 'Get the calendars';
										break;
							
									/* Salesday Counts */
									case 125:
										$cta_button_copy = 'Get the salesday charts';
										break;
							
									default:
										$cta_button_copy = 'Read more';
										break;
							
								endswitch;
							?>
							
							<p class="cta-btn"><a class="flat-btn" href="<?php echo get_permalink(); ?>"><?php echo $cta_button_copy ?></a></p>
							
						</div> <?php /* END .post-info */ ?>

					</li>

				<?php endwhile; ?>
			</ol> <?php /* END .archive-post-list .inner-conatiner */ ?>

		<?php else : ?>

			<h1>No posts were found</h1>

			<p>Sorry, but no results were found for the requested category. Perhaps searching will help find a related post.</p>

			<?php get_search_form(); ?>

		<?php endif; ?>

	</main>

<?php get_footer(); ?>