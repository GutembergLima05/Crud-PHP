<?php
session_start();

include("../database/connection.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    if ($conn->connect_error) {
        $error_message = "Falha na conexão com o banco de dados: " . $conn->connect_error;
    }

    try {
        // Verifica se o usuário existe
        $check_stmt = $conn->prepare("SELECT * FROM pessoa WHERE id = ?");
        if (!$check_stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows == 0) {
            throw new Exception("Erro: Usuário não existe.");
        }

        // Exclui o usuário da tabela pessoa
        $stmt = $conn->prepare("DELETE FROM pessoa WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Define mensagem de sucesso
            $_SESSION['alert_message'] = "Usuário excluído com sucesso!";
            $_SESSION['alert_type'] = "success";
            $_SESSION['redirect_url'] = "index.php";
        } else {
            throw new Exception("Erro ao excluir: " . $stmt->error);
        }

        $stmt->close();
        $check_stmt->close();
        $conn->close();

        // Redireciona para a página inicial após a exclusão bem-sucedida
        header("Location: ../../excluir.php");
        exit();
    } catch (Exception $e) {
        $error_message = $e->getMessage();

        // Define mensagem de erro
        $_SESSION['alert_message'] = $error_message;
        $_SESSION['alert_type'] = "error";
        $_SESSION['redirect_url'] = "excluir.php";

        // Redireciona para a página de exclusão com mensagem de erro
        header("Location: ../../excluir.php");
        exit();
    }
}
?>
