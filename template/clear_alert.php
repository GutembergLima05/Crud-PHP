<?php
session_start();

// Limpa apenas os dados do alerta da sessão, se existirem
if (isset($_SESSION['alert_message'])) {
    unset($_SESSION['alert_message']);
}
if (isset($_SESSION['alert_type'])) {
    unset($_SESSION['alert_type']);
}
if (isset($_SESSION['redirect_url'])) {
    unset($_SESSION['redirect_url']);
}

echo json_encode(['status' => 'success']); // Responde com um JSON de sucesso
?>
