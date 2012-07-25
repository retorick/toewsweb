<?xml version="1.0"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/spellcheck/originaltext">
  <html>
  <body>
    <h2>Original</h2>
    <p><xsl:value-of select="text()"/></p>
    <table border="1">
      <tr bgcolor="#9acd32">
      </tr>
    </table>
  </body>
  </html>
</xsl:template>

</xsl:stylesheet>

