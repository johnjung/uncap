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
<div class="bgne"><h2 class="bgnw">Browse by Collection</h2></div>

<ul>
<?php foreach (array('bronzeville', 'cbmr', 'chm', 'columbia',
                     'cookcty', 'csu', 'cyc', 'defender', 'depaul',
                     'du', 'dusable', 'ehc', 'eta', 'gerhart', 'harsh',
                     'hwlc', 'iit', 'ilhs', 'isdsa', 'kart', 'lake',
                     'lanetech', 'lbp', 'loyola', 'malcolmx', 'neiu',
                     'newberry', 'northpark', 'nu', 'pshs', 'roosevelt',
                     'rush', 'shorefront', 'spertus', 'sscac', 'taylor',
                     'uic', 'uoc', 'werner') as $collection) { ?>
    <li><a href="/browse.php?browse=<?=$collection?>"><?=$collection?></a></li>
<?php } ?>
</ul>
</div>
</div>
