<?php

/* Pull in the generic global functions needed for this script. */
require_once('/var/www/html/inspireyourpeople.com/wp-content/themes/inspireyourpeople/resources/includes/global-functions.php');

/* Loads all wordpress functions so they can be used locally in the file. */
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

/* ========================================================================== */
										/* [ Controlling Conditionals ] */
/* ========================================================================== */

/*
 * Run the default modal ajax processing if the required modal variable 'modalType' is set in $_POST
 */
if( isset($_POST["modalType"]) && !isset($_POST["postEtfFormSubmit"]) && !isset($_POST["videoEmailSubmit"]) ){

	/* Set any passed default global modal vars from post */
	$post_id =  isset($_POST["modalPostID"]) ? $_POST["modalPostID"] : '';

	/* Set default required modal vars from post */
	$modal_type = isset($_POST["modalType"]) ? $_POST["modalType"] : '';
	$modal_id = isset($_POST["modalID"]) ? $_POST["modalID"] : '';

	/*
	 * See if the modal type was set and pass to defined function or the error function if modal type wasn't found
	 */
	switch($modal_type):

		case "info":
			process_info_modal();
			break;

		case "post-etf":
			process_post_etf_modal();
			break;

		case "video":
			process_video_modal();
			break;

		default:
			process_modal_not_found();
			break;

	endswitch;

} /* END if isset post modalType */


/*
 * This will run after the modal video capture form is submitted.
 */
if( isset($_POST["videoEmailSubmit"]) ){

	/* Set default form submission vars from post */
	$errors = array();
	$modal_id = isset($_POST["modalID"]) ? $_POST["modalID"] : '';
	$modal_type = isset($_POST["modalType"]) ? $_POST["modalType"] : '';
	$captured_email = isset($_POST["videoEmail"]) ? $_POST["videoEmail"] : '';

	/* Validate the entered email and set the error variable if not valid. */
	if(strlen($captured_email) <= 0){
		$errors[] = "Please enter your email.";
	}else{
		if(!preg_match("/^([a-z0-9_]\.?)*[a-z0-9_]+@([a-z0-9-_]+\.)+[a-z]{2,3}$/i", stripslashes(trim($captured_email)))) {$error[] = "Please enter a valid e-mail address.";}
	}

	/* If there are no errors, pass their cleaned vars to the capture processing function. If there were, display them. */
	if(sizeof($errors) > 0){
		process_modal_form_errors($errors);
	}else{
		process_capture($captured_email, null, $modal_type, $modal_id); /* process_capture is in global functions file */
	}

} /* END isset($_POST["videoEmailSubmit"]) */


/*
 * This will run after the post etf modal form is submitted.
 */
if( isset($_POST["postEtfFormSubmit"]) ){

	/* Ensure all post contents are loaded in variables and cleaned before passing them to the email sending function. */
	$post_etf_email_to = isset($_POST["postEtfEmailTo"]) ? $_POST["postEtfEmailTo"] : '';
	$post_etf_email_from = isset($_POST["postEtfEmailFrom"]) ? $_POST["postEtfEmailFrom"] : '';

	$post_etf_from_name = isset($_POST["postEtfFromName"]) ? $_POST["postEtfFromName"] : '';
	//$postEtfFromName = special_brand_etf_characters($postEtfFromName);

	$post_etf_message = isset($_POST["postEtfMessage"]) ? $_POST["postEtfMessage"] : '';
	$post_etf_message = strip_tags($post_etf_message);
	//$post_etf_message = special_brand_etf_characters($post_etf_message);

	if( !empty($post_etf_message) ){
		$post_etf_text_message = $post_etf_message;

		$post_etf_message = '
			<p style="color:#666666; font-family:\'HelveticaNeue-Light\', \'Helvetica Neue Light\', \'Helvetica Neue\', helvetica, arial, sans-serif; font-size:22px; font-weight:300; line-height:30px; margin-bottom:1em; margin-top:0; text-align:left;">
				&ldquo;'.$post_etf_message.'&rdquo;
			</p>
		';
	}

	$post_etf_validation = isset($_POST["postEtfValidation"]) ? $_POST["postEtfValidation"] : '';

	$post_etf_post_id = isset($_POST["postEtfPostID"]) ? $_POST["postEtfPostID"] : '';

	/* Finding errors in the variables */
	if(strlen($post_etf_from_name) <= 0) {$error[] = "Your name is required.";}
	if(strlen($post_etf_email_to) <= 0) {$error[] = "Please enter the recipients email address.";}
	if(strlen($post_etf_email_from) <= 0) {$error[] = "Please enter your email address.";}
	if(!preg_match("/^([a-z0-9_]\.?)*[a-z0-9_]+@([a-z0-9-_]+\.)+[a-z]{2,3}$/i", stripslashes(trim($post_etf_email_to)))) {$error[] = "The recipients e-mail address is not valid.";}
	if(!preg_match("/^([a-z0-9_]\.?)*[a-z0-9_]+@([a-z0-9-_]+\.)+[a-z]{2,3}$/i", stripslashes(trim($post_etf_email_from)))) {$error[] = "Your e-mail address is not valid.";}
	if(strcmp( trim($post_etf_validation) , "4" ) != 0) {$error[] = "Please add the two numbers, and write the answer in the field above.";}


	/* If there are no errors, pass their cleaned vars to the etf sending function. If there were, display them. */
	if(sizeof($errors) > 0){

		process_modal_form_errors($errors);

	}else{

		process_post_etf_send($post_etf_email_to, $post_etf_email_from, $post_etf_from_name, $post_etf_message, $post_etf_post_id);

	}

} /* END isset($_POST["postEtfFormSubmit"]) */



