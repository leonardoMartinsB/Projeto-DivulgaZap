<?php
require_once 'includes/conexao.php';
require_once 'includes/auth.php';

$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$localizacao = isset($_GET['localizacao']) ? $_GET['localizacao'] : '';

$sql = "SELECT s.id, s.titulo, s.descricao, s.categoria, s.localizacao, 
               s.foto_principal, s.tipo_imagem, u.nome as prestador, u.telefone
        FROM servicos s
        JOIN usuarios u ON s.usuario_id = u.id
        WHERE 1=1";

$params = [];

if (!empty($busca)) {
    $sql .= " AND (s.titulo LIKE ? OR s.descricao LIKE ?)";
    $params[] = "%$busca%";
    $params[] = "%$busca%";
}

if (!empty($categoria)) {
    $sql .= " AND s.categoria = ?";
    $params[] = $categoria;
}

if (!empty($localizacao)) {
    $sql .= " AND s.localizacao = ?";
    $params[] = $localizacao;
}

$sql .= " ORDER BY s.data_cadastro DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar serviços: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços Disponíveis | DivulgaZap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --verde-primario: rgb(12, 153, 45);
            --verde-escuro: #218838;
            --preto-profundo: #121212;
            --cinza-escuro: #1e1e1e;
            --cinza-medio: rgb(121, 121, 121);
            --cinza-claro: #e1e1e1;
            --branco: #ffffff;
            --sombra: 0 4px 20px rgba(0, 0, 0, 0.1);
            --sombra-destaque: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            overflow-x: hidden;
        }

        .navbar-user {
            background-color: var(--preto-profundo);
            padding: 1rem 0;
            box-shadow: var(--sombra);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand-user {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--branco);
            text-decoration: none;
        }

        .navbar-brand-user span {
            color: var(--verde-primario);
        }

        .nav-link {
            color: white !important;
            font-weight: 600;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--verde-primario) !important;
        }

        .navbar-nav {
            width: 100%;
            justify-content: center !important;
            gap: 20px;
        }

        .user-menu .user-name {
            color: var(--branco) !important;
            font-weight: 600;
        }

        .dropdown-menu {
            background-color: var(--cinza-escuro);
            border: none;
            box-shadow: var(--sombra-destaque);
        }

        .dropdown-item {
            color: var(--cinza-claro);
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(12, 153, 45, 0.1);
            color: var(--verde-primario);
        }

        /* Cards de Serviços */
        .service-card {
            background-color: var(--branco);
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--sombra);
            transition: all 0.3s ease;
            height: 100%;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--sombra-destaque);
        }

        .service-card-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .service-card-body {
            padding: 1.5rem;
        }

        .service-card-title {
            font-weight: 600;
            color: var(--preto-profundo);
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }

        .service-card-desc {
            color: var(--cinza-medio);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .service-card-footer {
            background-color: #f8f9fa;
            padding: 0.75rem 1.5rem;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .badge-category {
            background-color: var(--cinza-medio);
            color: var(--branco);
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        .badge-location {
            background-color: var(--verde-primario);
            color: var(--branco);
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        .btn-details {
            background-color: var(--verde-primario);
            color: var(--branco);
            font-weight: 500;
            padding: 0.375rem 1rem;
            border-radius: 5px;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-details:hover {
            background-color: var(--verde-escuro);
            color: var(--branco);
            transform: translateY(-2px);
        }

        /* Filtros */
        .search-container {
            background-color: var(--branco);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: var(--sombra);
            margin-bottom: 2rem;
        }

        .search-title {
            color: var(--preto-profundo);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--cinza-claro);
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--verde-primario);
            box-shadow: 0 0 0 0.25rem rgba(12, 153, 45, 0.25);
        }

        .btn-success {
            background-color: var(--verde-primario);
            border-color: var(--verde-primario);
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: var(--verde-escuro);
            border-color: var(--verde-escuro);
            transform: translateY(-2px);
        }

        /* Estado vazio */
        .empty-state {
            text-align: center;
            padding: 3rem;
            background-color: var(--branco);
            border-radius: 8px;
            box-shadow: var(--sombra);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--verde-primario);
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: var(--preto-profundo);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--cinza-medio);
            margin-bottom: 1.5rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: #f8f9fa;
            color: #2c3e50;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 500;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .back-link i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }

        .back-link:hover {
            background-color: #e9ecef;
            color: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .back-link:hover i {
            transform: translateX(-3px);
        }

        .back-link.primary {
            background-color: var(--verde-primario);
            color: white;
            border-color: var(--verde-primario);
        }

        .back-link.primary:hover {
            background-color: var(--verde-escuro);
            color: white;
        }

        /* Footer */
        .footer {
            background-color: var(--preto-profundo);
            color: var(--cinza-claro);
            padding: 3rem 0 2rem;
            margin-top: 4rem;
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--verde-primario), var(--verde-escuro));
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: inline-block;
            color: var(--branco);
            text-decoration: none;
        }

        .footer-logo span {
            color: var(--verde-primario);
        }

        .footer-about p {
            color: var(--cinza-claro);
            opacity: 0.8;
            margin-bottom: 1.5rem;
        }

        .footer-social {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background-color: var(--verde-primario);
            transform: translateY(-3px);
        }

        .footer-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 10px;
            color: var(--branco);
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background-color: var(--verde-primario);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: var(--cinza-claro);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .footer-links a:hover {
            color: var(--verde-primario);
            padding-left: 5px;
        }

        .footer-links i {
            margin-right: 8px;
            font-size: 0.8rem;
            color: var(--verde-primario);
        }

        .footer-contact p {
            color: var(--cinza-claro);
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }

        .footer-contact i {
            margin-right: 10px;
            color: var(--verde-primario);
            margin-top: 4px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-bottom p {
            color: var(--cinza-claro);
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        /* Responsividade */
        @media (max-width: 767.98px) {
            .navbar-nav {
                gap: 10px;
                margin-top: 1rem;
            }

            .service-card {
                margin-bottom: 1.5rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
    </style>
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
                        <a class="nav-link active" href="servicos.php">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="painel/cadastrar.php">Anúnciar Serviço</a>
                    </li>
                </ul>
            </div>
            <div class="user-menu dropdown">
                <div class="user-name dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="cursor: pointer; font-size: 1rem;">
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
        <div class="search-container">
            <h2 class="search-title">Encontre os melhores serviços</h2>
            <form method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="busca" placeholder="Buscar serviços..."
                            value="<?= htmlspecialchars($busca) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="categoria">
                        <option value="">Todas categorias</option>
                        <?php
                        $categorias = ['Manicure', 'Eletricista', 'Encanador', 'Marceneiro', 'Designer', 'Pedreiro', 'Costureira', 'Pintor', 'Técnico de Celular', 'Motorista', 'Outros'];
                        foreach ($categorias as $cat) {
                            $selected = ($categoria == $cat) ? 'selected' : '';
                            echo "<option value='$cat' $selected>$cat</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="localizacao">
                        <option value="">Todas localizações</option>
                        <?php
                        $localizacoes = ['Zona Norte', 'Zona Leste', 'Zona Oeste', 'Zona Sul', 'Centro'];
                        foreach ($localizacoes as $loc) {
                            $selected = ($localizacao == $loc) ? 'selected' : '';
                            echo "<option value='$loc' $selected>$loc</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-success w-100"><i class="fas fa-filter"></i></button>
                </div>
            </form>
        </div>

        <div class="row">
            <?php if (count($servicos) > 0): ?>
                <?php foreach ($servicos as $servico): ?>
                    <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
                        <div class="service-card">
                            <?php if ($servico['foto_principal']): ?>
                                <img src="data:<?= $servico['tipo_imagem'] ?>;base64,<?= base64_encode($servico['foto_principal']) ?>"
                                    class="service-card-img" alt="<?= htmlspecialchars($servico['titulo']) ?>">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/400x300?text=Sem+Imagem" class="service-card-img"
                                    alt="Sem imagem">
                            <?php endif; ?>

                            <div class="service-card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge-category"><?= htmlspecialchars($servico['categoria']) ?></span>
                                    <span class="badge-location">
                                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($servico['localizacao']) ?>
                                    </span>
                                </div>

                                <h3 class="service-card-title"><?= htmlspecialchars($servico['titulo']) ?></h3>
                                <p class="service-card-desc"><?= htmlspecialchars($servico['descricao']) ?></p>
                            </div>

                            <div class="service-card-footer">
                                <small class="text-muted">
                                    <i class="fas fa-user"></i> <?= htmlspecialchars($servico['prestador']) ?>
                                </small>
                                <a href="servicos-detalhes.php?id=<?= $servico['id'] ?>" class="btn-details">
                                    Ver detalhes <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <h3>Nenhum serviço encontrado</h3>
                        <p class="text-muted mb-4">Não encontramos serviços com os critérios selecionados.</p>
                        <a href="servicos.php" class="btn btn-success">Limpar filtros</a>
                        <a href="painel/cadastrar.php" class="btn btn-outline-success ms-2">Cadastrar serviço</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <a href="index.php" class="footer-logo">Divulga<span>Zap</span></a>
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
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    </script>
</body>

</html>