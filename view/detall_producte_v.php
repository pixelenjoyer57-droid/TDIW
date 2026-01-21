<div class="producto-detalle">
    <div class="breadcrumb">
        <a href="index.php">Inicio</a> / 
        <a href="index.php?accio=llistar-categories">Menú</a> / 
        <span><?php echo htmlspecialchars($producto['categoria_nombre']); ?></span>
    </div>
    
    <div class="detalle-contenedor">
        <div class="producto-imagen-grande">
            <?php if ($producto['url_imagen']): ?>
                <img src="<?php echo htmlspecialchars($producto['url_imagen']); ?>" 
                     alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            <?php else: ?>
                <div class="imagen-placeholder-grande">📦</div>
            <?php endif; ?>
        </div>
        
        <div class="producto-info-detalle">
            <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
            
            <p class="categoria-badge">
                <?php echo htmlspecialchars($producto['categoria_nombre']); ?>
            </p>
            
            <div class="descripcion-completa">
                <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
            </div>
            
            <div class="precio-detalle">
                <span class="precio-grande"><?php echo number_format($producto['precio'], 2); ?>€</span>
                
                <?php if ($producto['stock'] > 0): ?>
                    <span class="stock disponible">✓ Disponible</span>
                <?php else: ?>
                    <span class="stock agotado">✗ Sin stock</span>
                <?php endif; ?>
            </div>
            
            <?php if ($producto['stock'] > 0): ?>
                <form class="form-agregar-carrito">
                    <div class="cantidad-selector">
                        <label for="cantidad">Cantidad:</label>
                        <select id="cantidad-detalle" name="cantidad">
                            <?php for ($i = 1; $i <= min(10, $producto['stock']); $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <button type="button" class="btn btn-primary btn-large" 
                            onclick="addToCart(<?php echo $producto['id']; ?>, true)">
                        🛒 Agregar al Carrito
                    </button>
                </form>
            <?php else: ?>
                <div class="alert alert-error">
                    <p>Este producto no está disponible en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>