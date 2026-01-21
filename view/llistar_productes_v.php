<div class="productos-container">
    <div class="breadcrumb">
        <a href="index.php">🏠 Inicio</a> / 
        <a href="index.php?accio=llistar-categories">📋 Menú</a> / 
        <span><?php echo htmlspecialchars($categoria['nombre']); ?></span>
    </div>
    
    <div class="categoria-header">
        <h1><?php echo htmlspecialchars($categoria['nombre']); ?></h1>
        <p><?php echo htmlspecialchars($categoria['descripcion']); ?></p>
    </div>
    
    <?php if (empty($productos)): ?>
        <div class="alert alert-warning">
            <p>⚠️ No hay productos disponibles en esta categoría.</p>
        </div>
    <?php else: ?>
        <div class="productos-grid">
            <?php foreach ($productos as $producto): ?>
                <div class="producto-card">
                    <div class="producto-imagen">
                        <?php if ($producto['url_imagen']): ?>
                            <img src="<?php echo htmlspecialchars($producto['url_imagen']); ?>" 
                                 alt="<?php echo htmlspecialchars($producto['nombre']); ?>" loading="lazy">
                        <?php else: ?>
                            <div class="imagen-placeholder">📦</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="producto-contenido">
                        <h3>
                            <a href="index.php?accio=detall-producte&id=<?php echo htmlspecialchars($producto['id']); ?>">
                                <?php echo htmlspecialchars($producto['nombre']); ?>
                            </a>
                        </h3>
                        
                        <div class="precio-section">
                            <span class="precio"><?php echo number_format($producto['precio'], 2); ?>€</span>
                            <?php if ($producto['stock'] > 0): ?>
                                <span class="stock disponible">✓ Stock</span>
                            <?php else: ?>
                                <span class="stock agotado">✗ Agotado</span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($producto['stock'] > 0): ?>
                            <div class="add-cart-form" style="display: flex; gap: 5px; margin-top: 10px;">
                                <input type="number" id="qty-<?php echo $producto['id']; ?>" 
                                       value="1" min="1" max="10" 
                                       style="width: 50px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                                <button onclick="addToCart(<?php echo $producto['id']; ?>)" 
                                        class="btn btn-primary btn-small">
                                    Añadir 🛒
                                </button>
                            </div>
                        <?php endif; ?>
                        
                        <a href="index.php?accio=detall-producte&id=<?php echo htmlspecialchars($producto['id']); ?>" 
                           class="btn-link-detail" style="display:block; margin-top:5px; font-size:0.9rem;">
                            Ver detalles
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>