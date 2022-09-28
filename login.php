<?php
session_start(); //Importante ponerlo en el nav y sacarlo de aca
require_once "tools/connection.php"; //Ponerlo en el nav y sacarlo de aca

//En caso de sesion iniciada te devuelve al index
if(isset($_SESSION['user']->id)){
  header('location:./');
  die();
}

if(isset($_POST['login'])){//Entra aca solo si se apreto el boton de login

  $email = isset($_POST['email']) ? $_POST['email'] : "";
  $password = isset($_POST['password']) ? $_POST['password'] : "";

  validate($email,$password,$conn);

  die();//Termina el programa
}

function validate($email,$password,$conn){
  $message = "";

  $consulta = $conn->prepare("SELECT * FROM usuarios WHERE email=(?) LIMIT 1");
  $consulta->execute([$email]);
  $userDB = $consulta->fetch();

  //!Falta validar email de la DB
  if(strlen($email) < 5 || !str_contains($email,'@') || !str_contains($email,'.')){
    $message = "El email es inválido, vuelva a intentarlo";
  }
  //Verificamos que la contraseña coincida con la del registro
  else if(!password_verify($password,$userDB['password'])) $message = "Contraseña incorrecta";

  if($message == ""){
    $_SESSION['user'] = (object)[
      "id" => $userDB['id'],
      "name" => $userDB['nombre'],
      "email" => $userDB['email'],
      "phone" => $userDB['celular'],
      "dni" => $userDB['dni'],
      "numSocio" => $userDB['numSocio'],
      "ultimaReserva" => $userDB['ultimaReserva']
    ];
    header('location:./');
  }
  else{
    $_SESSION['FLASH'] = [
      "emailValue" => $email,
      "passwordValue" => $password,
      "errorMessage" => $message
    ];
    header('location:./login.php'); //Recarga el documento con metodo Get
  }
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
