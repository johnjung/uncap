<?php

include "../config.php";

$clean = array();
if (isset($_GET['eadid'])) {
	$clean['eadid'] = $_GET['eadid'];
}

$HTML = array();
foreach($clean as $k => $v) 
	$HTML[$k] = htmlspecialchars($clean[$k]);

$URL = array();
foreach ($clean as $k => $v) 
	$URL[$k] = urlencode($clean[$k]);

$q = $MARKLOGIC . "/request.xqy?action=get&eadid=ICU.SPCL.BOTANY&format=raw-xml";
$x = fopen($q, 'rb');
$xmlstring = stream_get_contents($x);
fclose($x);

$xml = new DOMDocument();
$xml->loadXML($xmlstring);

$xsl = new DOMDocument();
$xsl->load('xslt/eadnav.xsl');

$xp = new XSLTProcessor();
$xp->importStyleSheet($xsl);

print $xp->transformToXML($xml);
?>
