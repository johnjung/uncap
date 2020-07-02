/*
 * This plugin is tightly coupled with the UNCAP website and will need to be
 * modified to work in another environment.
 */

(function() {
	$.fn.gotohighlight = function(options) {
		update = function() {
			/* get all highlights. */
			var highlights = $(".highlight");

			/* find the offsets of all highlights. */
			var highlightoffsets = $.map(highlights, function(e, i) {
				var top = 0;
				var c = e;
				while (true) {
					top += parseInt($(c).position().top + $(c).margin().top + $(c).border().top + $(c).padding().top);
					c = $(c).offsetParent();
					if (c.attr('id') == 'text')
						break;
					if ($(c)[0].tagName == 'BODY')
						break;
				}
				return top;
			});

			/* the current offset is the largest non-positive one. */
			var c = highlightoffsets.length - 1;
			while (c) {
				if (highlightoffsets[c] <= 0)
					break;
				c--;
			}
			if (c < 0)
				c = 0;

			/* add the offset to the current index, and 'roll' the
			 * index so that clicking previous on the first result
			 * goes to the last result, and clicking 'next' on the
			 * last result goes back to the first.
			 */
			c += options.offset;
			while (c < 0)
				c += highlightoffsets.length;
			while (c >= highlightoffsets.length)
				c -= highlightoffsets.length;

			/* scroll to that location in the document. */
			$('#text').animate({scrollTop: parseInt($('#text').scrollTop()) + highlightoffsets[c]}, "normal");

			/* don't do the default action of the click. */
			return false;
		}

		return this.each(function(i,e) {
			/*
			 * If there are highlights on the page, insert an anchor
			 * tag around the contents of "this". When that anchor
			 * is clicked, update the page.
			 */
			if ($('.highlight').size() > 0) {
				$(this).wrapInner("<a href='#'/>").click(update);
			}
		});
	}
})();

