<?php
$file = 'apps.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo = [
        'nombre' => $_POST['nombre'],
        'paquete' => $_POST['paquete'],
        'creador' => $_POST['creador'],
        'categoria' => $_POST['categoria'],
        'descripcion' => $_POST['descripcion'],
        'url' => $_POST['url'],
        'icono' => $_POST['icono']
    ];
    if (file_exists($file)) {
        $apps = json_decode(file_get_contents($file), true);
    } else {
        $apps = [];
    }
    $apps[] = $nuevo;
    file_put_contents($file, json_encode($apps, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "<script>alert('App publicada exitosamente'); window.location.href='index.html';</script>";
} elseif (isset($_GET['buscar'])) {
    $buscar = strtolower($_GET['buscar']);
    if (file_exists($file)) {
        $apps = json_decode(file_get_contents($file), true);
        foreach ($apps as $app) {
            if (strpos(strtolower($app['nombre']), $buscar) !== false || strpos(strtolower($app['categoria']), $buscar) !== false) {
                echo "<div style='margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 10px;'>
                    <img src='{$app['icono']}' style='width:50px; height:50px;'><br>
                    <strong>{$app['nombre']}</strong><br>
                    {$app['descripcion']}<br>
                    <a href='{$app['url']}' target='_blank'>Ir a la App</a>
                </div>";
            }
        }
    } else {
        echo "No hay apps registradas.";
    }
}
?>