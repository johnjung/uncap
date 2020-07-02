<?php

include "config.php";

/*
 * API examples:
 *
 * BOOLEAN-AND NON-FIELDED SEARCH
 *
 * Pass a space-separated list of words to the q parameter:
 * search.php
 * ?q=huh+what+right+uh
 * 
 * Backend:
 * http://marklogic.lib.uchicago.edu:8021/request.xqy
 * ?action=search
 * &q=letters+editor
 *
 * EXACT-PHRASE NON-FIELDED SEARCH
 *
 * Pass an exact phrase to q, without quotes.
 * Pass the parameter exactphrase.
 * search.php
 * ?exactphrase
 * &q=huh+what+right+uh
 *
 * Backend:
 * http://marklogic.lib.uchicago.edu:8021/request.xqy
 * ?action=search
 * &q=%22letters+editor%22
 * 
 * BOOLEAN-AND FIELDED SEARCH
 * 
 * Pass a fieldname to field, and a space-separated list of words to q:
 * search.php
 * ?field=persname
 * &q=Sengstacke,+John+Herman+Henry
 * 
 * Backend:
 * http://marklogic.lib.uchicago.edu:8021/request.xqy
 * ?action=search
 * &field=unittitle%3Aletters
 * &field=unittitle%3Aeditor
 * 
 * EXACT-PHRASE FIELDED SEARCH
 * 
 * Pass a fieldname to field, and an exact-phrase to q, without quotes.
 * Pass the parameter exactphrase.
 * search.php
 * ?exactphrase
 * &field=persname
 * &q=Sengstacke,+John+Herman+Henry
 * 
 * Backend:
 * http://marklogic.lib.uchicago.edu:8021/request.xqy
 * ?action=search
 * &field=unittitle%3Aletters+editor
 * 
 * NOTES
 *
 * Search results are not sorted by relevance.
 *
 * TO DO
 * 
 */

/*
 * FUNCTIONS
 */

function title($clean, $resultcount) {
	$title = trim($clean['q'], "'\"");
	if ($clean['q'] == '')
		return "No documents match your search.";
	if ($resultcount == 1)
		return sprintf("1 document matches your search for \"%s\"", $title);
	else 
		return sprintf("%d documents match your search for \"%s\"", $resultcount, $title);
}

function subtitle($clean) {
	
	/*
	 * The search was limited to the following collections and institutions...
	 */

	$c = array();
	foreach (explode('&', $_SERVER['QUERY_STRING']) as $param) {
		$parts = explode('=', $param);
		if (count($parts) != 2)
			continue;
		$name = $parts[0];
		$value = $parts[1];
		if ($name == 'collection') {
			switch (urldecode($value)) {
				case 'collection/chicago jazz archive':
					$c['Chicago Jazz Archive'] = true;
					break;
				case 'collection/modern poetry':
					$c['Modern Poetry'] = true;
					break;
				case 'institution/chicago defender':
					$c['Chicago Defender'] = true;
					break;
				case 'institution/dusable':
					$c['DuSable Museum of African American History'] = true;
					break;
				case 'institution/vivian g harsh':
					$c['Chicago Public Library, Carter G. Woodson Regional Library, Vivian G. Harsh Research Collection of Afro-American History and Literature'] = true;
					break;
				case 'institution/sscac':
					$c['South Side Community Art Center'] = true;
					break;
				case 'institution/University of Chicago':
					$c['The University of Chicago Library'] = true;
					break;
				case 'institution/Northwestern University':
					$c['Northwestern University'] = true;
					break;
				case 'project/SCRC':
					$c['Special Collections Research Center'] = true;
					break;
				case 'project/MTS':
					$c['Mapping the Stacks'] = true;
					break;
			}
		}
	}
	/* get unique values */
	$c = array_keys($c);

	$s = '';
	if (count($c) > 0 && count($c) < 5) {
		$s .= sprintf("<p><i>The search was limited to the following collections and institutions:<br/>%s.</i></p>", implode(', ', $c));
	}

	/*
	 * The search was limited to...
	 */

	switch ($clean['field']) {
		case 'corpname':
		case 'persname':
		case 'subject':
			$s .= sprintf("<p><i>The search was limited to subject headings.</i></p>");
			break;
		case 'dsc':
			$s .= sprintf("<p><i>The search was limited to finding aid inventories.</i></p>");
			break;
		case 'unittitle':
			$s .= sprintf("<p><i>The search was limited to headings.</i></p>");
			break;
	}

	return $s;
}

/*
 * INPUT 
 */

$clean = array();

$clean['mode'] = 'basic';
if (isset($_GET['mode'])) {
	switch ($_GET['mode']) {	
		case 'advanced':
		case 'basic':
			$clean['mode'] = $_GET['mode'];
			break;
	}
}

