// resource/js/spa.js

// ======================================================
// FUNCIONES GLOBALES
// ======================================================

/**
 * Fetches the current cart status and updates the navbar badge
 */
function updateNavbarCart() {
    fetch('controller/carrito_status_c.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cartLink = document.querySelector('.cart-link');
                let badge = document.querySelector('.cart-badge');
                
                // Check if we have items
                if (data.total_items > 0) {
                    const priceFormatted = parseFloat(data.total_precio).toFixed(2);
                    const text = `${data.total_items} | ${priceFormatted}€`;
                    
                    if (badge) {
                        // Update existing badge
                        badge.textContent = text;
                    } else if (cartLink) {
                        // Create badge if it doesn't exist
                        badge = document.createElement('span');
                        badge.className = 'cart-badge';
                        badge.textContent = text;
                        cartLink.appendChild(badge);
                    }
                } else {
                    // Remove badge if cart is empty
                    if (badge) badge.remove();
                }
            }
        })
        .catch(err => console.error('Error updating navbar:', err));
}

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
            alert('✅ ¡Producto añadido al carrito!');
            
            // 1. Update the Navbar Badge without reloading the page
            updateNavbarCart();
            
            // 2. If we are currently on the cart page, reload the content too
            if (window.location.href.includes('accio=carrito')) {
                cargarContenido('index.php?accio=carrito', false);
            }
        } else {
            alert('❌ Error: ' + (data.error || 'No se pudo añadir.'));
            if(data.error === 'Debes iniciar sesión') {
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
            // 1. Reload the cart table (Main Content)
            cargarContenido('index.php?accio=carrito', false); 
            
            // 2. Update the Navbar Badge
            updateNavbarCart();
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
        
        if (link && 
            link.href.includes(window.location.origin) && 
            !link.getAttribute('target') &&
            !link.classList.contains('no-spa') &&
            !link.href.includes('#')) { 
            
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

    window.addEventListener('popstate', () => {
        cargarContenido(window.location.href, false);
    });
});

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

        if (response.url !== form.action && !response.url.includes('accio=')) {
             window.location.reload();
             return;
        }

        const html = await response.text();
        const mainContainer = document.querySelector('main.container');
        if(mainContainer) mainContainer.innerHTML = html;
        
        // After forms like checkout, update nav too
        updateNavbarCart();

    } catch (error) {
        console.error(error);
    }
}