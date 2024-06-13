
$(document).ready(function () {
    $('#form-verificar-usuario').submit(function (event) {
        event.preventDefault();

        var usuario = $('#usuario').val();

        $.ajax({
            type: 'POST',
            url: 'backend/service/validarUsuario_backend.php',
            data: { usuario: usuario },
            success: function (response) {

                $('#verificacao-usuario').hide();
                $('#mudanca-senha').html(response).show();
            },
            error: function () {
                alert('Erro ao verificar usuário. Por favor, tente novamente.');
            }
        });
    });
});