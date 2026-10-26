<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config.php';

function e($valor) { return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8'); }
function redirecionar($pagina) { header('Location: ' . $pagina); exit; }
function usuario_atual() { return $_SESSION['sisbank_user'] ?? null; }
function logado() { return isset($_SESSION['sisbank_user']); }
function exigir_login() { if (!logado()) redirecionar('login.php'); }
function tipo_usuario() { return $_SESSION['sisbank_user']['tipo'] ?? ''; }
function exigir_tipo($tipos) {
    exigir_login();
    // O dono tem acesso administrativo a todas as áreas do sistema.
    if (tipo_usuario() === 'dono') return;
    if (!in_array(tipo_usuario(), (array)$tipos, true)) {
        $_SESSION['mensagem'] = 'Você não tem permissão para acessar essa página.';
        redirecionar('dashboard.php');
    }
}
function mensagem() {
    if (isset($_SESSION['mensagem'])) {
        $m = $_SESSION['mensagem']; unset($_SESSION['mensagem']);
        return '<div class="alerta">' . e($m) . '</div>';
    }
    return '';
}
function dinheiro($valor) { return 'R$ ' . number_format((float)$valor, 2, ',', '.'); }
function senha_valida($informada, $armazenada) {
    // Aceita hashes password_hash e, para facilitar testes com cadastros antigos, senha legada em texto.
    return password_verify($informada, $armazenada) || hash_equals((string)$armazenada, (string)$informada);
}
function saldo_conta($conta) {
    global $conexao;
    $sql = 'SELECT tipo, valor FROM tblancamentos WHERE conta = ?';
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 's', $conta);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $saldo = 0;
    while ($l = mysqli_fetch_assoc($resultado)) {
        $tipo = strtoupper(trim($l['tipo']));
        // Convenção deste projeto: D = depósito/entrada; S = saque/saída.
        if ($tipo === 'D' || $tipo === 'E') $saldo += (float)$l['valor'];
        else $saldo -= (float)$l['valor'];
    }
    mysqli_stmt_close($stmt);
    return $saldo;
}
function conta_cliente_atual() { return $_SESSION['sisbank_user']['conta'] ?? ''; }
function conta_ativa($conta) {
    global $conexao;
    $stmt = mysqli_prepare($conexao, "SELECT conta FROM tbcontas WHERE conta = ? AND status = 'A' LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $conta); mysqli_stmt_execute($stmt);
    $r = mysqli_stmt_get_result($stmt); $ok = mysqli_num_rows($r) > 0; mysqli_stmt_close($stmt); return $ok;
}
?>
