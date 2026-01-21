<div class="login-container">
    <h2>Iniciar Sesión</h2>
    
    <div id="login-feedback"></div>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form id="form-login" class="form-login">
        <div class="form-group">
            <label for="email">Email *</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                required 
                placeholder="tu@email.com">
        </div>
        
        <div class="form-group">
            <label for="contrasena">Contraseña *</label>
            <input 
                type="password" 
                id="contrasena" 
                name="contrasena" 
                required 
                minlength="6">
        </div>
        
        <button type="submit" id="btn-login" class="btn btn-primary">Iniciar Sesión</button>
    </form>
    
    <p>¿No tienes cuenta? <a href="index.php?accio=registre">Regístrate aquí</a></p>
</div>

<script>
// Interceptar el formulario de Login para hacerlo estilo SPA
document.getElementById('form-login').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('btn-login');
    const feedback = document.getElementById('login-feedback');
    const formData = new FormData(this);
    
    btn.disabled = true;
    btn.innerText = "Verificando...";
    feedback.innerHTML = '';

    // Enviamos a la URL de login pero esperando JSON (requiere que login_c.php soporte JSON o devuelva HTML)
    // TRUCO: Como tu login_c.php original probablemente redirige o devuelve HTML completo,
    // para mantenerlo simple en esta práctica, usaremos POST normal via fetch
    // y miraremos si la respuesta contiene "error" o si redirige.
    
    fetch('index.php?accio=login', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(html => {
        // Si el HTML devuelto contiene el texto "Cerrar Sesión", significa que entramos bien
        if (html.includes('accio=logout')) {
             window.location.href = 'index.php'; // Recargar para ver menú actualizado
        } else {
             // Si seguimos en login, buscamos el mensaje de error en el HTML devuelto
             // O simplemente mostramos el HTML nuevo en el contenedor principal
             const parser = new DOMParser();
             const doc = parser.parseFromString(html, 'text/html');
             const errorBox = doc.querySelector('.alert-error');
             
             if(errorBox) {
                 feedback.innerHTML = errorBox.outerHTML;
             } else {
                 // Si no hay error claro pero no logueó, cargamos todo el contenido
                 document.querySelector('main.container').innerHTML = html;
             }
             btn.disabled = false;
             btn.innerText = "Iniciar Sesión";
        }
    })
    .catch(err => {
        console.error(err);
        feedback.innerHTML = '<div class="alert alert-error">Error de conexión</div>';
        btn.disabled = false;
        btn.innerText = "Iniciar Sesión";
    });
});
</script>