<?php
require_once __DIR__ . '/includes/functions.php';
if (logado()) redirecionar('dashboard.php');
redirecionar('login.php');
?>
