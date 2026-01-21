<div class="container" style="max-width: 600px; margin-top: 2rem;">
    <div class="card-perfil" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h1 style="text-align: center; margin-bottom: 2rem;">👤 Mi Perfil</h1>
        
        <div class="perfil-img-container" style="text-align: center; margin-bottom: 2rem;">
            <?php 
                // Imagen por defecto si no hay ninguna guardada
                $imgSrc = !empty($usuario['imagen_perfil']) ? htmlspecialchars($usuario['imagen_perfil']) : 'resource/img/logo_pagina.jpg';
                // Añadimos timestamp para evitar caché al actualizar
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('perfil-form');
  const msg = document.getElementById('perfil-msg');
  const imgPreview = document.getElementById('img-preview');
  const fileInput = document.getElementById('imagen');
  const fileName = document.getElementById('file-name');

  // Mostrar nombre del archivo seleccionado
  fileInput.addEventListener('change', function() {
      if(this.files && this.files[0]) {
          fileName.textContent = "Seleccionado: " + this.files[0].name;
          // Preview local inmediato
          const reader = new FileReader();
          reader.onload = function(e) { imgPreview.src = e.target.result; }
          reader.readAsDataURL(this.files[0]);
      }
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    msg.textContent = "Guardando...";
    msg.style.color = "#666";
    
    const formData = new FormData();
    if (fileInput.files[0]) {
        formData.append('imagen', fileInput.files[0]);
    }
    formData.append('telefono', document.getElementById('telefono').value);

    fetch('controller/perfil_update_c.php', {
      method: 'POST',
      body: formData
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
          msg.textContent = '✅ Perfil actualizado correctamente.';
          msg.style.color = 'var(--color-success)';
          msg.style.backgroundColor = "#d4edda";
      } else {
          msg.textContent = '❌ Error: ' + data.error;
          msg.style.color = '#721c24';
          msg.style.backgroundColor = "#f8d7da";
      }
    })
    .catch(err => {
        msg.textContent = "Error de conexión";
    });
  });

  document.getElementById('perfil-baja').addEventListener('click', function () {
    if (confirm('¿ESTÁS SEGURO? Esta acción borrará tu cuenta y tus pedidos permanentemente.')) {
      fetch('controller/perfil_delete_c.php', { method: 'POST' })
        .then(r => r.json())
        .then(data => {
          if (data.success) window.location.href = 'index.php?accio=logout';
          else alert(data.error);
        });
    }
  });
});
</script>