<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage InspireYourPeople.com 2016
 */
?>
<?php ob_start(); /* Here to prevent wordpress from pre-rending content before all functions run, but specifically the capture_cookie_check_and_set function in the global_functions file. */ ?>
<!DOCTYPE html>
<html>
<head>

	<title>
		<?php
			global $page, $paged;
		
			if ( is_tag() ){
				echo "More Posts About: ";
			}

			wp_title( '|', true, 'right' );
		
			// Add the blog name.
			bloginfo( 'name' );
		
			// Add the blog description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";
		
			// Add a page number if necessary:
			if ( $paged >= 2 || $page >= 2 )
				echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) );
		?>
	</title>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php /* <meta name="viewport" content="width=device-width"> */ ?>
	<meta name="robots" content="noodp"> <?php /* Prevents search engines from using the alternative description from the ODP/DMOZ */ ?>

	<?php if ( is_home() || is_category() ): ?>

		<meta name="description" content="">
		<meta name="keywords" content="">

	<?php elseif ( is_single() ): ?>

		<meta name="description" content="<?php echo esc_html(get_the_excerpt()); ?>">

		<?php 
			$post_tags = get_the_tags();
			foreach($post_tags as $tag)
				$csv_tags .= $tag->name . ',';
				
			echo '<meta name="keywords" content="'.$csv_tags.'" />';
		?>

	<?php endif; ?>


	<?php
		/* Pulls in the social media meta tags */
		include('resources/includes/social-media-meta.php'); ?>

	<link rel="shortcut icon" href="<?php echo bloginfo('template_directory') ?>/resources/images/icons/throughout/favicon.ico" />
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>?=v010816">

	<!--[if lt IE 9]>
		<script src="<?php echo bloginfo('template_directory') ?>/resources/js/html5shiv.min.js"></script>
		<script src="<?php echo bloginfo('template_directory') ?>/resources/js/respond.min.js"></script>
	<![endif]-->

	<?php /* TypeKit Font Import */ ?>
	<script src="https://use.typekit.net/olm3agc.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>

	<?php
		/* Pulls in the analytics integrations */
		include('resources/includes/analytics-integration.php'); ?>

</head>

<body class="<?php echo post_or_page_specific_class(); ?>">

	<div class="content-container">

		<?php
			/* Pulls in the header navigation */
			include('resources/includes/header-navigation.php'); ?>