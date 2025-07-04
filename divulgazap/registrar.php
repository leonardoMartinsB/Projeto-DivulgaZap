<?php
session_start();
require 'includes/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $email = strtolower(trim($_POST['email']));
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);

    if ($stmt->rowCount() > 0) {
        $erro = "E-mail já cadastrado.";
    } else {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, telefone, email, senha) VALUES (:nome, :telefone, :email, :senha)");
        $stmt->execute([
            ':nome' => $nome,
            ':telefone' => $telefone,
            ':email' => $email,
            ':senha' => $hash
        ]);

        $_SESSION['usuario_id'] = $pdo->lastInsertId();
        $_SESSION['usuario_nome'] = $nome;

        header('Location: home.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - DivulgaZap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/register.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Divulga<span>Zap</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <main class="register-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="register-card">
                        <div class="register-header">
                            <div class="register-logo">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h1 class="register-title">Crie sua conta</h1>
                            <p class="register-subtitle">Cadastre-se para divulgar seus serviços ou contratar
                                profissionais</p>
                        </div>
                        <?php if ($erro): ?>
                            <div class="alert alert-danger"><?= $erro ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <input type="text" name="nome" placeholder="Nome completo" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="telefone" placeholder="Telefone com DDD" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" placeholder="E-mail" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <input type="password" name="senha" placeholder="Senha (mínimo 6 caracteres)"
                                    class="form-control" required minlength="6">
                            </div>
                            <button type="submit" class="btn btn-register">
                                <i class="fas fa-user-plus me-2"></i>Criar Conta
                            </button>
                        </form>
                        <div class="register-footer">
                            <p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> DivulgaZap. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('input[name="telefone"]').addEventListener('input', function (e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    </script>
</body>

</html>