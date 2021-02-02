<?xml version="1.0"?>

<xsl:stylesheet version="1.0"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output omit-xml-declaration="yes"/>

<!-- PARAMETER: EADID -->
<xsl:param name="eadid"/>

<!-- PARAMETER: Q -->
<xsl:param name="q"/>

<!-- CONTINUE -->
<xsl:template match="dsc//did">
<xsl:apply-templates/>
</xsl:template>

<!-- SKIP -->
<xsl:template match="author | did | eadheader | dsc/head | langmaterial | langusage | publisher"/>

<!-- CONVERT TO P -->
<xsl:template match="address | corpname | geoname | occupation | subject | unitdate">
<p><xsl:apply-templates/></p>
</xsl:template>

	<!-- * --><!-- matches next child element, skipping text nodes, comments, and 
		processing instructions. For every element that doesn’t have a more specific template, 
		the processor will just “keep going”, working it’s way through the element tree.
		This specific template doesn’t output anything, but a more specific template can. -->
<xsl:template match="*">
<xsl:apply-templates/>
</xsl:template>

<!-- ABSTRACT --><!-- wondering if creating a table is the best approach; 
	why not a <div>? -->
<xsl:template match="abstract">
<tr><th>Abstract:</th><td><p><xsl:apply-templates/></p></td></tr>
</xsl:template>

<!-- ADDRESSLINE -->
<xsl:template match="addressline">
<xsl:apply-templates/><br/>
</xsl:template>

<!-- AUTHOR -->
<xsl:template match="author">
<p><xsl:apply-templates/></p>
</xsl:template>

<!-- C## --><!-- creates a series div for each c element, to be followed by
	<p> for each box and folder QQ how does it put c elements in order
	with Box/Folder in order rather than in sequence of  c c c/b b b/f f f? -->
<xsl:template match="
  c[@level] | 
  c01[@level] | c02[@level] | c03[@level] | c04[@level] | c05[@level] | c06[@level] | 
  c07[@level] | c08[@level] | c09[@level] | c10[@level] | c11[@level] | c12[@level]"> 
<div class="series"><xsl:apply-templates/></div>
</xsl:template>

<!-- CONTAINER TYPE BOX -->
<xsl:template match="container[@type='box'] | container[@type='Box']">
<p class="box">Box <xsl:apply-templates/></p>
</xsl:template>

<!-- CONTAINER TYPE FOLDER -->
<xsl:template match="container[@type='folder'] | container[@type='Folder']">
<p class="folder">Folder <xsl:apply-templates/></p>
</xsl:template>

<!-- CONTAINER TYPE OTHERTYPE -->
<xsl:template match="container[@type='othertype']">
<p class="othertype"><xsl:apply-templates/></p>
</xsl:template>

<!-- CONTROLACCESS (subject headings) -->
<xsl:template match="controlaccess">
	<xsl:apply-templates/>
</xsl:template>

<!-- look for how the class "compact" is handled in the CSS -->
	<xsl:template match="controlaccess/corpname | controlaccess/famname | controlaccess/geogname | controlaccess/persname | controlaccess/subject">
	<p class="compact"><xsl:apply-templates/></p>
</xsl:template>

<!-- DAOLOC : totally need this to show where digital collections may be found! -->
<xsl:template match="daoloc">
<p><a href="{@href}"><xsl:value-of select="."/></a></p>
</xsl:template>

<!-- DATE -->
<xsl:template match="date">
<xsl:text> </xsl:text><xsl:apply-templates/>
</xsl:template>

<!-- DID -->
<xsl:template match="did">
<table><xsl:apply-templates/></table>
</xsl:template>

<xsl:template match="dsc//did">
<div class="did"><xsl:apply-templates/></div>
</xsl:template>

<!-- DSC -->
<xsl:template match="dsc">
<h3 id="{generate-id(.)}">INVENTORY</h3><xsl:apply-templates/>
</xsl:template>

<!-- EAD -->
<xsl:template match="ead">
<div id="sidebar">
	<div id="search">
		<div class="bgse">
			<div class="bgsw">
				<div class="bgne">
					<h2 class="bgnw">Search this Finding Aid</h2>
					<form action="view.php" id="searchform" method="get">
						<input name="eadid" type="hidden" value="{$eadid}"/>
						<input name="q" type="text" value="{$q}"/>
						<input type="submit" value="Search"/>
						<p>
							<span class="plainsidebarlink" id="previousmatch">Previous Match</span>
							<span class="plainsidebarlink" id="nextmatch">Next Match</span>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="toc"><div id="tocinner">
		<ul><xsl:apply-templates mode="nav"/></ul>
	</div></div>
