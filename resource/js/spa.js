// resource/js/spa.js

// ======================================================
// FUNCIONES GLOBALES (Deben estar FUERA del DOMContentLoaded)
// ======================================================

function addToCart(productoId, isDetail = false) {
    let cantidad = 1;
    if (isDetail) {
        const select = document.getElementById('cantidad-detalle');
        cantidad = select ? parseInt(select.value) : 1;
    } else {
        const input = document.getElementById('qty-' + productoId);
        cantidad = input ? parseInt(input.value) : 1;
    }

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
            // Actualización visual simple (puedes mejorarla actualizando solo el badge)
            alert('✅ ¡Producto añadido al carrito!');
            
            // Recargamos SOLO el header si tuviéramos una función para ello,
            // o recargamos la página si no hay más remedio (rompe un poco la SPA pero asegura consistencia)
            // Para SPA pura: Deberías tener una función updateCartBadge() que haga fetch al header.
            // Por ahora, location.reload() es lo más seguro para sincronizar el menú.
            location.reload(); 
        } else {
            alert('❌ Error: ' + (data.error || 'No se pudo añadir.'));
            if(data.error === 'Debes iniciar sesión') {
                // Redirigir al login usando la SPA
                cargarContenido('index.php?accio=login');
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateCart(id, accion) {
    fetch('controller/carrito_update_c.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ producto_id: id, accion: accion })
    })
    .then(r => r.json())
    .then(data => {
        if(data.success) {
            // Recargamos el contenido actual (el carrito)
            cargarContenido('index.php?accio=carrito', false); 
            // Nota: Si el badge del menú debe cambiar, necesitarías actualizarlo aparte
        } else {
            alert('Error: ' + (data.error || 'Desconocido'));
        }
    })
    .catch(err => console.error(err));
}

// ======================================================
// LÓGICA SPA (Se ejecuta al cargar la página)
// ======================================================

document.addEventListener('DOMContentLoaded', () => {
    console.log("SPA Iniciada");

    // 1. NAVEGACIÓN: Interceptar clicks en enlaces <a>
    document.body.addEventListener('click', e => {
        const link = e.target.closest('a');
        
        // Verificamos si es un enlace interno válido para SPA
        if (link && 
            link.href.includes(window.location.origin) && 
            !link.getAttribute('target') &&
            !link.classList.contains('no-spa') &&
            !link.href.includes('#')) { // Ignorar anclas internas
            
            e.preventDefault(); 
            cargarContenido(link.href);
        }
    });

    // 2. FORMULARIOS: Interceptar envíos
    document.body.addEventListener('submit', e => {
        const form = e.target;
        if (form.action.includes(window.location.origin) && !form.classList.contains('no-spa')) {
            e.preventDefault();
            handleFormSubmit(form);
        }
    });

    // 3. Manejar botones de Atrás/Adelante del navegador
    window.addEventListener('popstate', () => {
        cargarContenido(window.location.href, false);
    });
});

// FUNCIÓN CORE: Cargar contenido
async function cargarContenido(url, pushToHistory = true) {
    const mainContainer = document.querySelector('main.container');
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
                
                // Re-ejecutar scripts que vengan en el HTML (si los hubiera)
                // Aunque tu enfoque actual usa funciones globales, esto es buena práctica
                const scripts = mainContainer.querySelectorAll("script");
                scripts.forEach(script => eval(script.innerText));
            }

            if (pushToHistory) {
                history.pushState({}, '', url);
            }
        } else {
            console.error('Error HTTP:', response.status);
        }
    } catch (error) {
        console.error('Error de conexión:', error);
    }
}

async function handleFormSubmit(form) {
    const formData = new FormData(form);
    
    try {
        const response = await fetch(form.action, {
            method: form.method || 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        // Si la URL cambió (redirección de PHP), recargamos para actualizar estado (Login/Logout)
        if (response.url !== form.action && !response.url.includes('accio=')) {
             window.location.reload();
             return;
        }

        const html = await response.text();
        const mainContainer = document.querySelector('main.container');
        if(mainContainer) mainContainer.innerHTML = html;

    } catch (error) {
        console.error(error);
    }
}