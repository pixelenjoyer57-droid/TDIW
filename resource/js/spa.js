// resource/js/spa.js

document.addEventListener('DOMContentLoaded', () => {
    console.log("SPA y Funciones Globales Cargadas");

    // 1. Interceptar clicks en enlaces para navegación SPA
    document.body.addEventListener('click', e => {
        const link = e.target.closest('a');
        
        // Si es un enlace interno, no tiene target="_blank" y no es una descarga
        if (link && 
            link.href.includes(window.location.origin) && 
            !link.getAttribute('target') &&
            !link.classList.contains('no-spa')) { // Clase opcional para saltar SPA
            
            e.preventDefault(); 
            cargarContenido(link.href);
        }
    });

    // 2. Manejar botones de Atrás/Adelante del navegador
    window.addEventListener('popstate', () => {
        cargarContenido(window.location.href, false);
    });
});

/**
 * Función principal para cargar contenido vía AJAX
 */
async function cargarContenido(url, pushToHistory = true) {
    const mainContainer = document.querySelector('main.container');
    
    // Indicador visual de carga (opacidad)
    if(mainContainer) mainContainer.style.opacity = '0.5';

    try {
        const response = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        if (response.ok) {
            const html = await response.text();
            
            if(mainContainer) {
                mainContainer.innerHTML = html;
                mainContainer.style.opacity = '1';
            }

            // Cambiar URL en la barra de dirección
            if (pushToHistory) {
                history.pushState({}, '', url);
            }
            
            // Aquí puedes reinicializar otros scripts si fuera necesario en el futuro
        } else {
            console.error('Error HTTP al cargar:', response.status);
            if(mainContainer) mainContainer.innerHTML = '<p>Error al cargar el contenido.</p>';
        }
    } catch (error) {
        console.error('Error de conexión:', error);
    }
}

/**
 * FUNCIONES GLOBALES (Ej: Carrito)
 * Las movemos aquí para que funcionen siempre, sin importar qué vista se cargue.
 */
function addToCart(productoId) {
    const cantidadInput = document.getElementById('qty-' + productoId);
    const cantidad = cantidadInput ? parseInt(cantidadInput.value) : 1;

    fetch('controller/carrito_add_c.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            producto_id: productoId,
            cantidad: cantidad
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ¡Producto añadido al carrito!');
            // Opcional: Actualizar el contador del menú dinámicamente aquí
            // Por ahora recargamos para ver cambios (en SPA idealmente actualizaríamos solo el DOM del menú)
            location.reload(); 
        } else {
            alert('❌ Error: ' + (data.error || 'No se pudo añadir.'));
            if(data.error === 'Debes iniciar sesión') {
                // Usamos nuestra función SPA para ir al login
                cargarContenido('index.php?accio=login');
            }
        }
    })
    .catch(error => console.error('Error:', error));
}