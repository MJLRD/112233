<?php 
session_start(); 
if(!isset($_SESSION['user'])){
  header('Location: login.php'); 
  exit; 
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book-Mastery | Mi Cuenta</title>
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

    .profile-card {
      max-width: 450px;
      margin: 30px auto;
      padding: 25px;
      border-radius: 12px;
      background: #ffffff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .profile-icon {
      font-size: 70px;
      color: #6c7ae0;
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
            <li><a class="dropdown-item" href="profile.php">Cuenta</a></li>
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

<!-- TITLE -->
<h1 class="page-title">Mi Cuenta</h1>

<!-- PROFILE CARD -->
<div class="profile-card text-center">
  <div class="profile-icon">👤</div>
  <h3 class="mt-3"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></h3>
  <p class="text-muted">Rol: <strong><?php echo htmlspecialchars($_SESSION['user']['role']); ?></strong></p>

  <a href="logout.php" class="btn btn-danger mt-3">Cerrar Sesión</a>
</div>

<!-- FOOTER -->
<footer class="bg-light text-center py-3 mt-4">
  © 2025 Book-Mastery
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
