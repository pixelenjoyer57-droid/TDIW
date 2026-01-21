<!-- view/menu_superior_v.php -->
<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-logo">
            <span class="logo-text" >CULINARY DELIGHTS</span>
        </a>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="index.php" class="nav-link">🏠 Inicio</a>
            </li>
            <li class="nav-item">
                <a href="index.php?accio=llistar-categories" class="nav-link">📋 Menú</a>
            </li>
            <li class="nav-item">
                <a href="index.php?accio=carrito" class="nav-link">
                    🛒 Carrito
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="user-dropdown-toggle">
                    👤 Usuario
                </a>
                
                <ul class="dropdown-menu" id="user-dropdown-menu">
                    <?php if (!$usuario_logueado): ?>
                        <li>
                            <a href="index.php?accio=login" class="dropdown-item">
                                🔑 Iniciar Sesión
                            </a>
                        </li>
                        <li>
                            <a href="index.php?accio=registre" class="dropdown-item">
                                ✍️ Registrarse
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <span class="dropdown-header">
                                👋 Bienvenido, <?php echo htmlspecialchars(substr($nombre_usuario, 0, 15)); ?>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a href="index.php?accio=perfil" class="dropdown-item">
                                👤 Mi Perfil
                            </a>
                        </li>
                        <li>
                            <a href="index.php?accio=mis-pedidos" class="dropdown-item">
                                📦 Mis Pedidos
                            </a>
                        </li>
                        <li>
                            <a href="index.php?accio=logout" class="dropdown-item logout">
                                🚪 Cerrar Sesión
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggle = document.getElementById('user-dropdown-toggle');
    const dropdownMenu = document.getElementById('user-dropdown-menu');
    
    if (dropdownToggle) {
        dropdownToggle.addEventListener('click', function(e) {
            e.preventDefault();
            dropdownMenu.classList.toggle('show');
        });
        
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                dropdownMenu.classList.remove('show');
            }
        });
    }
});
</script>
