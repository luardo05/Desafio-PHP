<?php
session_start();
require_once '../../config/database.php';


if (!isset($_SESSION['usuario_id'])) {
    exit("Acesso negado");
}

$id = $_GET['id']; 
$usuario_id = $_SESSION['usuario_id'];

$sql = "DELETE FROM atividades WHERE id = :id AND usuario_id = :usuario_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id' => $id,
    ':usuario_id' => $usuario_id
]);

header("Location: listar.php");
exit;