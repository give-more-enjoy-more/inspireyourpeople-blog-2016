$(function() {

	// -------------------------------------------------
	// Controls Main Navigation Drop Down Functionality
	// -------------------------------------------------
	var mainDropConfig = {
				over: showSubmenu, // function = onMouseOver callback (REQUIRED)    
				timeout:450, // number = milliseconds delay before onMouseOut
				out: hideSubmenu // function = onMouseOut callback (REQUIRED)
			},
			
			brandsSubmenuDropConfig = {
				over: showOtherBrandsSubmenu, // function = onMouseOver callback (REQUIRED)    
				timeout:50, // number = milliseconds delay before onMouseOut    
				out: hideOtherBrandsSubmenu // function = onMouseOut callback (REQUIRED)
			};

		
	// Setup hover Intent Listeners For Dropdown
	$('.menu-item').hoverIntent(mainDropConfig);
	$('.reveal-brand-info-submenu').parent().hoverIntent(brandsSubmenuDropConfig);


	// Functions for main nav dropdowns
	function showSubmenu(){
		// Remove brand submenu active class(resolved IE7 issue), then add the active class to the first brand menu item
		$('.submenu-brand-list-item').removeClass('brand-submenu-item-active');
		$('.submenu-brand-list-item:first').addClass('brand-submenu-item-active');
		
		
		// Positions the far right dropdown menus if they are currently triggered
		if( $(this).children('.right-submenu').length != 0 ){
		
				var menuItemOuterWidth = $(this).outerWidth(),
						miniSubmenu = $(this).children('.right-submenu'),
						miniSubmenuOuterWidth = miniSubmenu.outerWidth(),
						miniSubmenuMarginOffset = miniSubmenuOuterWidth - menuItemOuterWidth;
		
				miniSubmenu.css('margin-left', - miniSubmenuMarginOffset );
		}

		// Centers the dropdown menus with a class of 'center-submenu' if they are currently triggered
		if( $(this).children('.center-submenu').length != 0 ){
		
				var menuItemOuterWidth = $(this).outerWidth(),
						miniSubmenu = $(this).children('.center-submenu'),
						miniSubmenuOuterWidth = miniSubmenu.outerWidth(),
						miniSubmenuMarginOffset = (miniSubmenuOuterWidth / 2) - (menuItemOuterWidth / 2);
		
				miniSubmenu.css('margin-left', - miniSubmenuMarginOffset );
		}



		// Finally, because of the delay on the timeout, let's remove the menu active class first and then
		// add the active state class to the top level menu item to show the dropdown menu to prevent menu overlap
		$('.menu-item').removeClass('menu-item-active');
		$(this).addClass('menu-item-active');
	}
	
	function hideSubmenu(){
		$(this).removeClass('menu-item-active');
	}



	// Functions for Brand Submenu
	function showOtherBrandsSubmenu(){
		$('.submenu-brand-list-item').removeClass('brand-submenu-item-active');
		$(this).addClass('brand-submenu-item-active');
	}
	
	function hideOtherBrandsSubmenu(){
		// Do Nothing! We don't want to remove the active submenu class unless another brand option is selected. 
	}



	// -------------------------------------------------------------------------------------------------
	// Conditional for touch devices (tables, phones, etc.) to not follow nav click links on first touch
	// -------------------------------------------------------------------------------------------------
	$('.avoid-follow-if-touch-device').on('click', function(e){
	
		if(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
			e.preventDefault();
		}
	
	});





	// ------------------------------------------
	// Controls Main Navigation Window Scrolling
	// ------------------------------------------
	var topNavi = $('.top-navigation'),
			topNaviHeight = topNavi.outerHeight(),
			topNaviPosition = topNavi.offset().top,
			infoOrigBottomPadding = $('.info-account-bar').css('padding-bottom');
	
	$(window).scroll(function (event) {
		var yBroswerPosition = $(this).scrollTop();
	
		if(yBroswerPosition >= topNaviPosition){
			
			topNavi.addClass('top-fixed-navi');
			$('.info-account-bar').css('padding-bottom', topNaviHeight);
	
		}else{
		
			topNavi.removeClass('top-fixed-navi');
			$('.info-account-bar').css('padding-bottom', infoOrigBottomPadding);
	
		}
	});
	
	
	// --------------------------------------------------------
	// On Page Refresh, if scroll is below nav, add fixed class
	// --------------------------------------------------------
	$(document).ready(function(){
		var yBroswerPosition = $(window).scrollTop();

		if(yBroswerPosition >= topNaviPosition){
					
			topNavi.addClass('top-fixed-navi');
		}
	});









});