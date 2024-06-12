<?php
include("./backend/database/connection.php");

if(isset($_POST['id'])){
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
    <link rel="stylesheet" href="style/editar.css">
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
                <li><a href="#">Serviços</a></li>
                <li><a href="#">Contato</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">

    <?php if (isset($_GET['error'])): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

        <form action="backend/service/editar_backend.php" method="post" class="editar-form">
            <h2>Edição de Pessoa</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : '';?>" required>
            
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo isset($row['email']) ? htmlspecialchars($row['nome']) : '';?>" required>
            
            <label for="nascimento">Nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" value="<?php echo isset($row['email']) ? htmlspecialchars($row['nascimento']) : '';?>" required>
            
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : '';?>">
            
            <div class="buttons-container">
                <a href="index.php" class="voltar-button">Voltar</a>
                <button type="submit">Salvar Alterações</button>
            </div>
        </form>
    </div>
</body>
</html>
