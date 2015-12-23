<form role="search" method="get" id="searchform" class="single-input-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" value="<?php echo get_search_query(); ?>" placeholder="Type your search here" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="Search" />
</form>