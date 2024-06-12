<?php

include("../database/connection.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $nome = $_POST["nome"];
    $nascimento = $_POST["nascimento"];
    $endereco = $_POST["endereco"];

    if ($conn->connect_error) {
        $error_message = "Falha na conexão com o banco de dados: " . $conn->connect_error;
    }

    try {
        // Verifica se o email já está cadastrado
        $check_stmt = $conn->prepare("SELECT email FROM pessoa WHERE email = ?");
        if (!$check_stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            throw new Exception("Erro: Email já cadastrado.");
        }

        // Insere os dados na tabela pessoa
        $stmt = $conn->prepare("INSERT INTO pessoa (email, nome, nascimento, endereco) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("ssss", $email, $nome, $nascimento, $endereco);

        if ($stmt->execute()) {
            header("Location: ../../index.php");
            exit();
        } else {
            throw new Exception("Erro ao cadastrar: " . $stmt->error);
        }

        $stmt->close();
        $check_stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }

    if (!empty($error_message)) {
        header("Location: ../../cadastro.php?error=" . urlencode($error_message));
        exit();
    }
}
?>
