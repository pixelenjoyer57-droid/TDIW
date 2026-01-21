<div class="carrito-container">
    <h1>🛒 Tu Carrito de Compra</h1>
    
    <?php if (isset($compra_realizada) && $compra_realizada): ?>
        <div class="alert alert-success">
            <h2>✅ ¡Compra Confirmada!</h2>
            <p>Tu pedido ha sido procesado correctamente. En breve recibirás tus deliciosos productos.</p>
            <a href="index.php?accio=llistar-categories" class="btn btn-primary" style="margin-top: 1rem;">Seguir pidiendo</a>
        </div>
    <?php elseif (empty($items)): ?>
        <div class="carrito-vacio">
            <div class="imagen-placeholder-grande" style="font-size: 4rem; margin-bottom: 1rem;">🍽️</div>
            <h2>Tu carrito está vacío</h2>
            <p>¿A qué esperas para probar nuestras hamburguesas?</p>
            <a href="index.php?accio=llistar-categories" class="btn btn-primary btn-large" style="margin-top: 1rem;">
                Ver Menú
            </a>
        </div>
    <?php else: ?>
        
        <div class="carrito-grid">
            <div class="carrito-items">
                <table class="tabla-carrito">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cant.</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="producto-celda">
                                    <div class="mini-img">
                                        <?php if($item['url_imagen']): ?>
                                            <img src="<?php echo htmlspecialchars($item['url_imagen']); ?>" alt="img">
                                        <?php else: ?>
                                            📦
                                        <?php endif; ?>
                                    </div>
                                    <span><?php echo htmlspecialchars($item['nombre']); ?></span>
                                </td>
                                <td><?php echo number_format($item['precio'], 2); ?>€</td>
                                <td><?php echo $item['cantidad']; ?></td>
                                <td class="precio-bold"><?php echo number_format($item['subtotal'], 2); ?>€</td>
                                <td>
                                    <button class="btn-borrar" title="Eliminar">🗑️</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="carrito-resumen">
                <h3>Resumen del Pedido</h3>
                <div class="resumen-row">
                    <span>Subtotal</span>
                    <span><?php echo number_format($total, 2); ?>€</span>
                </div>
                <div class="resumen-row">
                    <span>Envío</span>
                    <span>0.00€</span>
                </div>
                <hr>
                <div class="resumen-total">
                    <span>Total</span>
                    <span><?php echo number_format($total, 2); ?>€</span>
                </div>
                
                <form action="index.php?accio=checkout" method="POST">
                    <button type="submit" class="btn btn-success btn-large btn-block">
                        ✅ Tramitar Pedido
                    </button>
                </form>
                <a href="index.php?accio=llistar-categories" class="btn-link-volver">← Seguir comprando</a>
            </div>
        </div>
    <?php endif; ?>
</div>