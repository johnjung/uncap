<?php

include 'config.php';

/*
 * INPUT 
 */
$clean = array();
$clean['browse'] = 'collection/UNCAP';
if (isset($_GET['browse'])) {
    if (in_array($_GET['browse'], array('bronzeville', 'cbmr', 'chm',
        'columbia', 'cookcty', 'csu', 'cyc', 'defender', 'depaul',
        'du', 'dusable', 'ehc', 'eta', 'gerhart', 'harsh', 'hwlc',
        'iit', 'ilhs', 'isdsa', 'kart', 'lake', 'lanetech', 'lbp',
        'loyola', 'malcolmx', 'neiu', 'newberry', 'northpark', 'nu',
        'pshs', 'roosevelt', 'rush', 'shorefront', 'spertus', 'sscac',
        'taylor', 'uic', 'uoc', 'werner'))) {
			$clean['browse'] = $_GET['browse'];
			break;
	}
}

/* 
 * FUNCTIONS
 */

function getsnippet($url, $institutions=True) {
    $id = array_pop(explode('#', $url));

	$xml = new DOMDocument();
    if ($institutions) { 
	    $xml->load('xml/institutions.xml');
    } else {
	    $xml->load('xml/collections.xml');
    }

	$xp = new DOMXPath($xml);
	$nl = $xp->query(sprintf("//*[@id='%s']/following-sibling::p/span[@class='snippet']", $id));
	if ($nl->length > 0)
		return sprintf("<p>%s (<a href='%s'>read more...</a>)</p>", $nl->item(0)->nodeValue, $url);
	else
		return "";
}

/*
 * LOAD AND TRANSFORM MARKLOGIC XML
 */

$str = file_get_contents(
	sprintf($MARKLOGIC . "/admin/gimme2.xqy?collection=%s", urlencode($clean['browse']))
);

$str = str_replace(' xmlns="urn:isbn:1-931666-22-9"', '', $str);

$xml = new DOMDocument();
$xml->loadXML($str);

$xsl = new DOMDocument();
if (!$xsl->load('xslt/browse.xsl'))
	die('problem loading XSLT');

$xp = new XSLTProcessor();
$xp->importStyleSheet($xsl);

$BROWSE = $xp->transformToXML($xml);

/*
 * CREATE PAGE TITLE
 */
switch ($clean['browse']) {
	case 'collection/chicago jazz archive':
		$TITLE = "Browse by Collection : Chicago Jazz Archive";
		$SNIPPET = getsnippet("/collections.php#chicagojazzarchive", False);
		break;
	case 'collection/modern poetry':
		$TITLE = "Browse by Collection : Modern Poetry";
		$SNIPPET = getsnippet("/collections.php#contemporarypoetry", False);
		break;
	case 'collection/UNCAP':
		$TITLE = "Browse All Finding Aids";
		$SNIPPET = '';
		break;
	case 'institution/chicago defender':
		$TITLE = "Browse by Institution : Chicago Defender";
		$SNIPPET = getsnippet("/institutions.php#chicagodefender", True);
		break;
	case 'institution/dusable':
		$TITLE = "Browse by Institution : DuSable Museum of African American History";
		$SNIPPET = getsnippet("/institutions.php#dusable", True);
		break;
	case 'institution/Northwestern University':
		$TITLE = "Browse by Institution : Northwestern University";
		$SNIPPET = getsnippet("/institutions.php#northwesternuniversitylibrary", True);
		break;
	case 'institution/sscac':
		$TITLE = "Browse by Institution : South Side Community Art Center";
		$SNIPPET = getsnippet("/institutions.php#sscac", True);
		break;
	case 'institution/University of Chicago':
		$TITLE = "Browse by Institution : University of Chicago Library";
		$SNIPPET = getsnippet("/institutions.php#universityofchicago", True);
		break;
	case 'institution/vivian g harsh':
		$TITLE = "Browse by Institution : Chicago Public Library, Carter G. Woodson Regional Library, Vivian G. Harsh Research Collection of Afro-American History and Literature";
		$SNIPPET = getsnippet("/institutions.php#chicagopubliclibrary", True);
		break;
	case 'project/MTS':
		$TITLE = "Browse by Collection : Mapping the Stacks";
		$SNIPPET = getsnippet("/collections.php#mappingthestacks", False);
		break;
	case 'project/NWU':		
		$TITLE = "Browse by Collection : NWU";
		$SNIPPET = "";
		break;
	case 'project/SCRC':		
		$TITLE = "Browse by Collection : Special Collections Research Center";
		$SNIPPET = getsnippet("/institutions.php#universityofchicago", True);
		break;
}

?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Browse UNCAP</title>
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

<!--TEXT-->
<div id="textwrapper">

<h2><?php print $TITLE; ?></h2>
<?php print $SNIPPET; ?>
<h3>Finding Aids</h3>
<ol id="browse">
<?php print $BROWSE; ?>
</ol>

<?php include "includes/footer.php"; ?>
</div>
<!--TEXT-->

</div>
<!-- /WRAPPER 2 -->
</div>
<!-- /WRAPPER 1 -->

</body>
</html>
