<?php

include(__DIR__ . "/../config.php");

$q = $MARKLOGIC . "/admin/gimme.xqy";
$x = fopen($q, 'rb');
$xmlstring = stream_get_contents($x);
fclose($x);

$xml = new DOMDocument();
$xml->loadXML($xmlstring);

$xsl = new DOMDocument();
$xsl->load('xslt/alleadidssidebar.xsl');

$xp = new XSLTProcessor();
$xp->importStyleSheet($xsl);

$ALLFINDINGAIDS = $xp->transformToXML($xml);

?>
<div class="bgse">
<div class="bgsw">
<div class="bgne"><h2 class="bgnw">Search all Finding Aids</h2></div>
<form action="search.php" id="searchform" method="get">
<input id="searchterm" name="q" type="text"/>
<p style="font-size: 13px;"><input name="exactphrase" style="display: inline; width: auto;" type="checkbox" /> search this exact phrase</p>
<input type="submit" value="Search"/>
<p><a href="advancedsearch.html" id="advancedsearchlink">Advanced Search</a></p>
</form>
</div>
</div>

<div class="bgse">
<div class="bgsw">
<div class="bgne"><h2 class="bgnw">Browse by Institution</h2></div>

<ul>
<li><a href="/browse.php?browse=institution/chicago+defender">Chicago Defender</a></li>
<li><a href="/browse.php?browse=institution/dusable">DuSable Museum of African American History</a></li>
<li><a href="/browse.php?browse=institution/vivian+g+harsh">Chicago Public
Library, Carter G. Woodson Regional Library, Vivian G. Harsh Research Collection of
Afro-American History and Literature</a></li>
<li><a href="/browse.php?browse=institution/Northwestern+University">Northwestern University</a></li>
<li><a href="/browse.php?browse=institution/sscac">South Side Community Art Center</a></li>
<li><a href="/browse.php?browse=institution/University+of+Chicago">University of Chicago</a></li>
</ul>
</div>
</div>

<div class="bgse">
<div class="bgsw">
<div class="bgne"><h2 class="bgnw">Browse All Finding Aids</h2></div>

<ul>
<?php print $ALLFINDINGAIDS; ?>
<li><a href="/browse.php">more ...</a></li>
</ul>
</div>
</div>
