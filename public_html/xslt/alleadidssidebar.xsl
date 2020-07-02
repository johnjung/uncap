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

<!-- BODY -->
<xsl:template match="body">
<xsl:apply-templates select="div">
<!--<xsl:sort select="."/>-->
</xsl:apply-templates>
</xsl:template>

<!-- DIV -->
<xsl:template match="div">
<xsl:if test="position() &lt; 4"><li><a href="/view.php?eadid={span[1]}"><xsl:value-of select="span[2]"/></a></li></xsl:if>
</xsl:template>

</xsl:stylesheet>
