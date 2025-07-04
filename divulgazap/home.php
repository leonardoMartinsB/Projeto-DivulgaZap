<?php
include 'includes/auth.php';
include 'includes/conexao.php';

$usuario_id = $_SESSION['usuario_id'];
$stmt_user_ads = $pdo->prepare("SELECT * FROM servicos WHERE usuario_id = ? ORDER BY data_cadastro DESC LIMIT 3");
$stmt_user_ads->execute([$usuario_id]);
$user_ads = $stmt_user_ads->fetchAll(PDO::FETCH_ASSOC);

$stmt_all_ads = $pdo->prepare("SELECT s.*, u.nome as usuario_nome FROM servicos s 
                                JOIN usuarios u ON s.usuario_id = u.id 
                                WHERE s.usuario_id != ? 
                                ORDER BY s.data_cadastro DESC LIMIT 3");
$stmt_all_ads->execute([$usuario_id]);
$all_ads = $stmt_all_ads->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - DivulgaZap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/home.css">
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
                    aria-expanded="false" style="cursor:pointer;">
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
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirmar Saída</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja sair da sua conta?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="includes/logout.php" class="btn btn-primary">Confirmar Saída</a>
                </div>
            </div>
        </div>
    </div>
    <section class="welcome-section">
        <div class="container">
            <div class="welcome-content" data-aos="fade-up">
                <h1 class="welcome-title">Bem-vindo, <span><?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>!
                </h1>
                <p class="welcome-subtitle">Agora você pode divulgar seus serviços ou encontrar profissionais
                    qualificados com facilidade.</p>
                <div class="welcome-cta">
                </div>
            </div>
        </div>
    </section>
    <section class="dashboard-section bg-light">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Seus Anúncios Recentes</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Seus 3 serviços mais recentes</p>
            <div class="services-grid">
                <?php if (count($user_ads) > 0): ?>
                    <?php foreach ($user_ads as $ad): ?>
                        <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                            <div class="service-badge">Ativo</div>
                            <?php if ($ad['foto_principal']): ?>
                                <img src="data:<?= $ad['tipo_imagem'] ?>;base64,<?= base64_encode($ad['foto_principal']) ?>"
                                    alt="<?= htmlspecialchars($ad['titulo']) ?>" class="service-image">
                            <?php else: ?>
                                <img src="assets/images/default-service.jpg" alt="Serviço sem imagem" class="service-image">
                            <?php endif; ?>
                            <div class="service-content">
                                <h3 class="service-title"><?= htmlspecialchars($ad['titulo']) ?></h3>
                                <p class="service-description"><?= htmlspecialchars($ad['descricao']) ?></p>
                                <div class="service-meta">
                                    <span class="service-location"><i class="fas fa-map-marker-alt"></i>
                                        <?= htmlspecialchars($ad['localizacao']) ?></span>
                                </div>
                                <div class="service-actions">
                                    <a href="servico.php?id=<?= $ad['id'] ?>" class="btn btn-service btn-service-primary">
                                        <i class="fas fa-eye"></i> Visualizar
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center" data-aos="fade-up">
                        <p>Você ainda não tem anúncios cadastrados.</p>
                        <a href="painel/cadastrar.php" class="btn btn-welcome btn-welcome-primary">
                            <i class="fas fa-plus"></i> Criar Primeiro Anúncio
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (count($user_ads) > 0): ?>
                <div class="row mt-4">
                    <div class="col-md-6" data-aos="fade-up">
                        <a href="painel/cadastrar.php" class="btn btn-welcome btn-welcome-primary">
                            <i class="fas fa-plus"></i> Adicionar Novo Anúncio
                        </a>
                    </div>
                    <div class="col-md-6 text-md-end" data-aos="fade-up">
                        <a href="painel/dashboard.php" class="btn btn-welcome btn-welcome-outline"
                            style="border-color: var(--verde-primario); color: var(--verde-primario);">
                            <i class="fas fa-list"></i> Ver Todos Anúncios
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <section class="dashboard-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Todos os Serviços</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Profissionais que podem te ajudar</p>
            <div class="services-grid">
                <?php if (count($all_ads) > 0): ?>
                    <?php foreach ($all_ads as $ad): ?>
                        <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                            <?php if ($ad['foto_principal']): ?>
                                <img src="data:<?= $ad['tipo_imagem'] ?>;base64,<?= base64_encode($ad['foto_principal']) ?>"
                                    alt="<?= htmlspecialchars($ad['titulo']) ?>" class="service-image">
                            <?php else: ?>
                                <img src="assets/images/default-service.jpg" alt="Serviço sem imagem" class="service-image">
                            <?php endif; ?>
                            <div class="service-content">
                                <h3 class="service-title"><?= htmlspecialchars($ad['titulo']) ?></h3>
                                <p class="service-description"><?= htmlspecialchars($ad['descricao']) ?></p>
                                <div class="service-meta">
                                    <span class="service-location"><i class="fas fa-map-marker-alt"></i>
                                        <?= htmlspecialchars($ad['localizacao']) ?></span>
                                    <span class="service-provider"><i class="fas fa-user"></i>
                                        <?= htmlspecialchars($ad['usuario_nome']) ?></span>
                                </div>
                                <a href="servicos-detalhes.php?id=<?= $ad['id'] ?>" class="btn btn-service btn-service-primary"
                                    style="width: 100%;">
                                    <i class="fas fa-eye"></i> Visualizar Serviço
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center" data-aos="fade-up">
                        <p>Nenhum serviço disponível no momento.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="servicos.php" class="btn btn-welcome btn-welcome-primary">
                    <i class="fas fa-search"></i> Ver Todos Serviços
                </a>
            </div>
        </div>
    </section>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar-user');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    </script>
</body>

</html>