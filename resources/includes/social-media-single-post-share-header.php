<section class="social-media-single-post-share">
	<p class="social-icons">
		<a class="event-trigger" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" data-event-fields='{"category":"Social Media Share", "action":"Share", "label":"Facebook"}' title="Share this on Facebook" target="_blank">
			<img src="/wp-content/themes/inspireyourpeople/resources/images/icons/social-media/facebook-circle-30x30.png" alt="Facebook" width="25" height="25" /></a>

		<a class="event-trigger" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&source=InspireYourPeople.com" data-event-fields='{"category":"Social Media Share", "action":"Share", "label":"LinkedIn"}' title="Share this on LinkedIn" target="_blank">
			<img src="/wp-content/themes/inspireyourpeople/resources/images/icons/social-media/linkedin-circle-30x30.png" alt="LinkedIn" width="25" height="25" /></a>

		<a class="event-trigger" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" data-event-fields='{"category":"Social Media Share", "action":"Share", "label":"Google Plus"}' title="Share this on Google+" target="_blank">
			<img src="/wp-content/themes/inspireyourpeople/resources/images/icons/social-media/google-plus-circle-30x30.png" alt="Google+" width="25" height="25" /></a>

		<a class="event-trigger" href="http://twitter.com/?status=Enjoyed+this+from+InspireYourPeople.com...+<?php the_permalink(); ?>+@InspireMyPeople" data-event-fields='{"category":"Social Media Share", "action":"Share", "label":"Twitter"}' title="Tweet this" target="_blank">
			<img src="/wp-content/themes/inspireyourpeople/resources/images/icons/social-media/twitter-circle-30x30.png" alt="Twitter" width="25" height="25" /></a>

		<a class="event-trigger launch-modal" href="#" data-modal-type="post-etf" data-modal-post-id="<?php echo $post->ID ?>" data-event-fields='{"category":"Social Media Share", "action":"Share", "label":"Email this thought to a Friend"}' title="Email this thought">
			<img src="/wp-content/themes/inspireyourpeople/resources/images/icons/social-media/etf-circle-30x30.png" width="25" height="25" alt="Email this thought" /></a>
	</p>
</section>