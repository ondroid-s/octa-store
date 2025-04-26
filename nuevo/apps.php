
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $paquete = $_POST['paquete'];
    $creador = $_POST['creador'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $url = $_POST['url'];
    $icono = $_POST['icono'];

    $newApp = [
        'nombre' => $nombre,
        'paquete' => $paquete,
        'creador' => $creador,
        'categoria' => $categoria,
        'descripcion' => $descripcion,
        'url' => $url,
        'icono' => $icono
    ];

    $apps = file_exists('apps.json') ? json_decode(file_get_contents('apps.json'), true) : [];
    $apps[] = $newApp;

    file_put_contents('apps.json', json_encode($apps, JSON_PRETTY_PRINT));
    echo "<script>alert('App publicada con éxito');window.location.href='index.html';</script>";
} else if (isset($_GET['query'])) {
    $query = strtolower($_GET['query']);
    $apps = file_exists('apps.json') ? json_decode(file_get_contents('apps.json'), true) : [];

    echo '<div id="resultado">';
    foreach ($apps as $app) {
        if (strpos(strtolower($app['nombre']), $query) !== false) {
            echo "<div class='result-item'>
                    <img src='{$app['icono']}' alt='Icono'>
                    <div class='info'>
                        <strong>{$app['nombre']}</strong>
                        <p>{$app['descripcion']}</p>
                        <a href='{$app['url']}' target='_blank'>Ver App</a>
                    </div>
                  </div>";
        }
    }
    echo '</div>';
}
?>
