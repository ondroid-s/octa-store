
<?php
$usuariosFile = 'usuarios.json';

if (!file_exists($usuariosFile)) {
    file_put_contents($usuariosFile, '{}');
}

$usuarios = json_decode(file_get_contents($usuariosFile), true);

if (isset($_POST['register'])) {
    $nombre_apellido = $_POST['nombre_apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $pais = $_POST['pais'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $experiencia = $_POST['experiencia'];
    $usuario = $_POST['usuario'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    if (isset($usuarios[$usuario])) {
        echo "<script>alert('Este usuario ya existe. Intenta con otro.');window.location.href='register.html';</script>";
    } else {
        $usuarios[$usuario] = [
            'nombre_apellido' => $nombre_apellido,
            'correo' => $correo,
            'telefono' => $telefono,
            'pais' => $pais,
            'fecha_nacimiento' => $fecha_nacimiento,
            'experiencia' => $experiencia,
            'contraseña' => $contraseña
        ];
        file_put_contents($usuariosFile, json_encode($usuarios));
        
        if ($experiencia == 'administrador') {
            $url = 'https://admin.com';
        } elseif ($experiencia == 'diseñador') {
            $url = 'dis.html';
        } elseif ($experiencia == 'programador') {
            $url = 'pgg.html';
        } else {
            $url = 'index.html';
        }
        
        echo "<script>alert('¡Cuenta creada exitosamente!');window.location.href='$url';</script>";
    }
}

if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    if (isset($usuarios[$usuario]) && password_verify($contraseña, $usuarios[$usuario]['contraseña'])) {
        $experiencia = $usuarios[$usuario]['experiencia'];

        if ($experiencia == 'administrador') {
            $url = 'https://admin.com';
        } elseif ($experiencia == 'diseñador') {
            $url = 'dis.html';
        } elseif ($experiencia == 'programador') {
            $url = 'pgg.html';
        } else {
            $url = 'index.html';
        }

        echo "<script>alert('¡Bienvenido $usuario!');window.location.href='$url';</script>";
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos.');window.location.href='index.html';</script>";
    }
}
?>
