<!-- resource/llistar_categories.php -->
<!-- Recurso completo: estructura HTML + controlador -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías - Mi Tienda</title>
    <link rel="stylesheet" href="resource/css/styles.css">
</head>
<body>
    <header>
        <?php require __DIR__ . '/../controller/menu_superior_c.php'; ?>
    </header>
    
    <main class="container">
        <?php require __DIR__ . '/../controller/llistar_categories_c.php'; ?>
    </main>
    
    <footer>
        <p>&copy; 2025 Mi Tienda Online. Práctica TDIW.</p>
    </footer>
</body>
</html>
