function showSweetAlert(message, type, redirectUrl = '') {
    Swal.fire({
        title: type.charAt(0).toUpperCase() + type.slice(1),
        text: message,
        icon: type,
        showConfirmButton: false,
        timer: 3000 // Exibe o alerta por 1 segundo
    }).then((result) => {
        if (redirectUrl) {
            window.location.href = redirectUrl; // Redireciona se houver uma URL de redirecionamento
        }
        clearAlertSession(); // Chama a função para limpar os dados do alerta da sessão após 1 segundo
    });
}

function clearAlertSession() {
    fetch('./template/clear_alert.php') // Realiza uma solicitação para o PHP que limpa a sessão
        .then(response => response.json())
        .then(data => console.log('Alert session cleared:', data))
        .catch(error => console.error('Failed to clear alert session:', error));
}
