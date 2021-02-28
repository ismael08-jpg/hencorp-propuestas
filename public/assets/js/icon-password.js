let icono = document.getElementById('icono-password');
let inputPassword = document.getElementById('password');
let contador = 0;

icono.addEventListener('click', function(){
    if (contador == 0) {
        icono.className = 'fas fa-eye icono-password';
        inputPassword.type = 'text';
        contador += 1;
    } else {
        icono.className = 'fas fa-eye-slash icono-password';
        inputPassword.type = 'password';
        contador = 0;
    }
});