/* ========================================================================== */
															/* [ Functions ] */
/* ========================================================================== */

/*
 * @name: Process Modal Not Found
 * @function: This function echos the default modal not found message.
 */
function process_modal_not_found(){

	echo "
		<h2 class='modal-title'>Uh oh!</h2>
		<h3 class='center-copy'>Sorry! It looks like this modal doesn't exist.</h3>
	";

} /* END process_modal_not_found function */


/*
 * @name: Process Info Modal
 * @function: This function processes and handles info modals.
 */
function process_info_modal(){

	echo "
		<h2 class='modal-title'>This is an info modal!</h2>
	";

} /* END process_info_modal function */


/*
 * @name: Process Post ETF Modal
 * @function: This function processes and handles post email-to-a-friend modals.
 */
function process_post_etf_modal(){

	global $post_id;

	echo "
		<h2 class='modal-title'>Email this thought</h2>

		<form name='postEtfForm' class='multi-input-form' id='postEtfForm' method='post' action=". $_SERVER['REQUEST_URI'] .">
			<label for='postEtfEmailTo'>Email to:</label><input class='has-input-note' id='postEtfEmailTo' name='postEtfEmailTo' type='text' value='' />
			<p class='input-note'>Addresses of the people you send this to will not be collected or used by us for any promotional purposes.</p>

			<label for='postEtfMessage'>Your Message: (optional)</label><textarea id='postEtfMessage' name='postEtfMessage' rows='3'></textarea>

			<label for='postEtfFromName'>Your Name:</label><input id='postEtfFromName' name='postEtfFromName' type='text' value='' />

			<label for='postEtfEmailFrom'>Your Email:</label><input id='postEtfEmailFrom' name='postEtfEmailFrom' type='text' value='' />

			<label for='postEtfValidation'>What is 2+2?</label><input class='has-input-note' id='postEtfValidation' name='postEtfValidation' type='text' value='' />
			<p class='input-note'>Please answer the question above.</p>

			<input name='postEtfPostID' type='hidden' value='". $post_id ."' />
			<input name='postEtfFormSubmit' type='submit' value='Share this thought' />
		</form>

		<script>
			$.validator.addMethod('postEtfValidation', function(value) {
				if (value.length != 0)
					return $.trim(value) == '4';
				else
					return true;
			});

			$('#postEtfForm').validate({
				rules: {
					postEtfEmailTo: {
						required: true,
						email: true
					},
					postEtfFromName: {
						required: true,
						minlength: 2
					},
					postEtfEmailFrom: {
						required: true,
						email: true
					},
					postEtfValidation: {
						required: true,
						postEtfValidation: true
					}
				},

				messages: {
					postEtfEmailTo: {
					   required: 'Please enter the recipients email address',
					   email: 'Please enter a valid email address'
					 },
					postEtfFromName: 'Please enter your name',
					postEtfEmailFrom: {
					   required: 'Please enter your email address',
					   email: 'Please enter a valid email address'
					 },

					postEtfValidation: 'Please add the two numbers and write the answer in the field above.'
				},

				onfocusout: false,

				showErrors: function(errorMap, errorList) {
					if ( (errorList.length >=1) && $('#postEtfForm .error-title').length == 0 )
						$('<h3 class=\"error-title error\">Please correct the highlighted fields below.</h3>').prependTo('#postEtfForm');

					this.defaultShowErrors();
				},

				errorPlacement: function(error, element) {
					element.attr('placeholder',error.text());
				},

				submitHandler: function(form) {
					var action = $(form).attr('action');

					$.post(action, $(form).serialize(), function(data) {
						$('#postEtfForm').fadeOut(200, function(){

							$('<h3 class=\"title center-copy\">Thanks for sharing!</h3><p class=\"subtitle center-copy\">The email is on its way.</p>').appendTo('.remodal-content-container').hide().fadeIn(200);

						});

					});
				}

			});
		</script>
	";

} /* END process_post_etf_modal function */


/*
 * Sends the actual email with pdf attached.
 * @argument $pdf_url initiated in process_post_pdf_request_form() and sent via function call.
 */
