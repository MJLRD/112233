<?php
// header.php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi Sitio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="styles.css" rel="stylesheet">
<link rel="stylesheet" href="_unified_assets/unified-style.css">
<script src="_unified_assets/unified-nav.js" defer></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">MiSitio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
      </ul>
      <div class="d-flex align-items-center text-light me-3" id="clock">--:--:--</div>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="accountMenu" role="button" data-bs-toggle="dropdown">
            Cuenta
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountMenu">
            <?php if(isset($_SESSION['user'])): ?>
              <li><a class="dropdown-item" href="profile.php">Mi cuenta</a></li>
              <?php if($_SESSION['user']['role'] === 'admin'): ?>
                <li><a class="dropdown-item" href="admin.php">Panel admin</a></li>
              <?php endif; ?>
              <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
            <?php else: ?>
              <li><a class="dropdown-item" href="login.php">Iniciar sesión</a></li>
            <?php endif; ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="about.php">About Us</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
