<?php

include "config.php";

$clean = array();
if (isset($_GET['eadid'])) 
	$clean['eadid'] = $_GET['eadid'];
if (isset($_GET['q']))
	$clean['q'] = $_GET['q'];
if (isset($_GET['xml']))
	$clean['xml'] = true;

$HTML = array();
foreach($clean as $k => $v) 
	$HTML[$k] = htmlspecialchars($clean[$k]);

$URL = array();
foreach ($clean as $k => $v) 
	$URL[$k] = urlencode($clean[$k]);

if (!(array_key_exists('q', $URL))) {
    $URL['q'] = '';
}

$x = fopen(sprintf('%s/request.xqy?action=get&format=raw-xml&eadid=%s&q=%s', $MARKLOGIC, $URL['eadid'], $URL['q']), 'rb');
$xmlstring = stream_get_contents($x);
fclose($x);

$xmlstring = str_replace(' xmlns="urn:isbn:1-931666-22-9"', '', $xmlstring);

if (array_key_exists('xml', $clean))
	die($xmlstring);

$xml = new DOMDocument();
$xml->loadXML($xmlstring);

/* Extract the title from the XML string. */
$xp = new DOMXPath($xml);
$nl = $xp->query("//frontmatter/titlepage/titleproper");
$PAGETITLE = 'UNCAP';
if ($nl->length) {
	$PAGETITLE .= ': ' . $nl->item(0)->nodeValue;
}

$xsl = new DOMDocument();
$xsl->load('xslt/view.xsl');

$xp = new XSLTProcessor();
$xp->importStyleSheet($xsl);
$xp->setParameter('', 'eadid', $clean['eadid']);

if (array_key_exists('q', $clean)) {
    $xp->setParameter('', 'q', $clean['q']);
}

$EAD = $xp->transformToXML($xml);
?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title><?php print $PAGETITLE; ?></title>
<?php include "includes/headview.php"; ?>
</head>
<body id="ead">
<!--HEADER-->
<div id="header"><?php include "includes/header.php"; ?></div>

<!--SIDEBAR AND TEXT-->
<?php print $EAD; ?>

</body>
</html>
