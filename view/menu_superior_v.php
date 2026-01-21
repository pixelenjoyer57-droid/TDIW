<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-logo">
            <span class="logo-text">CULINARY DELIGHTS</span>
        </a>
        
        <div class="nav-search">
            <form action="index.php" method="GET" style="display:flex; align-items:center;">
                <input type="hidden" name="accio" value="llistar-productes">
                <input type="text" name="q" placeholder="Buscar..." style="padding: 5px; border-radius: 4px; border: 1px solid #ccc;">
                <button type="submit" style="background: none; border: none; cursor: pointer;">🔍</button>
            </form>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="index.php" class="nav-link">🏠 Inicio</a>
            </li>
            <li class="nav-item">
                <a href="index.php?accio=llistar-categories" class="nav-link">📋 Menú</a>
            </li>
            
            <li class="nav-item dropdown-wrapper">
                <a href="index.php?accio=carrito" class="nav-link cart-link">
                    🛒 Carrito
                    <?php if (isset($carrito_total_items) && $carrito_total_items > 0): ?>
                        <span class="cart-badge">
                            <?php echo $carrito_total_items; ?> | <?php echo number_format($carrito_total_precio ?? 0, 2); ?>€
                        </span>
                    <?php endif; ?>
                </a>
                
                <div class="custom-dropdown cart-dropdown-content">
                    <?php if (empty($_SESSION['carrito'])): ?>
                        <div class="cart-empty" style="padding:1rem; text-align:center;">Tu carrito está vacío</div>
                    <?php else: ?>
                        <ul class="cart-mini-list">
                            <?php foreach ($_SESSION['carrito'] as $item): ?>
                                <li class="cart-mini-item">
                                    <span class="item-name"><?php echo htmlspecialchars($item['nombre']); ?></span>
                                    <span class="item-qty">x<?php echo $item['cantidad']; ?></span>
                                    <span class="item-price"><?php echo number_format($item['precio'] * $item['cantidad'], 2); ?>€</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="cart-mini-total">
                            <strong>Total: <?php echo number_format($carrito_total_precio ?? 0, 2); ?>€</strong>
                        </div>
                        <a href="index.php?accio=carrito" class="btn-checkout-mini">Ver Carrito Completo</a>
                    <?php endif; ?>
                </div>
            </li>

            <li class="nav-item dropdown-wrapper">
                <a href="#" class="nav-link">
                    👤 Usuario
                </a>
                
                <ul class="custom-dropdown user-dropdown-content">
                    <?php if (!$usuario_logueado): ?>
                        <li><a href="index.php?accio=login" class="dropdown-item">🔑 Iniciar Sesión</a></li>
                        <li><a href="index.php?accio=registre" class="dropdown-item">✍️ Registrarse</a></li>
                    <?php else: ?>
                        <li><span class="dropdown-header">Hola, <?php echo htmlspecialchars($nombre_usuario); ?></span></li>
                        <li class="divider"></li>
                        <li><a href="index.php?accio=perfil" class="dropdown-item">👤 Mi Perfil</a></li>
                        <li><a href="index.php?accio=mis-pedidos" class="dropdown-item">📦 Mis Pedidos</a></li>
                        <li><a href="index.php?accio=logout" class="dropdown-item logout">🚪 Cerrar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<style>
/* CSS UNIFICADO PARA LOS DROPDOWNS */
.dropdown-wrapper {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
}

/* El menú oculto por defecto */
.custom-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background-color: white;
    min-width: 220px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    border-radius: 8px;
    padding: 0.5rem 0;
    z-index: 1000;
    border: 1px solid #eee;
}

/* Mostrar al hacer HOVER */
.dropdown-wrapper:hover .custom-dropdown {
    display: block;
}

/* Estilos internos de los menús */
.custom-dropdown.cart-dropdown-content { width: 300px; padding: 1rem; }
.cart-mini-list { list-style: none; padding: 0; margin: 0; max-height: 200px; overflow-y: auto; }
.cart-mini-item { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee; font-size: 0.9rem; }
.cart-mini-total { text-align: right; margin-top: 10px; padding-top: 10px; border-top: 2px solid #eee; }
.btn-checkout-mini { display: block; text-align: center; background: #ff6b35; color: white; padding: 8px; margin-top: 10px; border-radius: 4px; text-decoration: none; }

.dropdown-item { display: block; padding: 10px 20px; color: #333; text-decoration: none; }
.dropdown-item:hover { background-color: #f8f9fa; color: #ff6b35; }
.dropdown-header { display: block; padding: 10px 20px; font-weight: bold; color: #666; font-size: 0.9em; }
.divider { height: 1px; background-color: #eee; margin: 5px 0; }
.cart-badge { background: #ff6b35; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem; margin-left: 5px; }

/* Ocultar en móviles la búsqueda si no cabe */
@media(max-width: 768px) { .nav-search { display: none; } }
</style>