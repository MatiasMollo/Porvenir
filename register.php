<?php
session_start(); //Eliminar y ponerlo en el Nav, incluir el mismo en los documentos

if(isset($_SESSION['registrarme'])){
  //Declaracion de variables
  $name = isset($_POST['name']) ? $_POST['name'] : "";
  $email = isset($_POST['email']) ? $_POST['email'] : "";
  $password = isset($_POST['password']) ? $_POST['password'] : "";
  $rPassword = isset($_POST['repeatPassword']) ? $_POST['repeatPassword'] : "";
  $dni = isset($_POST['dni']) ? $_POST['dni'] : "";
  $numSocio = isset($_POST['numSocio']) ? $_POST['numSocio'] : "";

  validate($name,$email,$password,$rPassword,$dni,$numSocio);

  die(); //Deja de ejecutarse

}

function validate($name,$email,$password,$rPassword,$dni,$numSocio){
  $message = "";

  if(strlen($name) < 5) $message = "El nombre especificado no es válido";
  else if(strlen($email) < 5 || $emailExiste){ //FALTA EMAIL EN LA DB
    $message = "El email especificado no es válido o ya se encuentra registrado";
  }
  else if(strlen($password) < 8) $message = "La contraseña debe tener al menos 8 caracteres";
  else if(strcmp($password,$rPassword) != 0) $message = "Las contraseñas no coinciden";
  else if(!is_int($dni)) $message = "El DNI especificado no es válido";

  $_SESSION['FLASH'] = [
    "nameValue" => $name,
    "emailValue" => $email,
    "passwordValue" => $password,(object)
    "dniValue" => $dni,
    "numSocioValue" => $numSocio,
    "message" => $message
  ];
}

?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Registrarse - Porvenir</title>
  </head>
  <body>
    <form style="display:flex;flex-direction:column" action="register.php" method="post">
      <label for="name">
        Nombre completo
        <input type="text" name="name" id="name" value="
        <?php if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['nameValue'] ?>" required>
      </label>
      <label for="email">
        Email
        <input type="email" name="email" id="email" value="
        <?php if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['emailValue'] ?>" required>
      </label>
      <label for="password">
        Contraseña
        <input type="password" name="password" id="password" value="
        <?php if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['passwordValue'] ?>" required>
      </label>
      <label for="repeatPassword">
        Confirmar contraseña
        <input type="password" name="repeatPassword" id="repeatPassword" value="" required>
      </label>
      <label for="dni">
        DNI
        <input type="tel" name="dni" id="dni" value="
        <?php if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['dniValue'] ?>" required>
      </label>
      <label for="socio">
        N° de socio
        <input type="tel" name="numSocio" id="socio" value="
        <?php if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['numSocioValue'] ?>">
      </label>
      <button type="submit" name="register">Registrarme</button>
    </form>
  </body>
</html>
