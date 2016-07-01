<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
	<ul>
		<xsl:for-each select="menu/opcao">
			<li>
				<xsl:if test="opcao">
					<xsl:attribute name="class">has-sub</xsl:attribute>
				</xsl:if>
				<xsl:choose>
					<xsl:when test="position() = last()"><xsl:attribute name="class">last</xsl:attribute></xsl:when>
				</xsl:choose>
				<a>
					<xsl:attribute name="href"><xsl:value-of select="@link" /></xsl:attribute>
					<span><xsl:value-of select="@nome"/></span>
				</a>
				<ul>
				<xsl:for-each select="opcao">
					<li>
						<xsl:choose>
							<xsl:when test="position() = last()"><xsl:attribute name="class">last</xsl:attribute></xsl:when>
						</xsl:choose>
						<a>
							<xsl:attribute name="href"><xsl:value-of select="@link" /></xsl:attribute>
							<span><xsl:value-of select="@nome"/></span>
						</a>
					</li>
				</xsl:for-each>
				</ul>
			</li>
		</xsl:for-each>
	</ul>
</xsl:template>
</xsl:stylesheet>