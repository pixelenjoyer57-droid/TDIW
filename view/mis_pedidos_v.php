<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
    <div class="card-pedidos" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h1 style="margin-bottom: 1.5rem;">📦 Mis Pedidos</h1>

        <?php if (empty($pedidos)): ?>
            <div class="empty-state">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                <h3>No has realizado ningún pedido aún.</h3>
                <p>¡Nuestras hamburguesas te están esperando!</p>
                <a href="index.php?accio=llistar-categories" class="btn btn-primary" style="margin-top: 1rem;">Ver Carta</a>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nº Pedido</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td style="font-weight: bold; color: var(--color-primary);">
                                    #<?php echo str_pad($pedido['id'], 5, '0', STR_PAD_LEFT); ?>
                                </td>
                                <td>
                                    <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_creacion'])); ?>
                                </td>
                                <td style="font-weight: bold;">
                                    <?php echo number_format($pedido['importe_total'], 2); ?>€
                                </td>
                                <td>
                                    <span class="badge-success">✅ Completado</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 2rem; text-align: right;">
                <a href="index.php?accio=llistar-categories" class="btn btn-primary">Seguir comprando</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<footer>
    <p>&copy; 2025 Mi Tienda Online. Práctica TDIW.</p>
</footer>