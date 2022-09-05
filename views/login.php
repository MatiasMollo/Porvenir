
<?php
session_start(); //Importante ponerlo en el nav y sacarlo de aca

 ?>

!<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login - Porvenir</title>
  </head>
  <body>
    <form action="index.html" method="post">
      <div>
        <label for="email">Email</label>
        <input type="text" name="email"
         value="<?= $_SESSION['FLASH']['emailValue'] ?>">
      </div>
      <div>
        <label for="password">Contraseña</label>
        <input type="text" name="email"
         value="<?= $_SESSION['FLASH']['passwordValue'] ?>">
      </div>
      <p><?= $_SESSION['FLASH']['errorMessage'] ?></p>
    </form>
  </body>
</html>
