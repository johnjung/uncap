/* 
 * jquery.highlightnavigation.js, a jquery plugin to update page navigation
 * when a user scrolls.
 * 
 * This plugin is tightly coupled with the UNCAP website and will need to be
 * modified to work in another environment.
 */

(function($) {
	$.fn.highlightnavigation = function() {
		var linkelement = $('#toc');
		var controller = $('#text');

		controller.scroll(function() {
			controller.stopTime("update");
			controller.oneTime(50, "update", update);
		});
	
		update();

		function update() {
			var links = linkelement.find(("a:visible:not(:empty)[href ^= '#']"));

			var targets = $.map(links, function(e) {
				return $($(e).attr('href'));
			});

			// TAKE SCROLLING INTO ACCOUNT WHILE GETTING POSITIONS
			// OF ELEMENTS.
			var targetpositions = $.map(targets, function(e) {
				return Math.floor($(e).position().top);
			});

			// FIND THE LARGEST NEGATIVE (ALMOST) POSITION. IF
			// THERE IS NONE, USE THE FIRST ELEMENT. THE REASON
			// FOR 'ALMOST' IS THAT OPERA PUTS THE ELEMENT AT
			// A TOP OF 1PX, FOR SOME REASON.
			var c = targetpositions.length - 1;
			while (c >= 0) {
				if (targetpositions[c] <= 1)
					break;
				c--;
			}
			if (c < 0)
				c = 0;

			$(links).parent('li').removeClass('active');
			$(links[c]).parent('li').addClass('active');
		}
	}
}(jQuery));

