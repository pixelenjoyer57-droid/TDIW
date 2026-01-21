// resource/js/perfil.js
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('perfil-form');
  const baja = document.getElementById('perfil-baja');
  const msg = document.getElementById('perfil-msg');

  // Guardar (actualizar teléfono)
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    fetch('controller/perfil_update_c.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({telefono: document.getElementById('telefono').value})
    })
    .then(r => r.json())
    .then(data => {
      msg.textContent = data.success ? 'Teléfono actualizado.' : data.error;
      msg.style.color = data.success ? 'green' : 'red';
    });
  });

  // Darse de baja (eliminar cuenta)
  baja.addEventListener('click', function (e) {
    if (confirm('¿Seguro que quieres eliminar tu cuenta?')) {
      fetch('controller/perfil_delete_c.php', { method: 'POST' })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            window.location.href = 'logout.php';
          } else {
            msg.textContent = data.error;
            msg.style.color = 'red';
          }
        });
    }
  });
});
