<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" encoding="UTF-8" indent="yes"/>
  
  <xsl:template match="/">
    <div class="bg-white rounded-lg shadow-md p-6">
      <h2 class="text-2xl font-bold mb-4 text-gray-800">
        Emploi du temps - <xsl:value-of select="emploi/@classe"/>
      </h2>
      
      <xsl:choose>
        <xsl:when test="emploi/seance">
          <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
              <thead>
                <tr class="bg-gray-100">
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b">Jour</th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b">Horaire</th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b">Module</th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b">Enseignant</th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b">Salle</th>
                </tr>
              </thead>
              <tbody>
                <xsl:for-each select="emploi/seance">
                  <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 border-b text-sm">
                      <span class="font-medium text-blue-600">
                        <xsl:value-of select="@jour"/>
                      </span>
                    </td>
                    <td class="px-4 py-3 border-b text-sm">
                      <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                        <xsl:value-of select="substring(@debut, 1, 5)"/> - <xsl:value-of select="substring(@fin, 1, 5)"/>
                      </span>
                    </td>
                    <td class="px-4 py-3 border-b text-sm font-medium">
                      <xsl:value-of select="@module"/>
                    </td>
                    <td class="px-4 py-3 border-b text-sm">
                      <xsl:value-of select="@enseignant"/>
                    </td>
                    <td class="px-4 py-3 border-b text-sm">
                      <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                        <xsl:value-of select="@salle"/>
                      </span>
                    </td>
                  </tr>
                </xsl:for-each>
              </tbody>
            </table>
          </div>
          <div class="mt-4 text-sm text-gray-600">
            Total: <xsl:value-of select="count(emploi/seance)"/> séance(s)
          </div>
        </xsl:when>
        <xsl:otherwise>
          <div class="text-center py-8">
            <div class="text-gray-400 text-6xl mb-4">📅</div>
            <p class="text-gray-600 text-lg">Aucune séance programmée pour cette classe</p>
          </div>
        </xsl:otherwise>
      </xsl:choose>
    </div>
  </xsl:template>
</xsl:stylesheet>