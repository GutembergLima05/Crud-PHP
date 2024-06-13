<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
    <link rel="stylesheet" href="style/mudar-senha.css"> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div id="verificacao-usuario">
                <h2>Verificação de Usuário</h2>
                <form id="form-verificar-usuario" method="post">
                    <input type="text" id="usuario" name="usuario" placeholder="Usuário" required>
                    <button type="submit">Verificar</button>
                </form>
                <a href="login.php" class="back-button">Voltar para o Login.</a>
            </div>
            <div id="mudanca-senha" style="display: none;">
                <!-- Conteúdo para mudança de senha será exibido aqui -->
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/mudarSenha.js"></script>
    <?php include("./template/alert.php"); ?>
</body>

</html>
