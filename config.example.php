<?php
// Copie este arquivo para config.php e ajuste os dados do seu ambiente local.
// Nunca publique config.php com senhas reais em um repositório público.
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'contabancária'; // Use exatamente o nome do banco criado no phpMyAdmin.

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
if (!$conexao) {
    // Evita expor detalhes internos do servidor para visitantes.
    error_log('Falha na conexão MySQL: ' . mysqli_connect_error());
    die('Não foi possível conectar ao banco de dados. Confira as configurações locais.');
}
mysqli_set_charset($conexao, 'utf8mb4');

// Defina credenciais exclusivas para o acesso administrativo local.
$DONO_USUARIO = 'defina_um_usuario';
$DONO_SENHA = 'TROQUE_POR_UMA_SENHA_FORTE';
?>
