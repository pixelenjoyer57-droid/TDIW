<div class="container" style="max-width: 600px; margin-top: 2rem;">
    <div class="card-perfil" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h1 style="text-align: center; margin-bottom: 2rem;">👤 Mi Perfil</h1>
        
        <div class="perfil-img-container" style="text-align: center; margin-bottom: 2rem;">
            <?php 
                $imgSrc = !empty($usuario['imagen_perfil']) ? htmlspecialchars($usuario['imagen_perfil']) : 'resource/img/logo_pagina.jpg';
                $imgSrc .= '?t=' . time();
            ?>
            <img id="img-preview" src="<?php echo $imgSrc; ?>" alt="Foto de perfil" 
                style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid var(--color-primary); box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
        </div>

        <form id="perfil-form" enctype="multipart/form-data">
            <div class="form-group" style="text-align: center;">
                <label for="imagen" class="btn btn-secondary" style="cursor: pointer; display: inline-block;">
                    📷 Cambiar Foto
                </label>
                <input type="file" id="imagen" name="imagen" accept="image/*" style="display: none;">
                <p id="file-name" style="font-size: 0.8rem; color: #666; margin-top: 0.5rem;"></p>
            </div>

            <div class="form-group">
                <label>Nombre completo</label>
                <input type="text" value="<?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?>" disabled style="background-color: #f5f5f5; border-color: #ddd;">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" disabled style="background-color: #f5f5f5; border-color: #ddd;">
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['numero_telefono'] ?? ''); ?>" placeholder="Ej: 666777888">
            </div>

            <hr style="border: 0; border-top: 1px solid #eee; margin: 2rem 0;">

            <div style="display: flex; gap: 1rem; justify-content: space-between;">
                <button type="submit" id="perfil-guardar" class="btn btn-primary" style="flex: 1;">💾 Guardar cambios</button>
                <button type="button" id="perfil-baja" class="btn btn-danger" style="background-color: #dc3545; color: white; border: none;">✖ Darse de baja</button>
            </div>
            
            <div id="perfil-msg" style="margin-top: 1.5rem; text-align: center; font-weight: bold; padding: 0.5rem; border-radius: 4px;"></div>
        </form>
    </div>
</div>