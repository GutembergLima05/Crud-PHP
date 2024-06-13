<?php
include("../database/connection.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    if ($conn->connect_error) {
        $error_message = "Falha na conexão com o banco de dados: " . $conn->connect_error;
    }

    try {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Atualiza a senha
        $stmt = $conn->prepare("UPDATE usuario SET senha = ? WHERE usuario = ?");
        if (!$stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("ss", $senha_hash, $usuario);

        if ($stmt->execute()) {
            header("Location: ../../login.php");
            exit();
        } else {
            throw new Exception("Erro ao mudar senha: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }

    if (!empty($error_message)) {
        header("Location: ../../mudar-senha.php?error=" . urlencode($error_message));
        exit();
    }
}
?>