</div>
<div id="text"><xsl:apply-templates/></div>
</xsl:template>

<!-- EADID -->
<xsl:template match="eadid"/>

<!-- GEOGNAME -->
<xsl:template match="geogname">
<p><xsl:apply-templates/></p>
</xsl:template>

<!-- HEAD -->
<xsl:template match="head">
<h3 id="{generate-id(.)}"><xsl:apply-templates/></h3>
</xsl:template>

<!-- HIGHLIGHT -->
<xsl:template match="highlight">
<span class="highlight"><xsl:value-of select="."/></span>
</xsl:template>

<!-- ITEM -->
<xsl:template match="item">
<li><xsl:apply-templates/></li>
</xsl:template>

<!-- LIST -->
<xsl:template match="list">
<ul><xsl:apply-templates/></ul>
</xsl:template>

<xsl:template match="dsc//list">
<ul class="bullets"><xsl:apply-templates/></ul>
</xsl:template>

<!-- NOTE -->
<xsl:template match="note">
<xsl:apply-templates/>
</xsl:template>

<xsl:template match="note[@label='Note']">
<tr><th>Note:</th><td><xsl:apply-templates/></td></tr>
</xsl:template>

<!-- ORIGINATION -->
<xsl:template match="origination">
<p class="note"><xsl:apply-templates/></p>
</xsl:template>

<xsl:template match="origination[@label='Collector']">
<tr><th>Collector:</th><td><p><xsl:apply-templates/></p></td></tr>
</xsl:template>

<!-- P -->
<xsl:template match="p">
<xsl:copy><xsl:apply-templates/></xsl:copy>
</xsl:template>

<xsl:template match="dsc//p">
<p class="note"><xsl:apply-templates/></p>
</xsl:template>

<!-- PHYSDESC -->
<xsl:template match="physdesc[@label='Size'] | physdesc[@label='size'] | physdesc[@label='Alternate Extent Statement']">
<tr><th>Size:</th><td><p><xsl:apply-templates/></p></td></tr>
</xsl:template>

<xsl:template match="physdesc">
<p class="note"><xsl:apply-templates/></p>
</xsl:template>

<xsl:template match="physdesc/extent">
<tr><th>Size:</th><td><p><xsl:apply-templates/></p></td></tr>
<!-- <p class="note"><xsl:apply-templates/></p> -->
</xsl:template>

<!-- REPOSITORY -->
<xsl:template match="repository">
<tr><th>Repository:</th><td><xsl:apply-templates/></td></tr>
</xsl:template>

<!-- TITLE -->
<xsl:template match="title[@render='italic']">
<em><xsl:apply-templates/></em>
</xsl:template>

<!-- TITLEPAGE -->
<xsl:template match="titlepage">
<div style="text-align: center;"><xsl:apply-templates/></div>
</xsl:template>

