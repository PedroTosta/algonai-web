<?php ob_start(); ?>
<?php
    if (!isset($_SESSION)) session_start();
    session_destroy(); // Destrói a sessão limpando todos os valores salvos
    header("Location: ../view/login.php"); exit; // Redireciona o visitante
  ?>