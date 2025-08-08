<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Nouvelle séance - Emploi du temps</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-orange-100 flex">
    <?php require_once "dashboard.php";?>
    <div class="w-full p-4">
        <h1 class="text-2xl font-bold mb-6">Ajouter une nouvelle séance</h1>
        
        <form id="seanceForm" class="bg-white p-6 rounded shadow-md space-y-4 max-w-2xl mx-auto">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Classe :</label>
                <select name="id_classe" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sélectionnez une classe</option>
                    <option value="1">AL3</option>
                    <option value="2">SRS3</option>
                    <option value="3">IA-BD3</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Enseignant :</label>
                <select name="id_ens" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sélectionnez un enseignant</option>
                    <option value="1">SEWAVI Kofi</option>
                    <option value="2">DUSSEY Amina</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Salle :</label>
                <select name="id_salle" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sélectionnez une salle</option>
                    <option value="1">B-002</option>
                    <option value="2">B-004</option>
                    <option value="3">A-101</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Module :</label>
                <select name="id_module" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sélectionnez un module</option>
                    <option value="M1">JavaEE</option>
                    <option value="M2">C#</option>
                    <option value="M3">POO</option>
                    <option value="M4">Python</option>
                    <option value="M5">Webmastering</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jour :</label>
                <select name="jour" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sélectionnez un jour</option>
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Heure début :</label>
                    <input type="time" name="heure_debut" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Heure fin :</label>
                    <input type="time" name="heure_fin" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-medium transition-colors">
                Ajouter la séance
            </button>
        </form>

        <div id="message" class="mt-6 max-w-2xl mx-auto"></div>
    </div>

    <script>
        document.getElementById('seanceForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const messageDiv = document.getElementById('message');

            // Affichage du loading
            messageDiv.innerHTML = '<div class="text-blue-600 text-center"><div class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div> Ajout en cours...</div>';

            fetch('php/ajouter_emploi.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">✅ ' + (data.message || 'Séance ajoutée avec succès') + '</div>';
                    this.reset();
                } else {
                    messageDiv.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">❌ ' + (data.error || 'Erreur inconnue') + '</div>';
                }
            })
            .catch(err => {
                messageDiv.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">❌ Erreur de connexion au serveur</div>';
                console.error(err);
            });
        });
    </script>
</body>
</html>