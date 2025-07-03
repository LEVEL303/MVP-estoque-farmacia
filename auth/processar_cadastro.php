<?php
require_once '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($senha != $confirmar_senha) {
        header('Location: cadastro.php?erro=Senhas não coincidem');
        exit;
    }

    if (strlen($senha) < 6 || strlen($senha) > 50) {
        header('Location: cadastro.php?erro=Senha deve ter entre 6 e 50 caracteres');
        exit;
    }

    $nome = trim($_POST['nome']);
    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conexao->prepare("INSERT INTO usuarios (nome, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome, $senha);
    
    if ($stmt->execute()) {
        header('Location: login.php?msg=Usuário cadastrado com sucesso');
    } else {
        header('Location: cadastro.php?erro=Usuário já cadastrado');
    }
    $stmt->close();
}
$conexao->close();