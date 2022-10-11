<?php
include "addons/nav.php";
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
      "fechaNacimiento" => $userDB['fechaNacimiento'],
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Login - El Porvenir</title>
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
      <button type="submit" name="login" class="btn btn-primary">Ingresar</button>
    </form>
  </body>
</html>
