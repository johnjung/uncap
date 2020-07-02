<meta http-equiv="content-type" content="text/html; charset=utf-8"/>   
<link href="/css/reset.css" rel="stylesheet" type="text/css"/>
<link href="/css/uncap.css" rel="stylesheet" type="text/css"/>
<link href="/css/type.css" rel="stylesheet" type="text/css"/>
<link href="/css/static.css" rel="stylesheet" type="text/css"/>
<!--[if lte IE 7]>
<link href="/css/ie7.css" rel="stylesheet" type="text/css"/>
<![endif]-->
<!--[if lte IE 6]>
<link href="/css/ie6.css" rel="stylesheet" type="text/css"/>
<![endif]-->
<script src="/scripts/jquery-1.4.4.min.js" type="text/javascript"></script>
<script src='https://www.lib.uchicago.edu/static/base/js/ga.public.js'></script>
<script src="/scripts/jquery.expandable.js" type="text/javascript"></script>
<script src="/scripts/fancybox/jquery.fancybox-1.3.4.js" type="text/javascript"></script>
<link href="/scripts/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css"/>
<script src="/scripts/jquery.gotohighlight.js" type="text/javascript"></script>
<script src="/scripts/jquery.highlightnavigation.js" type="text/javascript"></script>
<script src="/scripts/jquery.sizes.js" type="text/javascript"></script>
<script src="/scripts/jquery.smoothanchors.js" type="text/javascript"></script>
<script src="/scripts/jquery.timers.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready( function() {
	// SET UP EXPANDABLE NAVIGATION IN EAD SIDEBAR.
	$('#ead #sidebar li ul').expandable();
	
	// UPDATE HIGHLIGHTED NAVIGATION TO GO ALONG WITH SCROLLING.
	$('#toc').highlightnavigation();

	// SMOOTH SCROLLING TO ANCHORS.
	$.smoothAnchors("normal");

	// ADVANCED SEARCH.
	$('#advancedsearchlink').fancybox({
		frameWidth: 700,
		hideOnContentClick: false,
		scrolling: 'no'
	});

	// EAD 'PREVIOUS' AND 'NEXT' MATCH BUTTONS.
	$('#previousmatch').gotohighlight({offset: -1});
	$('#nextmatch').gotohighlight({offset: 1});

	// FOCUS ON TEXT AREA SO USER CAN HIT UP OR DOWN KEYS RIGHT AWAY.
	/* at first I was doing $('#text').focus(), but in IE 6 and 8 this
 	 * scrolls the main window down to the top of the text div. */
});
</script>
