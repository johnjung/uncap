/*
 * apply this to nested <ul>s.
 */

$.fn.expandable = function() {
	return this.each(function() {
		$(this).parent('li').find('a').eq(0).click(toggle);
		$(this).parent('li').find('a').eq(0).addClass('collapsed');
		$(this).hide();
	});

	function toggle() {
		var ul = $(this).next('ul');
		if (ul.is(':visible')) {
			ul.hide();
			$(this).removeClass('expanded').addClass('collapsed');
		} else {
			ul.show();
			$(this).removeClass('collapsed').addClass('expanded');
		}
	}
}

