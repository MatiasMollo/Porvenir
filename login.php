<?php
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
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/templateStyles.css">
    <link rel="stylesheet" href="css/navStyles.css">
    <title>Login - El Porvenir</title>
  </head>
  <body>
    <div class="container">
      <a href="./"> <img class="logo__link" src="addons/images/navimages/logoPorvenir.png" alt="logo del el porvenir"></a>
        <div class="background__form">
          <h2>Iniciar Sesión</h2>
          <form action="login.php" method="post">
            <div class="form__line">
              <label class="form__text" for="email">Email</label>
              <input class="form__box"type="text" name="email" id="email" required
                value="<?php
                  if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['emailValue'];
              ?>">
            </div>
            <div class="form__line">
              <label class="form__text" for="password">Contraseña</label>
              <input class="form__box" type="password" name="password" id="password" required
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
            <button type="submit" name="login" class="btn__login">Ingresar</button>
    </form>
        </div>
        <div class="form__info">
            <p class="info">Si usted no tiene cuenta, <a class="link__register" href="register.php">Registrese</a></p>
        </div>
    </div>
  </body>
</html>
