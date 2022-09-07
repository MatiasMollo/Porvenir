
<?php
session_start(); //Importante ponerlo en el nav y sacarlo de aca

if(isset($_POST['login'])){//Entra aca solo si se apreto el boton de login
echo "asd";
  $email = isset($_POST['email']) ? $_POST['email'] : "";
  $password = isset($_POST['password']) ? $_POST['password'] : "";
  validate($email,$password);

  die();//Termina el programa

}

function validate($email,$password){
  $message = "";
  //!Falta validar si tiene "@" IMPORTANTE
  if(strlen($email) < 5) $message = "El email es inválido, vuelva a intentarlo";
  else if(strlen($password) < 8) $message = "Contraseña incorrecta";

  //Falta validar si existe el usuario (DB)

  $_SESSION['FLASH'] = [
    "emailValue" => $email,
    "passwordValue" => $password,
    "errorMessage" => $message
  ];
  //DEVOLVER SOLO SI HAY ERRORES (si $msj != "")
  return header('location:login.php'); //Recarga este documento con el metodo GET
}

 ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login - Porvenir</title>
  </head>
  <body>
    <form action="login.php" method="post">
      <div>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" required
         value="<?php
          if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['emailValue'];
          ?>">
      </div>
      <div>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required
         value="<?php
          if(isset($_SESSION['FLASH'])) echo $_SESSION['FLASH']['passwordValue'];
          ?>">
      </div>
      <p><?php
        if(isset($_SESSION['FLASH'])){
          echo $_SESSION['FLASH']['errorMessage'];
          unset($_SESSION['FLASH']); //elimino datos flash
        }
        ?></p>
      <button type="submit" name="login">Ingresar</button>
    </form>
  </body>
</html>
