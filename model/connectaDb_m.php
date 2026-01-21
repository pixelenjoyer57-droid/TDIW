<?php
// model/connectaDb_m.php
// Conexión a PostgreSQL

// REEMPLAZA estos datos con tus credenciales reales
$databaseHost = 'deic-docencia.uab.cat';
$databaseName = 'tdiw-e10';          
$databaseUser = 'tdiw-e10';          
$databasePassword = 'EnuT8oSe';

// Cadena de conexión (connection string)
$connectionString = "host={$databaseHost} dbname={$databaseName} user={$databaseUser} password={$databasePassword}";

// Establecemos la conexión
$conn = pg_connect($connectionString);

// Verificamos si hubo error
if (!$conn) {
    die("Error: No se pudo conectar a la base de datos.");
}
?>
