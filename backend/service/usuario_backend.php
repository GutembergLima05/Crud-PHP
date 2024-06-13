<?php
include("../database/connection.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $cargo = $_POST["cargo"];

    // Verifica se o usuário já está cadastrado
    $check_stmt = $conn->prepare("SELECT usuario FROM usuario WHERE usuario = ?");
    if (!$check_stmt) {
        $error_message = "Falha na preparação da consulta: " . $conn->error;
    } else {
        try {
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
                header("Location: ../../login.php");
                exit();
            } else {
                throw new Exception("Erro ao cadastrar usuário: " . $insert_stmt->error);
            }

            $insert_stmt->close();
            $check_stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }
    }

    if (!empty($error_message)) {
        header("Location: ../../usuario.php?error=" . urlencode($error_message));
        exit();
    }
}
?>
