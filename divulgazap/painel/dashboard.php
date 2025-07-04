<?php
require_once '../includes/auth.php';
require_once '../includes/conexao.php';

$usuario_id = $_SESSION['usuario_id'];
$stmt = $pdo->prepare("SELECT * FROM servicos WHERE usuario_id = :uid ORDER BY data_cadastro DESC");
$stmt->execute([':uid' => $usuario_id]);
$servicos = $stmt->fetchAll();

$stmt_count = $pdo->prepare("SELECT COUNT(*) FROM servicos WHERE usuario_id = :uid");
$stmt_count->execute([':uid' => $usuario_id]);
$total_servicos = $stmt_count->fetchColumn();

$stmt_user = $pdo->prepare("SELECT nome, email FROM usuarios WHERE id = :uid");
$stmt_user->execute([':uid' => $usuario_id]);
$usuario = $stmt_user->fetch();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DivulgaZap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-user">
        <div class="container">
            <a class="navbar-brand-user" href="../home.php">
                <span>Divulga</span>Zap
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarUser">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../home.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../servicos.php">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastrar.php">Anúnciar Serviço</a>
                    </li>
                </ul>
                <div class="user-menu dropdown">
                    <div class="user-name dropdown-toggle" style="color:white" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário') ?>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="dashboard.php">Gerenciar Anúncios</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#logoutModal">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Meus <span>Anúncios</span></h1>
            <a href="cadastrar.php" class="btn-primary-dashboard" style=" text-decoration: none;>
                <i class=" fas fa-plus"></i> Novo Anúncio
            </a>
        </div>
        <div class="services-grid">
            <?php if (empty($servicos)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3 class="empty-title">Nenhum anúncio cadastrado</h3>
                    <p class="empty-text">Você ainda não possui serviços cadastrados. Clique no botão abaixo para criar seu
                        primeiro anúncio.</p>
                    <a href="cadastrar.php" class="btn-primary-dashboard" style=" text-decoration: none;">
                        <i class=" fas fa-plus"></i> Criar Primeiro Anúncio
                    </a>
                </div>
            <?php else: ?>
                <?php foreach ($servicos as $servico): ?>
                    <div class="service-card">
                        <div class="service-image-container">
                            <?php if ($servico['foto_principal']): ?>
                                <img src="data:<?= $servico['tipo_imagem'] ?>;base64,<?= base64_encode($servico['foto_principal']) ?>"
                                    alt="<?= htmlspecialchars($servico['titulo']) ?>" class="service-image">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                    alt="Serviço sem imagem" class="service-image">
                            <?php endif; ?>
                            <span class="service-status">Ativo</span>
                        </div>
                        <div class="service-content">
                            <h3 class="service-title"><?= htmlspecialchars($servico['titulo']) ?></h3>
                            <div class="service-meta">
                                <span class="service-category"><?= $servico['categoria'] ?></span>
                                <span class="service-location">
                                    <i class="fas fa-map-marker-alt"></i> <?= $servico['localizacao'] ?>
                                </span>
                            </div>
                            <p class="service-description"><?= nl2br(htmlspecialchars($servico['descricao'])) ?></p>
                            <div class="service-actions">
                                <a href="editar.php?id=<?= $servico['id'] ?>" class="btn-action btn-edit"
                                    style=" text-decoration: none;">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-service-id="<?= $servico['id'] ?>">
                                    <i class="fas fa-trash-alt"></i> Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <a href="../index.php" class="footer-logo">Divulga<span>Zap</span></a>
                    <p class="mt-3">A plataforma que conecta profissionais locais a clientes em busca de serviços de
                        qualidade.</p>
                    <div class="footer-social mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Links Rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="../home.php" class="text-white">Início</a></li>
                        <li class="mb-2"><a href="../servicos.php" class="text-white">Serviços</a></li>
                        <li><a href="cadastrar.php" class="text-white">Anúnciar Serviços</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contato</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Av. Paulista, 1000 - São Paulo/SP
                        </li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> (11) 9999-9999</li>
                        <li><i class="fas fa-envelope me-2"></i> contato@divulgazap.com</li>
                    </ul>
                </div>
            </div>
            <div class="text-center mt-4 pt-3 border-top border-secondary">
                <p class="mb-0">&copy; <?= date('Y') ?> DivulgaZap. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="logoutModalLabel">Confirmar Saída</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja sair da sua conta?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="../includes/logout.php" class="btn btn-success">Confirmar Saída</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle me-2"></i>
                        Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 text-danger fs-1 me-3">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Tem certeza que deseja excluir este serviço?</h5>
                            <p class="mb-0">Esta ação não pode ser desfeita. Todos os dados deste serviço serão
                                permanentemente removidos.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fas fa-times me-1"></i> Cancelar</button>
                    <form id="deleteForm" method="POST" action="deletar.php">
                        <input type="hidden" name="id" id="deleteId">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt me-1"></i> Excluir
                            Permanentemente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var serviceId = button.getAttribute('data-service-id');
                document.getElementById('deleteId').value = serviceId;
            });
        });
    </script>
</body>

</html>