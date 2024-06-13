<?php

session_start();

include("./backend/database/connection.php");

// verificação de login
if (!isset($_SESSION["usuario"]) || !isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
} else {
    $usuario = $_SESSION['usuario'];
}


$id_perfil = $_SESSION['id'];


    $query = 'SELECT * FROM usuario WHERE id = ?';
    $result = $conn->prepare($query);
    $result->bind_param('i', $id_perfil);
    $result->execute();

    $row = $result->get_result()->fetch_assoc();
    $result->close();


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de Pessoa</title>
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

        <form action="" method="post" class="perfil-form">
            <h2>Alterar Dados</h2>
            <input type="hidden" id="id" name="id" value="<?php echo isset($row['id']) ? htmlspecialchars($row['id']) : ''; ?>">

            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo isset($row['usuario']) ? htmlspecialchars($row['usuario']) : ''; ?>" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Deixe em branco para manter a senha atual">

            <label for="cargo">Cargo:</label>
            <input disabled type="text" id="cargo" name="cargo" value="<?php echo isset($row['cargo']) ? htmlspecialchars($row['cargo']) : ''; ?>">

            <div class="buttons-container">
                <a href="index.php" class="voltar-button">Voltar</a>
                <button type="submit">Salvar Alterações</button>
            </div>
        </form>
    </div>
    <script src="./js/dropdown.js"></script>
</body>

</html>