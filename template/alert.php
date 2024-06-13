<?php
if (isset($_SESSION['alert_message']) && !empty($_SESSION['alert_message'])) {
    echo '<script src="./js/alert.js"></script>'; 
    echo '<script>';
    echo 'showSweetAlert("' . $_SESSION['alert_message'] . '", "' . $_SESSION['alert_type'] . '", "' . (isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : '') . '");';
    echo '</script>';

    // Limpa os dados do alerta da sessão após exibição
    echo '<script>';
    echo 'clearAlertSession();'; // Chama a função para limpar os dados do alerta da sessão
    echo '</script>';
}
?>
