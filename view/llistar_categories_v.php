<div class="categories-container">
    <h1>📋 Nuestras Categorías</h1>
    <p class="subtitle">Elige tu tipo de comida favorita</p>
    
    <?php if (empty($categorias)): ?>
        <div class="alert alert-info">
            <p>No hay categorías disponibles en este momento. Vuelve pronto.</p>
        </div>
    <?php else: ?>
        <div class="categories-grid">
            <?php foreach ($categorias as $categoria): ?>
                <div class="category-card">
                    <div class="category-icon">
                        <?php 
                        // Emoji según categoría
                        $emojis = [
                            'Pizzas' => '🍕',
                            'Kebabs' => '🍖',
                            'Hamburguesas' => '🍔'
                        ];
                        echo $emojis[$categoria['nombre']] ?? '🍽️';
                        ?>
                    </div>
                    
                    <h3>
                        <a href="index.php?accio=llistar-productes&categoria=<?php echo htmlspecialchars($categoria['id']); ?>">
                            <?php echo htmlspecialchars($categoria['nombre']); ?>
                        </a>
                    </h3>
                    
                    <p><?php echo htmlspecialchars($categoria['descripcion']); ?></p>
                    
                    <a href="index.php?accio=llistar-productes&categoria=<?php echo htmlspecialchars($categoria['id']); ?>" class="btn btn-primary">
                        Ver productos →
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>