<div class="carrito-container">
    <h1>🛒 Tu Carrito de Compra</h1>
    
    <?php if (isset($compra_realizada) && $compra_realizada): ?>
        <div class="alert alert-success">
            <h2>✅ ¡Compra Confirmada!</h2>
            <p>Tu pedido ha sido procesado correctamente.</p>
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
                                
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <button class="btn-qty" onclick="updateCart(<?php echo $item['id_producto']; ?>, 'restar')">−</button>
                                        <span style="font-weight: bold; min-width: 20px; text-align: center;"><?php echo $item['cantidad']; ?></span>
                                        <button class="btn-qty" onclick="updateCart(<?php echo $item['id_producto']; ?>, 'sumar')">+</button>
                                    </div>
                                </td>
                                
                                <td class="precio-bold"><?php echo number_format($item['subtotal'], 2); ?>€</td>
                                <td>
                                    <button class="btn-borrar" onclick="updateCart(<?php echo $item['id_producto']; ?>, 'eliminar')" title="Eliminar">🗑️</button>
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

<style>
/* Estilos mínimos para los botones nuevos */
.btn-qty { width: 26px; height: 26px; border-radius: 50%; border: 1px solid #ccc; background: white; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold; }
.btn-qty:hover { background: #f0f0f0; border-color: #999; }
.btn-borrar { background: none; border: none; cursor: pointer; font-size: 1.2rem; }
.btn-borrar:hover { transform: scale(1.1); }
</style>

<script>
function updateCart(id, accion) {
    fetch('controller/carrito_update_c.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ producto_id: id, accion: accion })
    })
    .then(r => r.json())
    .then(data => {
        if(data.success) {
            location.reload(); 
        } else {
            alert('Error: ' + (data.error || 'Desconocido'));
        }
    })
    .catch(err => console.error(err));
}
</script>