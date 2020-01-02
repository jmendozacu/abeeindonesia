require(['jquery'], function ($) {
	jQuery(document).ready(function(){
		function tabsMenu() {
			isRtl = false;
			if(jQuery('body').hasClass('rtl')){
				isRtl = true;
			}
			if (jQuery(document.body).width() > 1007){
				/*jQuery('.megamenu li.level-top .megamenu-wrapper.tabs-menu').each(function() {
					var columnsCount = jQuery(this).data('columns');
					var isVerticalTabs = jQuery(this).hasClass('vertical');

					jQuery(this).find('.megamenu-inner').each(function() {
						var submenuColumnsCount = jQuery(this).data('columns');
						jQuery(this).find('li.level2').each(function() {
							jQuery(this).css({'width' : 100/submenuColumnsCount + '%'});
						});
					});
				});*/
				setTimeout(function() {
					var windowHeight = jQuery(window).height();
					function culcHeight(el) {
						var maxHeight = 0;
						jQuery(el).find('.megamenu-inner').each(function() {
							if (jQuery(this).outerHeight() > maxHeight) {
								maxHeight = jQuery(this).outerHeight();
							}
						});
						jQuery(el).find('.megamenu-wrapper').each(function() {
							if (jQuery(this).outerHeight() > maxHeight) {
								maxHeight = jQuery(this).outerHeight();
							}
						});

						if (jQuery(el).hasClass('vertical')) {
							var setHeight = maxHeight + parseInt(jQuery(el).css('padding-top')) + parseInt(jQuery(el).css('padding-bottom'));
							jQuery(el).css('min-height', setHeight);
						} else {
							var setHeight = maxHeight + parseInt(jQuery(el).css('padding-top'))
												+ parseInt(jQuery(el).css('padding-bottom'))
												+ parseInt(jQuery(el).css('border-top-width'))
												+ parseInt(jQuery(el).css('border-bottom-width'))
												+ parseInt(jQuery(el).find('li.level1').height());
							if (setHeight+jQuery(el).offset().top > windowHeight) {
								setHeight = windowHeight - jQuery(el).offset().top - 40;
							}
							jQuery(el).css('min-height', setHeight);
						}
						jQuery(el).find('.megamenu-inner').each(function() {
							jQuery(this).css({'height' : maxHeight});
						});
						jQuery(el).find('.megamenu-wrapper').each(function() {
							jQuery(this).css({'height' : maxHeight});
						});
					}
					jQuery('.page-header .megamenu li.level-top').on('hover', function(){
						if (jQuery(this).find('.megamenu-wrapper.tabs-menu').length) {
							culcHeight(jQuery(this).find('.megamenu-wrapper.tabs-menu'));
						}
					});
					jQuery('#sticky-header .megamenu li.level-top:not(".set-height")').on('mouseenter click', function(){
						jQuery(this).addClass('set-height');
						if (jQuery(this).find('.megamenu-wrapper.tabs-menu').length) {
							var menuEl = jQuery(this).find('.megamenu-wrapper.tabs-menu');
							culcHeight(menuEl);
						}
					});
				}, 1000);
			}
		}

		tabsMenu();

		function megamenuPos() {
	    	if (jQuery(document.body).width() > 1007){
                setTimeout( function() {
					jQuery('.megamenu li.parent').each(function() {
						if (jQuery(this).find('.megamenu-wrapper').length > 0) {
							if (!jQuery('.header-wrapper').hasClass('vertical-header')) {
                                if ( $(this).data('fixed-width') != '1' ) {
                                    jQuery(this).height();
                                    jQuery(this).find('.megamenu-wrapper').css({
                                        top: jQuery(this).position().top + jQuery(this).height()
                                    });
                                }
							} else {
								jQuery(this).find('.megamenu-wrapper').css({
									top: jQuery(this).position().top,
									width: jQuery('#maincontent .main-container > .content-inner').outerWidth() + 20
								})
							}
						}
					});
                }, 100 );
			}
		}		
		function mobileMenuIcon() {
			jQuery(".nav.topmenu li.parent").each(function() {
				if (!jQuery(this).find("> a .ui-menu-icon").length) {
					jQuery(this).find("> a").prepend('<span class="ui-menu-icon ui-icon ui-icon-carat-1-e"></span>');
				}
				if(jQuery(this).children('ul.default-menu').length) {
					jQuery(this).addClass('default-menu-parent');
				}
			});	
		}

		function countMobileMenuHeight() {
			if(jQuery(document.body).width() < 1008 && jQuery('#mobile-nav').hasClass('type-2')) {
				if (jQuery('#mobile-nav.type-2 .is-open').length) {
					jQuery('#mobile-nav.type-2').animate({'height' : jQuery('#mobile-nav.type-2 .is-open').last().height()}, 300);
				} else {
					jQuery('#mobile-nav.type-2').animate({'height' : '100%'}, 300);
				}
			}
		}
		
		function mobileMenu(){
		    if(jQuery(document.body).width() < 1008) {
			  	setTimeout(function() {
				  	jQuery('#mobile-nav .megamenu-wrapper ul.expanded').removeClass('expanded');
			  	}, 1300);
			  	jQuery('#mobile-nav li.parent > a').each(function() {
			  		if (!jQuery(this).find('.icon-more').length) {
			  			jQuery(this).append('<span class="icon-more"><i class="icon-plus meigee-plus"></i><i class="icon-minus meigee-minus"></i></span>');
			  		}
		  		});
		  		if (!jQuery('#mobile-nav').hasClass('type-2')) {
		  			jQuery('#mobile-nav li.parent > a').on('click', function(e){
		  				if(jQuery(this).parent().hasClass('clicked')) {
		  					window.location.href = jQuery(this).attr('href');
		  				}
		  				if(!jQuery(this).parent().hasClass('clicked')) {
		  					e.preventDefault();
		  					jQuery(this).parent().addClass('clicked');
		  					jQuery(this).next().addClass('menu-open').slideToggle();
		  					jQuery(this).next().addClass('expanded');
		  					jQuery(this).next().slideDown();
		  					return false;
		  				}
		  			});
		  			jQuery('#mobile-nav li.parent > a .icon-more').on('click', function(e){
		  				if(jQuery(this).parent().parent().hasClass('clicked')) {
		  					e.preventDefault();
		  					e.stopPropagation();
		  					jQuery(this).parent().parent().removeClass('clicked');
		  					jQuery(this).parent().next().slideUp();
		  					jQuery(this).parent().next().removeClass('menu-open expanded');
		  				}
		  			});
		  		} else {
		  			jQuery('#mobile-nav li.parent > a').on('click', function(e){
		  				if(jQuery(this).parent().hasClass('clicked')) {
		  					window.location.href = jQuery(this).attr('href');
		  				}
		  				if(!jQuery(this).parent().hasClass('clicked')) {
		  					e.preventDefault();
		  					jQuery(this).parent().addClass('clicked');
		  					jQuery(this).next().addClass('is-open');
		  					countMobileMenuHeight();
		  					return false;
		  				}
		  			});
		  			jQuery('#mobile-nav li.parent > a .icon-more').on('click', function(e){
		  				if(jQuery(this).parent().parent().hasClass('clicked')) {
		  					e.preventDefault();
		  					e.stopPropagation();
		  					jQuery(this).parent().parent().removeClass('clicked');
		  					jQuery(this).parent().next().removeClass('is-open');
		  					countMobileMenuHeight();
		  				}
				    });
		  			jQuery('#mobile-nav li.back-link a').on('click', function(e){
	  					e.preventDefault();
	  					e.stopPropagation();
	  					jQuery(this).closest('.is-open').removeClass('is-open');
	  					jQuery(this).closest('li.parent.clicked').removeClass('clicked');
	  					countMobileMenuHeight();
				    });
		  		}
		    	jQuery('html .page-wrapper').on('click', function(e){
		    		if (jQuery('html').hasClass('nav-open') && !e.target.closest('.mobile-menu-wrapper')) {
		    			jQuery('html').removeClass('nav-open');
		                setTimeout(function () {
		                    jQuery('html').removeClass('nav-before-open');
		                }, 300);
		    		}
		    	});
		    }
		}
		function menuCategorySlider() {
		    if (jQuery(document.body).width() >= 1008) {
		        isRtl = false;
		        if(jQuery('body').hasClass('rtl')){
		            isRtl = true;
		        }
		        jQuery(".menu-category-slider").each(function() {
		            if (!jQuery(this).closest('.mobile-menu-inner').length || !jQuery(this).hasClass('owl-loaded')) {
		                slider = jQuery(this);
		                navigation = slider.data("navigation");
		                pagination = slider.data("pagination");
		                items = slider.data("items");
		                itemsMobile = slider.data("itemsMobile");
		                stagePadding = slider.data("stagePadding");
		                slideSpeed = slider.data("speed");
		                navigation ? navigation = true : navigation = false;
		                pagination ? pagination = true : pagination = false;
		                items ? items = items : items = 1;
		                itemsMobile ? itemsMobile = itemsMobile : itemsMobile = 1;
		                stagePadding ? stagePadding = stagePadding : stagePadding = 0;
		                slider.owlCarousel({
		                    items: items,
		                    responsive: {
		                        0: {
		                            items: itemsMobile
		                        },
		                        767: {
		                            items: (items > 1 ? items = 2 : items = 1),
		                            margin: 0,
		                            stagePadding: 0,
		                            loop: true,
		                            center: true,
		                        },
		                        1331: {
		                            items: slider.data("items"),
		                            margin: 0,
		                            stagePadding: 0,
		                            loop: true,
		                            center: true,
		                        },
		                    },
		                    nav: navigation,
		                    navSpeed: slideSpeed,
		                    dots: pagination,
		                    dotsSpeed: 400,
		                    navText: ['<span><i class="caret-left"></i><i class="caret-left"></i></span>', '<span><i class="caret-right"></i><i class="caret-right"></i></span>'],
		                    rtl:isRtl
		                }) 
		            }
		        });
		    } 
		}
		 

		mobileMenu();
		mobileMenuIcon();
        // mobileCollapse();
		megamenuPos();
	    jQuery(window).on("scroll", function() {
	    	if ( (jQuery('#sticky-header[style*="display: block"]').length > 0) || (jQuery('.page-header').hasClass('sticky-header')) ) {
				megamenuPos();
	    	}
	    });
		jQuery(window).load(function(){
            menuCategorySlider();
		});
		jQuery(window).resize(function(){
			tabsMenu();
			megamenuPos();
			mobileMenuIcon();
			mobileMenu();
            menuCategorySlider();
            countMobileMenuHeight();
			// mobileCollapse();
		});
	
		jQuery('.megamenu li.level-top').on('mouseenter', function(event){
			jQuery(this).children('a.level-top').addClass('ui-state-focus');
			jQuery(this).addClass('menu-active');
		});
	
		jQuery('.megamenu li.level-top').on('mouseleave', function(event){
			jQuery(this).children('a.level-top').removeClass('ui-state-focus');
			jQuery(this).removeClass('menu-active');
		});
	
		jQuery('.megamenu li a.level-top').on('click', function(event){
			jQuery(this).toggleClass('ui-state-focus');
			jQuery(this).closest('li.level-top').toggleClass('menu-active');
		});
		
		columnsWidth = function(o, n) {
			if (n.size() > 1) {
				n.each(function() {
					jQuery(this).css("width", (100 / n.size()) + "%")
				})
			} else {
				n.css("width", (100 / o) + "%")
			}
		};
		jQuery(".megamenu .megamenu-wrapper").each(function() {
			columnsCount = jQuery(this).data("columns");
			items = jQuery(this).find("ul.level0 > li[class*='nav']");
			groupsCount = items.size() / columnsCount;
			ratio = 1;
			for (i = 0; i < groupsCount; i++) {
				currentGroupe = items.slice((i * columnsCount), (columnsCount * ratio));
				columnsWidth(columnsCount, currentGroupe);
				ratio++
			}
		});
		jQuery(".nav.topmenu li.parent").each(function() {
			if (!jQuery(this).find("> a.level-top .ui-menu-icon").length) {
				jQuery(this).find("> a.level-top").prepend('<span class="ui-menu-icon ui-icon ui-icon-carat-1-e"></span>');
			}
			if(jQuery(this).children('ul.default-menu').length) {
				jQuery(this).addClass('default-menu-parent');
			}
		});	
		
		
	});
	
});