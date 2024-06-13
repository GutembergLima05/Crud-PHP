<?php
session_start();

include("../database/connection.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $id_logado = $_SESSION['id'];

    if ($conn->connect_error) {
        $error_message = "Falha na conexão com o banco de dados: " . $conn->connect_error;
    }

    try {
        // Verifica se o usuário existe
        $check_stmt = $conn->prepare("SELECT usuario FROM usuario WHERE id = ?");
        if (!$check_stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $check_stmt->bind_param("i", $id_logado);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows <= 0) {
            throw new Exception("Erro: Usuário não existe");
        }

        // Verificação da senha digitada
        if (!empty($senha)) {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE usuario SET usuario = ?, senha = ? WHERE id = ?");
            $stmt->bind_param("ssi", $usuario, $senha_hash, $id_logado);
        } else {
            $stmt = $conn->prepare("UPDATE usuario SET usuario = ? WHERE id = ?");
            $stmt->bind_param("si", $usuario, $id_logado);
        }

        if (!$stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }

        if ($stmt->execute()) {
            header("Location: ../../login.php");
            exit();
        } else {
            throw new Exception("Erro ao alterar dados: " . $stmt->error);
        }

        $stmt->close();
        $check_stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }

    if (!empty($error_message)) {
        header("Location: ../../perfil.php?error=" . urlencode($error_message));
        exit();
    }
}
?>
