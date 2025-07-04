<?php
require_once '../includes/auth.php';
require_once '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $usuario_id = $_SESSION['usuario_id'];

    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM servicos WHERE id = :id AND usuario_id = :uid");
            $stmt->execute([':id' => $id, ':uid' => $usuario_id]);

            $_SESSION['sucesso'] = "Serviço excluído com sucesso!";
        } catch (PDOException $e) {
            $_SESSION['erro'] = "Erro ao excluir serviço: " . $e->getMessage();
        }
    }

    header('Location: dashboard.php');
    exit;
}
?>