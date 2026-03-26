<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT id, nome as title, data_inicio as start, data_fim as end, status FROM atividades WHERE usuario_id = :usuario_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':usuario_id' => $usuario_id]);
$atividades = $stmt->fetchAll();

$eventos = [];
foreach ($atividades as $ativ) {
    $cor = '#f0ad4e'; 
    if ($ativ['status'] == 'concluida') $cor = '#28a745'; 
    if ($ativ['status'] == 'cancelada') $cor = '#dc3545'; 

    $eventos[] = [
        'id'    => $ativ['id'],
        'title' => $ativ['title'],
        'start' => $ativ['start'],
        'end'   => $ativ['end'],
        'color' => $cor
    ];
}

echo json_encode($eventos);