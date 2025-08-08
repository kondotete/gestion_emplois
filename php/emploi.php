<?php
require 'db.php';
header('Content-Type: application/xml; charset=utf-8');
ob_clean();

$classe = $_GET['classe'] ?? '1';

try {
    // Requête corrigée avec les bons noms de tables et colonnes
    $stmt = $pdo->prepare("
        SELECT s.jour, s.debut, s.fin, e.nom_ens, e.prenom_ens, m.nomModule, sa.nom_salle
        FROM seances s
        JOIN enseignants e ON s.id_ens = e.id_ens
        JOIN modules m ON s.idModule = m.idModule
        JOIN salles sa ON s.id_salle = sa.id_salle
        WHERE s.id_classe = ?
        ORDER BY 
            CASE s.jour 
                WHEN 'Lundi' THEN 1
                WHEN 'Mardi' THEN 2
                WHEN 'Mercredi' THEN 3
                WHEN 'Jeudi' THEN 4
                WHEN 'Vendredi' THEN 5
                WHEN 'Samedi' THEN 6
                ELSE 7
            END,
            s.debut
    ");
    $stmt->execute([$classe]);
    $seances = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer le nom de la classe
    $stmtClasse = $pdo->prepare("
        SELECT c.nom_classe 
        FROM classes c 
        WHERE c.id_classe = ?
    ");
    $stmtClasse->execute([$classe]);
    $classeInfo = $stmtClasse->fetch(PDO::FETCH_ASSOC);
    $nomClasse = $classeInfo ? $classeInfo['nom_classe'] : 'CL' . $classe;

    echo "<?xml version='1.0' encoding='UTF-8'?>\n";
    echo "<emploi classe='" . htmlspecialchars($nomClasse) . "'>\n";
    
    foreach ($seances as $seance) {
        echo "  <seance 
            jour='" . htmlspecialchars($seance['jour']) . "' 
            debut='" . htmlspecialchars($seance['debut']) . "' 
            fin='" . htmlspecialchars($seance['fin']) . "' 
            enseignant='" . htmlspecialchars($seance['nom_ens'] . ' ' . $seance['prenom_ens']) . "' 
            module='" . htmlspecialchars($seance['nomModule']) . "' 
            salle='" . htmlspecialchars($seance['nom_salle']) . "'/>\n";
    }
    
    echo "</emploi>\n";

} catch (PDOException $e) {
    echo "<?xml version='1.0' encoding='UTF-8'?>\n";
    echo "<emploi classe='Erreur'>\n";
    echo "  <!-- Erreur: " . htmlspecialchars($e->getMessage()) . " -->\n";
    echo "</emploi>\n";
}
?>