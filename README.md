# 📢 DivulgaZap

O **DivulgaZap** é uma plataforma moderna e responsiva para divulgação de serviços locais, voltada a prestadores autônomos. Usuários podem se registrar, anunciar serviços com imagem, editar ou excluir anúncios, deletar a própria conta e visualizar todos os anúncios públicos.  
Desenvolvido com foco em segurança, boas práticas e uma interface limpa e funcional.

---

## 🚀 Funcionalidades

- ✅ Registro de usuários com verificação de e-mail já cadastrado
- ✅ Login com tratamento de erros (e-mail ou senha inválidos)
- ✅ Início automático de sessão após login ou cadastro
- ✅ Navbar com nome do usuário e acesso ao painel
- ✅ Página de gerenciamento pessoal com CRUD de serviços
- ✅ Upload de imagem direto no banco de dados (BLOB)
- ✅ Exclusão de conta com remoção total de dados
- ✅ Proteção de rotas: páginas privadas só acessíveis com login
- ✅ Página pública de serviços disponíveis com imagem e descrição
- ✅ Layout responsivo com **Bootstrap 5.3** e visual moderno

---

## 🗂️ Estrutura do Projeto

divulgazap/
│
├── includes/
│ ├── conexao.php # Conexão PDO com o banco
│ ├── auth.php # Proteção de rotas
│ ├── header.php # Cabeçalho com navbar
│ └── footer.php # Rodapé fixo
│
├── painel/
│ ├── dashboard.php # Painel do usuário
│ ├── cadastrar.php # Cadastrar novo serviço
│ ├── editar.php # Editar serviço
│ ├── deletar.php # Excluir serviço
│ └── deletar_conta.php # Deletar conta e sair
│
├── assets/
│ └── css/
│ └── style.css # Estilo customizado
│
├── login.php # Tela de login
├── registrar.php # Tela de registro
├── logout.php # Encerra sessão
├── servicos.php # Página pública de serviços
└── index.php # Página inicial (landing page)

pgsql
Copiar
Editar

---

🎨 Estilo e Design
🎨 Cores predominantes: verde-escuro (#28a745), preto e cinza escuro

🖥️ Layout clean e responsivo com Bootstrap

📱 Totalmente compatível com dispositivos móveis

📷 Imagens dos anúncios integradas diretamente no banco (BLOB)

🔐 Segurança e Boas Práticas
Uso de password_hash() e password_verify()

Sessões protegidas com session_start()

Restrições por URL (rota protegida via auth.php)

Prepared statements com PDO para evitar SQL Injection

Tratamento de erros e mensagens claras para o usuário

🧪 Como rodar localmente
Clone o repositório:

bash
Copiar
Editar
git clone https://github.com/seuusuario/divulgazap.git
Crie o banco no MySQL e execute o SQL fornecido acima.

Configure os dados de acesso no arquivo:

Copiar
Editar
/includes/conexao.php
Rode o projeto com XAMPP, Laragon ou outro servidor local.

Acesse no navegador:

Copiar
Editar
http://localhost/divulgazap
