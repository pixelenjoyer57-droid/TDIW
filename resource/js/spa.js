// resource/js/spa.js

document.addEventListener('DOMContentLoaded', () => {
    console.log("SPA y Funciones Globales Cargadas");

    // ======================================================
    // 1. NAVEGACIÓN: Interceptar clicks en enlaces <a>
    // ======================================================
    document.body.addEventListener('click', e => {
        const link = e.target.closest('a');
        
        // Si es enlace interno, no es descarga y no fuerza recarga
        if (link && 
            link.href.includes(window.location.origin) && 
            !link.getAttribute('target') &&
            !link.classList.contains('no-spa')) { 
            
            e.preventDefault(); 
            cargarContenido(link.href);
        }
    });

    // ======================================================
    // 2. FORMULARIOS: Interceptar envíos (Login, Registro, etc)
    // ======================================================
    document.body.addEventListener('submit', e => {
        const form = e.target;
        
        // Solo interceptamos formularios internos que no sean de subida de archivos (opcional)
        // y que no tengan la clase no-spa.
        if (form.action.includes(window.location.origin) && !form.classList.contains('no-spa')) {
            e.preventDefault();
            handleFormSubmit(form);
        }
    });

    // ======================================================
    // 3. VALIDACIÓN EN VIVO (Delegación de eventos)
    // ======================================================
    // Validación de contraseñas en registro
    document.body.addEventListener('input', e => {
        if (e.target.id === 'contrasena' || e.target.id === 'contrasena_confirmar') {
            const form = e.target.closest('form');
            if (form && form.id === 'formRegistro') {
                validarContrasenas(form);
            }
        }
    });

    // 4. Manejar botones de Atrás/Adelante del navegador
    window.addEventListener('popstate', () => {
        cargarContenido(window.location.href, false);
    });
});

/**
 * Carga contenido HTML en el contenedor principal
 */
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
            }

            if (pushToHistory) {
                history.pushState({}, '', url);
            }
        } else {
            console.error('Error HTTP:', response.status);
            if(mainContainer) mainContainer.innerHTML = '<p>Error al cargar el contenido.</p>';
        }
    } catch (error) {
        console.error('Error de conexión:', error);
    }
}

/**
 * Maneja el envío de formularios via AJAX
 */
async function handleFormSubmit(form) {
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.innerText : '';
    
    // Feedback visual
    if(submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerText = "Procesando...";
    }

    try {
        // Enviamos los datos a la URL del action del formulario
        const response = await fetch(form.action, {
            method: form.method || 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const html = await response.text();

        // LOGICA DE REDIRECCIÓN INTELIGENTE:
        // Si la respuesta contiene una redirección o detectamos que hemos cambiado de estado
        // (Por ejemplo, si login nos devuelve el logout link, es que entramos)
        
        // Simplemente actualizamos el contenedor principal con lo que devuelva el servidor
        // El servidor (PHP) debe decidir si devuelve la vista de "éxito", la de "error" o redirige.
        const mainContainer = document.querySelector('main.container');
        
        // Caso especial: Si es Login exitoso, PHP suele mandar header("Location: index.php").
        // Fetch sigue la redirección automáticamente. Si acabamos en la portada, recargamos
        // para actualizar el menú (que está fuera del main).
        if (response.url.endsWith('index.php') || response.url.endsWith('index.php/')) {
             window.location.reload(); // Recarga completa necesaria para actualizar header/menú
             return;
        }

        if(mainContainer) {
            mainContainer.innerHTML = html;
            mainContainer.style.opacity = '1';
        }
        
        // Actualizamos URL si cambió (opcional)
        history.pushState({}, '', response.url);

    } catch (error) {
        console.error(error);
        alert("Error de conexión al enviar formulario");
    } finally {
        if(submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerText = originalText;
        }
    }
}

/**
 * Validación de contraseñas (Lógica movida desde registre_v.php)
 */
function validarContrasenas(form) {
    const pass1 = form.querySelector('#contrasena');
    const pass2 = form.querySelector('#contrasena_confirmar');
    const errorMsg = form.querySelector('#pass-error'); // Asegúrate de que este ID exista en tu vista

    if (pass1 && pass2 && errorMsg) {
        if (pass2.value && pass1.value !== pass2.value) {
            pass2.setCustomValidity("Las contraseñas no coinciden");
            errorMsg.style.display = 'block';
        } else {
            pass2.setCustomValidity("");
            errorMsg.style.display = 'none';
        }
    }
}

// ======================================================
// FUNCIONES GLOBALES (Carrito, etc.)
// ======================================================

function addToCart(productoId, isDetail = false) {
    // Si estamos en detalle, buscamos el select, si no, buscamos el input del listado
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
            // Recargar para actualizar badge del menú (solución simple)
            location.reload();
        } else {
            alert('❌ Error: ' + (data.error || 'No se pudo añadir.'));
            if(data.error === 'Debes iniciar sesión') {
                cargarContenido('index.php?accio=login');
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

// ESTA FUNCIÓN FALTABA EN TU CÓDIGO ANTERIOR
function updateCart(id, accion) {
    fetch('controller/carrito_update_c.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ producto_id: id, accion: accion })
    })
    .then(r => r.json())
    .then(data => {
        if(data.success) {
            // Recargamos el contenido actual (la vista del carrito)
            // No usamos reload() completo para que sea fluido, pero
            // necesitamos actualizar el menú superior también, así que reload() es más seguro
            // o cargarContenido + fetch menú. Por simplicidad:
            location.reload(); 
        } else {
            alert('Error: ' + (data.error || 'Desconocido'));
        }
    })
    .catch(err => console.error(err));
}