<!-- TITLEPROPER -->
<xsl:template match="titleproper">
<p class="publisher">
<xsl:choose>
	<xsl:when test="$eadid = 'MTS.calloway' or
                    $eadid = 'MTS.defender-individuals' or
	                $eadid = 'MTS.defender-organizations'">
		<p>To order photos from this finding aid, contact the Chicago
		Defender Archives, <a
		href="http://www.chicagodefender.com/index.php/archives-permissions">click
		here</a>.</p>
		<img alt="Chicago Defender" src="/img/defenderlarge.gif"/>
	</xsl:when>
	<xsl:when test="$eadid = 'MTS.davis' or
	                $eadid = 'MTS.dunmore' or
	                $eadid = 'MTS.movingimage' or
	                $eadid = 'MTS.rollins'">
		<p>For information about the DuSable Museum of African American History, visit
		<a href="http://www.dusablemuseum.org/">dusablemuseum.org</a> or email <a
		href="mailto:mts@dusablemuseum.org">mts@dusablemuseum.org</a>.</p>
		<img alt="DuSable Museum of African American History" src="/img/dusablelarge.gif"/>
	</xsl:when>
	<xsl:when test="$eadid = 'MTS.abbottsengstacke' or
	                $eadid = 'MTS.allen' or
	                $eadid = 'MTS.barnett' or
	                $eadid = 'MTS.browning' or
	                $eadid = 'MTS.burns' or
	                $eadid = 'MTS.colter' or
	                $eadid = 'MTS.core' or
	                $eadid = 'MTS.commodore' or
	                $eadid = 'MTS.dickerson' or
	                $eadid = 'MTS.dungill' or
	                $eadid = 'MTS.durham' or
	                $eadid = 'MTS.dyett' or
	                $eadid = 'MTS.hallbranch' or
	                $eadid = 'MTS.heritage' or
	                $eadid = 'MTS.jones' or
	                $eadid = 'MTS.minor' or
	                $eadid = 'MTS.morris' or
	                $eadid = 'MTS.motley' or
	                $eadid = 'MTS.path' or
	                $eadid = 'MTS.sncc' or
	                $eadid = 'MTS.stone' or
	                $eadid = 'MTS.walton' or
	                $eadid = 'MTS.wilson' or
	                $eadid = 'MTS.wyatt'">
		<p>For information about the Harsh Collection, you may <a
		href="http://www.chipublib.org/aboutcpl/ask_a_librarian.php">ask a
		librarian</a> on the <a href="http://www.chipublib.org/">Chicago Public Library
		website</a>.</p>
		<img alt="Chicago Public Library" src="/img/chicagopubliclibrarylarge.gif"/>
	</xsl:when>
	<xsl:when test="substring($eadid,1,3) = 'inu'">
		<p>For information about collections at the Northwestern
		University Library, you may
		<a href="http://www.library.northwestern.edu/archives">visit their
		website</a>.</p>
	  <img alt="Northwestern University Library" src="/img/northwesternlarge.gif"/>
	  <br/>Northwestern University Library
	</xsl:when>
	<xsl:when test="$eadid = 'MTS.sscac'">
		<p>For information about the South Side Community Art Center,
		<a href="http://www.southsidecommunityartcenter.com/">visit their
		website</a>.</p>
		<img alt="South Side Community Art Center" src="/img/sscaclarge.gif"/>
	</xsl:when>
	<xsl:otherwise>
		<p>For information about collections at the University of
		Chicago Library, you may <a href="http://www.lib.uchicago.edu/e/ask/SCRC.html">contact the Special
		Collections Research Center</a>.</p>
		<img alt="University of Chicago Library" src="/img/universityofchicagolibrarylarge.gif"/><br/>
		The University of Chicago Library
	</xsl:otherwise>
</xsl:choose>
</p>
<h1 style="text-align: center;"><xsl:apply-templates/></h1>
</xsl:template>

<!-- TITLESTMT -->
<xsl:template match="titlestmt">
<h3>Title</h3><xsl:value-of select="text()"/>
</xsl:template>

<!-- UNITDATE -->
<xsl:template match="unitdate">
<tr><th>Dates:</th><td><p><xsl:apply-templates/></p></td></tr>
</xsl:template>

<xsl:template match="dsc//unitdate">
<p class="note"><xsl:apply-templates/></p>
</xsl:template>

<!-- UNITID -->
<xsl:template match="unitid">
<!-- <p class="unitid"><xsl:apply-templates/></p> -->
</xsl:template>

<xsl:template match="unitid[@encodinganalog='035']"/>

<!-- UNITTITLE -->
<xsl:template match="unittitle">
<p class="unittitle"><xsl:apply-templates/></p>
</xsl:template>

<xsl:template match="unittitle[@label='Title'] | unittitle[@label='title'] | unittitle[@label='Collection Title']">
<tr><th>Title:</th><td><p><xsl:apply-templates/></p></td></tr>
</xsl:template>

<xsl:template match="archref/unittitle">
<p><xsl:apply-templates/></p>
</xsl:template>

<!-- Northwestern finding aids use level='file' in the inventory. UofC
finding aids omit the level attribute for these finding aids. -->

