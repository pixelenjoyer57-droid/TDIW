<div class="form-wrapper" id="perfil-wrapper">
    <h1>Perfil de usuario</h1>
    <form id="perfil-form">
        <div class="form-group">
            <label>Nombre completo</label>
            <input type="text" value="<?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?>" disabled>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" disabled>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['numero_telefono'] ?? ''); ?>">
        </div>
        <div style="display: flex; gap: 1rem;">
            <button type="submit" id="perfil-guardar" class="btn btn-primary">Guardar cambios</button>
            <button type="button" id="perfil-baja" class="btn btn-secondary" style="background-color: #d32f2f;">Darse de baja</button>
        </div>
        <div id="perfil-msg" style="margin-top: 1rem; font-weight: bold;"></div>
    </form>
</div>
<script src="resource/js/perfil.js"></script>