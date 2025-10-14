/**
 * JavaScript principal de Fashion Store
 * Maneja validaciones y funcionalidades del lado del cliente
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

/**
 * Validación de formularios
 */
function validarFormulario(formulario) {
    if (!formulario.checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
    }
    formulario.classList.add('was-validated');
}

/**
 * Confirmar eliminación
 */
function confirmarEliminacion() {
    return confirm('¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.');
}

/**
 * Limpiar formulario
 */
function limpiarFormulario(formularioId) {
    const formulario = document.getElementById(formularioId);
    if (formulario) {
        formulario.reset();
        formulario.classList.remove('was-validated');
    }
}

/**
 * Mostrar/Ocultar contraseña
 */
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelectorAll('.toggle-password');
    
    togglePassword.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
});

/**
 * Validar teléfono en tiempo real
 */
document.addEventListener('DOMContentLoaded', function() {
    const inputTelefono = document.querySelectorAll('input[type="tel"]');
    
    inputTelefono.forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
});

/**
 * Mostrar alerta de confirmación
 */
function mostrarAlerta(mensaje, tipo = 'info') {
    const alertContainer = document.createElement('div');
    alertContainer.className = 'alert alert-' + tipo + ' alert-dismissible fade show';
    alertContainer.role = 'alert';
    alertContainer.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const contenedor = document.querySelector('.container');
    if (contenedor) {
        contenedor.insertBefore(alertContainer, contenedor.firstChild);
    }
}