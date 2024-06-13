<?php
session_start();
include("../database/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $cargo = $_POST["cargo"];

    try {
        // Verifica se o usuário já está cadastrado
        $check_stmt = $conn->prepare("SELECT usuario FROM usuario WHERE usuario = ?");
        if (!$check_stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }

        $check_stmt->bind_param("s", $usuario);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            throw new Exception("Erro: Usuário já cadastrado.");
        }

        // Criptografia da senha
        $hashed_senha = password_hash($senha, PASSWORD_DEFAULT);

        // Insere os dados na tabela de usuários
        $insert_stmt = $conn->prepare("INSERT INTO usuario (usuario, senha, cargo) VALUES (?, ?, ?)");
        if (!$insert_stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }

        $insert_stmt->bind_param("sss", $usuario, $hashed_senha, $cargo);

        if ($insert_stmt->execute()) {
            // Definindo mensagem de sucesso
            $_SESSION['alert_message'] = "Usuário cadastrado com sucesso!";
            $_SESSION['alert_type'] = "success";
            $_SESSION['redirect_url'] = "login.php";

            header("Location: ../../usuario.php");
            exit();
        } else {
            throw new Exception("Erro ao cadastrar usuário: " . $insert_stmt->error);
        }

        $insert_stmt->close();
        $check_stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();

        // Definindo mensagem de erro
        $_SESSION['alert_message'] = $error_message;
        $_SESSION['alert_type'] = "error";
        $_SESSION['redirect_url'] = "usuario.php";

        header("Location: ../../usuario.php");
        exit();
    }
}
?>
