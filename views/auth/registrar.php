<?php
require_once '../../config/database.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if (empty($login) || empty($senha)) {
        $mensagem = "Preencha todos os campos!";
    } else {
        $senha_segura = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO usuarios (login, senha) VALUES (:login, :senha)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':login' => $login,
                ':senha' => $senha_segura
            ]);

            $mensagem = "Usuário cadastrado com sucesso! <a href='login.php'>Ir para Login</a>";
        } catch (PDOException $e) {
            $mensagem = "Erro: Este login já existe.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Agenda PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center">Criar Conta</h3>
                    
                    <?php if ($mensagem): ?>
                        <div class="alert alert-info"><?php echo $mensagem; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Usuário</label>
                            <input type="text" name="login" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <a href="http://localhost/agenda/views/auth/login.php">Já tem conta? Faça Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>