<?php
session_start();

// verificação de login
if (!isset($_SESSION["usuario"]) || !isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
} else{
    $usuario = $_SESSION['usuario'];
}


?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/cadastro.css">
</head>

<body>
    <nav>
        <div class="navbar">
            <div class="logo">
                <h1>PHP CRUD</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="cadastro.php">Cadastrar</a></li>
                <li class="dropdown">
                    <div id="dropdown-toggle" class="dropbtn">
                        <i class="fas fa-user-circle user-icon"></i>
                        <span class="nav-dropdown-link">Olá, <?php echo 'Gutemberg'; ?></span>
                        <i class="fas fa-chevron-down chevron-down-icon"></i>
                    </div>
                    <div class="dropdown-content">
                        <a href="backend/service/logout_backend.php">Sair</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

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
</body>

</html>