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
            // Atualizar variáveis de sessão apenas se a operação for bem-sucedida
            $_SESSION['usuario'] = $usuario;
            $_SESSION['alert_message'] = "Dados atualizados com sucesso!";
            $_SESSION['alert_type'] = "success";
            $_SESSION['redirect_url'] = "index.php"; // Altere conforme necessário

            // Fechar statement e conexão
            $stmt->close();
            $conn->close();

            // Redirecionar para a página de perfil
            header("Location: ../../perfil.php");
            exit();
        } else {
            throw new Exception("Erro ao alterar dados: " . $stmt->error);
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        if (strpos($e->getMessage(), "Duplicate entry") !== false) {
            $_SESSION['alert_message'] = "Erro: Já existe um usuário com este nome.";
        } else {
            $_SESSION['alert_message'] = $e->getMessage();
        }
        $_SESSION['alert_type'] = "error";
        $_SESSION['redirect_url'] = "perfil.php"; // Altere conforme necessário

        // Redirecionar para a página de perfil em caso de erro
        header("Location: ../../perfil.php");
        exit();
    }
}
?>
