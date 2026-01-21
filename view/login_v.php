<div class="login-container">
    <h2>Iniciar Sesión</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="index.php?accio=login" class="form-login" id="form-login">
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
        
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>
    
    <p>¿No tienes cuenta? <a href="index.php?accio=registre">Regístrate aquí</a></p>
</div>