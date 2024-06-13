<?php
include("../database/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];

    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    try {
        // Verifica se o usuário existe
        $check_stmt = $conn->prepare("SELECT usuario FROM usuario WHERE usuario = ?");
        if (!$check_stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $check_stmt->bind_param("s", $usuario);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Se o usuário existir, exiba o formulário para mudança de senha
?>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <p><?php echo htmlspecialchars($usuario); ?></p>
            </div>
            <h2>Mudança de Senha</h2>
            <form action="backend/service/mudar-senha_backend.php" method="post">
                <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
                <input type="password" name="senha" placeholder="Nova Senha" required>
                <button type="submit">Alterar Senha</button>
            </form>
            <a href="login.php" class="change-password-link">Voltar para o login.</a>
        <?php
        } else {
        ?>
            <div class="error-message">
                Usuário não encontrado. Verifique novamente.
            </div>
            <a href="mudar-senha.php" class="back-button">Tentar novamente</a>
<?php
        }

        $check_stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }

    if (!empty($error_message)) {
        header("Location: ../../mudar-senha.php?error=" . urlencode($error_message));
        exit();
    }
}
?>