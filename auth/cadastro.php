<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cadastro de Usuário</title>
</head>

<body>

    <div class="container mt-5" style="max-width: 400px;">
        <h2 class="mb-4 text-center">Cadastro de Usuário</h2>
        <form action="processar_cadastro.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Nome de usuário</label>
                <input type="text" class="form-control" name="nome" maxlength="50" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" class="form-control" name="senha" minlength="6" maxlength="50" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Confirmar senha</label>
                <input type="password" class="form-control" name="confirmar_senha" minlength="6" maxlength="50" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
        </form>

        <p class="mt-3 text-center">
            Já tem conta? <a href="login.php">Fazer login</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>