<?php
$host = 'localhost';
$usuario = 'root';
$senha = 'admin';
$banco = 'estoque_farmacia';

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die('Erro na conexão: ' . $conexao->connect_error);
}