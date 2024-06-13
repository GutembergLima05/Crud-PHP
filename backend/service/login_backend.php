<?php

include("../database/connection.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    // Verifica se o usuário existe e se a senha está correta
    $stmt = $conn->prepare("SELECT id, usuario, senha, cargo FROM usuario WHERE usuario = ?");
    if (!$stmt) {
        $error_message = "Falha na preparação da consulta: " . $conn->error;
    } else {
        try {
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $db_usuario, $db_senha, $db_cargo);
                $stmt->fetch();

                // Verifica se a senha fornecida corresponde à senha criptografada no banco de dados
                if (password_verify($senha, $db_senha)) {
                    session_start();
                    // Senha correta, define variáveis de sessão e redireciona para a página inicial
                    $_SESSION["id"] = $id;
                    $_SESSION["usuario"] = $db_usuario;
                    $_SESSION["cargo"] = $db_cargo; 
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
        }
    }

    if (!empty($error_message)) {
        header("Location: ../../login.php?error=" . urlencode($error_message));
        exit();
    }
}
?>
