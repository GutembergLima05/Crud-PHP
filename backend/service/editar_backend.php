<?php

include("../database/connection.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $email = $_POST["email"];
    $nome = $_POST["nome"];
    $nascimento = $_POST["nascimento"];
    $endereco = $_POST["endereco"];

    if ($conn->connect_error) {
        $error_message = "Falha na conexão com o banco de dados: " . $conn->connect_error;
    }

    try {
        // Verifica se o email já está cadastrado por outro registro
        $check_stmt = $conn->prepare("SELECT id FROM pessoa WHERE email = ? AND id != ?");
        if (!$check_stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $check_stmt->bind_param("si", $email, $id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            throw new Exception("Erro: Email já cadastrado.");
        }

        // Atualiza os dados na tabela pessoa
        $stmt = $conn->prepare("UPDATE pessoa SET email = ?, nome = ?, nascimento = ?, endereco = ? WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("ssssi", $email, $nome, $nascimento, $endereco, $id);

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
        header("Location: ../../editar.php?error=" . urlencode($error_message));
        exit();
    }
}
?>
