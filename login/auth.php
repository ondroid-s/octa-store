
<?php
$usuariosFile = 'usuarios.json';

if (!file_exists($usuariosFile)) {
    file_put_contents($usuariosFile, '{}');
}

$usuarios = json_decode(file_get_contents($usuariosFile), true);

if (isset($_POST['register'])) {
    $usuario = $_POST['usuario'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    if (isset($usuarios[$usuario])) {
        echo "<script>alert('Este usuario ya existe. Intenta con otro.');window.location.href='register.html';</script>";
    } else {
        $usuarios[$usuario] = $contraseña;
        file_put_contents($usuariosFile, json_encode($usuarios));
        echo "<script>alert('¡Cuenta creada exitosamente!');window.location.href='https://example.com';</script>";
    }
}

if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    if (isset($usuarios[$usuario]) && password_verify($contraseña, $usuarios[$usuario])) {
        echo "<script>alert('¡Bienvenido $usuario!');window.location.href='https://example.com';</script>";
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos.');window.location.href='index.html';</script>";
    }
}
?>
