let icono = document.getElementById('icono-password'),
    inputUsuario = document.getElementById('usuario'),
    inputPassword = document.getElementById('password'),
    errorUsuario = document.getElementById('error-usuario'),
    errorPassword = document.getElementById('error-password'),
    formulario = document.getElementById('frm-login'),
    contador = 0,
    spanCrYear = document.getElementById('cr-year'),
    fecha = new Date();

// Año Copyright
spanCrYear.textContent = fecha.getFullYear();

// Funcionalidad de mostrar contraseña en input
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

// Validación de formulario de login

function asignarError(texto, control) {
    control.textContent = texto;
}

function estaVacio(control) {
    if(control.value.trim().length == 0) {
        return true;
    }
    return false;
}


inputUsuario.addEventListener('keyup', function() {
    if (estaVacio(inputUsuario)) {
        asignarError('Ingrese su nombre de usuario.', errorUsuario);
        inputUsuario.className = 'form-control hay-error';
    } else {
        asignarError('', errorUsuario);
        inputUsuario.className = 'form-control correcto';
    }
});

inputUsuario.addEventListener('blur', function() {
    if (estaVacio(inputUsuario)) {
        asignarError('Ingrese su nombre de usuario.', errorUsuario);
        inputUsuario.className = 'form-control hay-error';
    } else {
        asignarError('', errorUsuario);
        inputUsuario.className = 'form-control correcto';
    }
});


inputPassword.addEventListener('keyup', function() {
    if (estaVacio(inputPassword)) {
        asignarError('Ingrese su contraseña.', errorPassword);
        inputPassword.className = 'form-control hay-error';
    } else {
        asignarError('', errorPassword);
        inputPassword.className = 'form-control correcto';
    }
});

inputPassword.addEventListener('blur', function() {
    if (estaVacio(inputPassword)) {
        asignarError('Ingrese su contraseña.', errorPassword);
        inputPassword.className = 'form-control hay-error';
    } else {
        asignarError('', errorPassword);
        inputPassword.className = 'form-control correcto';
    }
});

formulario.addEventListener('submit', function(e) {
    let errores = 0;

    if (estaVacio(inputUsuario)) {
        asignarError('Ingrese su nombre de usuario.', errorUsuario);
        inputUsuario.className = 'form-control hay-error';
        errores += 1;
    }

    if (estaVacio(inputPassword)) {
        asignarError('Ingrese su contraseña.', errorPassword);
        inputPassword.className = 'form-control hay-error';
        errores += 1;
    }

    if (errores > 0)
        e.preventDefault();
});




