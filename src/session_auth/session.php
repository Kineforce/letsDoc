<?php

// Inicializando sessão para integrar com a sessão do GOnline
if (!isset($_SESSION)) {
    session_start();
}

// Se não existe uma variável login na sessão (herdada no login no GOnline), então o usuário não está autenticado
if (!isset($_SESSION['login'])) {
    // Redirecionar para o site do IESB
    header("Location: http://iesb.br");
    die();
}
