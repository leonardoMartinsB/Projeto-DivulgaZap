<?php
require_once 'includes/conexao.php';
require_once 'includes/auth.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: services.php");
    exit();
}

$servico_id = intval($_GET['id']);

try {
    $sql = "SELECT s.*, u.nome as prestador, u.telefone, u.email
            FROM servicos s
            JOIN usuarios u ON s.usuario_id = u.id
            WHERE s.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$servico_id]);
    $servico = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$servico) {
        header("Location: services.php");
        exit();
    }
} catch (PDOException $e) {
    die("Erro ao buscar serviço: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($servico['titulo']) ?> | DivulgaZap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/servico_detalhe.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-user">
        <div class="container">
            <a class="navbar-brand-user" href="home.php">
                <span>Divulga</span>Zap
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarUser">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="servicos.php">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="painel/cadastrar.php">Anúnciar Serviço</a>
                    </li>
                </ul>
            </div>
            <div class="user-menu dropdown">
                <div class="user-name dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="cursor: pointer; color: white !important; font-size: 1rem;">
                    <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                </div>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="painel/dashboard.php">Gerenciar Anúncios</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <a href="servicos.php" class="back-link primary mb-3 d-inline-block">
            <i class="fas fa-arrow-left"></i> Voltar para serviços
        </a>
        <div class="service-header">
            <div class="row">
                <div class="col-md-8">
                    <h1><?= htmlspecialchars($servico['titulo']) ?></h1>
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge badge-category"><?= htmlspecialchars($servico['categoria']) ?></span>
                        <span class="badge badge-location">
                            <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($servico['localizacao']) ?>
                        </span>
                    </div>
                    <p class="lead"><?= nl2br(htmlspecialchars($servico['descricao'])) ?></p>
                </div>
                <div class="col-md-4">
                    <?php if ($servico['foto_principal']): ?>
                        <img src="data:<?= $servico['tipo_imagem'] ?>;base64,<?= base64_encode($servico['foto_principal']) ?>"
                            class="service-image" alt="<?= htmlspecialchars($servico['titulo']) ?>">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/400x300?text=Sem+Imagem" class="service-image"
                            alt="Sem imagem">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="service-details-card p-4 mb-4">
                    <h3 class="h4 mb-4">Sobre este serviço</h3>
                    <div class="mb-4">
                        <h4 class="h5">Informações adicionais</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-calendar"></i> Data de cadastro</span>
                                <span><?= date('d/m/Y', strtotime($servico['data_cadastro'])) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-tag"></i> Categoria</span>
                                <span><?= htmlspecialchars($servico['categoria']) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-geo-alt"></i> Localização</span>
                                <span><?= htmlspecialchars($servico['localizacao']) ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="contact-card mb-4">
                    <h3 class="h4 mb-4">Contato</h3>
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <i class="bi bi-person-circle fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0"><?= htmlspecialchars($servico['prestador']) ?></h5>
                            <small class="text-muted">Prestador do serviço</small>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-telephone me-2"></i>
                            <?= htmlspecialchars($servico['telefone']) ?>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-envelope me-2"></i>
                            <?= htmlspecialchars($servico['email']) ?>
                        </li>
                    </ul>

                    <a href="https://wa.me/55<?= preg_replace('/[^0-9]/', '', $servico['telefone']) ?>?text=Olá%20<?= urlencode($servico['prestador']) ?>%20,%20vi%20seu%20serviço%20no%20DivulgaZap%20e%20gostaria%20de%20mais%20informações%20sobre%20<?= urlencode($servico['titulo']) ?>"
                        class="btn btn-whatsapp w-100" target="_blank">
                        <i class="bi bi-whatsapp"></i> Contatar via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <a href="index.php" class="footer-logo" style=" text-decoration: none;">Divulga<span>Zap</span></a>
                    <p>A plataforma que conecta profissionais locais a clientes em busca de serviços de qualidade, tudo
                        de forma simples e direta pelo WhatsApp.</p>
                    <div class="footer-social">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div class="footer-links">
                    <h3 class="footer-title">Links Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="home.php"><i class="fas fa-chevron-right"></i> Início</a></li>
                        <li><a href="servicos.php"><i class="fas fa-chevron-right"></i> Serviços</a></li>
                        <li><a href="painel/cadastrar.php"><i class="fas fa-chevron-right"></i> Anúnciar Serviços</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h3 class="footer-title">Contato</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Av. Paulista, 1000 - São Paulo/SP</p>
                    <p><i class="fas fa-phone-alt"></i> (11) 9999-9999</p>
                    <p><i class="fas fa-envelope"></i> contato@divulgazap.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> DivulgaZap. Todos os direitos reservados.</p>
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
                    <a href="includes/logout.php" class="btn btn-success">Confirmar Saída</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>

</html>