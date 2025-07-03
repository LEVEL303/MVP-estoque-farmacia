<?php
session_start();
require_once '../db/conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../auth/login.php');
    exit;
}
$id_usuario = $_SESSION['usuario'];

$msg = $_GET['msg'] ?? null;
$erro = $_GET['erro'] ?? null;

$stmt = $conexao->prepare("SELECT * FROM produtos WHERE id_usuario = ? ORDER BY nome");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$produtos = $stmt->get_result();

if ($msg || $erro) {
    echo '<script>history.replaceState(null, "", "listar.php");</script>';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Produtos</h2>
        <div>
            <a href="../auth/logout.php" class="btn btn-outline-danger">Sair</a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionar">Adicionar Produto</button>
        </div>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($erro): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($erro) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Cód. Barras</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Grupo</th>
                <th>Classificação</th>
                <th>Fabricante</th>
                <th>Validade</th>
                <th>Quantidade</th>
                <th>Controlado</th>
                <th>Princípio Ativo</th>
                <th>Registro MS</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="tabelaProdutos">
        <?php while ($p = $produtos->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($p['cod_barras']) ?></td>
                <td><?= htmlspecialchars($p['nome']) ?></td>
                <td><?= htmlspecialchars($p['descricao'] ?? '') ?></td>
                <td><?= $p['grupo'] ?></td>

                <td><?= $p['grupo'] === 'medicamento' ? $p['classificacao'] : '—' ?></td>
                <td><?= htmlspecialchars($p['fabricante']) ?></td>
                <td><?= date('d/m/Y', strtotime($p['validade'])) ?></td>
                <td><?= $p['quantidade'] ?></td>

                <td><?= $p['grupo'] === 'medicamento' ? ($p['medicamento_controlado'] ? 'Sim' : 'Não') : '—' ?></td>
                <td><?= $p['grupo'] === 'medicamento' ? htmlspecialchars($p['principio_ativo'] ?? '') : '—' ?></td>
                <td><?= $p['grupo'] === 'medicamento' ? htmlspecialchars($p['registro_ms'] ?? '') : '—' ?></td>

                <td>R$<?= number_format($p['preco'], 2, ',', '.') ?></td>

                <td>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#modalExcluir"
                            data-id="<?= $p['id'] ?>"
                            data-nome="<?= htmlspecialchars($p['nome']) ?>"
                        >Excluir
                        </button>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Modal Adicionar -->
    <div class="modal fade" id="modalAdicionar" tabindex="-1" aria-labelledby="modalAdicionarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> 
            <form action="adicionar_produto.php" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarLabel">Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>Código de Barras*</label>
                        <input type="text" name="cod_barras" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Nome*</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>

                    <div class="col-md-12">
                        <label>Descrição</label>
                        <textarea name="descricao" class="form-control"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label>Grupo*</label>
                        <select name="grupo" class="form-select" id="grupoSelect" required>
                            <option value="">Selecione</option>
                            <option value="medicamento">Medicamento</option>
                            <option value="perfumaria">Perfumaria</option>
                            <option value="diversos">Diversos</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Classificação</label>
                        <select name="classificacao" class="form-select" id="classificacaoField">
                            <option value="">—</option>
                            <option value="generico">Genérico</option>
                            <option value="etico">Ético</option>
                            <option value="similar">Similar</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Fabricante*</label>
                        <input type="text" name="fabricante" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Validade*</label>
                        <input type="date" name="validade" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Quantidade*</label>
                        <input type="number" name="quantidade" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-6">
                        <label>Controlado</label>
                        <select name="medicamento_controlado" class="form-select" id="controladoField">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Princípio Ativo</label>
                        <input type="text" name="principio_ativo" class="form-control" id="principioAtivoField">
                    </div>

                    <div class="col-md-6">
                        <label>Registro MS</label>
                        <input type="text" name="registro_ms" class="form-control" id="registroMSField">
                    </div>

                    <div class="col-md-6">
                        <label>Preço*</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Excluir -->
    <div class="modal fade" id="modalExcluir" tabindex="-1">
        <div class="modal-dialog">
            <form action="deletar_produto.php" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Tem certeza que deseja excluir <strong id="excluirNome"></strong>?</p>
                    <input type="hidden" name="id" id="excluirId">
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalExcluir = document.getElementById('modalExcluir');
            modalExcluir.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nome = button.getAttribute('data-nome');

                document.getElementById('excluirId').value = id;
                document.getElementById('excluirNome').textContent = nome;
            });
        });
    </script>

</body>

</html>
