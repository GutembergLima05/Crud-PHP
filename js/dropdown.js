document.addEventListener('DOMContentLoaded', function() {
    var dropdownToggle = document.getElementById('dropdown-toggle');
    var dropdownContent = document.querySelector('.dropdown-content');

    dropdownToggle.addEventListener('click', function() {
        dropdownContent.classList.toggle('show');
    });

    // Fechar o dropdown se clicar fora dele
    window.addEventListener('click', function(event) {
        if (!dropdownToggle.contains(event.target)) {
            dropdownContent.classList.remove('show');
        }
    });
});