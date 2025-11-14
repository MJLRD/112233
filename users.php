<?php
session_start();
require 'conexion.php'; // conexión a la BD

// Si no hay sesión, redirigir al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener datos del usuario
$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

$mensaje = "";

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nuevo_username = trim($_POST['username']);
    $nueva_pass = trim($_POST['password']);

    // Si la contraseña se cambia
    if (!empty($nueva_pass)) {

        // Validación
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $nueva_pass)) {
            $mensaje = "La contraseña debe tener mínimo 8 caracteres, una mayúscula y un número.";
        } else {
            $hash = password_hash($nueva_pass, PASSWORD_DEFAULT);

            $sql = "UPDATE users SET username=?, password=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $nuevo_username, $hash, $usuario_id);
            $stmt->execute();
            $stmt->close();

            $mensaje = "Datos actualizados correctamente.";
        }

    } else {
        // Actualiza solo el username
        $sql = "UPDATE users SET username=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nuevo_username, $usuario_id);
        $stmt->execute();
        $stmt->close();

        $mensaje = "Datos actualizados correctamente.";
    }

    // Actualizar variable local
    $username = $nuevo_username;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mi Cuenta</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #e8eff5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.contenedor {
    background: white;
    width: 380px;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #3a4750;
}

input[type="text"], 
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #cbd3da;
    border-radius: 8px;
    font-size: 15px;
}

button {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    background: #3a86ff;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
}

button:hover {
    background: #2563eb;
}

.logout {
    background: #d62828;
}

.logout:hover {
    background: #b51f1f;
}

.mensaje {
    margin-top: 12px;
    color: green;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="contenedor">
    <h2>Mi Cuenta</h2>

    <?php if ($mensaje != "") echo "<p class='mensaje'>$mensaje</p>"; ?>

    <form method="POST">

        <label>Nombre de usuario:</label>
        <input type="text" name="username" value="<?php echo $username; ?>" required>

        <label>Nueva contraseña (opcional):</label>
        <input type="password" name="password" placeholder="••••••••">

        <button type="submit">Guardar cambios</button>
    </form>

    <form action="logout.php" method="POST">
        <button class="logout">Cerrar sesión</button>
    </form>
</div>

</body>
</html>