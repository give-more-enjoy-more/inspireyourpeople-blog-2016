<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage InspireYourPeople.com 2016
 */
?>

	<?php
		/* Pull in the generic global functions needed for this script. */
		require_once('resources/includes/global-functions.php'); ?>

	<?php
		/* Pulls in the subscriber form and processing for every page except the subscribe page */
		if(!is_page('subscribe')){
			include('resources/includes/footer-subscriber-acquisition.php');
		}
	?>

		<footer class="clear-fix">

			<div class="footer-brand-promo">
				<p>The ultimate mission: We're here to make good things happen for other people <a class="flat-btn white-btn" href="/category/make-good-things-happen/">Learn More</a></p>
			</div> <?php // END .footer-brand-promo ?>

			<div class="inner-container">

				<div class="customer-service">
					<p class="title">Customer Service</p>

					<ul class="footer-link-list">
						<li><a href="/support/">Support</a></li>
						<li><a href="/support/shipping/">Shipping</a></li>
						<li><a href="/support/track-orders/">Track Orders</a></li>
						<li><a href="/support/returns/">Returns</a></li>
						<li><a href="/support/privacy/">Privacy</a></li>
						<li><a href="/support/faq/">FAQ</a></li>
					</ul>
				</div> <?php // END .customer-service ?>

				<div class="about-us">
					<p class="title">About Us</p>

					<ul class="footer-link-list">
						<li><a href="/who-we-are/">Who We Are</a></li>
						<li><a href="/connect-with-sam/">Connect With Sam</a></li>
						<li><a href="/customers/">Our Customers</a></li>
						<li><a href="/customer-buzz/">Customer Feedback</a></li>
						<li><a href="/blog/subscribe/">Subscribe</a></li>
						<li><a href="/work-with-us/">Work With Us</a></li>
						<li><a href="/support/contact/">Contact</a></li>
					</ul>
				</div> <?php // END .footer-about-us ?>

				<div class="whos-sam-parker">
					<p class="title">Who is Sam Parker</p>

					<div class="office-location">
						<a class="office-map" href="https://www.google.com/maps/preview?q=115+South+15th+Street+Suite+502+Richmond,+VA+23219&ie=UTF-8&hq=&hnear=0x89b1111968e958ab:0x711b8eb839153665,115+S+15th+St+%23502,+Richmond,+VA+23219&gl=us&ei=f3t6U6jYNdapyASbrYKYAQ&ved=0CCcQ8gEwAA" target="_blank"><img src="http://www.inspireyourpeople.com/themes/gmv3/resources/images/throughout/footer-office-map-215x155.jpg" height="155" width="215" alt="Office Location" title="Office Location" /></a>

						<p class="office-address">
							115 South 15th Street, Suite 502<br />
							Richmond, VA 23219 USA
						</p>
					</div> <?php // END .office-location ?>

					<p class="sam-bio">Sam is one of the people behind InspireYourPeople.com. With the help of the talented people he works with, Sam developed and wrote the material you'll find on the site. His goal (and the team's) ... To make good things happen for other people.</p>

					<p class="sam-connect-btns">
						<a class="flat-btn white-btn" href="/connect-with-sam/">More on Sam</a> <a class="flat-btn white-btn" href="/speaking/">Sam Speaks</a>
					</p>

					<p class="social-icon-list">
						<a class="social-icon" href="http://www.facebook.com/nogomos" target="_blank"><img src="<?php echo bloginfo('template_directory') ?>/resources/images/icons/social-media/facebook-circle-30x30.png" width="25" height="25" alt="Facebook" title="Facebook" /></a>
						<a class="social-icon" href="https://twitter.com/inspiremypeople" target="_blank"><img src="<?php echo bloginfo('template_directory') ?>/resources/images/icons/social-media/twitter-circle-30x30.png" width="25" height="25" alt="Twitter" title="Twitter" /></a>
						<a class="social-icon" href="https://plus.google.com/109527210813453584818/" target="_blank"><img src="<?php echo bloginfo('template_directory') ?>/resources/images/icons/social-media/google-plus-circle-30x30.png" width="25" height="25" alt="Google+" title="Google+" /></a>
						<a class="social-icon" href="https://www.instagram.com/inspire_your_people/" target="_blank"><img src="<?php echo bloginfo('template_directory') ?>/resources/images/icons/social-media/instagram-circle-30x30.png" width="25" height="25" alt="Instagram" title="Instagram" /></a>
						<a class="social-icon" href="http://www.linkedin.com/in/justparker" target="_blank"><img src="<?php echo bloginfo('template_directory') ?>/resources/images/icons/social-media/linkedin-circle-30x30.png" width="25" height="25" alt="LinkedIn" title="LinkedIn" /></a>
					</p>
				</div> <?php // END .whos-sam-parker ?>

			</div> <?php // END .inner-container ?>

			<p class="contact-information">
				<span class="phone-number">Phone</span> - 1-866-952-4483
				<span class="fax">Fax</span> - 1-804-884-3831
				<span class="email">Email</span> - <a class="contact-email" href="mailto:Hello@InspireYourPeople.com">Hello@InspireYourPeople.com</a>
			</p>

			<p class="copyright">Copyright &copy; 1998 - <?= date("Y") ?> InspireYourPeople.com</p>

		</footer> <?php /* END footer */ ?>

	</div> <?php /* END .content-container */ ?>


	<?php
		/* Pulls in the footer javascripts */
		include('resources/includes/footer-javascript-imports.php'); ?>

	<?php wp_footer(); ?>

</body>
</html>
<?php ob_end_flush(); /* Here to prevent wordpress from pre-rending content before all functions run, but specifically the capture_cookie_check_and_set function in the global_functions file. */ ?>