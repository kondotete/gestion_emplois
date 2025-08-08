<?php
require 'db.php';
header('Content-Type: application/json');

$id_classe = $_POST['id_classe'] ?? null;
$id_prof = $_POST['id_ens'] ?? null;
$id_salle = $_POST['id_salle'] ?? null;
$id_module = $_POST['idModule'] ?? null;
$jour = $_POST['jour'] ?? null;
$heure_debut = $_POST['debut'] ?? null;
$heure_fin = $_POST['fin'] ?? null;

if (!$id_classe || !$id_ens || !$id_salle || !$id_module || !$jour || !$debut || !$fin) {
    echo json_encode(['success' => false, 'error' => 'Champs requis manquants']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO seances 
        (id_classe, id_ens, id_salle, idModule, jour, debut,  fin)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $id_classe,
        $id_ens,
        $id_salle,
        $id_module,
        $jour,
        $debut,
        $fin
    ]);

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}