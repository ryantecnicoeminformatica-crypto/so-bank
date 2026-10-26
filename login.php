<?php
require_once __DIR__ . '/includes/functions.php';
if (logado()) redirecionar('dashboard.php');
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? 'funcionario';
    $nome = trim($_POST['nome'] ?? '');
    $senhaInformada = $_POST['senha'] ?? '';
    if ($tipo === 'dono') {
        // Conta administrativa configurada em config.php, sem criar tabela nova.
        if (hash_equals((string)$DONO_USUARIO, $nome) && hash_equals((string)$DONO_SENHA, (string)$senhaInformada)) {
            session_regenerate_id(true);
            $_SESSION['sisbank_user'] = ['nome' => 'Dono do SO BANK', 'tipo' => 'dono'];
            redirecionar('dashboard.php');
        }
        $erro = 'Usuário ou senha do dono inválidos.';
    } elseif ($tipo === 'cliente') {
        $stmt = mysqli_prepare($conexao, "SELECT conta, cliente, senha FROM tbcontas WHERE conta = ? AND status = 'A' LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $nome);
        mysqli_stmt_execute($stmt); $res = mysqli_stmt_get_result($stmt); $row = mysqli_fetch_assoc($res); mysqli_stmt_close($stmt);
        if ($row && senha_valida($senhaInformada, $row['senha'])) {
            session_regenerate_id(true);
            $_SESSION['sisbank_user'] = ['nome'=>$row['cliente'], 'tipo'=>'cliente', 'conta'=>$row['conta']];
            redirecionar('dashboard.php');
        }
        $erro = 'Conta ou senha inválidas.';
    } elseif (in_array($tipo, ['gerente','funcionario'], true)) {
        $tabela = $tipo === 'gerente' ? 'tbgerentes' : 'tbfuncionarios';
        $stmt = mysqli_prepare($conexao, "SELECT nome, senha FROM $tabela WHERE nome = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $nome); mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt); $row = mysqli_fetch_assoc($res); mysqli_stmt_close($stmt);
        if ($row && senha_valida($senhaInformada, $row['senha'])) {
            session_regenerate_id(true);
            $_SESSION['sisbank_user'] = ['nome'=>$row['nome'], 'tipo'=>$tipo];
            redirecionar('dashboard.php');
        }
        $erro = 'Usuário ou senha inválidos.';
    } else { $erro = 'Selecione um tipo de acesso válido.'; }
}
?><!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Acesso | SO BANK</title><link rel="stylesheet" href="assets/style.css"></head><body class="pagina-login"><section class="login-lado"><a class="marca marca-login" href="index.php"><span class="marca-icone">S</span><span>SO <span class="marca-clara">BANK</span><small>CONTROLE DE CONTAS BANCÁRIAS</small></span></a><div class="texto-login"><span class="etiqueta">SISTEMA BANCÁRIO</span><h1>Seu controle financeiro, <em>em um só lugar.</em></h1><p>Uma forma simples e organizada de gerenciar contas, movimentações e extratos.</p><div class="mini-estatisticas"><span>● Contas organizadas</span><span>● Acesso seguro</span><span>● Consulta rápida</span></div></div><small class="login-rodape">Projeto educacional · PHP + MySQL</small></section><section class="login-form-lado"><form class="cartao-login" method="post" autocomplete="off"><span class="etiqueta">BEM-VINDO AO SO BANK</span><h2>Entrar na sua conta</h2><p class="muted">Informe seus dados para continuar.</p><?php if ($erro): ?><div class="alerta"><?= e($erro) ?></div><?php endif; ?><label for="tipo">Tipo de acesso</label><select id="tipo" name="tipo"><option value="funcionario">Funcionário</option><option value="gerente">Gerente</option><option value="cliente">Cliente</option><option value="dono">Dono / Administrador</option></select><label for="nome" id="rotuloNome">Usuário</label><input id="nome" name="nome" type="text" required placeholder="Digite seu usuário"><label for="senha">Senha</label><input id="senha" name="senha" type="password" required placeholder="Digite sua senha"><button class="botao botao-principal botao-largo" type="submit">Entrar no sistema <span>→</span></button><p class="dica-login">Clientes usam o número da conta. O acesso administrativo é configurado localmente no arquivo config.php.</p></form></section><script>const tipo=document.getElementById('tipo'), rotulo=document.getElementById('rotuloNome'), nome=document.getElementById('nome');function ajustar(){if(tipo.value==='cliente'){rotulo.textContent='Número da conta';nome.placeholder='Digite o número da conta'}else if(tipo.value==='dono'){rotulo.textContent='Usuário administrativo';nome.placeholder='Digite o usuário do dono'}else{rotulo.textContent='Usuário';nome.placeholder='Digite seu usuário'}}tipo.addEventListener('change',ajustar);ajustar();</script></body></html>
