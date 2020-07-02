/*
 * modified from http://www.ooeygui.net/articles/399
 * The version of the plugin that is posted online looks for <a name=""> anchors, and can't find
 * "id" anchors. 
 *
 * but in the end, id's caused me a bunch of trouble! in IE7, this
 * script would scroll too far and then "jump" back to where the 
 * heading would have been if it hadn't been positioned. <a name=""></a>
 * doesn't have this problem. The simplest fix is to just set everything
 * up to use anchor tags instead of id references. 
 * 
 * jej: 8/6/2009
 */

(function($){
	$.extend({
		smoothAnchors : function(speed, easing, redirect) {
			speed = speed || "fast";
			easing = easing || null;
			redirect = (redirect === true || redirect == null) ? true : false;
			
			$("a").each(function() {
				var url = $(this).attr("href");
				// make sure url is on this page (starts with a pound sign)
				if (!url || url.indexOf("#") != 0)
					return;

				// make sure there's something after the pound sign 
				// (not just a placeholder url)
				var uParts = url.split("#", 2);
				if (uParts.length < 2 || uParts[1] == '')
					return;

				var anchor = $(url);
				if (!anchor)
					return;

				$(this).click(function() {
					if ($('body').attr('id') == 'ead') {
						var scrollelements = $('#text');
						var viewportheight = document.getElementById('text').clientHeight;
						var viewportwidth = document.getElementById('text').clientWidth;
						var contentheight = $('#text').height();
						var contentwidth = $('#text').width();
						var anchoroffsettop = $('#text').scrollTop() + anchor.position().top + anchor.margin().top + anchor.border().top + anchor.padding().top;
						var anchoroffsetleft = $('#text').scrollTop() + anchor.position().left + anchor.margin().top + anchor.border().top + anchor.padding().top;
					} else {
						var scrollelements = $('html, body');
						var viewportheight = $(window).height();
						var viewportwidth = $(window).width();
						var contentheight = $(document).height();
						var contentwidth = $(document).width();
						var anchoroffsettop = anchor.offset().top;
						var anchoroffsetleft = anchor.offset().left;
					}

					/* at a certain point this code was only scrolling to the anchor under
					 * certain circumstances. I'm not sure why. Removing it solved a problem 
					 * where on the 57th street art fair finding aid I couldn't scroll to
					 * 'acknowledgements' from 'descriptive summary'. 
					if (contentheight - anchoroffsettop >= viewportheight
					 || anchoroffsettop > viewportheight
					 || contentwidth - anchoroffsetleft >= viewportwidth
					 || anchoroffsetleft > viewportwidth) 
					*/
					scrollelements.animate({
						scrollTop: anchoroffsettop,
						scrollLeft: anchoroffsetleft
					}, speed, easing, function() {
						if (redirect) { 
							window.location = url;
						}
					});
					return false;
				});
			});
		}
	});
})(jQuery);
