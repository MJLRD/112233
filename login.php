<?php
session_start();
include 'db.php';

// Si ya está logueado, lo mandamos a inicio
if (isset($_SESSION['user'])) {
    header('Location: inicio_unificado.html');
    exit;
}

$alert = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validaciones
    if (!$username || !$password) {
        $alert = "Debes completar todos los campos.";
    } elseif (strlen($username) > 10) {
        $alert = "El usuario no puede superar los 10 caracteres.";
    } elseif (strlen($password) < 8) {
        $alert = "La contraseña debe tener al menos 8 caracteres.";
    } else {

        // Buscar usuario
        $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Validar contraseña encriptada
        if ($user && password_verify($password, $user['password'])) {

            // Guardar datos en sesión
            $_SESSION['user'] = [
                'id'       => $user['id'],
                'username' => $user['username'],
                'role'     => $user['role']
            ];

            header('Location: index.php');
            exit;

        } else {
            $alert = "Usuario o contraseña incorrectos.";
        }
    }
}
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Book-Mastery</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f5f6fa;
      color: #333;
    }

    .navbar-custom {
      background-color: #6c7ae0;
    }

    .navbar-custom .nav-link,
    .navbar-custom .navbar-brand {
      color: #fff !important;
    }

    .page-title {
      text-align: center;
      margin-top: 25px;
      font-size: 2rem;
      font-weight: bold;
      color: #4b4e6d;
    }

    .login-card {
      max-width: 450px;
      margin: 40px auto;
      padding: 25px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .btn-custom {
      background-color: #6c7ae0;
      color: white;
      font-weight: bold;
    }
  </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="inicio_unificado.html">Book-Mastery</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="generos.html">Géneros</a></li>
        <li class="nav-item"><a class="nav-link" href="reseñas.html">Reseñas</a></li>
      </ul>

      <form class="d-flex me-3 search-bar">
        <input class="form-control" type="search" placeholder="Buscar..." aria-label="Buscar">
      </form>

      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Menú</a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="login.php">Login</a></li>
            <li><a class="dropdown-item" href="register.php">Registro</a></li>
            <li><a class="dropdown-item" href="AbUs.html">About Us</a></li>
            <li><a class="dropdown-item" href="cv.html">CV</a></li>
            <li><a class="dropdown-item" href="curso.html">Curso</a></li>
            <li><a class="dropdown-item" href="cuestionario.html">Cuestionario</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<h1 class="page-title">Iniciar sesión</h1>

<div class="login-card">

    <?php if ($alert): ?>
    <div class="alert alert-danger text-center">
        <?php echo htmlspecialchars($alert); ?>
    </div>
    <?php endif; ?>

    <form method="POST">

      <div class="mb-3">
        <label class="form-label">Usuario</label>
        <input type="text"
               name="username"
               class="form-control"
               required
               maxlength="10"
               placeholder="Máx. 10 caracteres">
      </div>

      <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password"
               name="password"
               class="form-control"
               required
               minlength="8"
               placeholder="Mínimo 8 caracteres">
      </div>

      <button class="btn btn-custom w-100 mt-3">Entrar</button>
    </form>

    <hr>
    <div class="text-center">
        <a href="Registro.php">¿No tienes cuenta? Regístrate</a>
    </div>

</div>

<footer class="bg-light text-center py-3 mt-4">
  © 2025 Book-Mastery
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
