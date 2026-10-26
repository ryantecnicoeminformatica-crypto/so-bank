<?php
require_once __DIR__ . '/functions.php';
$titulo = $titulo ?? 'SO BANK';
$u = usuario_atual();
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($titulo) ?> | SO BANK</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topo"><a class="marca" href="<?= logado() ? 'dashboard.php' : 'index.php' ?>"><span class="marca-icone">S</span><span>SO <span class="marca-clara">BANK</span><small>CONTROLE DE CONTAS BANCÁRIAS</small></span></a>
<?php if ($u): ?><div class="usuario-topo"><span class="avatar"><?= e(strtoupper(substr($u['nome'],0,1))) ?></span><span><b><?= e($u['nome']) ?></b><small><?= e(ucfirst($u['tipo'])) ?></small></span><a class="sair" href="logout.php">Sair ↗</a></div><?php endif; ?>
</header>
<?php if ($u): ?><nav class="menu"><a href="dashboard.php">Visão geral</a><?php if (in_array($u['tipo'], ['dono','gerente','funcionario'])): ?><a href="contas.php">Contas</a><a href="lancamentos.php">Lançamentos</a><?php endif; ?><?php if (in_array($u['tipo'], ['dono','gerente'], true)): ?><a href="gerentes.php">Gerentes</a><a href="funcionarios.php">Funcionários</a><?php endif; ?><a href="saldos.php">Saldos</a><a href="extratos.php">Extratos</a></nav><?php endif; ?>
<main class="container">
<?= mensagem() ?>
