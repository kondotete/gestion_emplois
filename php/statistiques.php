<?php
require 'db.php';
header('Content-Type: application/json; charset=utf-8');

try {
    $sql = "
        SELECT 
            CONCAT(e.nom_ens, ' ', e.prenom_ens) AS nom_prof,
            SUM(
                TIME_TO_SEC(TIMEDIFF(s.fin, s.debut)) / 3600
            ) AS heures_totales
        FROM seances s
        JOIN enseignants e ON s.id_ens = e.id_ens
        GROUP BY e.id_ens, e.nom_ens, e.prenom_ens
        ORDER BY heures_totales DESC
    ";

    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Formatage des données pour le graphique
    $result = [];
    foreach ($data as $row) {
        $result[] = [
            'nom_prof' => $row['nom_prof'],
            'heures_totales' => round($row['heures_totales'], 2)
        ];
    }

    echo json_encode($result);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de base de données: ' . $e->getMessage()]);
}
?>