function process_post_etf_send($post_etf_email_to, $post_etf_email_from, $post_etf_from_name, $post_etf_message, $post_etf_post_id)
{

	/* Initialize variables */
	$current_year = date('Y');
	$url_base = 'http://www.inspireyourpeople.com';

	$post_etf_permalink = get_permalink($post_etf_post_id);
	$post_etf_post_excerpt = apply_filters('get_the_excerpt', get_post_field('post_excerpt', $post_etf_post_id));
	$post_etf_title = get_the_title( $post_etf_post_id );
	$post_etf_subject_line = $post_etf_title . ' by InspireYourPeople.com';

	/* Imports the necessary scripts to control MIME being sent. Use 'find . -name swift_required.php' to find location via ssh */
	require_once '/etc/apache2/sites-available/vendor/swiftmailer/swiftmailer/lib/swift_required.php';
//		require_once '/usr/share/pear/swift_required.php';

	/* [ Sets the transport method to PHP Mail ] */
	$transport = Swift_MailTransport::newInstance();

	/* [ Create the Mailer using the created Transport ] */
	$mailer = Swift_Mailer::newInstance($transport);

	/* [ Create the message ] */
	$message = Swift_Message::newInstance($post_etf_subject_line)
	  ->setFrom(array($post_etf_email_from => $post_etf_from_name))
	  ->setTo(array($post_etf_email_to))
		->setBcc(array('jim@inspireyourpeople.com', 'sam@inspireyourpeople.com'))

		/* [ Create HTML Version ] */
		->setBody('
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			</head>

			<body style="background:#F2F2F2; padding:0; margin:0;">

				<!-- Gray BG -->
				<div style="background:#F2F2F2; width:100%;"><table width="100%" border="0" cellspacing="0" bgcolor="#F2F2F2" cellpadding="0" align="center" style="background:#F2F2F2; width:100%;"><tr><td>

					<!-- White BG Wrapper -->
					<table width="750" border="0" cellspacing="0" bgcolor="#FFFFFF" cellpadding="0" align="center" style="margin:0 auto;"><tr><td>

						<!-- Main Content -->
						<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="570">

							<!-- Spacer -->
							<tr><td height="35">&nbsp;</td></tr>

							<!-- Copy -->
							<tr><td>
								<!-- Emailer name -->
								<p style="color:#474747; font-family:\'HelveticaNeue-Light\', \'Helvetica Neue Light\', \'Helvetica Neue\', helvetica, arial, sans-serif; font-size:26px; font-weight:300; line-height:34px; margin-bottom:1em; margin-top:0; text-align:left;">
									<strong>'.$post_etf_from_name.'</strong> sent you this (<a href="http://www.inspireyourpeople.com/?utm_source=iyp-post-etf&utm_medium=email&utm_content=text_post+title+from+inspireyourpeople&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3; text-decoration:none;">from InspireYourPeople.com</a>):
								</p>

								<!-- Emailer message, if supplied -->
								'.$post_etf_message.'

								<p style="color:#666666; font-family:\'HelveticaNeue-Light\', \'Helvetica Neue Light\', \'Helvetica Neue\', helvetica, arial, sans-serif; font-size:22px; font-weight:300; line-height:30px; margin-bottom:1em; margin-top:0; text-align:left;">
									<a href="'.$post_etf_permalink.'?utm_source=iyp-post-etf&utm_medium=email&utm_content=text_post+title&utm_campaign=inspireyourpeople+post+etf" style="color:#4C4C4C; text-decoration:none;">'.$post_etf_subject_line.'</a>
								</p>

								<p style="color:#666666; font-family:\'HelveticaNeue-Light\', \'Helvetica Neue Light\', \'Helvetica Neue\', helvetica, arial, sans-serif; font-size:18px; font-weight:300; line-height:24px; margin-bottom:2em; margin-top:0; text-align:left;">
									'.$post_etf_post_excerpt.'
								</p>

								<p style="color:#FFFFFF; font-family:\'Helvetica Neue\', helvetica, arial, sans-serif; font-size:20px; font-weight:300; line-height:30px; margin-bottom:0; margin-top:0; text-align:center;">
									<a href="'.$post_etf_permalink.'?utm_source=iyp-post-etf&utm_medium=email&utm_content=button+-+see+the+sales+tool&utm_campaign=inspireyourpeople+post+etf" style="background-color:#1A80D3; border:2px solid #1A80D3; color:#FFFFFF; display:inline-block; padding:0.5em 1.5em; text-decoration:none;">See the thought</a>
								</p>
							</td></tr>

						</table> <!-- END Main Content -->

						<!-- Closing Content -->
						<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="500">

							<!-- Spacer -->
							<tr><td height="20">&nbsp;</td></tr>

							<!-- URL & Number -->
							<tr><td align="center">
								<p style="color:#666666; font-family:helvetica, arial, sans-serif; font-size:16px; font-weight:300; line-height:24px; margin-top:0; margin-bottom:0; text-align:center;">
									<a href="http://www.inspireyourpeople.com/?utm_source=iyp-post-etf&utm_medium=email&utm_content=text+-+inspireyourpeople-dot-com&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3;">InspireYourPeople.com</a><br />
									<a href="tel:18669524483" style="color:#666666; text-decoration:none;">1-866-952-4483</a>
								</p>
							</td></tr>

						</table> <!-- END Closing Content -->


						<!-- Brand Footer -->
						<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="650">

							<!-- Line Spacer -->
							<tr><td height="40" style="border-bottom:1px solid #D7D7D7;">&nbsp;</td></tr>
							<tr><td height="35">&nbsp;</td></tr>

							<!-- Header -->
							<tr><td align="center">
								<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:30px; font-weight:300; line-height:38px; margin-bottom:0; margin-top:0; text-align:center;">
									Inspiring messages for your team...
								</p>
							</td></tr>

							<!-- Spacer -->
							<tr><td height="30">&nbsp;</td></tr>

							<!-- Logos & Copy -->
							<tr><td>
								<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="630">
									
									<tr>
										
										<td width="300">
											<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="300">
												<tr>
													<td width="115" valign="middle">
														<a href="http://www.inspireyourpeople.com/212-the-extra-degree/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+212+logo&utm_campaign=inspireyourpeople+post+etf"><img src="http://www.inspireyourpeople.com/images/dedicateds/logos/212-115x88.jpg" width="115" height="88" alt="212&deg; the extra degree&reg;" border="0" /></a>
													</td>
													
													<td width="185" valign="middle">
														<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:15px; font-weight:300; line-height:20px; margin-bottom:0.1em; margin-top:0.5em; text-align:left;">
															Inspire extra effort,<br />care and attention.
														</p>
														<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:18px; font-weight:300; line-height:24px; margin-bottom:0; margin-top:0; text-align:left;">
															<a href="http://www.inspireyourpeople.com/212-the-extra-degree/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+212+the+extra+degree&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3;">212&deg; the extra degree</a>
														</p>
													</td>
												</tr>
											</table>
										</td>
											
										<!-- Spacer -->
										<td width="30">&nbsp;</td>

										<td width="300">
											<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="300">
												<tr>
													<td width="115" valign="middle">
														<a href="http://www.inspireyourpeople.com/cross-the-line/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+cross+the+line+logo&utm_campaign=inspireyourpeople+post+etf"><img src="http://www.inspireyourpeople.com/images/dedicateds/logos/cross-the-line-115x88.jpg" width="115" height="88" alt="Cross The Line&reg;" border="0" /></a>
													</td>
													
													<td width="185" valign="middle">
														<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:15px; font-weight:300; line-height:20px; margin-bottom:0.1em; margin-top:0.5em; text-align:left;">
															Inspire commitment,<br />effort, and resilience.
														</p>
														<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:18px; font-weight:300; line-height:24px; margin-bottom:0; margin-top:0; text-align:left;">
															<a href="http://www.inspireyourpeople.com/cross-the-line/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+cross+the+line&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3;">Cross The Line</a>
														</p>
													</td>
												</tr>
											</table>
										</td>

									</tr>

									<!-- Spacer -->
									<tr><td height="30" colspan="3">&nbsp;</td></tr>

									<tr>
										
										<td width="300">
											<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="300">
												<tr>
													<td width="115" valign="middle">
														<a href="http://www.inspireyourpeople.com/smile-and-move/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+smile+and+move+logo&utm_campaign=inspireyourpeople+post+etf"><img src="http://www.inspireyourpeople.com/images/dedicateds/logos/smile-and-move-115x88.jpg" width="115" height="88" alt="Smile &amp; Move&reg;" border="0" /></a>
													</td>
													
													<td width="185" valign="middle">
														<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:15px; font-weight:300; line-height:20px; margin-bottom:0.1em; margin-top:0.5em; text-align:left;">
															Encourage better<br />attitudes and service.
														</p>
														<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:18px; font-weight:300; line-height:24px; margin-bottom:0; margin-top:0; text-align:left;">
															<a href="http://www.inspireyourpeople.com/smile-and-move/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+smile+and+move&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3;">Smile &amp; Move</a>
														</p>
													</td>
												</tr>
											</table>
										</td>
										
										<!-- Spacer -->
										<td width="30">&nbsp;</td>
				
										<td width="300">
											<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="300">
												<tr>
													<td width="115" valign="middle">
														<a href="http://www.inspireyourpeople.com/lead-simply/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+lead+simply+logo&utm_campaign=inspireyourpeople+post+etf"><img src="http://www.inspireyourpeople.com/images/dedicateds/logos/lead-simply-115x88.jpg" width="115" height="88" alt="Lead Simply&trade;" border="0" /></a>
													</td>
													
													<td width="185" valign="middle">
														<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:15px; font-weight:300; line-height:20px; margin-bottom:0.1em; margin-top:0.5em; text-align:left;">
															Create better leaders (who create better teams).
														</p>
														<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:18px; font-weight:300; line-height:24px; margin-bottom:0; margin-top:0; text-align:left;">
															<a href="http://www.inspireyourpeople.com/lead-simply/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+lead+simply&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3;">Lead Simply</a>
														</p>
													</td>
												</tr>
											</table>
										</td>
										
									</tr>
									

									<!-- Spacer -->
									<tr><td height="30" colspan="3">&nbsp;</td></tr>

									<tr>
											
										<td align="center" colspan="3" width="300">
											<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="300">
												<tr>
													<td width="115" valign="middle">
														<a href="http://www.inspireyourpeople.com/love-your-people/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+love+your+people+logo&utm_campaign=inspireyourpeople+post+etf"><img src="http://www.inspireyourpeople.com/images/dedicateds/logos/love-your-people-115x88.jpg" width="115" height="88" alt="Love Your People&reg;" border="0" /></a>
													</td>
													
													<td width="185" valign="middle">
														<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:15px; font-weight:300; line-height:20px; margin-bottom:0.1em; margin-top:0.5em; text-align:left;">
															Encourage more trust<br />and accountability.
														</p>
														<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:18px; font-weight:300; line-height:24px; margin-bottom:0; margin-top:0; text-align:left;">
															<a href="http://www.inspireyourpeople.com/love-your-people/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+love+your+people&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3;">Love Your People</a>
														</p>
													</td>
												</tr>
											</table>
										</td>
										
									</tr>
									
								</table>
							</td></tr>
							
						</table> <!-- END Brand Footer -->

						<!-- Quick And Easy Ways To Inspire Footer -->
						<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="650">

							<!-- Line Spacer -->
							<tr><td height="45" style="border-bottom:1px solid #D7D7D7;">&nbsp;</td></tr>
							<tr><td height="35">&nbsp;</td></tr>

							<!-- Upcoming Meetings Header -->
							<tr><td align="center">
								<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:30px; font-weight:300; line-height:38px; margin-bottom:0.5em; margin-top:0; text-align:center;">
									Quick and easy ways to inspire your people
								</p>
							</td></tr>

							<!-- Product Links -->
							<tr><td>
								<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;" width="615">

									<tr>
										<td width="75" valign="top" align="center">
											<p style="color:#1A80D3; font-family:helvetica, arial, sans-serif; font-size:18px; line-height:30px; margin-bottom:0; margin-top:0; text-align:center;">
												<a href="http://www.inspireyourpeople.com/books-and-booklets/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+books&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3; text-decoration:none;">Books</a><br />
												<a href="http://www.inspireyourpeople.com/videos/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+videos&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3; text-decoration:none;">Videos</a>
											</p>
										</td>

										<td width="180" valign="top" align="center">
											<p style="color:#1A80D3; font-family:helvetica, arial, sans-serif; font-size:18px; line-height:30px; margin-bottom:0; margin-top:0; text-align:center;">
												<a href="http://www.inspireyourpeople.com/meetings-discussions/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+meeting+packages&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3; text-decoration:none;">Meeting Packages</a><br />
												<a href="http://www.inspireyourpeople.com/presentations/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+powerpoint+slides&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3; text-decoration:none;">PowerPoints&reg;</a>
											</p>
										</td>

										<td width="200" valign="top" align="center">
											<p style="color:#1A80D3; font-family:helvetica, arial, sans-serif; font-size:18px; line-height:30px; margin-bottom:0; margin-top:0; text-align:center;">
												<a href="http://www.inspireyourpeople.com/category/posters-and-prints/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+posters+and+banners&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3; text-decoration:none;">Posters &amp; Banners</a><br />
												<a href="http://www.inspireyourpeople.com/category/mugs-and-water-bottles/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+mugs+water+bottles&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3; text-decoration:none;">Mugs &amp; Water Bottles</a>
											</p>
										</td>

										<td width="160" valign="top" align="center">
											<p style="color:#1A80D3; font-family:helvetica, arial, sans-serif; font-size:18px; line-height:30px; margin-bottom:0; margin-top:0; text-align:center;">
												<a href="http://www.inspireyourpeople.com/category/pocket-cards/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+pocket+cards&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3; text-decoration:none;">Pocket Cards</a><br />
												<a href="http://www.inspireyourpeople.com/gear/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+gifts+and+gear&utm_campaign=inspireyourpeople+post+etf" style="color:#1A80D3; text-decoration:none;">Gifts &amp; Gear</a>
											</p>
										</td>
									</tr>

								</table>
							</td></tr>

							<!-- Spacer -->
							<tr><td height="50">&nbsp;</td></tr>

						</table> <!-- END Quick And Easy Ways To Inspire Footer -->

						<!-- Connect With Us Footer -->
						<table align="center" bgcolor="#E5E5E5" border="0" cellpadding="20" cellspacing="0" style="margin:0 auto;" width="750">
							<tr><td align="center">
								<p style="color:#262626; font-family:helvetica, arial, sans-serif; font-size:20px; font-weight:300; line-height:40px; margin-bottom:0.1em; margin-top:0; text-align:center;">
									Connect with us:
								</p>
								<a href="https://www.facebook.com/nogomos" style="margin-right:5px;"><img src="http://www.inspireyourpeople.com/images/dedicateds/social-media/facebook-circle-30x30.png" alt="Facebook" width="30" height="30" border="0" /></a>
								<a href="https://twitter.com/inspiremypeople" style="margin-right:5px;"><img src="http://www.inspireyourpeople.com/images/dedicateds/social-media/twitter-circle-30x30.png" alt="twitter" width="30" height="30" border="0" /></a>
								<a href="https://plus.google.com/+SamParker212/posts" style="margin-right:5px;"><img src="http://www.inspireyourpeople.com/images/dedicateds/social-media/google-plus-circle-30x30.png" alt="Google Plus" width="30" height="30" border="0" /></a>
								<a href="https://www.linkedin.com/company/inspireyourpeople-com" style="margin-right:5px;"><img src="http://www.inspireyourpeople.com/images/dedicateds/social-media/linkedin-circle-30x30.png" alt="LinkedIn" width="30" height="30" border="0" /></a>
								<a href="https://www.instagram.com/inspire_your_people/"><img src="http://www.inspireyourpeople.com/images/dedicateds/social-media/instagram-circle-30x30.png" alt="Instagram" width="30" height="30" border="0" /></a>
							</td></tr>
						</table> <!-- END Connect With Us Footer -->

						<!-- Real People, Copyright Footer -->
						<table align="center" bgcolor="#262626" border="0" cellpadding="20" cellspacing="0" style="margin:0 auto;" width="750">
							<tr><td align="center">
								<p style="font-family:helvetica, arial, sans-serif;margin-top:1em; margin-bottom: 1.5em; color:#FFFFFF; font-size:20px; font-weight:500; line-height:22px; text-align:center;">
									We\'re real people here and we\'d love to help you. Really.
								</p>

								<p style="color:#656565; font-family:helvetica, arial, sans-serif; font-size:14px; line-height:22px; margin-bottom:1.5em; margin-top:0; text-align:center;">
									&copy; by <a href="http://www.inspireyourpeople.com/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+inspireyourpeople+dot+com&utm_campaign=inspireyourpeople+post+etf" style="color:#656565; text-decoration:none;">InspireYourPeople.com</a> &nbsp;|&nbsp; <a href="tel:18669524483" style="color:#656565; text-decoration:none;">1-866-952-4483</a><br />
									115 South 15th Street, Suite 502, Richmond, VA 23219
								</p>
							</td></tr>
						</table> <!-- END Real People, Copyright Footer -->

					</td></tr></table> <!-- END White BG Wrapper -->

				</td></tr></table></div> <!-- END Gray BG -->

			</body>
			</html>
		', 'text/html')

		/* [ Create TXT Version (purposely not indented) ] */
		->addPart('

'.$post_etf_from_name.' sent you this (from InspireYourPeople.com):

'.$post_etf_text_message.'

-

'.$post_etf_subject_line.'
-----------

'.$post_etf_post_excerpt.'

--
See the sales tool
'.$post_etf_permalink.'
--

-------------

Inspiring messages for your team...

Inspire a little extra effort and attention. 212 the extra degree
http://www.inspireyourpeople.com/212-the-extra-degree/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+212+the+extra+degree&utm_campaign=inspireyourpeople+post+etf

Encourage better attitudes and service. Smile & Move
http://www.inspireyourpeople.com/smile-and-move/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+smile+and+move&utm_campaign=inspireyourpeople+post+etf

Inspire commitment, effort, and resilience. Cross The Line
http://www.inspireyourpeople.com/cross-the-line/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+cross+the+line&utm_campaign=inspireyourpeople+post+etf

Encourage more trust and accountability. Love Your People
http://www.inspireyourpeople.com/love-your-people/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+love+your+people&utm_campaign=inspireyourpeople+post+etf

No fluff. No parables. No matrixes. Just truth. Lead [simply]
http://www.inspireyourpeople.com/lead-simply/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+lead+simply&utm_campaign=inspireyourpeople+post+etf

-------------


Need a speaker for your next event?
Sam\'s thoughts and ideas have inspired thousands of people. He\'s the guy behind this stuff. Maybe he can help your organization.


Click below to learn about Sam or call (866) 952-4483
http://www.inspireyourpeople.com/speaking/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+learn+about+sam&utm_campaign=inspireyourpeople+post+etf


-------------


Upcoming meeting, project, or event?

Our fresh no-fluff messages, handouts, and themes can help you kick it off or support it by making it more interesting and meaningful.

------
Books
http://www.inspireyourpeople.com/books-and-booklets/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+books&utm_campaign=inspireyourpeople+post+etf

------
Videos
http://www.inspireyourpeople.com/videos/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+videos&utm_campaign=inspireyourpeople+post+etf

------
Meeting Packages
http://www.inspireyourpeople.com/meetings-discussions/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+meeting+packages&utm_campaign=inspireyourpeople+post+etf

------
PowerPoint(R) Slides
http://www.inspireyourpeople.com/presentations/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+powerpoint+slides&utm_campaign=inspireyourpeople+post+etf

------
Pocket Cards
http://www.inspireyourpeople.com/category/pocket-cards/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+pocket+cards&utm_campaign=inspireyourpeople+post+etf

------
Wristbands
http://www.inspireyourpeople.com/category/wristbands/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+wristbands&utm_campaign=inspireyourpeople+post+etf

------
Posters & Banners
http://www.inspireyourpeople.com/category/posters-and-prints/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+posters+and+banners&utm_campaign=inspireyourpeople+post+etf

------
Gifts & Gear
http://www.inspireyourpeople.com/gear/?utm_source=iyp-post-etf&utm_medium=email&utm_content=footer+-+gifts+and+gear&utm_campaign=inspireyourpeople+post+etf


-------------

Connect with us:
------

Facebook: https://www.facebook.com/nogomos

Twitter: https://twitter.com/inspiremypeople

Google+: https://plus.google.com/+SamParker212/posts

LinkedIn: http://www.linkedin.com/company/inspireyourpeople-com

Instagram: http://instagram.com/inspire_your_people

-------------
We\'re real people here and we\'d love to help you. Really.

(c) by InspireYourPeople.com | 115 South 15th Street, Suite 502, Richmond, VA 23219 USA
		', 'text/plain')

	; /* END of message creation */


	/* Send the message */
	$sent = $mailer->send($message, $failures);


	/* If the email was sent display thank you message and capture email */
	if($sent){

		/* process_capture arguments: $captured_email, $captured_name, $capture_type, $capture_id */
		/* process_capture is in global functions file */
		process_capture($post_etf_email_from, $post_etf_from_name, 'post-etf-share');

		echo "<h2>Your email has been sent!</h2>";

	} else {
	 	die("Sorry but the email could not be sent. Please go back and try again!");
	}


} /* END function send_post_pdf */



/*
 * @name: Process Modal Form Errors
 * @function: This function processes and handles modals form errors.
 * @arguments: $errors
 */
function process_modal_form_errors($errors){

	$size = sizeof($error);

	for ($i=0; $i < $size; $i++)
	{
		if($i == 0)
			echo '<h3>Please fix the errors bellow and resubmit the form</h3>';

		echo '<p class="modal-form-errors">- '.$error[$i].'</p>';
	}

} /* END process_modal_form_errors function */


/*
 * @name: Process Video Modal
 * @function: This function processes the modal id and echos the video and script to control it.
 */
function process_video_modal(){

	/* Initilize global variables needed by this function. By default, variables in functions have local scope, and need to be set to global to access vars set outside the function. */
	global $modal_type, $modal_id;

	/* Initilize function specific vars needed */
 	$cookie_not_created = !is_capture_cookie_set(); /* is_capture_cookie_set in global functions file */
	$show_video_capture = is_null( $_POST["showCapture"] );
	$show_video_share = is_null( $_POST["showShare"] );
	$video_modal_result_echo = '';

	/* Set brand specific variables */
	switch($modal_id):

		case "ctl":
			$video_src = '//player.vimeo.com/video/42272816?api=1&player_id=vimeoIframeVideo';
			$video_title = 'Cross The Line video';
			break;

		case "ctl-edu":
			$video_src = '//player.vimeo.com/video/42272814?api=1&player_id=vimeoIframeVideo';
			$video_title = 'Cross The Line video';
			break;

		case "ls":
			$video_src = '//player.vimeo.com/video/71604847?api=1&player_id=vimeoIframeVideo';
			$video_title = 'Lead Simply video';
			break;

		case "lyp":
			$video_src = '//player.vimeo.com/video/41103076?api=1&player_id=vimeoIframeVideo';
			$video_title = 'Love Your People video';
			break;

		case "sm":
			$video_src = '//player.vimeo.com/video/111015361?api=1&player_id=vimeoIframeVideo';
			$video_title = 'Smile &amp; Move video';
			break;

		default:
			$video_src = '//player.vimeo.com/video/109480151?api=1&player_id=vimeoIframeVideo';
			$video_title = '212&deg; the extra degree video';
			break;

	endswitch;


	/*
	 * Assemble the modal contents to echo.
	 */
	$video_modal_result_echo .= "<h2 class='modal-title'>$video_title</h2>";

	/* Show the video capture form and video depending on boolean, true by default. If false, show video only. */
	if($show_video_capture && $cookie_not_created){

		$video_modal_result_echo .= "<div class='embed-video-capture-container'>";
		$video_modal_result_echo .= "
			<form action='/wp-content/themes/inspireyourpeople/resources/includes/modal-ajax-processing.php' method='post' name='videoEmailCaptureForm' class='video-email-capture-form single-input-form' id='videoEmailCaptureForm'>
				<p class='title'>Please enter your email address to view the video.</p>
				<input name='videoEmail' class='video-email' type='text' placeholder='Enter Your Email Here' />
				<input name='modalType' type='hidden' value='$modal_type' />
				<input name='modalID' type='hidden' value='$modal_id' />
				<input name='videoEmailSubmit' type='submit' value='Watch It!' />
			</form>
			<div class='video-overlay'></div>
			<div class='embed-video-container'><iframe class='iframe-video' id='vimeoIframeVideo' src='$video_src' frameborder='0'></iframe></div>
		";

		$video_modal_result_echo .= "
			<script>
				$(document).ready(function() {

					$('#videoEmailCaptureForm').validate({
						rules: {
							videoEmail: {
								required: true,
								email: true
							}
						},

						messages: {
							videoEmail: {
							   required: 'Please enter your email address',
							   email: 'Please enter a valid email address'
							 }
						},

						errorElement: 'p',

						errorPlacement: function(error) {
							error.appendTo('#videoEmailCaptureForm');
						},

						submitHandler: function(form) {
							var action = $(form).attr('action');

							$.post(action, $(form).serialize(), function(data) {
								$('.video-email-capture-form, .video-overlay').fadeOut(200);

								/* Function to start playback of the video. Function is defined in the functions.js file. */
								play_modal_vimeo_video();

								/* [ Trigger a Google Analytics Event if the visitor successfully signs up.  ] */
								ga('send', 'event', 'Video Watch Email Capture', 'Submit', 'Captured Email From Video - $modal_id');

							});
						}

					});

				});
			</script>
		";

		$video_modal_result_echo .= "</div>";

	}else{
		$video_modal_result_echo .= "<div class='embed-video-container'><iframe class='iframe-video' id='vimeoIframeVideo' src='$video_src' frameborder='0'></iframe></div>";
	}

	/* Show the video share depending on boolean, true by default */
	if($show_video_share){

		/* Initialize url variables */
		$iyp_base_url = 'http://www.inspireyourpeople.com';

		/* Set brand specific variables */
		switch($modal_id):

			case "ctl":
				$brand_name = 'Cross The Line';
				$image_url 	= $iyp_base_url . '/wp-content/themes/inspireyourpeople/resources/images/products/throughout/ctl-video-organization-700x700.jpg';
				$learn_url 	= $iyp_base_url . '/cross-the-line/';
				$share_url 	= $learn_url;
				$shop_url 	= $iyp_base_url . '/product/cross-the-line-video-organization-edition/';
				break;

			case "ls":
				$brand_name = 'Lead Simply';
				$image_url 	= $iyp_base_url . '/wp-content/themes/inspireyourpeople/resources/images/products/throughout/ls-video-700x700.jpg';
				$learn_url 	= $iyp_base_url . '/lead-simply/';
				$share_url 	= $learn_url;
				$shop_url 	= $iyp_base_url . '/product/lead-simply-video/';
				break;

			case "lyp":
				$brand_name = 'Love Your People';
				$image_url 	= $iyp_base_url . '/wp-content/themes/inspireyourpeople/resources/images/products/throughout/lyp-video-700x700.jpg';
				$learn_url 	= $iyp_base_url . '/love-your-people/';
				$share_url 	= $learn_url;
				$shop_url 	= $iyp_base_url . '/product/love-your-people-video/';
				break;

			case "sm":
				$brand_name = 'Smile & Move';
				$image_url 	= $iyp_base_url . '/wp-content/themes/inspireyourpeople/resources/images/products/throughout/sm-video-700x700.jpg';
				$learn_url 	= $iyp_base_url . '/smile-and-move/';
				$share_url 	= $learn_url;
				$shop_url 	= $iyp_base_url . '/product/smile-and-move-video-the-smovie/';
				break;

			default:
				$brand_name = '212 the extra degree';
				$image_url 	= $iyp_base_url . '/wp-content/themes/inspireyourpeople/resources/images/products/throughout/212-video-700x700.jpg';
				$learn_url 	= $iyp_base_url . '/212-the-extra-degree/';
				$share_url 	= $learn_url;
				$shop_url		= $iyp_base_url . '/product/212-the-extra-degree-video/';
				break;

		endswitch;

		$video_modal_result_echo .= '
			<div class="etf-cta-btns">
				<ul class="cta-options">
					<li class="cta-btn"><a href="'. $shop_url .'"><img class="modal-option-icon" src="/wp-content/themes/inspireyourpeople/resources/images/icons/throughout/modal-shop-45x40.png" alt="Shop" width="45" height="40" /> Buy the video</a></li>
					<li class="cta-btn"><a href="'. $learn_url .'"><img class="modal-option-icon" src="/wp-content/themes/inspireyourpeople/resources/images/icons/throughout/modal-learn-more-37x40.png" alt="Learn" width="37" height="40" /> Learn more</a></li>
					<li class="cta-btn share-prompt last">
						<a href="'. $learn_url .'"><img class="modal-option-icon" src="/wp-content/themes/inspireyourpeople/resources/images/icons/throughout/modal-share-33x40.png" alt="Share" width="33" height="40" /> Share the video</a>
					</li>
				</ul>

				<ul class="cta-options social-share">
					<li class="cta-btn"><a class="event-trigger" href="https://www.facebook.com/sharer/sharer.php?u='. $share_url .'" data-event-fields=\'{"category":"Social Media Share","action":"Share","label":"Facebook"}\' title="Share this on Facebook" target="_blank"><img class="social-media-icon" src="/wp-content/themes/inspireyourpeople/resources/images/icons/social-media/modal-share-facebook-26x27.png" alt="Facebook" width="26" height="27" /> Facebook</a></li>
					<li class="cta-btn"><a class="event-trigger" href="http://twitter.com/?status=Love+this+for+motivation+from+InspireYourPeople.com...+'. $share_url .'+@InspireMyPeople" data-event-fields=\'{"category":"Social Media Share","action":"Share","label":"Twitter"}\' title="Tweet this" target="_blank"><img class="social-media-icon" src="/wp-content/themes/inspireyourpeople/resources/images/icons/social-media/modal-share-twitter-26x21.png" alt="Twitter" width="26" height="21" /> Twitter</a></li>
					<li class="cta-btn"><a class="event-trigger" href="https://plus.google.com/share?url='. $share_url .'" data-event-fields=\'{"category":"Social Media Share","action":"Share","label":"Google Plus"}\' title="Share this on Google+" target="_blank"><img class="social-media-icon" src="/wp-content/themes/inspireyourpeople/resources/images/icons/social-media/modal-share-google-plus-26x24.png" alt="Google+" width="26" height="24" /> Google+</a></li>
					<li class="cta-btn"><a class="event-trigger" href="http://www.linkedin.com/shareArticle?mini=true&url='. $share_url .'" data-event-fields=\'{"category":"Social Media Share","action":"Share","label":"LinkedIn"}\' title="Share this on LinkedIn" target="_blank"><img class="social-media-icon" src="/wp-content/themes/inspireyourpeople/resources/images/icons/social-media/modal-share-linkedin-26x22.png" alt="LinkedIn" width="26" height="22" /> LinkedIn</a></li>
					<li class="cta-btn last"><a class="event-trigger" href="http://pinterest.com/pin/create/button/?url='. $share_url .'&media='. $image_url .'" data-event-fields=\'{"category":"Social Media Share","action":"Share","label":"Pinterest"}\' title="Share this on Pinterest" target="_blank"><img class="social-media-icon" src="/wp-content/themes/inspireyourpeople/resources/images/icons/social-media/modal-share-pinterest-26x26.png" alt="Pinterest" width="26" height="26" /> Pinterest</a></li>
				</ul>
			</div>

			<script>
				/* Share menu functionality for modal windows */
				$(".etf-cta-btns .share-prompt").on(\'click\', function(e){
					e.preventDefault();
					$(".etf-cta-btns .social-share").slideToggle(300);
				});
			</script>
		';

	} /* END if $show_video_share */


	/* Echo out the compiled result */
	echo $video_modal_result_echo;

} /* END process_video_modal function */

?>