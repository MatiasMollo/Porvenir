<?php 
    if(!isset($_SESSION['user'])) header('location:destroySession.php');
    //?Importante iniciar las sesiones en el documento en donde lo incluyamos (session_start())
?>
<div class="sidebar sidebar--login">
    <div class="sidebar__box">
        <div class="sidebar__text_simple"><?= $_SESSION['user']->name ?></div>
        <a class="sidebar__item" href="miPerfil.php"><div class="sidebar__text sidebar__icon">Mi Perfil</div></a>
        <?php if($_SESSION['user']->id == 1): ?>
            <a class="sidebar__item" href="panel.php"><div class="sidebar__text sidebar__icon">Panel de Administrador</div></a>
        <?php endif ?>
        <a class="sidebar__item" href="destroySession.php"><div class="sidebar__text sidebar__icon">Cerrar Sesión</div></a>
    </div>
</div>
<link rel="stylesheet" href="addons/css/sidebarStyles.css">
<script src="addons/javaScript/sidebarScript.js"></script>