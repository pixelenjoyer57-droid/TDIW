<div class="registre-container">
    <div class="form-wrapper">
        <h1>📝 Crear Nueva Cuenta</h1>
        <p class="subtitle">Únete a nuestra comunidad</p>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="index.php?accio=registre" class="form-registro" id="formRegistro">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre_usuario">Nombre de Usuario *</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" required 
                           minlength="3" maxlength="50" pattern="[a-zA-Z0-9_-]+"
                           placeholder="usuario123" value="<?php echo htmlspecialchars($form_data['nombre_usuario'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required placeholder="tu@email.com"
                           value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+"
                           value="<?php echo htmlspecialchars($form_data['nombre'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido *</label>
                    <input type="text" id="apellido" name="apellido" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+"
                           value="<?php echo htmlspecialchars($form_data['apellido'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="numero_telefono">Teléfono (Opcional)</label>
                <input type="tel" id="numero_telefono" name="numero_telefono" placeholder="+34 666 777 888"
                       pattern="[\d\s\+\-\(\)]*" value="<?php echo htmlspecialchars($form_data['numero_telefono'] ?? ''); ?>">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="contrasena">Contraseña *</label>
                    <input type="password" id="contrasena" name="contrasena" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="contrasena_confirmar">Confirmar Contraseña *</label>
                    <input type="password" id="contrasena_confirmar" name="contrasena_confirmar" required minlength="6">
                    <small id="pass-error" style="color: red; display: none;">Las contraseñas no coinciden</small>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-large">✍️ Crear Cuenta</button>
        </form>
    </div>
</div>

<style>
.registre-container { max-width: 600px; margin: 2rem auto; }
.form-wrapper { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-group { margin-bottom: 1rem; }
.form-group input { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
@media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
</style>