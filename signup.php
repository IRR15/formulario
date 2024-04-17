<?php
    require 'database.php';

    $message = '';

    if(!empty($_POST['usuario']) && !empty($_POST['password'])){
        $sql = "INSERT INTO users (usuario, password) VALUES (:usuario, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario',$_POST['usuario']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            $message = 'Se creo satisfactoriamente el usuario';
        }else{
            $message = 'Oh no a ocurrido un error!!!'; 
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate</title>
    <link rel ="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php
        require 'partials/header.php'
    ?>
    <?php if (!empty($message)):?>
        <p><?= $message ?></p>
    <?php endif; ?>
    
    <h1>Registrate</h1>
    <span>o <a href="login.php">Inicia sesion</a></span>

    <form action = "signup.php" method="post">
        <input type="text" name ="usuario" placeholder="Ingresa tu usuario">
        <input type="password" name="password" placeholder="Ingresa la contraseña">
        <input type="password" name="confirm_password" placeholder="Confirma la contraseña">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>