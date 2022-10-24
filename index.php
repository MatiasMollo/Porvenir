<?php
//if(isset($_SESSION['user'])) var_dump($_SESSION['user']); //! Quien puso esta linea amigo?????
session_start();
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/templateStyles.css">
    <title>Inicio - El Porvenir</title>
  </head>
  <body>
    <?php include("addons/navGuest.php");?>
    <main>
        <div>
          Estás en el index
          <br>
          <?php
            if(isset($_SESSION['user'])) echo $_SESSION['user']->name;
            else echo "No hay sesion";
          ?>
        </div>
    </main>
    <?php 
      if(isset($_SESSION['user'])) require_once("addons/sidebarLogged.php");
      else require_once("addons/sidebarLoginGuest.php");
      
      require_once("addons/footer.php");
    ?>

  </body>
</html>