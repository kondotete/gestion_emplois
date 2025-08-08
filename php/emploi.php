<?php
    require 'db.php';
    header('Content-Type: application/xml');
    ob_clean();
    $classe = $_GET['classe'] ?? '1';

    $stmt = $pdo->prepare("SELECT s.jour, s.debut, s.fin, e.nom_ens, m.nomModule, s.nom_salle
                        FROM seances s
                        JOIN enseignants e ON s.id_ens = s.id_ens
                        JOIN modules m ON e.idModule = m.idModule
                        JOIN salles s ON s.id_salle = s.id_salle
                        WHERE c.ID_CLASSE = ?");
    $stmt->execute([$classe]);
    $cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<emploi classe='CL$classe'>";
    foreach ($seances as $seance) {
        echo "<seance jour='{$seance['jour']}' debut='{$seance['debut']}' fin='{$seance['fin']}' enseignant='{$seance['nom_ens']}' module='{$seance['nomModule']}' salle='{$seance['nom_salle']}'/>";
    }
    echo "</emploi>";
?>
