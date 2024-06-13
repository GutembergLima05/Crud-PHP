<?php
session_start();

// verificação de login
if (!isset($_SESSION["usuario"]) || !isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/cadastro.css">
</head>

<body>
    <?php include('./template/nav.php'); ?>

    <div class="container">

        <?php if (isset($_GET['error'])) : ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="backend/service/cadastro_backend.php" method="post" class="cadastro-form">
            <h2>Cadastro de Pessoa</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu email" required>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>

            <label for="nascimento">Nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" placeholder="Digite seu endereço">

            <div class="buttons-container">
                <a href="index.php" class="voltar-button">Voltar</a>
                <button type="submit">Cadastrar</button>
            </div>
        </form>
    </div>

    <script src="./js/dropdown.js"></script>
    <?php include("./template/alert.php"); ?>
</body>

</html>