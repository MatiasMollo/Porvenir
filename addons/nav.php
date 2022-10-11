<?php
session_start();
require_once "tools/connection.php";
?>
<nav class="navbar navbar-light navbar-expand-lg">
  <h2 class="navbar-brand mx-5 d-flex">El Porvenir</h2>
  <div class="nav-buttons d-flex container-fluid">
    <ul class="flex-direction-row d-flex align-items-center my-auto">
      <?php if(isset($_SESSION['user'])): ?>
          <li><a href="#" class="nav-link">Reservar canchas</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= $_SESSION['user']->name ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Mi perfil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="destroySession.php">Cerrar Sesión</a></li>
            </ul>
          </li>
      <?php else: ?>
        <li><a href="login.php" class="nav-link">Iniciar sesión</a></li>
        <li><a href="register.php" class="">Registrarme</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
