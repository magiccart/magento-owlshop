jQuery(document).ready(function($){
	(function(){
		$fonts = $('select.mc-fonts');
		$size  = $('select.font-size', $fonts.parent().parent().parent());
		$size.change(function(){$fonts.trigger("click")});
		$fonts.each(function(index, val) {
			$(this).after('<div class="font_preview" style="padding: 10px">Preview this Font</div>');
		});
		$fonts.click(function() {
			var $item 	= $(this);
			var $parent = $item.parent();
			var $font 	= $item.val();
			var $size 	= $('select.font-size').val();
			previewFont($size, $font);
			//$item.bind("change", function() {
				var $size 	= $('select.font-size').val();
				var $font 	= $(this).val();
				previewFont($size, $font);
			//});
			function previewFont(size, font){ 
				var link = jQuery("<link>", {
		  			type: "text/css",
		  			rel: "stylesheet", 
		  			href: "//fonts.googleapis.com/css?family=" + font, 
				}).appendTo("head");
				//console.log(size);
				$('.font_preview', $parent).css({"font-size": size, "font-family": font});
			};
		})
	})(jQuery)
});
