<!-- view/registre_v.php -->
<div class="registre-container">
    <div class="form-wrapper">
        <h1>📝 Crear Nueva Cuenta</h1>
        <p class="subtitle">Únete a nuestra comunidad de amantes de la comida</p>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($mensaje); ?>
                <p style="margin-top: 1rem;">
                    <a href="index.php?accio=login" class="link-inline">Ir a iniciar sesión →</a>
                </p>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php?accio=registre" class="form-registro" novalidate>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre_usuario">Nombre de Usuario *</label>
                    <input 
                        type="text" 
                        id="nombre_usuario" 
                        name="nombre_usuario" 
                        required 
                        minlength="3"
                        maxlength="50"
                        pattern="[a-zA-Z0-9_-]+"
                        placeholder="usuario123"
                        value="<?php echo htmlspecialchars($form_data['nombre_usuario'] ?? ''); ?>"
                        title="Solo letras, números, guiones y guiones bajos">
                    <small>Entre 3 y 50 caracteres</small>
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        placeholder="tu@email.com"
                        value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>">
                    <small>Usaremos este email para tu cuenta</small>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        required 
                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+"
                        placeholder="Juan"
                        value="<?php echo htmlspecialchars($form_data['nombre'] ?? ''); ?>"
                        title="Solo letras y espacios">
                </div>
                
                <div class="form-group">
                    <label for="apellido">Apellido *</label>
                    <input 
                        type="text" 
                        id="apellido" 
                        name="apellido" 
                        required 
                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+"
                        placeholder="González"
                        value="<?php echo htmlspecialchars($form_data['apellido'] ?? ''); ?>"
                        title="Solo letras y espacios">
                </div>
            </div>
            
            <div class="form-group">
                <label for="numero_telefono">Teléfono (Opcional)</label>
                <input 
                    type="tel" 
                    id="numero_telefono" 
                    name="numero_telefono" 
                    placeholder="+34 666 777 888"
                    value="<?php echo htmlspecialchars($form_data['numero_telefono'] ?? ''); ?>"
                    pattern="[\d\s\+\-\(\)]*"
                    title="Formato: +34 666 777 888">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="contrasena">Contraseña *</label>
                    <input 
                        type="password" 
                        id="contrasena" 
                        name="contrasena" 
                        required 
                        minlength="6"
                        placeholder="Mínimo 6 caracteres">
                    <small>Mínimo 6 caracteres para seguridad</small>
                </div>
                
                <div class="form-group">
                    <label for="contrasena_confirmar">Confirmar Contraseña *</label>
                    <input 
                        type="password" 
                        id="contrasena_confirmar" 
                        name="contrasena_confirmar" 
                        required 
                        minlength="6"
                        placeholder="Repite tu contraseña">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-large">
                ✍️ Crear Cuenta
            </button>
        </form>
        
        <p class="form-footer">
            ¿Ya tienes cuenta? 
            <a href="index.php?accio=login" class="link-inline">Inicia sesión aquí →</a>
        </p>
    </div>
</div>

<style>
.registre-container {
    max-width: 500px;
    margin: 2rem auto;
}

.form-wrapper {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.form-wrapper h1 {
    text-align: center;
    margin-bottom: 0.5rem;
    color: #333;
}

.subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 2rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
    font-family: inherit;
    transition: all 0.3s;
}

.form-group input:focus {
    outline: none;
    border-color: #ff6b35;
    box-shadow: 0 0 8px rgba(255, 107, 53, 0.2);
}

.form-group input:invalid {
    border-color: #d32f2f;
}

.form-group small {
    display: block;
    margin-top: 0.3rem;
    color: #999;
    font-size: 0.85rem;
}

.form-footer {
    text-align: center;
    margin-top: 1.5rem;
    color: #666;
}

.link-inline {
    color: #ff6b35;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s;
}

.link-inline:hover {
    text-decoration: underline;
}

@media (max-width: 600px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-wrapper {
        padding: 1.5rem;
    }
}
</style>
