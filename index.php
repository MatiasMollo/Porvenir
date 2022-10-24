<?php
if(isset($_SESSION['user'])) var_dump($_SESSION['user']);
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
          
        </div>
    </main>
    <?php 
        include("addons/navGuest.php"); 
        require_once("addons/sidebarLoginGuest.php");
        require_once("addons/footer.php");
    ?>

  </body>
</html>