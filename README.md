<div align="center">
  <h1>SO BANK</h1>
  <p><strong>Sistema educacional de controle de contas bancárias</strong></p>
  <p>Projeto desenvolvido com PHP, MySQL, HTML e CSS para praticar desenvolvimento web e operações bancárias básicas.</p>
</div>

## Sobre o projeto

O SO BANK é um projeto escolar executado localmente com XAMPP. Ele reúne telas para cadastro e consulta de contas, lançamentos, saldos, extratos e administração de usuários, conforme as tabelas já existentes no banco de dados do projeto.

## Tecnologias

- PHP
- MySQL / MariaDB
- HTML5
- CSS3
- XAMPP

## Como executar localmente

1. Instale e abra o XAMPP.
2. Inicie **Apache** e **MySQL**.
3. Coloque a pasta `so-bank` dentro de `C:\xampp\htdocs\`.
4. No phpMyAdmin, crie ou selecione o banco que já foi usado no projeto e mantenha a estrutura de tabelas exigida pela apostila.
5. Copie `config.example.php` e renomeie a cópia para `config.php`.
6. Abra `config.php` e informe o nome exato do banco, usuário e senha do MySQL local. Defina também um usuário e uma senha fortes para o acesso administrativo.
7. Acesse `http://localhost/so-bank/` no navegador.

> O projeto não inclui banco exportado nem dados de usuários. As tabelas precisam existir no MySQL local antes de utilizar as páginas.

## Configuração e segurança

- `config.php` contém credenciais locais e está excluído pelo `.gitignore`. **Não o envie ao GitHub.**
- `config.example.php` é apenas um modelo; substitua os valores de exemplo antes de executar.
- Não use senhas reais, dados de clientes ou cópias do banco em um repositório público.
- O acesso administrativo é configurado no `config.php` e não exige uma tabela adicional.

## Estrutura principal

- `login.php` — tela de acesso
- `dashboard.php` — painel principal
- `contas.php` — cadastro e consulta de contas
- `lancamentos.php` — depósitos, saques e histórico
- `saldos.php` — consulta de saldos
- `extratos.php` — consulta de extratos
- `funcionarios.php` e `gerentes.php` — administração de usuários
- `includes/` — funções compartilhadas, cabeçalho e rodapé
- `assets/style.css` — estilos da interface

## Observação

Este projeto foi criado para fins educacionais e para execução em ambiente local. Não é um sistema bancário real e não deve ser utilizado para guardar ou processar dinheiro de verdade.
