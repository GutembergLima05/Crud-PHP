<?php
session_start();

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

        // Atualiza os dados na tabela pessoa apenas com os campos que foram enviados
        $update_query = "UPDATE pessoa SET email = ?, nome = ?, nascimento = ?, endereco = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        if (!$stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("ssssi", $email, $nome, $nascimento, $endereco, $id);

        if ($stmt->execute()) {
            // Sucesso ao atualizar
            $_SESSION['alert_message'] = "Dados atualizados com sucesso!";
            $_SESSION['alert_type'] = "success";
            $_SESSION['redirect_url'] = "index.php";
        } else {
            throw new Exception("Erro ao atualizar: " . $stmt->error);
        }

        $stmt->close();
        $check_stmt->close();
        $conn->close();

        header("Location: ../../editar.php");
        exit();
    } catch (Exception $e) {
        $error_message = $e->getMessage();

        // Define mensagem de erro específica se o email estiver duplicado
        if (strpos($error_message, "Erro: Email já cadastrado.") !== false) {
            $_SESSION['alert_message'] = "Erro: Email já cadastrado.";
        } else {
            $_SESSION['alert_message'] = $error_message;
        }

        $_SESSION['alert_type'] = "error";
        $_SESSION['redirect_url'] = "index.php";

        
        header("Location: ../../editar.php");
        exit();
    }
}
?>
