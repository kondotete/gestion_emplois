<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Statistiques Enseignants</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-orange-100 flex">
  <?php require_once "dashboard.php";?>
  <div class="w-full p-4">
    <h1 class="text-3xl font-bold mb-6">Statistiques des enseignants</h1>
  
    <div class="bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-xl font-semibold mb-4">Total d'heures par enseignant</h2>
      <div id="loadingStats" class="text-center py-8">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <p class="mt-2">Chargement des statistiques...</p>
      </div>
      <canvas id="enseignantChart" height="100" style="display: none;"></canvas>
      <div id="errorStats" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"></div>
    </div>
    
    <!-- Tableau des détails -->
    <div id="statsTable" class="mt-6 bg-white p-6 rounded-lg shadow-md" style="display: none;">
      <h3 class="text-lg font-semibold mb-4">Détails par enseignant</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
          <thead>
            <tr class="bg-gray-100">
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b">Enseignant</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b">Total d'heures</th>
            </tr>
          </thead>
          <tbody id="statsTableBody">
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    // Fonction pour charger les statistiques
    function loadStatistics() {
      fetch('php/statistiques.php')
        .then(response => {
          if (!response.ok) {
            throw new Error('Erreur réseau: ' + response.status);
          }
          return response.json();
        })
        .then(data => {
          console.log('Données reçues:', data);
          
          if (data.error) {
            throw new Error(data.error);
          }
          
          if (!Array.isArray(data) || data.length === 0) {
            throw new Error('Aucune donnée disponible');
          }

          // Masquer le loading
          document.getElementById('loadingStats').style.display = 'none';
          
          // Afficher le graphique
          document.getElementById('enseignantChart').style.display = 'block';
          document.getElementById('statsTable').style.display = 'block';

          // Préparer les données pour le graphique
          const labels = data.map(item => item.nom_prof);
          const heures = data.map(item => parseFloat(item.heures_totales));

          // Créer le graphique
          const ctx = document.getElementById('enseignantChart').getContext('2d');
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: labels,
              datasets: [{
                label: 'Heures enseignées',
                data: heures,
                backgroundColor: 'rgba(34, 197, 94, 0.7)',
                borderColor: 'rgba(34, 197, 94, 1)',
                borderWidth: 2,
                borderRadius: 4,
                borderSkipped: false,
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: { 
                  display: true,
                  position: 'top'
                },
                tooltip: { 
                  enabled: true,
                  callbacks: {
                    label: function(context) {
                      return context.dataset.label + ': ' + context.parsed.y + 'h';
                    }
                  }
                }
              },
              scales: {
                y: {
                  beginAtZero: true,
                  title: { 
                    display: true, 
                    text: 'Nombre d\'heures' 
                  },
                  ticks: {
                    callback: function(value) {
                      return value + 'h';
                    }
                  }
                },
                x: {
                  title: { 
                    display: true, 
                    text: 'Enseignants' 
                  }
                }
              }
            }
          });

          // Remplir le tableau des détails
          const tableBody = document.getElementById('statsTableBody');
          tableBody.innerHTML = '';
          
          data.forEach(item => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';
            row.innerHTML = `
              <td class="px-4 py-3 border-b text-sm font-medium">${item.nom_prof}</td>
              <td class="px-4 py-3 border-b text-sm">
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                  ${parseFloat(item.heures_totales).toFixed(1)}h
                </span>
              </td>
            `;
            tableBody.appendChild(row);
          });
        })
        .catch(error => {
          console.error('Erreur:', error);
          document.getElementById('loadingStats').style.display = 'none';
          const errorDiv = document.getElementById('errorStats');
          errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
          errorDiv.innerHTML = `<strong>Erreur:</strong> ${error.message}`;
          errorDiv.style.display = 'block';
        });
    }

    // Charger les statistiques au chargement de la page
    document.addEventListener('DOMContentLoaded', loadStatistics);
  </script>
</body>
</html>