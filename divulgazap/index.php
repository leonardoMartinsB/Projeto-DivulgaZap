<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DivulgaZap - Conectando Profissionais e Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Divulga<span>Zap</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">Como Funciona</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#featured-services">Serviços</a>
                    </li>
                </ul>
                <div class="ms-lg-3 mt-3 mt-lg-0">
                    <a href="login.php" class="btn btn-entrar">Entrar</a>
                </div>
            </div>
        </div>
    </nav>
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">Encontre os melhores <span>serviços locais</span> perto de você</h1>
                        <p class="hero-subtitle">Conectamos profissionais qualificados com clientes em busca de serviços
                            de qualidade, tudo de forma simples e direta pelo WhatsApp.</p>

                        <div class="hero-cta">
                            <a href="home.php" class="btn btn-outline-light btn-outline-light-custom btn-lg">
                                <i class="fas fa-bullhorn me-2"></i>Divulgar Serviço
                            </a>
                        </div>
                        <div class="hero-stats">
                            <div class="stat-item">
                                <div class="stat-number">+5.000</div>
                                <div class="stat-label">Profissionais</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">100%</div>
                                <div class="stat-label">Gratuito</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">24h</div>
                                <div class="stat-label">Disponível</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image text-center">
                        <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                            alt="Profissionais diversos" class="img-fluid rounded-3 shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <h2 class="section-title">Como Funciona</h2>
            <p class="section-subtitle">Três passos simples para encontrar ou oferecer serviços</p>

            <div class="steps-container">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="step-title">Cadastre-se</h3>
                    <p class="step-description">Crie seu perfil em menos de 2 minutos e comece a divulgar seus serviços
                        gratuitamente.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-search-location"></i>
                    </div>
                    <h3 class="step-title">Encontre ou Divulgue</h3>
                    <p class="step-description">Busque por serviços próximos a você ou cadastre os seus para serem
                        encontrados.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3 class="step-title">Converse Direto</h3>
                    <p class="step-description">Entre em contato via WhatsApp e feche o serviço sem intermediários.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="featured-services" class="featured-services">
        <div class="container">
            <h2 class="section-title">Serviços em Destaque</h2>
            <p class="section-subtitle">Profissionais bem avaliados perto de você</p>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-badge">⭐ Top Avaliado</div>
                    <img src="https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="Manicure profissional" class="service-image">
                    <div class="service-content">
                        <h3 class="service-title">Manicure Completa</h3>
                        <p class="service-description">Alongamento em gel, design artístico e esmaltação profissional.
                            Atendo em domicílio.</p>
                        <div class="service-meta">
                            <span class="service-rating"><i class="fas fa-star"></i> 4.9 (128)</span>
                            <span class="service-location"><i class="fas fa-map-marker-alt"></i> Zona Sul</span>
                        </div>
                        <a href="#" class="service-btn">
                            <i class="fab fa-whatsapp"></i> Chamar Agora
                        </a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-badge">🔥 Popular</div>
                    <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="Eletricista residencial" class="service-image">
                    <div class="service-content">
                        <h3 class="service-title">Eletricista 24h</h3>
                        <p class="service-description">Instalações, manutenções e reparos elétricos. Atendimento
                            emergencial.</p>
                        <div class="service-meta">
                            <span class="service-rating"><i class="fas fa-star"></i> 4.8 (97)</span>
                            <span class="service-location"><i class="fas fa-map-marker-alt"></i> Centro</span>
                        </div>
                        <a href="#" class="service-btn">
                            <i class="fab fa-whatsapp"></i> Chamar Agora
                        </a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-badge">🆕 Novo</div>
                    <img src="https://images.unsplash.com/photo-1600585152220-90363fe7e115?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="Marcenaria sob medida" class="service-image">
                    <div class="service-content">
                        <h3 class="service-title">Marceneiro Profissional</h3>
                        <p class="service-description">Móveis planejados, reformas e consertos em madeira maciça e MDF.
                        </p>
                        <div class="service-meta">
                            <span class="service-rating"><i class="fas fa-star"></i> 4.7 (86)</span>
                            <span class="service-location"><i class="fas fa-map-marker-alt"></i> Zona Oeste</span>
                        </div>
                        <a href="#" class="service-btn">
                            <i class="fab fa-whatsapp"></i> Chamar Agora
                        </a>
                    </div>
                </div>
            </div>
            <div class="view-all">
                <a href="servicos.php" class="btn btn-view-all">
                    <i class="fas fa-arrow-right me-2"></i>Ver Todos os Serviços
                </a>
            </div>
        </div>
    </section>
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Pronto para encontrar ou oferecer serviços?</h2>
                <p class="cta-text">Junte-se a milhares de profissionais e clientes que já estão usando o DivulgaZap
                    para conectar-se de forma simples e direta.</p>

                <div class="cta-buttons">
                    <a href="registrar.php" class="btn btn-cta-primary">
                        <i class="fas fa-user-plus me-2"></i>Cadastre-se Grátis
                    </a>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <a href="#" class="footer-logo">Divulga<span>Zap</span></a>
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
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Início</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Serviços</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Como Funciona</a></li>
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
                <p>&copy; 2025 DivulgaZap. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>