<?php

/*
 * When you make a change to UNCAP, you can use this file to test your
 * changes. You'll have to keep the browses array updated. Check the
 * website before and after you make changes.
 */

$browses = array(
 'http://uncap-test.lib.uchicago.edu/browse.php?browse=institution/chicago defender' => 2,
 'http://uncap-test.lib.uchicago.edu/browse.php?browse=institution/dusable' => 4,
 'http://uncap-test.lib.uchicago.edu/browse.php?browse=institution/Northwestern University' => 111,
 'http://uncap-test.lib.uchicago.edu/browse.php?browse=institution/sscac' => 1,
 'http://uncap-test.lib.uchicago.edu/browse.php?browse=institution/University of Chicago' => 118,
 'http://uncap-test.lib.uchicago.edu/browse.php?browse=institution/vivian g harsh' => 24,
 'http://uncap-test.lib.uchicago.edu/browse.php' => 262);

$searches = array(
	'http://uncap-test.lib.uchicago.edu/search.php?q=chicago' => 236,
	'http://uncap-test.lib.uchicago.edu/search.php?mode=advanced&field=&q=chicago&collection=institution%2Fchicago+defender&collection=institution%2Fdusable&collection=institution%2FNorthwestern+University&collection=institution%2Fsscac&collection=institution%2FUniversity+of+Chicago&collection=institution%2Fvivian+g+harsh' => 236,
	'http://uncap-test.lib.uchicago.edu/search.php?q=university+of+chicago&exactphrase=on' => 170,
	'http://uncap-test.lib.uchicago.edu/search.php?mode=advanced&field=persname&q=smith&collection=institution%2Fchicago+defender&collection=institution%2Fdusable&collection=institution%2FNorthwestern+University&collection=institution%2Fsscac&collection=institution%2FUniversity+of+Chicago&collection=institution%2Fvivian+g+harsh' => 3,
	'http://uncap-test.lib.uchicago.edu/search.php?mode=advanced&field=subject&q=acting&collection=institution%2Fchicago+defender&collection=institution%2Fdusable&collection=institution%2FNorthwestern+University&collection=institution%2Fsscac&collection=institution%2FUniversity+of+Chicago&collection=institution%2Fvivian+g+harsh' => 3
);

foreach ($browses as $browse => $expectedcount) {
	$xml = new DOMDocument();
	$xml->loadHTMLFile($browse);
	$actualcount = $xml->getElementById('browse')->getElementsByTagName('li')->length;
	if ($actualcount != $expectedcount) {
		printf("%s has %d results, should have %d.\n", $browse, $expectedcount, $actualcount);
	}
}

foreach ($searches as $search => $expectedcount) {
	$xml = new DOMDocument();
	$xml->loadHTMLFile($search);
	$actualcount = $xml->getElementById('browse')->getElementsByTagName('h3')->length;
	if ($actualcount != $expectedcount) {
		printf("%s has %d results, should have %d.\n", $search, $expectedcount, $actualcount);
	}
}

?>
