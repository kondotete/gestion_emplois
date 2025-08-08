<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  
  <xsl:output method="html" encoding="UTF-8" indent="yes" />
  
  <xsl:template match="/classe">
    <html>
      <head>
        <title>Classe - <xsl:value-of select="@filiere" /></title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
      </head>
      <body class="p-8 bg-gray-100">
        <h1 class="text-2xl font-bold mb-4">Filière : <xsl:value-of select="@filiere" /> – Niveau : <xsl:value-of select="@niveau" /></h1>

        <!-- Étudiants -->
        <div class="mb-8">
          <h2 class="text-xl font-semibold mb-2">Étudiants</h2>
          <table class="min-w-full bg-white shadow rounded">
            <thead class="bg-gray-200">
              <tr>
                <th class="p-2 text-left">Numéro</th>
                <th class="p-2 text-left">Nom</th>
                <th class="p-2 text-left">Prénom</th>
              </tr>
            </thead>
            <tbody>
              <xsl:for-each select="etudiants/etudiant">
                <tr class="border-b">
                  <td class="p-2"><xsl:value-of select="@numInscription" /></td>
                  <td class="p-2"><xsl:value-of select="@nom" /></td>
                  <td class="p-2"><xsl:value-of select="@prenom" /></td>
                </tr>
              </xsl:for-each>
            </tbody>
          </table>
        </div>

        <!-- Modules -->
        <div>
          <h2 class="text-xl font-semibold mb-2">Modules</h2>
          <ul class="list-disc list-inside bg-white p-4 rounded shadow">
            <xsl:for-each select="modules/module">
              <li>
                <strong><xsl:value-of select="@idModule" /></strong> – <xsl:value-of select="@nomModule" />
              </li>
            </xsl:for-each>
          </ul>
        </div>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>