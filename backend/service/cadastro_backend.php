<?php

include("../database/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $nascimento = $_POST["nascimento"];
    $endereco = $_POST["endereco"];

    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO pessoa (cpf, nome, nascimento, endereco) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        die("Falha na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("isss", $cpf, $nome, $nascimento, $endereco);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

?>
