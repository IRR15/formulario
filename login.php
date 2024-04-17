<?php 
    session_start();

    if (isset($_SESSION['user_id'])) {
        header('Location: /php-login');
        exit(); // Agrega una salida después de redirigir para evitar que el código siguiente se ejecute
    }

    require 'database.php';

    $message = ''; // Inicializa la variable de mensaje fuera del bloque de condición

    if (!empty($_POST['usuario']) && !empty($_POST['password'])) {
        $records = $conn->prepare('SELECT id, usuario, password FROM users WHERE usuario=:usuario');
        $records->bindParam(':usuario', $_POST['usuario']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        if ($results && password_verify($_POST['password'], $results['password'])) {
            $_SESSION['user_id'] = $results['id'];
            header('Location: /php-login');
            exit(); // Agrega una salida después de redirigir para evitar que el código siguiente se ejecute
        } else {
            $message = 'Lo siento, el usuario o la contraseña no coinciden.';
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia sesión</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require 'partials/header.php'; ?>
    <h1>Inicia sesión</h1>
    <span>o <a href="signup.php">Regístrate</a></span>

    <?php if(!empty($message)) : ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <input type="text" name="usuario" placeholder="Ingresa tu usuario">
        <input type="password" name="password" placeholder="Ingresa la contraseña">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
