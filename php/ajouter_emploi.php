<?php
require 'db.php';
header('Content-Type: application/json; charset=utf-8');

try {
    $id_classe = $_POST['id_classe'] ?? null;
    $id_ens = $_POST['id_ens'] ?? null;
    $id_salle = $_POST['id_salle'] ?? null;
    $id_module = $_POST['id_module'] ?? null;
    $jour = $_POST['jour'] ?? null;
    $heure_debut = $_POST['heure_debut'] ?? null;
    $heure_fin = $_POST['heure_fin'] ?? null;

    // Validation des champs obligatoires
    if (!$id_classe || !$id_ens || !$id_salle || !$id_module || !$jour || !$heure_debut || !$heure_fin) {
        throw new Exception('Tous les champs sont obligatoires');
    }

    // Validation des heures
    if (strtotime($heure_debut) >= strtotime($heure_fin)) {
        throw new Exception('L\'heure de début doit être antérieure à l\'heure de fin');
    }

    // Vérifier les conflits de salle
    $stmtConflitSalle = $pdo->prepare("
        SELECT COUNT(*) as conflicts 
        FROM seances 
        WHERE id_salle = ? 
        AND jour = ? 
        AND (
            (debut <= ? AND fin > ?) OR 
            (debut < ? AND fin >= ?) OR
            (debut >= ? AND fin <= ?)
        )
    ");
    $stmtConflitSalle->execute([
        $id_salle, $jour, 
        $heure_debut, $heure_debut,
        $heure_fin, $heure_fin,
        $heure_debut, $heure_fin
    ]);
    
    if ($stmtConflitSalle->fetch()['conflicts'] > 0) {
        throw new Exception('Conflit détecté : la salle est déjà occupée à cette heure');
    }

    // Vérifier les conflits d'enseignant
    $stmtConflitEns = $pdo->prepare("
        SELECT COUNT(*) as conflicts 
        FROM seances 
        WHERE id_ens = ? 
        AND jour = ? 
        AND (
            (debut <= ? AND fin > ?) OR 
            (debut < ? AND fin >= ?) OR
            (debut >= ? AND fin <= ?)
        )
    ");
    $stmtConflitEns->execute([
        $id_ens, $jour, 
        $heure_debut, $heure_debut,
        $heure_fin, $heure_fin,
        $heure_debut, $heure_fin
    ]);
    
    if ($stmtConflitEns->fetch()['conflicts'] > 0) {
        throw new Exception('Conflit détecté : l\'enseignant a déjà cours à cette heure');
    }

    // Insertion de la séance
    $stmt = $pdo->prepare("
        INSERT INTO seances (id_classe, id_ens, id_salle, idModule, jour, debut, fin)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $id_classe,
        $id_ens,
        $id_salle,
        $id_module,
        $jour,
        $heure_debut,
        $heure_fin
    ]);

    echo json_encode(['success' => true, 'message' => 'Séance ajoutée avec succès']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erreur de base de données: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>