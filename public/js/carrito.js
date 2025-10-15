class Carrito {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.actualizarContadorGlobal();
    }

    bindEvents() {
        // Botones toggle del carrito (escritorio y móvil)
        document.getElementById('btn-carrito')?.addEventListener('click', () => this.toggleCarrito());
        document.getElementById('btn-carrito-mobile')?.addEventListener('click', () => this.toggleCarrito());
        
        // Cerrar carrito al hacer clic fuera o en la X
        document.addEventListener('click', (e) => this.cerrarCarritoExterno(e));
        
        // Agregar productos al carrito
        document.addEventListener('click', (e) => {
            if (e.target.closest('.agregar-carrito')) {
                this.agregarProducto(e);
            }
        });

        // Actualizar panel del carrito inicialmente
        this.actualizarPanel();
    }

    toggleCarrito() {
        const panel = document.getElementById('carrito-panel');
        const overlay = document.getElementById('carrito-overlay');
        
        if (panel.classList.contains('show')) {
            this.cerrarCarrito();
        } else {
            this.abrirCarrito();
        }
    }

    abrirCarrito() {
        const panel = document.getElementById('carrito-panel');
        const overlay = document.getElementById('carrito-overlay');
        
        panel.classList.add('show');
        overlay.classList.add('show');
        this.actualizarPanel();
        
        // Agregar evento para cerrar con ESC
        document.addEventListener('keydown', this.cerrarConEscape.bind(this));
    }

    cerrarCarrito() {
        const panel = document.getElementById('carrito-panel');
        const overlay = document.getElementById('carrito-overlay');
        
        panel.classList.remove('show');
        overlay.classList.remove('show');
        
        // Remover evento ESC
        document.removeEventListener('keydown', this.cerrarConEscape.bind(this));
    }

    cerrarConEscape(e) {
        if (e.key === 'Escape') {
            this.cerrarCarrito();
        }
    }

    cerrarCarritoExterno(e) {
        const panel = document.getElementById('carrito-panel');
        const btnCerrar = document.getElementById('btn-cerrar-carrito');
        const overlay = document.getElementById('carrito-overlay');
        
        // Cerrar al hacer clic en la X
        if (btnCerrar && btnCerrar.contains(e.target)) {
            this.cerrarCarrito();
            return;
        }
        
        // Cerrar al hacer clic fuera del panel
        if (panel && overlay && 
            !panel.contains(e.target) && 
            !e.target.closest('.carrito-btn') &&
            overlay.contains(e.target)) {
            this.cerrarCarrito();
        }
    }

    async actualizarPanel() {
        try {
            const response = await fetch(baseUrl + 'carrito/mostrarPanel');
            
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            
            const html = await response.text();
            
            const panel = document.getElementById('carrito-panel');
            if (panel) {
                panel.innerHTML = html;
                this.bindPanelEvents();
            }
            
            this.actualizarContadorGlobal();
        } catch (error) {
            console.error('Error actualizando panel del carrito:', error);
            this.mostrarMensaje('Error al cargar el carrito', 'error');
        }
    }

    bindPanelEvents() {
        // Eliminar items
        document.querySelectorAll('.eliminar-item').forEach(btn => {
            btn.addEventListener('click', (e) => this.eliminarProducto(e));
        });

        // Control de cantidad
        document.querySelectorAll('.aumentar-cantidad').forEach(btn => {
            btn.addEventListener('click', (e) => this.cambiarCantidad(e, 1));
        });

        document.querySelectorAll('.disminuir-cantidad').forEach(btn => {
            btn.addEventListener('click', (e) => this.cambiarCantidad(e, -1));
        });

        // Vaciar carrito
        document.getElementById('btn-vaciar-carrito')?.addEventListener('click', () => this.vaciarCarrito());
    }

    async agregarProducto(e) {
        e.preventDefault();
        
        const btn = e.target.closest('.agregar-carrito');
        const productoId = btn.getAttribute('data-producto-id');
        
        if (!productoId) {
            this.mostrarMensaje('ID de producto no válido', 'error');
            return;
        }

        // Efecto visual en el botón
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Agregado';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
        }, 1500);

        const cantidad = 1;

        try {
            const formData = new FormData();
            formData.append('cantidad', cantidad);

            const response = await fetch(baseUrl + 'carrito/agregar/' + productoId, {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                this.mostrarMensaje('Producto agregado al carrito', 'success');
                await this.actualizarPanel();
                this.abrirCarrito();
            } else {
                throw new Error('Error del servidor: ' + response.status);
            }
        } catch (error) {
            console.error('Error agregando producto:', error);
            this.mostrarMensaje('Error al agregar producto al carrito', 'error');
        }
    }

    async eliminarProducto(e) {
        e.preventDefault();
        
        const productoId = e.currentTarget.getAttribute('data-producto-id');

        if (!productoId) {
            this.mostrarMensaje('ID de producto no válido', 'error');
            return;
        }

        try {
            const response = await fetch(baseUrl + 'carrito/eliminar/' + productoId);
            
            if (response.ok) {
                this.mostrarMensaje('Producto eliminado del carrito', 'success');
                await this.actualizarPanel();
            } else {
                throw new Error('Error del servidor: ' + response.status);
            }
        } catch (error) {
            console.error('Error eliminando producto:', error);
            this.mostrarMensaje('Error al eliminar producto del carrito', 'error');
        }
    }

    async cambiarCantidad(e, cambio) {
        e.preventDefault();
        
        const productoId = e.currentTarget.getAttribute('data-producto-id');
        const cantidadElement = e.currentTarget.closest('.cantidad-controls').querySelector('.cantidad-value');
        
        if (!productoId || !cantidadElement) {
            this.mostrarMensaje('Error al cambiar cantidad', 'error');
            return;
        }

        let cantidad = parseInt(cantidadElement.textContent) + cambio;

        if (cantidad < 1) cantidad = 1;

        try {
            const formData = new FormData();
            formData.append('cantidad', cantidad);

            const response = await fetch(baseUrl + 'carrito/actualizar/' + productoId, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                cantidadElement.textContent = cantidad;
                await this.actualizarPanel(); // Actualizar todo el panel para recalcular total
            } else {
                this.mostrarMensaje(result.message, 'error');
            }
        } catch (error) {
            console.error('Error actualizando cantidad:', error);
            this.mostrarMensaje('Error actualizando cantidad', 'error');
        }
    }

    async vaciarCarrito() {
        if (!confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
            return;
        }

        try {
            const response = await fetch(baseUrl + 'carrito/vaciar');
            
            if (response.ok) {
                this.mostrarMensaje('Carrito vaciado', 'success');
                await this.actualizarPanel();
            } else {
                throw new Error('Error del servidor: ' + response.status);
            }
        } catch (error) {
            console.error('Error vaciando carrito:', error);
            this.mostrarMensaje('Error al vaciar carrito', 'error');
        }
    }

    actualizarContadorGlobal() {
        // Actualizar ambos contadores (escritorio y móvil)
        const contadores = [
            document.getElementById('carrito-contador'),
            document.getElementById('carrito-contador-mobile')
        ];
        
        contadores.forEach(contador => {
            if (contador) {
                // Calcular total de items sumando cantidades
                let totalItems = 0;
                const carritoItems = document.querySelectorAll('.carrito-item');
                
                carritoItems.forEach(item => {
                    const cantidad = parseInt(item.querySelector('.cantidad-value')?.textContent || '0');
                    totalItems += cantidad;
                });
                
                if (totalItems > 0) {
                    contador.textContent = totalItems > 99 ? '99+' : totalItems;
                    contador.style.display = 'flex';
                } else {
                    contador.style.display = 'none';
                }
            }
        });
    }

    mostrarMensaje(mensaje, tipo = 'info') {
        // Sistema de notificaciones mejorado
        const toast = document.createElement('div');
        toast.className = `alert alert-${tipo === 'error' ? 'danger' : tipo === 'success' ? 'success' : 'info'} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 1060; min-width: 300px;';
        toast.innerHTML = `
            <strong>${tipo === 'error' ? '❌ Error' : tipo === 'success' ? '✅ Éxito' : 'ℹ️ Info'}</strong>
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto-eliminar después de 4 segundos
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 4000);
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    if (typeof baseUrl === 'undefined') {
        console.error('baseUrl no está definida. Asegúrate de definirla en el header.');
        return;
    }
    
    window.carrito = new Carrito();
});