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
    <h1 class="text-3xl font-bold mb-6">Total d'heures par enseignant</h1>
  
    <div class="bg-white p-6 rounded-lg shadow-md">
      <canvas id="enseignantChart" height="100"></canvas>
    </div>
  </div>

  <script>
    fetch('http://localhost/emploi-du-temps/php/statistiques.php')
      .then(response => response.json())
      .then(data => {
        const labels = data.map(item => item.NOM_PROF);
        const heures = data.map(item => item.heures_totales);

        const ctx = document.getElementById('enseignantChart').getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Heures enseignées',
              data: heures,
              backgroundColor: 'rgba(47, 202, 93, 0.7)',
              borderColor: 'rgba(47, 202, 93, 0.7)',
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { display: true },
              tooltip: { enabled: true }
            },
            scales: {
              y: {
                beginAtZero: true,
                title: { display: true, text: 'Heures' }
              },
              x: {
                title: { display: true, text: 'Enseignants' }
              }
            }
          }
        });
      });
  </script>
</body>
</html>
