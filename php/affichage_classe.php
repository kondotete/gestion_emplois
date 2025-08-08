<?php
if (isset($_GET['classe'])) {
    $classeID = htmlspecialchars($_GET['classe']);
    $xmlUrl = "http://localhost/gestion_emploi/php/classes.php?classe=" . $classeID;

    $xml = new DOMDocument;
    $xml->load($xmlUrl);

    $xsl = new DOMDocument;
    $xsl->load("http://localhost/gestion_emploi/xsl/classe.xsl");

    $proc = new XSLTProcessor();
    $proc->importStylesheet($xsl);

    $output = $proc->transformToXML($xml);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage d'une classe</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 flex">
    <?php require_once "../dashboard.php";?>
    <div class="w-full p-4">
        <h1 class="text-2xl font-bold mb-6">Sélection de classe</h1>

        <form method="GET" class="mb-8">
            <label for="classe" class="block mb-2 font-semibold">Choisissez une classe :</label>
            <select name="classe" id="classe" class="p-2 border rounded shadow">
            <option value="1">classe 1</option>
            <option value="2">classe 2</option>
            </select>
            <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded shadow">Afficher</button>
        </form>

        <?php if (isset($output)) echo $output; ?>
    </div>

</body>
</html>