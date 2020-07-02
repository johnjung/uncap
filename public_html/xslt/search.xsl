<?xml version="1.0"?>

<xsl:stylesheet version="1.0"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output indent="yes" omit-xml-declaration="yes"/>

<!-- PARAMETER: EXACTPHRASE -->
<xsl:param name="exactphrase"/>

<!-- PARAMETER: Q -->
<xsl:param name="q"/>

<xsl:template match="*">
<xsl:apply-templates/>
</xsl:template>

<xsl:template match="div[@class = 'total-number-of-results']"/>

<xsl:template match="div[@class = 'search-results']">
<xsl:for-each select="div[@class = 'search-result' and div[@class = 'eadid']/text()]">
<xsl:sort select="normalize-space(div[@class = 'project'])"/>
<xsl:variable name="eadid" select="div[@class='eadid']"/>
<h3>
<xsl:choose>
	<xsl:when test="$eadid = 'MTS.calloway' or
                        $eadid = 'MTS.defender-individuals' or
	                $eadid = 'MTS.defender-organizations'"><img alt="Chicago Public Library" src="/img/chicagopubliclibrarysmall.gif"/></xsl:when>

	<xsl:when test="$eadid = 'MTS.davis' or
	                $eadid = 'MTS.dunmore' or
	                $eadid = 'MTS.movingimage' or
	                $eadid = 'MTS.rollins'"><img alt="DuSable Museum of African American History" src="/img/dusablesmall.gif"/></xsl:when>

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
	                $eadid = 'MTS.wyatt'"><img alt="Chicago Public Library" src="/img/chicagopubliclibrarysmall.gif"/></xsl:when>

	<xsl:when test="substring($eadid,1,3) = 'inu'">
	  <img alt="Northwestern University Library" src="/img/northwesternsmall.gif"/>
	</xsl:when>

	<xsl:when test="$eadid = 'MTS.sscac'"><img alt="South Side Community Art Center" src="/img/sscacsmall.gif"/></xsl:when>

	<xsl:otherwise><img alt="University of Chicago Library" src="/img/universityofchicagolibrarysmall.gif"/></xsl:otherwise>
</xsl:choose>
<a>
<xsl:attribute name="href">
	<xsl:choose>
		<xsl:when test="$exactphrase = 'on'">
			<xsl:value-of select="concat(
				'view.php?eadid=',
				div[@class = 'eadid'],
				'&amp;q=%22',
				$q,
				'%22'
			)"/>
		</xsl:when>
		<xsl:otherwise>
			<xsl:value-of select="concat(
				'view.php?eadid=',
				div[@class = 'eadid'],
				'&amp;q=',
				$q
			)"/>
		</xsl:otherwise>
	</xsl:choose>
</xsl:attribute>
<xsl:attribute name="target">_blank</xsl:attribute>
<xsl:value-of select="div[@class = 'project']"/>
</a>
</h3>
<p><xsl:value-of select="div[@class = 'abstract']"/></p>
</xsl:for-each>
</xsl:template>

</xsl:stylesheet>
