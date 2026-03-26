<?php
session_start();

require_once '../../config/database.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE login = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':login' => $login]);
    $usuario = $stmt->fetch(); 

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_login'] = $usuario['login'];

        header("Location: ../dashboard.php"); 
        exit;
    } else {
        $erro = "Login ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Agenda PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center">Entrar</h3>
                    
                    <?php if ($erro): ?>
                        <div class="alert alert-danger"><?php echo $erro; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Login</label>
                            <input type="text" name="login" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Entrar</button>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <a href="registrar.php" class="text-decoration-none">Não tem conta? Cadastre-se</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>