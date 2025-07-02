<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>

<body>

    <div class="container mt-5" style="max-width: 400px;">
        <h2 class="mb-4 text-center">Login</h2>
        <form action="#" method="POST">
            <div class="mb-3">
                <label class="form-label">Usuário</label>
                <input type="text" class="form-control" name="nome" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" class="form-control" name="senha" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <p class="mt-3 text-center">
            Ainda não tem conta? <a href="cadastro.php">Cadastre-se</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>