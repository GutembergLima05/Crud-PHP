<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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
                <li><a href="#">Serviços</a></li>
                <li><a href="#">Contato</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <form action="backend/service/cadastro_backend.php" method="post" class="cadastro-form">
            <h2>Cadastro de Pessoa</h2>
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>
            
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            
            <label for="nascimento">Nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" required>
            
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>
            
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>