<?xml version="1.0"?>

<xsl:stylesheet version="1.0"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output indent="yes" omit-xml-declaration="yes"/>

<!-- STOP -->
<xsl:template match="head"/>

<!-- * -->
<xsl:template match="*">
<xsl:apply-templates/>
</xsl:template>

<!-- Northwestern finding aids return three spans. id, filing title, and
     display title. UofC finding aids return two: id and display title. 
     I refer to span[2], span[1], and span[last()] to deal with that. --> 

<!-- BODY -->
<xsl:template match="body">
<xsl:apply-templates select="div">
<xsl:sort select="span[2]"/>
</xsl:apply-templates>
</xsl:template>

<!-- DIV -->
<xsl:template match="div[span/text()]">
<li><a href="/view.php?eadid={span[1]}" target="_blank"><xsl:value-of select="span[2]"/></a></li>
</xsl:template>

</xsl:stylesheet>