<xsl:template
 match="
  c[@level and not(@level='file')]/did/unittitle | 
  c01[@level and not(@level='file')]/did/unittitle | c02[@level and not(@level='file')]/did/unittitle |
  c03[@level and not(@level='file')]/did/unittitle | c04[@level and not(@level='file')]/did/unittitle |
  c05[@level and not(@level='file')]/did/unittitle | c06[@level and not(@level='file')]/did/unittitle |
  c07[@level and not(@level='file')]/did/unittitle | c08[@level and not(@level='file')]/did/unittitle |
  c09[@level and not(@level='file')]/did/unittitle | c10[@level and not(@level='file')]/did/unittitle |
  c11[@level and not(@level='file')]/did/unittitle | c12[@level and not(@level='file')]/did/unittitle">
	<h3 id="{generate-id()}"><xsl:apply-templates/></h3>
</xsl:template>

<!-- NAVIGATION -->

<xsl:template match="text()" mode="nav"/>

<xsl:template match="*" mode="nav">
<xsl:apply-templates mode="nav"/>
</xsl:template>

<xsl:template match="dsc" mode="nav">
<xsl:variable name="searchcount"><xsl:if test="count(.//highlight)"><xsl:value-of select="concat(' (', count(.//highlight), ')')"/></xsl:if></xsl:variable>
<li><a href="#{generate-id(.)}"><xsl:value-of select="concat('INVENTORY', $searchcount)"/></a></li><xsl:apply-templates mode="nav"/>
</xsl:template>

<xsl:template match="head" mode="nav">
<xsl:variable name="searchcount"><xsl:if test="count(..//highlight)"><xsl:value-of select="concat(' (', count(..//highlight), ')')"/></xsl:if></xsl:variable>
<li><a href="#{generate-id(.)}"><xsl:value-of select="concat(., $searchcount)"/></a></li>
</xsl:template>

<xsl:template match="descgrp/head" mode="nav"/>

<!-- skip these for finding aids like MTS.abbottsengstacke.xml -->
<xsl:template match="bibliography | dsc/head | scopecontent/head[position() &gt; 1]" mode="nav"/>

<xsl:template 
 match="
  c[not(@level = 'file') and did/unittitle//text()] | 
  c01[not(@level = 'file') and did/unittitle//text()] | c02[not(@level = 'file') and did/unittitle//text()] |
  c03[not(@level = 'file') and did/unittitle//text()] | c04[not(@level = 'file') and did/unittitle//text()] |
  c05[not(@level = 'file') and did/unittitle//text()] | c06[not(@level = 'file') and did/unittitle//text()] |
  c07[not(@level = 'file') and did/unittitle//text()] | c08[not(@level = 'file') and did/unittitle//text()] |
  c09[not(@level = 'file') and did/unittitle//text()] | c10[not(@level = 'file') and did/unittitle//text()] |
  c11[not(@level = 'file') and did/unittitle//text()] | c12[not(@level = 'file') and did/unittitle//text()]" mode="nav"> 
<xsl:variable name="searchcount"><xsl:if test="count(.//highlight)"><xsl:value-of select="concat(' (', count(.//highlight), ')')"/></xsl:if></xsl:variable>
<li><a href="#{generate-id(did/unittitle)}"><xsl:value-of select="concat(did/unittitle, $searchcount)"/></a>
  <xsl:if 
    test="
    descendant::c[not(@level = 'file') and did/unittitle//text()] | 
    descendant::c01[not(@level = 'file') and did/unittitle//text()] | descendant::c02[not(@level = 'file') and did/unittitle//text()] |
    descendant::c03[not(@level = 'file') and did/unittitle//text()] | descendant::c04[not(@level = 'file') and did/unittitle//text()] |
    descendant::c05[not(@level = 'file') and did/unittitle//text()] | descendant::c06[not(@level = 'file') and did/unittitle//text()] |
    descendant::c07[not(@level = 'file') and did/unittitle//text()] | descendant::c08[not(@level = 'file') and did/unittitle//text()] |
    descendant::c09[not(@level = 'file') and did/unittitle//text()] | descendant::c10[not(@level = 'file') and did/unittitle//text()] |
    descendant::c11[not(@level = 'file') and did/unittitle//text()] | descendant::c12[not(@level = 'file') and did/unittitle//text()]"> 
  <ul><xsl:apply-templates mode="nav"/></ul>
  </xsl:if>
</li>
</xsl:template>

<xsl:template name="searchcount">
<xsl:value-of select="concat(' (', count(//highlight), ')')"/>
</xsl:template>

</xsl:stylesheet>
