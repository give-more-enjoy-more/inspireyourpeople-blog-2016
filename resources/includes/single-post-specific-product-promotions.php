<?php

	/* To show an ad, either create an additional case with a new ad, or add an additonal post id to one of the already created ad cases below. Additional post id's should be comma separated. */
	switch (true):

		/* More Things For Your Desk Ad */
		/* case is_single(array(10)): */
		case FALSE:
			echo '
				<figure class="product-placement bottom-placement">
					<h2 class="placement-title">More inspiration for your desk...</h2>
					<p class="cta-images four-cta-links clear-fix">
						<a href="http://www.givemore.com/category/mugs-and-water-bottles/"><img src="https://www.givemore.com/images/ads/brandcombos/product-23-desk-mugs-200x200.jpg" alt="Motivating Mugs">Motivating Mugs</a>
						<a href="http://www.givemore.com/category/notepads-pens-and-mouse-pads/"><img src="https://www.givemore.com/images/ads/brandcombos/product-23-desk-notepads-200x200.jpg" alt="Notepads">Notepads</a>
						<a href="http://www.givemore.com/category/pens/"><img src="https://www.givemore.com/images/ads/brandcombos/product-23-desk-pens-200x200.jpg" alt="Pens">Pens</a>
						<a href="http://www.givemore.com/category/mouse-pads/"><img src="https://www.givemore.com/images/ads/brandcombos/product-23-desk-mousepads-200x200.jpg" alt="Mouse Pads">Mouse Pads</a>
					</p>
				</figure>
			';
			break;

		/* By default we do not want to show an ad ... so do nothing. */
		default:
			break;

	endswitch;

?>