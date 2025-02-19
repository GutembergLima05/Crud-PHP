<?php

session_start();

include("./backend/database/connection.php");

// verificação de login
if (!isset($_SESSION["usuario"]) || !isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = 'SELECT * FROM pessoa WHERE id = ?';
    $result = $conn->prepare($query);
    $result->bind_param('i', $id);
    $result->execute();

    $row = $result->get_result()->fetch_assoc();
    $result->close();
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
    <link rel="stylesheet" href="style/editar.css">
</head>

<body>

    <?php include('./template/nav.php'); ?>

    <div class="container">

        <?php if (isset($_GET['error'])) : ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="backend/service/editar_backend.php" method="post" class="editar-form">
            <h2>Edição de Pessoa</h2>
            <input type="hidden" id="id" name="id" value="<?php echo isset($row['id']) ? htmlspecialchars($row['id']) : ''; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>" required>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo isset($row['nome']) ? htmlspecialchars($row['nome']) : ''; ?>" required>

            <label for="nascimento">Nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" value="<?php echo isset($row['nascimento']) ? htmlspecialchars($row['nascimento']) : ''; ?>" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?php echo isset($row['endereco']) ? htmlspecialchars($row['endereco']) : ''; ?>">

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