<?php
session_start();
require_once '../db/conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $id_usuario = $_SESSION['usuario'];

    $stmt = $conexao->prepare("DELETE FROM produtos WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id, $id_usuario);

    if ($stmt->execute()) {
        header('Location: listar.php?msg=Produto excluído com sucesso');
    } else {
        header('Location: listar.php?erro=Erro ao excluir produto');
    }

    $stmt->close();
}
$conexao->close();