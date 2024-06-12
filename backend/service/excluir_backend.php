<?php

include("../database/connection.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    if ($conn->connect_error) {
        $error_message = "Falha na conexão com o banco de dados: " . $conn->connect_error;
    }

    try {
        // Verifica se o usuario existe
        $check_stmt = $conn->prepare("SELECT * FROM pessoa WHERE id = ?");
        if (!$check_stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows < 0) {
            throw new Exception("Erro: Usuário não existe.");
        }

        // Atualiza os dados na tabela pessoa
        $stmt = $conn->prepare("DELETE FROM pessoa WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: ../../index.php");
            exit();
        } else {
            throw new Exception("Erro ao atualizar: " . $stmt->error);
        }

        $stmt->close();
        $check_stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }

    if (!empty($error_message)) {
        header("Location: ../../excluir.php?error=" . urlencode($error_message));
        exit();
    }
}
?>
