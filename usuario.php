<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style/usuario.css">
</head>
<body>
    <div class="cadastro-container">
        <div class="cadastro-card">
        <?php if (isset($_GET['error'])) : ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
            <h2>Cadastro de Usuário</h2>
            <form action="backend/service/usuario_backend.php" method="post">
                <input type="text" name="usuario" placeholder="Nome de usuário" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <select name="cargo" required>
                    <option value="">Selecione o cargo</option>
                    <option value="admin">Admin</option>
                    <option value="usuario">Usuário</option>
                </select>
                <button type="submit">Cadastrar</button>
            </form>
            <a href="login.php" class="login-link">Já possui uma conta? Faça login aqui.</a>
        </div>
    </div>
    <?php include("./template/alert.php"); ?>
</body>
</html>