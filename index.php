<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Emploi du Temps</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-orange-50 flex">
  <?php require_once "dashboard.php";?>
  <div class="flex flex-col w-full p-4">
    <h1 class="text-2xl font-bold mb-6">Emploi du temps</h1>
    
    <!-- Sélecteur de classe -->
    <div class="mb-6">
      <label for="classeSelect" class="block mb-2 font-semibold">Sélectionnez une classe :</label>
      <select id="classeSelect" class="p-2 border rounded shadow">
        <option value="1">AL3</option>
        <option value="2">SRS3</option>
        <option value="3">IA-BD3</option>
      </select>
      <button id="loadEmploi" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-600">
        Charger l'emploi du temps
      </button>
    </div>
    
    <div id="emploiContainer" class="container mx-auto flex flex-col">
      <div class="text-center py-8 text-gray-500">
        <div class="text-4xl mb-4">📅</div>
        <p>Sélectionnez une classe pour voir l'emploi du temps</p>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const classeSelect = document.getElementById('classeSelect');
      const loadButton = document.getElementById('loadEmploi');
      const container = document.getElementById('emploiContainer');

      function loadEmploi(classeId) {
        container.innerHTML = '<div class="text-center py-8"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><p class="mt-2">Chargement...</p></div>';
        
        // Correction du chemin selon votre structure
        fetch(`php/emploi.php?classe=${classeId}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Erreur réseau: ' + response.status);
            }
            return response.text();
          })
          .then(xmlString => {
            const parser = new DOMParser();
            const xml = parser.parseFromString(xmlString, "application/xml");
            
            // Vérifier s'il y a des erreurs de parsing XML
            const parseError = xml.getElementsByTagName('parsererror');
            if (parseError.length > 0) {
              throw new Error('Erreur de parsing XML');
            }
            
            // Charger le XSL
            const xslRequest = new XMLHttpRequest();
            xslRequest.open("GET", "xsl/emploi.xsl", true);
            xslRequest.onreadystatechange = function () {
              if (this.readyState == 4 && this.status == 200) {
                const xsl = parser.parseFromString(this.responseText, "application/xml");
                const xsltProcessor = new XSLTProcessor();
                xsltProcessor.importStylesheet(xsl);
                const resultDocument = xsltProcessor.transformToFragment(xml, document);
                container.innerHTML = '';
                container.appendChild(resultDocument);
              } else if (this.readyState == 4) {
                container.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Erreur lors du chargement du style XSL</div>';
              }
            };
            xslRequest.send();
          })
          .catch(error => {
            console.error('Erreur:', error);
            container.innerHTML = `<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
              <strong>Erreur:</strong> ${error.message}<br>
              <small>Vérifiez que le serveur est démarré et que les chemins sont corrects.</small>
            </div>`;
          });
      }

      loadButton.addEventListener('click', () => {
        const classeId = classeSelect.value;
        loadEmploi(classeId);
      });

      // Charger automatiquement la première classe
      loadEmploi(1);
    });
  </script>
</body>
</html>