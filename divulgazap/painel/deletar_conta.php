<?php
require_once '../includes/auth.php';
require_once '../includes/conexao.php';

$usuario_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :uid");
$stmt->execute([':uid' => $usuario_id]);

session_unset();
session_destroy();

header('Location: login.php');
exit;
