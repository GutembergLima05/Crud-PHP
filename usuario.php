<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style/usuario.css">
</head>
<body>
    <div class="cadastro-container">
        <div class="cadastro-card">
            <h2>Cadastro de Usuário</h2>
            <form action="cadastro_usuario.php" method="post">
                <input type="text" name="nome" placeholder="Nome de usuário" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Cadastrar</button>
            </form>
            <a href="login.php" class="login-link">Já possui uma conta? Faça login aqui.</a>
        </div>
    </div>
</body>
</html>
