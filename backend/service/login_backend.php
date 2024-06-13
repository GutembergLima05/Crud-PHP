<?php
session_start();
include("../database/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    try {
        // Verifica se o usuário existe e se a senha está correta
        $stmt = $conn->prepare("SELECT id, usuario, senha, cargo FROM usuario WHERE usuario = ?");
        if (!$stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $db_usuario, $db_senha, $db_cargo);
            $stmt->fetch();

            // Verifica se a senha fornecida corresponde à senha criptografada no banco de dados
            if (password_verify($senha, $db_senha)) {
                // Senha correta, define variáveis de sessão
                $_SESSION["id"] = $id;
                $_SESSION["usuario"] = $db_usuario;
                $_SESSION["cargo"] = $db_cargo;

                // Define mensagem de sucesso
                $_SESSION['alert_message'] = "Login realizado com sucesso!";
                $_SESSION['alert_type'] = "success";
                $_SESSION['redirect_url'] = "index.php";

                // Redireciona para a página inicial
                header("Location: ../../index.php");
                exit();
            } else {
                throw new Exception("Senha incorreta.");
            }
        } else {
            throw new Exception("Usuário não encontrado.");
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();

        // Definindo mensagem de erro
        $_SESSION['alert_message'] = $error_message;
        $_SESSION['alert_type'] = "error";
        $_SESSION['redirect_url'] = "login.php";

        header("Location: ../../login.php");
        exit();
    }
}
?>
