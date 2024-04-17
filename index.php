<?php
    session_start();

    require 'database.php';

    $user = null;

    if (isset($_SESSION['user_id'])) {
        $records = $conn->prepare('SELECT id, usuario, password FROM users WHERE id = :id');
        $records->bindParam(':id', $_SESSION['user_id']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        if ($results) {
            $user = $results;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require 'partials/header.php'; ?>
    <?php if (!empty($user)): ?>
        <br>Bienvenido <?= htmlspecialchars($user['usuario']) ?>
        <br><br>
        <br>Estás satisfactoriamente logueado
        <br><br>
        <a href="logout.php">Salir</a>
    <?php else: ?>  
        <h1>Por favor, inicia sesión</h1>
        <a href="login.php">Inicia sesión</a> o <a href="signup.php">Regístrate</a>
    <?php endif; ?>
</body>
</html>