$collections = array();
foreach (explode('&', $_SERVER['QUERY_STRING']) as $param) {
	$parts = explode('=', $param);
	if (count($parts) != 2)
		continue;
	$name = $parts[0];
	$value = $parts[1];
	if ($name == 'collection') {
		switch (urldecode($value)) {
			case 'institution/chicago defender':
			case 'collection/chicago jazz archive':
			case 'institution/dusable':
			case 'collection/modern poetry':
			case 'institution/sscac':
			case 'institution/vivian g harsh':
			case 'institution/Northwestern University':
				$collections[urldecode($value)] = true;
				break;
			case 'institution/University of Chicago':
			case 'project/SCRC':
				$collections['collection/chicago jazz archive'] = true;
				$collections['collection/modern poetry'] = true;
				break;
			case 'project/MTS':
				$collections['institution/chicago defender'] = true;
				$collections['institution/dusable'] = true;
				$collections['institution/sscac'] = true;
				$collections['institution/vivian g harsh'] = true;
				break;
		}
	}
}
$clean['collection'] = array_keys($collections);

if ($clean['mode'] == 'basic') {
	$clean['collection'] = array('collection/UNCAP');
}

if (isset($_GET['exactphrase']))
	$clean['exactphrase'] = 'on';

$clean['field'] = '';
if (isset($_GET['field'])) {
	switch ($_GET['field']) {
		case 'corpname':
		case 'dsc':
		case 'persname':
		case 'subject':
		case 'unittitle':
			$clean['field'] = $_GET['field'];
			break;
	}
}

$clean['q'] = '';
if (isset($_GET['q'])) {
	/* Trim whitespace. */
	$clean['q'] = trim($_GET['q']);
    /* Strip out HTML and PHP tags. */
    $clean['q'] = strip_tags($clean['q']);
	/* Trim single and double quotes. */
	$clean['q'] = trim($clean['q'], "'\"");
}

if (isset($_GET['xml']))
	$clean['xml'] = true;

/* 
 * MAIN
 */

if ($clean['q'] != '') {

	/* 
	 * All non-fielded searches.
	 */

	if ($clean['field'] == '') {

		/*
		 * Exact-phrase non-fielded search.
		 */

		if (array_key_exists("exactphrase", $clean)) {
			$f = sprintf("%s/request.xqy?action=search&q=%%22%s%%22", $MARKLOGIC, urlencode($clean['q']));
		} else {

		/*
		 * Boolean-AND non-fielded search.
		 */

			$f = sprintf("%s/request.xqy?action=search&q=%s", $MARKLOGIC, urlencode($clean['q']));
		}

	/*
	 * Fielded searches.
	 */

	} else {

		/* 
		 * Exact-phrase fielded searches.
		 */

		if (array_key_exists("exactphrase", $clean)) {
			$f = sprintf("%s/request.xqy?action=search&field=%s%%3a%s", 
				$MARKLOGIC,
				urlencode($clean['field']), 
				urlencode($clean['q']));

		/*
		 * Boolean-AND fielded searches.
		 */

		} else {
			$fields = '';
			foreach (preg_split('/\s+/', $clean['q']) as $field)
				$fields .= sprintf("&field=%s%%3A%s", urlencode($clean['field']), $field);
			$f = sprintf("%s/request.xqy?action=search&%s", $MARKLOGIC, $fields);
		}
	}
	
	/* 
	 * Then add collections, no matter what.
	 */

	foreach ($clean['collection'] as $c) {
		$f .= sprintf("&collection=%s", urlencode($c));
	}

	$str = file_get_contents($f);

	/*
	 * Remove xmlns, if present.
	 */
	
	$str = str_replace(' xmlns="urn:isbn:1-931666-22-9"', '', $str);

	if (array_key_exists('xml', $clean)) 
		die($str);

	$xml = new DOMDocument();
	$xml->loadXML($str);

	$xp = new DOMXPath($xml);
	$q = '/div[@class="search-data"]/div[@class="total-number-of-results"]';
	$nl = $xp->query($q);
	if ($nl->length) {
		$resultcount = (int)$nl->item(0)->nodeValue;
	} else {
		$resultcount = 0;
	}

	$xsl = new DOMDocument();
	$xsl->load('xslt/search.xsl');

	$xp = new XSLTProcessor();
	$xp->importStyleSheet($xsl);
	$xp->setParameter('', 'exactphrase', $clean['exactphrase']);
	$xp->setParameter('', 'q', $clean['q']);

	$SEARCH = $xp->transformToXML($xml);

	/* 
	 * Catch the case where someone unchecked all of the fields and did an
	 * advanced search.
	 */

	if (count($clean['collection']) == 0)
		$resultcount = 0;

}
?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php include "includes/headstatic.php"; ?>
</head>
<body>
<div id="wrapper1">
<div id="wrapper2">
<!--HEADER-->
<div id="header"><?php include "includes/header.php"; ?></div>

<!--SIDEBAR-->
<div id="sidebar">
<?php include "includes/sidebar.php"; ?>
</div>
<!--/SIDEBAR-->

<!--TEXT-->
<div id="textwrapper">

<h2><?php print title($clean, $resultcount); ?></h2>
<?php if ($resultcount): ?>
<?php print subtitle($clean); ?>
<ul id="browse">
<?php print $SEARCH; ?>
</ul>
<?php else: ?>
<p>There were no results for your search.</p>
<?php endif; ?>

<?php include "includes/footer.php"; ?>
</div>

</div>
<!-- /WRAPPER 2 -->
</div>
<!-- /WRAPPER 1 -->

</body>
</html>
