<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $status = 'pendente'; 
    $usuario_id = $_SESSION['usuario_id']; 

    $sql = "INSERT INTO atividades (usuario_id, nome, descricao, data_inicio, data_fim, status) 
            VALUES (:usuario_id, :nome, :descricao, :data_inicio, :data_fim, :status)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':data_inicio' => $data_inicio,
        ':data_fim' => $data_fim,
        ':status' => $status
    ]);

    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Atividade - Agenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Nova Atividade</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome da Atividade</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data/Hora Início</label>
                            <input type="datetime-local" name="data_inicio" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data/Hora Término</label>
                            <input type="datetime-local" name="data_fim" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Salvar Atividade</button>
                        <a href="../dashboard.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>