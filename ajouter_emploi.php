<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Nouvelle séance - Emploi du temps</title>
<script defer src="assets/js/ajouter_emploi.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-orange-100 flex ">
    <?php require_once "dashboard.php";?>
    <div class="w-full p-4">
        <h1 class="text-2xl font-bold mb-6">Ajouter une nouvelle séance</h1>
    <form onSubmit.prevent id="seanceForm" class="bg-white p-6 rounded shadow-md space-y-4 max-w-2xl mx-auto">
    <div>
        <label class="block">Classe :</label>
        <select name="id_classe" required class="w-full border p-2 rounded">
        <option value="1">AL3</option>
        <option value="2">SRS3</option>
        <option value="2">IA-BD3</option>
        </select>
    </div>

    <div>
        <label class="block">Enseignant :</label>
        <select name="id_ens" required class="w-full border p-2 rounded">
        <option value="1">SEWAVI</option>
        <option value="2">DUSSEY</option>
        </select>
    </div>

    <div>
        <label class="block">Salle :</label>
        <select name="id_salle" required class="w-full border p-2 rounded">
        <option value="1">Salle B-002</option>
        <option value="2">Salle B-004</option>
        </select>
    </div>

    <div>
        <label class="block">Module :</label>
        <select name="id_module" required class="w-full border p-2 rounded">
        <option value="M1">JavaEE</option>
        <option value="M2">C#</option>
        <option value="M3">POO</option>
        <option value="M4">Python</option>
        <option value="M5">Webmastering</option>
        </select>
    </div>

    <div>
        <label class="block">Jour :</label>
        <select name="jour" required class="w-full border p-2 rounded">
        <option value="Lundi">Lundi</option>
        <option value="Mardi">Mardi</option>
        <option value="Mercredi">Mercredi</option>
        <option value="Jeudi">Jeudi</option>
        <option value="Vendredi">Vendredi</option>
        <option value="Samedi">Samedi</option>
        <!-- etc. -->
        </select>
    </div>

    <div>
        <label class="block">Heure début :</label>
        <input type="time" name="heure_debut" required class="w-full border p-2 rounded">
    </div>

    <div>
        <label class="block">Heure fin :</label>
        <input type="time" name="heure_fin" required class="w-full border p-2 rounded">
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Ajouter la séance</button>
    </form>

    <div id="message" class="mt-6 max-w-lg mx-auto"></div>
    </div>
</body>
</html>