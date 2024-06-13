<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
        <?php if (isset($_GET['error'])) : ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
            <h2>Login</h2>
            <form action="backend/service/login_backend.php" method="post">
                <input type="text" name="usuario" placeholder="Usuário" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <div class="login-options">
                    <button type="submit">Entrar</button>
                    <a href="usuario.php" class="signup-link">Cadastrar novo usuário</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
