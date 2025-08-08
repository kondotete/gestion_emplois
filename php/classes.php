<?php
require 'db.php';
header('Content-Type: application/xml; charset=utf-8');
ob_clean();

$classeID = $_GET['classe'] ?? '1';

try {
    // Requête 1 : infos classe
    $stmt = $pdo->prepare("
        SELECT c.niveau, c.nom_classe, f.nom_filiere
        FROM classes c
        JOIN filieres f ON c.id_filiere = f.id_filiere
        WHERE c.id_classe = ?
    ");
    $stmt->execute([$classeID]);
    $classe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$classe) {
        throw new Exception("Classe introuvable");
    }

    // Requête 2 : étudiants
    $stmt = $pdo->prepare("
        SELECT et.num_inscription, et.nom, et.prenom
        FROM etudiants et
        WHERE et.id_classe = ?
        ORDER BY et.nom, et.prenom
    ");
    $stmt->execute([$classeID]);
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Requête 3 : modules
    $stmt = $pdo->prepare("
        SELECT DISTINCT m.idModule, m.nomModule
        FROM seances s
        JOIN modules m ON s.idModule = m.idModule
        WHERE s.id_classe = ?
        ORDER BY m.idModule
    ");
    $stmt->execute([$classeID]);
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Génération du XML
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<classe filiere=\"" . htmlspecialchars($classe['nom_filiere']) . "\" niveau=\"" . htmlspecialchars($classe['niveau']) . "\" nom=\"" . htmlspecialchars($classe['nom_classe']) . "\">\n";

    // Bloc étudiants
    echo "  <etudiants>\n";
    foreach ($etudiants as $etudiant) {
        echo "    <etudiant numInscription=\"" . htmlspecialchars($etudiant['num_inscription']) . "\" nom=\"" . htmlspecialchars($etudiant['nom']) . "\" prenom=\"" . htmlspecialchars($etudiant['prenom']) . "\"/>\n";
    }
    echo "  </etudiants>\n";

    // Bloc modules
    echo "  <modules>\n";
    foreach ($modules as $module) {
        echo "    <module idModule=\"" . htmlspecialchars($module['idModule']) . "\" nomModule=\"" . htmlspecialchars($module['nomModule']) . "\"/>\n";
    }
    echo "  </modules>\n";

    echo "</classe>\n";

} catch (Exception $e) {
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<classe filiere=\"Erreur\" niveau=\"0\" nom=\"Erreur\">\n";
    echo "  <etudiants></etudiants>\n";
    echo "  <modules></modules>\n";
    echo "  <!-- Erreur: " . htmlspecialchars($e->getMessage()) . " -->\n";
    echo "</classe>\n";
}
?>