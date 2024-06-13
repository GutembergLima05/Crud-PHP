<?php

session_start();

include("backend/database/connection.php");

// verificação de login
if (!isset($_SESSION["usuario"]) || !isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

// dados para tabela 
$query = "SELECT * FROM pessoa";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/index.css">
</head>

<body>

    <?php include('./template/nav.php'); ?>

    <div class="container">
        <h2>Lista de Pessoas Cadastradas</h2>
        <?php if (isset($error)) : ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php else : ?>
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
                    <?php if (empty($registros)) : ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Não há pessoas cadastradas. <a href="cadastro.php">Cadastre agora</a>.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($registros as $registro) : ?>
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

    <script src="./js/dropdown.js"></script>
    <?php include("./template/alert.php"); ?>
</body>

</html>