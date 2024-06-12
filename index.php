<?php

include("backend/database/connection.php");

$query = "SELECT id, email, nome, nascimento, endereco FROM pessoa";
$result = $conn->query($query);

if ($result) {
    $registros = [];
    while ($row = $result->fetch_assoc()) {
        $row['endereco'] = empty($row['endereco']) ? 'Sem endereço' : $row['endereco'];
        $row['nascimento'] = date('d/m/Y', strtotime($row['nascimento']));
        $registros[] = $row;
    }
    $conn->close();
} else {
    $error = "Erro ao recuperar registros: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
    <link rel="stylesheet" href="style/index.css">
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
        <h2>Lista de Pessoas Cadastradas</h2>
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Endereço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Não há pessoas cadastradas. <a href="cadastro.php">Cadastre agora</a>.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($registro['email']); ?></td>
                                <td><?php echo htmlspecialchars($registro['nome']); ?></td>
                                <td><?php echo htmlspecialchars($registro['nascimento']); ?></td>
                                <td><?php echo htmlspecialchars($registro['endereco']); ?></td>
                                <td>
                                    <form action="editar.php" method="post" style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">
                                        <button type="submit" class="editar-button">Editar</button>
                                    </form>
                                    
                                    <form action="excluir.php" method="post" style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">
                                        <button type="submit" class="excluir-button">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
