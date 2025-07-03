<?php
require_once '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($senha !== $confirmar_senha) {
        header('Location: cadastro.php?erro=Senhas não coincidem');
        exit;
    }

    if (strlen($senha) < 6 || strlen($senha) > 50) {
        header('Location: cadastro.php?erro=Senha deve ter entre 6 e 50 caracteres');
        exit;
    }

    if (strlen($nome) < 3 || strlen($nome) > 50) {
        header('Location: cadastro.php?erro=Nome de usuário deve ter entre 3 e 50 caracteres');
        exit;
    }

    $stmt_check = $conexao->prepare("SELECT COUNT(*) FROM usuarios WHERE nome = ?");
    $stmt_check->bind_param("s", $nome);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        header('Location: cadastro.php?erro=Nome de usuário já existe. Por favor, escolha outro.');
        exit;
    }

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conexao->prepare("INSERT INTO usuarios (nome, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome, $senha);

    if ($stmt->execute()) {
        header('Location: login.php?msg=Usuário cadastrado com sucesso');
    } else {
        header('Location: cadastro.php?erro=Erro ao cadastrar usuário. Tente novamente.');
    }
    $stmt->close();
}
$conexao->close();