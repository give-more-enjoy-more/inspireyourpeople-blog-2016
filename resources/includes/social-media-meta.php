<meta property="fb:admins" content="1842267468" />
<meta property="og:site_name" content="JustSell.com" />
<meta property="og:url" content="https://<?php echo $_SERVER['SERVER_NAME'] . $_SERVER[REQUEST_URI] ?>" />

<?php if ( is_home() || is_category() ): ?>

	<meta property="og:description" content="No-fluff tips &amp; ideas to better selling. (95% of all you need to know ... and do)" />
	<meta property="og:title" content="<?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?>" /> 
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?php echo bloginfo('template_directory') . '/resources/images/social-media/general/default-justsell-open-graph-1200x630.png'?>" />

<?php elseif ( is_single() || is_page() ): ?>

	<meta property="og:description" content="<?php echo esc_html(get_the_excerpt()); ?>" />
	<meta property="og:title" content="<?php the_title(); ?>" /> 
	<meta property="og:type" content="article" />

	<?php if ( get_post_meta( get_the_ID(), 'post_open_graph_image', true ) ) : ?>
		<meta property="og:image" content="<?php echo bloginfo('template_directory') . get_post_meta( get_the_ID(), 'post_open_graph_image', true ); ?>" />
	<?php else: ?>
		<meta property="og:image" content="<?php echo bloginfo('template_directory') . '/resources/images/social-media/general/default-justsell-open-graph-1200x630.png'?>" />
	<?php endif; ?>

<?php endif; ?>