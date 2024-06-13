<?php

session_start();

include("./backend/database/connection.php");

// verificação de login
if (!isset($_SESSION["usuario"]) || !isset($_SESSION["id"]) || !isset($_SESSION['cargo'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de Pessoa</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/perfil.css">
</head>

<body>

    <?php include('./template/nav.php'); ?>

    <div class="container">
        <i class="fas fa-user-circle user-iconPerfil"></i>

        <?php if (isset($_GET['error'])) : ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="backend/service/perfil_backend.php" method="post" class="perfil-form">
            <h2>Alterar Dados</h2>
            <input type="hidden" id="id" name="id" value="<?php echo isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : ''; ?>">

            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : ''; ?>" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Deixe em branco para manter a senha atual">

            <label for="cargo">Cargo:</label>
            <input disabled type="text" id="cargo" name="cargo" value="<?php echo isset($_SESSION['cargo']) ? htmlspecialchars($_SESSION['cargo']) : ''; ?>">

            <div class="buttons-container">
                <a href="index.php" class="voltar-button">Voltar</a>
                <button type="submit">Salvar Alterações</button>
            </div>
        </form>
    </div>

    <script src="./js/dropdown.js"></script>
    <?php include("./template/alert.php"); ?>
</body>

</html>