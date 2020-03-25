/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-06-30 14:27:05
 * @@Modify Date: 2015-11-04 14:12:49
 * @@Function:
 */
// function getMagicUrl($ctrl){
//     var ctrl = $ctrl || ''; // if(typeof $path == 'undefined') {path =''}
//     var protocol = window.location.protocol;
//     var domain = Mage.Cookies.domain.substr(1);
//     var path = '/';
//     if(Mage.Cookies.path != path) path = Mage.Cookies.path +'/';
//     var url = protocol + '//' + domain + path;   // http://domain.com/ or / https://domain.com/magento/
//     return url + ctrl;
// }
function getMagicUrl($ctrl){
    var ctrl = $ctrl || ''; // if(typeof $path == 'undefined') {path =''}
    return Themecfg.general.baseUrl + ctrl;
}
function crossSlide(){
	jQuery("#crosssell-products-list").flexisel({
			vertical: false,
			visibleItems: 6,
			responsiveBreakpoints : {
                portrait: { changePoint:480, visibleItems: 2 }, 
                landscape: { changePoint:640, visibleItems: 3 },
                tablet: { changePoint:768, visibleItems: 4 }
            }
	}); // use in frame
}
jQuery(document).ready(function($) {

  	$(document).ajaxStart(function(){
    	$("#magiccart-ajaxloading").css("display","block");
  	});
  	$(document).ajaxComplete(function(){
    	$("#magiccart-ajaxloading").css("display","none");
  	});

	/* Tabs in product detail */
	(function(selector){
		var $content = $(selector);
		var $child   = $content.children('.box-collateral');
		if(Themecfg.detail.inforTabs){
			var activeTab = Themecfg.detail.activeTab;
			var activeContent = $content.children('.box-collateral.'+activeTab);
			if(activeContent.length){
				activeContent.addClass('active');
			} else {
				$content.children('.box-collateral').first().addClass('active');
			}
		}
        var ul = jQuery('<ul class="toggle-tabs"></ul>');
		$.each($child, function(index, val) {
			var title = $(this).children('h2').first().text();
			if(!title) title = $(this).children('.form-add').children('h2').first().text(); // for review
			var active = $(this).hasClass('active') ? 'active': '';
                var li = jQuery('<li class="item '+ active +'"></li>');
                li.html(title);
                ul.append(li);
		});
        ul.insertBefore($content);
        var $tabs =  ul.children();

        $tabs.click(function(event) {
        	$(this).siblings().removeClass('active'); // $tabs.removeClass('active');
        	$(this).addClass('active');
        	$child.hide();
        	$child.eq($(this).index()).show();

        });

	})('.product-view .product-collateral');

		if($.fn.flexisel !== undefined){
			$(".product-image-thumbs").flexisel({margin: 15, clone: true, vertical: false,visibleItems: 3});
			/* if(Themecfg.detail.relatedSlide) $("#block-related").flexisel({vertical: false, clone: true, visibleItems: 1}); */
			if(Themecfg.detail.relatedSlide) $("#block-related ul").flexisel({
				clone: true,
				responsiveBreakpoints : {
					portrait: { changePoint:480, visibleItems: 1 }, 
					landscape: { changePoint:640, visibleItems: 2 },
					tablet: { changePoint:768, visibleItems: 3 }
				}			
			});
			if(Themecfg.detail.upsellSlide) $("#upsell-product ul").flexisel({
				clone: true,
				responsiveBreakpoints : {
					portrait: { changePoint:480, visibleItems: 1 }, 
					landscape: { changePoint:640, visibleItems: 2 },
					tablet: { changePoint:768, visibleItems: 3 }
				}			
			});
			
			if(Themecfg.checkout.crosssellsSlide) crossSlide();
		}

	/* Light Box Image */
	if(Themecfg.detail.lightBox > 0){
	    $('.product-image-gallery .gallery-image').click(function(e) {
	        e.preventDefault();
	        var currentImage = $(this).data('zoom-image');
	        var gallerylist = [];
	        var gallery = $('.product-image-gallery .gallery-image').not('#image-main');

	        gallery.each(function(index, el) {
	        	var img_src = $(this).data('zoom-image');       
				if(img_src == currentImage){
					gallerylist.unshift({
						href: ''+img_src+'',
						title: $(this).find('img').attr("title"),
						openEffect	: 'elastic'
					});	
				}else {
					gallerylist.push({
						href: ''+img_src+'',
						title: $(this).find('img').attr("title"),
						openEffect	: 'elastic'
					});
				}    	
	        });
	        $.fancybox(gallerylist);
	    });
	}
	
	/* Back to Top */

	(function(selector){
		var $backtotop = $(selector);
		$backtotop.hide();
		var height =  $(document).height();
		$(window).scroll(function () {
			var ajaxPopup = $('#toPopup');
			if(ajaxPopup.length) {
				var ajaxPosition = ajaxPopup.offset();
				ajaxPopup.css({
					top : ajaxPosition.top,
					position: 'absolute',
				});
			}
			if ($(this).scrollTop() > height/10) {
				$backtotop.fadeIn();
			} else {
				$backtotop.fadeOut();
			}
		});
		$backtotop.click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});

	})('#backtotop');
	
	function magicTooltip(){
		$('.button.btn-cart').attr('data-original-title',$('button.btn-cart').attr('title'));
		$('.link-wishlist').attr('data-original-title',$('.link-wishlist').attr('title'));
		$('.link-compare').attr('data-original-title',$('.link-compare').attr('title'));
		$('.email-friend-a').attr('data-original-title',$('.email-friend-a').attr('title'));
		$('.brand_item').attr('data-original-title',$('.brand_item').attr('title'));
		$('button.btn-cart, .link-wishlist, .link-compare,.email-friend-a,.link-quickview').attr('rel', 'tooltip');
		$("[rel=tooltip]").tooltip();  
	}
	magicTooltip();
	
	/*$(".block-title.heading").click(function () {
		$header = $(this);
		$content = $header.next();
		$content.slideToggle(500, function () {
			$header.find('i').toggleClass('fa-minus-square');
		});

	});*/
	var $toggleTab  = $('.toggle-tab');
	$toggleTab.click(function(){
		var parent = $(this).closest('.parent-toggle-tab');
		if(!parent.length) parent = $(this).parent();
		parent.toggleClass('toggle-visible').find('.toggle-content').toggleClass('visible');
	});
	
});

