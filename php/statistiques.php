<?php
require 'db.php';
header('Content-Type: application/json');

$sql = "
    SELECT p.nom ,
        SUM(TIMESTAMPDIFF(HOUR, s.debut, s.fin)) AS heures_totales
    FROM seance s
    JOIN enseignants e ON s.id_seance = s.id_seance
    GROUP BY e.id_ens
";

$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
?>