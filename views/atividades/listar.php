<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM atividades WHERE usuario_id = :usuario_id ORDER BY data_inicio ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':usuario_id' => $usuario_id]);
$atividades = $stmt->fetchAll(); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Atividades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Minhas Atividades</h2>
            <div>
                <a href="../dashboard.php" class="btn btn-secondary">Voltar</a>
                <a href="criar.php" class="btn btn-primary">+ Nova</a>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Atividade</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($atividades as $ativ): ?>
                        <tr>
                            <td>
                                <strong><?php echo $ativ['nome']; ?></strong><br>
                                <small class="text-muted"><?php echo $ativ['descricao']; ?></small>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($ativ['data_inicio'])); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($ativ['data_fim'])); ?></td>
                            <td>
                                <?php 
                                    $classe = "bg-warning";
                                    if($ativ['status'] == 'concluida') $classe = "bg-success";
                                    if($ativ['status'] == 'cancelada') $classe = "bg-danger";
                                ?>
                                <span class="badge <?php echo $classe; ?>">
                                    <?php echo ucfirst($ativ['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="editar.php?id=<?php echo $ativ['id']; ?>" class="btn btn-sm btn-info text-white">Editar/Status</a>
                                
                                <a href="excluir.php?id=<?php echo $ativ['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (count($atividades) == 0): ?>
                            <tr><td colspan="5" class="text-center">Nenhuma atividade encontrada.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>