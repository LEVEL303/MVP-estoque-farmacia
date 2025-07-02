<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: produtos/listar.php');
    exit;
}

header('Location: auth/login.php');