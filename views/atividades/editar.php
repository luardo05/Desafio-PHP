<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$id_atividade = $_GET['id'] ?? null;

if (!$id_atividade) {
    header("Location: listar.php");
    exit;
}

$sql = "SELECT * FROM atividades WHERE id = :id AND usuario_id = :usuario_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id_atividade, ':usuario_id' => $usuario_id]);
$atividade = $stmt->fetch();

if (!$atividade) {
    header("Location: listar.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $status = $_POST['status'];

    $sql_update = "UPDATE atividades SET 
                   nome = :nome, 
                   descricao = :descricao, 
                   data_inicio = :data_inicio, 
                   data_fim = :data_fim, 
                   status = :status 
                   WHERE id = :id AND usuario_id = :usuario_id";
    
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':data_inicio' => $data_inicio,
        ':data_fim' => $data_fim,
        ':status' => $status,
        ':id' => $id_atividade,
        ':usuario_id' => $usuario_id
    ]);

    header("Location: listar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Atividade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4>Editar Atividade</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $atividade['nome']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3"><?php echo $atividade['descricao']; ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Início</label>
                            <input type="datetime-local" name="data_inicio" class="form-control" 
                                   value="<?php echo date('Y-m-d\TH:i', strtotime($atividade['data_inicio'])); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Término</label>
                            <input type="datetime-local" name="data_fim" class="form-control" 
                                   value="<?php echo date('Y-m-d\TH:i', strtotime($atividade['data_fim'])); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="pendente" <?php echo $atividade['status'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
                                <option value="concluida" <?php echo $atividade['status'] == 'concluida' ? 'selected' : ''; ?>>Concluída</option>
                                <option value="cancelada" <?php echo $atividade['status'] == 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        <a href="listar.php" class="btn btn-secondary">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>