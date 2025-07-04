<?php
require_once '../includes/auth.php';
require_once '../includes/conexao.php';

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

$servico_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT * FROM servicos WHERE id = :id AND usuario_id = :usuario_id");
$stmt->execute([':id' => $servico_id, ':usuario_id' => $usuario_id]);
$servico = $stmt->fetch();

if (!$servico) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $localizacao = $_POST['localizacao'];

    if (!empty($_FILES['foto_principal']['name'])) {
        $foto_principal = file_get_contents($_FILES['foto_principal']['tmp_name']);
        $tipo_imagem = $_FILES['foto_principal']['type'];

        $sql = "UPDATE servicos SET 
                titulo = :titulo, 
                descricao = :descricao, 
                categoria = :categoria, 
                localizacao = :localizacao,
                foto_principal = :foto_principal,
                tipo_imagem = :tipo_imagem
                WHERE id = :id AND usuario_id = :usuario_id";

        $params = [
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':categoria' => $categoria,
            ':localizacao' => $localizacao,
            ':foto_principal' => $foto_principal,
            ':tipo_imagem' => $tipo_imagem,
            ':id' => $servico_id,
            ':usuario_id' => $usuario_id
        ];
    } else {
        $sql = "UPDATE servicos SET 
                titulo = :titulo, 
                descricao = :descricao, 
                categoria = :categoria, 
                localizacao = :localizacao
                WHERE id = :id AND usuario_id = :usuario_id";

        $params = [
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':categoria' => $categoria,
            ':localizacao' => $localizacao,
            ':id' => $servico_id,
            ':usuario_id' => $usuario_id
        ];
    }

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($params)) {
        $_SESSION['sucesso'] = "Serviço atualizado com sucesso!";
        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['erro'] = "Erro ao atualizar o serviço.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Serviço - DivulgaZap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/editar.css">
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
    <div class="edit-container">
        <h2 class="edit-title">Editar Serviço</h2>
        <?php if (isset($_SESSION['erro'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['erro'];
            unset($_SESSION['erro']); ?></div>
        <?php endif; ?>
        <form id="editarServicoForm" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Título do Serviço</label>
                <input type="text" name="titulo" class="form-control"
                    value="<?= htmlspecialchars($servico['titulo']) ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control"
                    required><?= htmlspecialchars($servico['descricao']) ?></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Categoria</label>
                <select name="categoria" class="form-select" required>
                    <option value="" disabled>Selecione uma categoria</option>
                    <option value="Manicure" <?= $servico['categoria'] == 'Manicure' ? 'selected' : '' ?>>Manicure</option>
                    <option value="Eletricista" <?= $servico['categoria'] == 'Eletricista' ? 'selected' : '' ?>>Eletricista
                    </option>
                    <option value="Encanador" <?= $servico['categoria'] == 'Encanador' ? 'selected' : '' ?>>Encanador
                    </option>
                    <option value="Marceneiro" <?= $servico['categoria'] == 'Marceneiro' ? 'selected' : '' ?>>Marceneiro
                    </option>
                    <option value="Designer" <?= $servico['categoria'] == 'Designer' ? 'selected' : '' ?>>Designer</option>
                    <option value="Pedreiro" <?= $servico['categoria'] == 'Pedreiro' ? 'selected' : '' ?>>Pedreiro</option>
                    <option value="Costureira" <?= $servico['categoria'] == 'Costureira' ? 'selected' : '' ?>>Costureira
                    </option>
                    <option value="Pintor" <?= $servico['categoria'] == 'Pintor' ? 'selected' : '' ?>>Pintor</option>
                    <option value="Técnico de Celular" <?= $servico['categoria'] == 'Técnico de Celular' ? 'selected' : '' ?>>Técnico de Celular</option>
                    <option value="Motorista" <?= $servico['categoria'] == 'Motorista' ? 'selected' : '' ?>>Motorista
                    </option>
                    <option value="Outros" <?= $servico['categoria'] == 'Outros' ? 'selected' : '' ?>>Outros</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Localização</label>
                <select name="localizacao" class="form-select" required>
                    <option value="" disabled>Selecione sua região</option>
                    <option value="Zona Norte" <?= $servico['localizacao'] == 'Zona Norte' ? 'selected' : '' ?>>Zona Norte
                    </option>
                    <option value="Zona Leste" <?= $servico['localizacao'] == 'Zona Leste' ? 'selected' : '' ?>>Zona Leste
                    </option>
                    <option value="Zona Oeste" <?= $servico['localizacao'] == 'Zona Oeste' ? 'selected' : '' ?>>Zona Oeste
                    </option>
                    <option value="Zona Sul" <?= $servico['localizacao'] == 'Zona Sul' ? 'selected' : '' ?>>Zona Sul
                    </option>
                    <option value="Centro" <?= $servico['localizacao'] == 'Centro' ? 'selected' : '' ?>>Centro</option>
                </select>
            </div>
            <div class="form-group image-preview-container">
                <label class="form-label">Foto do Serviço</label>
                <div class="image-preview" id="imagePreview">
                    <?php if ($servico['foto_principal']): ?>
                        <img src="data:<?= $servico['tipo_imagem'] ?>;base64,<?= base64_encode($servico['foto_principal']) ?>"
                            alt="Imagem atual do serviço">
                    <?php else: ?>
                        <div class="image-preview-text">
                            <i class="fas fa-image"></i>
                            <p>Nenhuma imagem selecionada</p>
                        </div>
                    <?php endif; ?>
                </div>
                <label for="fotoInput" class="custom-file-label mt-2">
                    <i class="fas fa-upload"></i> Alterar Imagem
                </label>
                <input type="file" name="foto_principal" id="fotoInput" class="d-none" accept="image/*">
            </div>
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Salvar Alterações
            </button>
        </form>
    </div>
    <div class="modal fade modal-confirmacao" id="confirmacaoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Salvando Alterações...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="modal-icon">
                        <i class="fas fa-circle-notch fa-spin"></i>
                    </div>
                    <p>Estamos salvando suas alterações. Por favor, aguarde...</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-confirmacao" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Alterações Salvas!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="modal-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p>As alterações no seu serviço foram salvas com sucesso.</p>
                </div>
                <div class="modal-footer">
                    <a href="dashboard.php" class="btn btn-success btn-confirm">Voltar para Meus Anúncios</a>
                </div>
            </div>
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
    <script>
        document.getElementById('fotoInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    preview.innerHTML = `<img src="${event.target.result}" alt="Preview da nova imagem">`;
                }

                reader.readAsDataURL(file);
            } else {
                <?php if ($servico['foto_principal']): ?>
                    preview.innerHTML = `<img src="data:<?= $servico['tipo_imagem'] ?>;base64,<?= base64_encode($servico['foto_principal']) ?>" alt="Imagem atual do serviço">`;
                <?php else: ?>
                    preview.innerHTML = '<div class="image-preview-text"><i class="fas fa-image"></i><p>Nenhuma imagem selecionada</p></div>';
                <?php endif; ?>
            }
        });

        document.getElementById('editarServicoForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const loadingModal = new bootstrap.Modal(document.getElementById('confirmacaoModal'));
            loadingModal.show();

            setTimeout(() => {
                loadingModal.hide();

                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                setTimeout(() => {
                    e.target.submit();
                }, 2000);
            }, 1500);
        });
    </script>
</body>

</html>