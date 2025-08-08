<?php
$output = '';
$error = '';

if (isset($_GET['classe'])) {
    $classeID = htmlspecialchars($_GET['classe']);
    
    // Correction des chemins - adapter selon votre structure
    $xmlUrl = "http://localhost/gestion/gestion_emplois-IA/php/classes.php?classe=" . $classeID;
    $xslPath = __DIR__ . "/xsl/classe.xsl"; // Chemin local vers le fichier XSL
    
    try {
        // Chargement du XML depuis l'URL
        $xml = new DOMDocument();
        $xml->load($xmlUrl);
        
        // Vérification si le fichier XSL existe localement
        if (!file_exists($xslPath)) {
            throw new Exception("Fichier XSL introuvable : " . $xslPath);
        }
        
        // Chargement du XSL depuis le fichier local
        $xsl = new DOMDocument();
        $xsl->load($xslPath);
        
        // Traitement XSLT
        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);
        $output = $proc->transformToXML($xml);
        
    } catch (Exception $e) {
        $error = "Erreur lors du traitement : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Affichage d'une classe</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-orange-50 flex">
  <?php require_once "dashboard.php";?>
    <div class="w-full p-4">
        <h1 class="text-2xl font-bold mb-6">Sélection de classe</h1>

        <form method="GET" class="mb-8">
            <label for="classe" class="block mb-2 font-semibold">Choisissez une classe :</label>
            <select name="classe" id="classe" class="p-2 border rounded shadow">
                <option value="">Sélectionnez une classe</option>
                <option value="1" <?= isset($_GET['classe']) && $_GET['classe'] == '1' ? 'selected' : '' ?>>AL3</option>
                <option value="2" <?= isset($_GET['classe']) && $_GET['classe'] == '2' ? 'selected' : '' ?>>SRS3</option>
                <option value="3" <?= isset($_GET['classe']) && $_GET['classe'] == '3' ? 'selected' : '' ?>>IA-BD3</option>
            </select>
            <button type="submit" class="ml-4 px-4 py-2 bg-green-500 text-white rounded shadow hover:bg-green-600">Afficher</button>
        </form>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Erreur :</strong> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($output): ?>
            <div class="mt-6">
                <?= $output ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>