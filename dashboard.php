<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Sidebar Responsive</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-orange-100">

  <!-- Sidebar -->
  <div class="md:w-64 w-full md:block hidden bg-white h-screen shadow-md p-4">
    <h2 class="text-2xl font-bold mb-6 text-black-600">Dashboard</h2>
    <nav class="flex flex-col gap-4">
      <a href="index.php" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-black-800 rounded">📅 Emploi du Temps</a>
      <a href="affichage_classe.php" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-black-800 rounded">🎓 Étudiants & Modules</a>
      <a href="statistiques.php" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-black-800 rounded">📊 Statistiques</a>
      <a href="ajouter_emploi.php" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-black-800 rounded">➕ Saisie Séance</a>
    </nav>
  </div>

  <!-- Content -->
  <div class="flex-1 p-6 absolute top-1 left-1">
    <button id="toggleSidebar" class="md:hidden mb-4 bg-blue-500 text-white px-4 py-2 rounded">
      ☰ Menu
    </button>
  </div>

  <!-- Sidebar Mobile -->
  <div id="mobileSidebar" class="fixed inset-0 bg-white z-50 p-6 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden">
    <button id="closeSidebar" class="mb-6 text-red-500 font-bold text-xl">✖</button>
    <nav class="flex flex-col gap-4">
      <a href="#" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-black-800 rounded">📅 Emploi du Temps</a>
      <a href="#" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-black-800 rounded">🎓 Étudiants & Modules</a>
      <a href="#" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-black-800 rounded">📊 Statistiques</a>
      <a href="#" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-black-800 rounded">➕ Saisie Séance</a>
    </nav>
  </div>

  <script>
    const toggleSidebar = document.getElementById('toggleSidebar');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const closeSidebar = document.getElementById('closeSidebar');

    toggleSidebar.addEventListener('click', () => {
      mobileSidebar.classList.remove('-translate-x-full');
    });

    closeSidebar.addEventListener('click', () => {
      mobileSidebar.classList.add('-translate-x-full');
    });
  </script>
</body>
</html>