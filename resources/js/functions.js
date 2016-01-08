$(document).ready(function() {

	/* Bypass the default modal window functionality to make ajax loading possible */
	$('.launch-modal').on('click', function(e){

		e.preventDefault();

		/* Check if the modal div exits, if not append to the bottom of the body */
		if($('.remodal').length === 0){
			$('body').append('<div class="remodal" data-remodal-id="modal"><button data-remodal-action="close" class="remodal-close"></button><div class="remodal-content-container"></div></div>');
		} /* END $.length */


		/* Check for data types and set to variables */
		var modalTriggerLink = $(this),
				dataModalPostID = modalTriggerLink.data("modal-post-id"),
				dataModalShowCapture = modalTriggerLink.data("modal-show-capture"),
				dataModalShowShare = modalTriggerLink.data("modal-show-share"),
				dataModalType = modalTriggerLink.data("modal-type"),
				dataModalID = modalTriggerLink.data("modal-id");


		/* Pass the data gathered above to $POST and process it with the php script via ajax.
		 * After the ajax has successfully processed the script, load the result in to the modal and open it.
		 */
		$.post( "/wp-content/themes/inspireyourpeople/resources/includes/modal-ajax-processing.php", { modalPostID:dataModalPostID, modalID:dataModalID, modalType:dataModalType, showCapture:dataModalShowCapture, showShare:dataModalShowShare }, function(data){

			$(".remodal-content-container").html(data);

		}).done(function(){

			var inst = $('[data-remodal-id=modal]').remodal({closeOnOutsideClick:false, hashTracking:false});
			inst.open();

			/* Triggers a GA event when a modal is launched. */
			switch (dataModalType){
				case 'video':
					ga('send', 'event', 'Modal Launched and Viewed', 'Click', 'Modal Launched and Viewed - Video Modal');
					break;

				case 'post-etf':
					ga('send', 'event', 'Modal Launched and Viewed', 'Click', 'Modal Launched and Viewed - Sales Tool ETF Modal');
					break;

				default:
					/* do nothing */
					break;
			} /* END switch (dataModalType) */

		}); /* END $.post */

	}); /* END .launch-modal on click callback function */


	/*
	 * This is called when the modal is closing and will remove the entire modal from the DOM.
	 * This was primarily put in place to keep the video modals from playing in the background.
	 */
	$(document).on('closing', '.remodal', function(e){
		var inst = $('[data-remodal-id=modal]').remodal();

		if (inst.getState() === 'closing'){
			inst.destroy();
		}
	});


	/* Google Analytics Event Tracking function. Simply place class 'event-trigger' to tag, and pass data like the example below. */
	/* Example data attribute: data-event-fields='{"category":"JustSell Monthly Calendars","action":"Download","label":"September 2015"}' */
	$('.event-trigger').click(function(){

		var trackedEvent = $(this),
				trackedEventAction = trackedEvent.data("event-fields").action,
				trackedEventCategory = trackedEvent.data("event-fields").category,
				trackedEventLabel = trackedEvent.data("event-fields").label;

		ga('send', 'event', trackedEventCategory, trackedEventAction, trackedEventLabel);

	}); /* END .event-trigger click function */


	/* Scrolls any url/href anchor tags down to their appropriate section */
	$('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {

			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			
			if (target.length) {
				var scrollLocation = target.offset().top - $('nav').outerHeight();

				$('html,body').animate({
					scrollTop: scrollLocation
				}, 2000);
				return false;
			}
		}
	}); /* END href with hash click function */


	/* Validation function for the book excerpt request form. */
	$('#content-capture-form').validate({
		rules: {
			contentCaptureEmail: {
				required: true,
				email: true
			}
		},

		messages: {
			contentCaptureEmail: {
				required: 'Please enter your email address',
				email: 'Please enter a valid email address'
			}
		},

		errorElement: "p",

		errorPlacement: function(error) {
			error.appendTo('#content-capture-form');
		},

		submitHandler: function(form) {
			var action = $(form).attr('action');

			$.post(action, $(form).serialize(), function() {

				$("#content-capture-form, .capture-content-form-container .title").fadeOut(200).promise().done(function(){
					$('<h3 class=\"title\">Thanks! Please enjoy!</h3>').hide().appendTo('.capture-content-form-container').fadeIn(300);
					setTimeout(function(){
						$(".capture-content-form-container, .capture-content-overlay").fadeOut(200);
					}, 2000);					
				});

				/* [ Trigger a Google Analytics Event if the visitor successfully signs up.  ] */
				ga('send', 'event', 'Post Content Restriction Capture', 'Submit', 'Email Captured From Post Content Restriction Capture');
			});
		}
	}); /* END #content-capture-form validate function */


	/* Validation function for the footer subscriber acquisition form. */
	$('#footer-subscriber-acquisition-form').validate({
		rules: {
			footerSubscriberAcquisitionEmail: {
				required: true,
				email: true
			}
		},

		messages: {
			footerSubscriberAcquisitionEmail: {
				required: 'Please enter your email address',
				email: 'Please enter a valid email address'
			}
		},

		errorElement: "p",

		errorPlacement: function(error) {
			error.appendTo('#footer-subscriber-acquisition-form');
		},

		submitHandler: function(form) {
			var action = $(form).attr('action');

			$.post(action, $(form).serialize(), function() {
				$('.footer-subscriber-acquisition .inner-container').fadeOut(300, function(){
					$('<div class="inner-container"><h3 class=\"title\">Thanks for signing up!</h3><p class=\"subtitle\">Sam\'s emails will come from <a href="mailto:Hello@InspireYourPeople.com">Hello@InspireYourPeople.com</a>.</p></div>').hide().appendTo('.footer-subscriber-acquisition').fadeIn(300);
				});

				/* [ Trigger a Google Analytics Event if the visitor successfully signs up.  ] */
				ga('send', 'event', 'Footer Email Subscribe Signup', 'Submit', 'Email Captured From Footer Subscriber Acquisition Form');
			});
		}
	}); /* END #footer-subscriber-acquisition-form validate function */

}); /* END document ready callback function */