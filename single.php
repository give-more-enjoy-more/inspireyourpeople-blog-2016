<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage InspireYourPeople.com 2016
 */
?>
<?php get_header(); ?>


	<?php while ( have_posts() ) : the_post(); ?>

		<main itemscope itemtype="http://schema.org/Article">

			<div class="article-padding">

				<article itemprop="articleBody">

					<header>

						<?php if ( get_post_meta( get_the_ID(), 'engaging_header_image', true ) ) : ?>
							<img class="engaging-header-image" src="<?php echo bloginfo('template_directory') . get_post_meta( get_the_ID(), 'engaging_header_image', true ); ?>" alt="<?php the_title(); ?>" />
						<?php endif; ?>

						<h1 class="article-title" itemprop="name"><?php the_title(); ?></h1>

						<?php if ( !is_single(array(10)) ): ?>
							<p class="article-author">by <strong itemprop="author"><?php the_author() ?></strong></p>
						<?php endif; ?>

						<?php
							/* Pulls in the social media share links */
							include('resources/includes/social-media-single-post-share-header.php'); ?>

					</header>

					<div class="article-content">

						<?php the_content(); ?>

						<?php
							/* Pulls in the social media share links */
							include('resources/includes/social-media-single-post-share-footer.php'); ?>

						<?php 
							/* Put the post id in the if array to show the simplified copyright. */
							if ( is_single(array(10)) ):
								echo '<p class="copyright-and-links center-copy">Copyright &copy; by Give More Media Inc.</p>';
							else:
								echo '<p class="copyright-and-links">Copyright &copy; by Give More Media Inc. If you\'d like to tell people about this somewhere (e.g. blog, newsletter, Facebook, social media), please reference Sam Parker of GiveMore.com as the author and link directly to the article. Excerpts are great but please don\'t publish the article in its entirety without advanced written permission (email us at <a href="mailto:GoodThings@GiveMore.com?subject=reprint%20permission">GoodThings@GiveMore.com</a> with the subject line \'reprint permission\').</p>';
							endif;
						?>

					</div> <?php /* END .article-content */ ?>

				</article>

					<?php
						/* Pulls in any post specific footer ads */
						include('resources/includes/single-post-specific-product-promotions.php'); ?>



			</div> <?php /* END .article-padding */ ?>

		</main>

	<?php endwhile; ?>

<?php get_footer(); ?>