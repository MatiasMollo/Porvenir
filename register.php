<?php
require_once "tools/connection.php";
session_start();

if(isset($_SESSION['user']->id)){
  header('location:./');
  die();
}

if(isset($_POST['register'])){
  //Declaracion de variables
  $name = !empty($_POST['name']) ? $_POST['name'] : "";
  $email = !empty($_POST['email']) ? $_POST['email'] : "";
  $password = !empty($_POST['password']) ? $_POST['password'] : "";
  $rPassword = !empty($_POST['repeatPassword']) ? $_POST['repeatPassword'] : "";
  $celular = !empty($_POST['celular']) ? $_POST['celular'] : "";
  $fechaNacimiento = !empty($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : "";
  $dni = !empty($_POST['dni']) ? $_POST['dni'] : "";
  $numSocio = !empty($_POST['numSocio']) ? $_POST['numSocio'] : null;

  //Reemplazamos caracteres no numericos
  str_replace(" ","",$celular);
  str_replace("-","",$celular);
  str_replace(" ","",$dni);

  //Se le pasan las variables a validate (tambien $conn porque si no no la toma)
  if(validate($name,$email,$password,$rPassword, $fechaNacimiento,$dni,$celular,$conn)){

    $password = password_hash($password,PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre,email,password,celular,dni,fechaNacimiento,numeroSocio) VALUES (:name,:email,:password,:phone,:dni,:fechaNacimiento,:numSocio)";
    $consulta = $conn->prepare($sql);
    $consulta->execute(array(
      "name" => $name,
      "email" => $email,
      "password" => $password,
      "phone" => $celular,
      "dni" => $dni,
      "fechaNacimiento" => date($fechaNacimiento),
      "numSocio" => $numSocio
    ));

    $consulta = $conn->prepare("SELECT id FROM usuarios WHERE dni=(?) LIMIT 1");
    $consulta->execute([$dni]);
    $id = $consulta->fetch()[0];

    $_SESSION['user'] = (object)[
      "id" => $id,
      "name" => $name,
      "email" => $email,
      "phone" => $celular,
      "dni" => $dni,
      "fechaNacimiento" => $fechaNacimiento,
      "numSocio" => $numSocio,
      "ultimaReserva" => 0
    ];
    header('location:./');
  }
  else header('location:register.php');

  die(); //Deja de ejecutarse
}

function validate($name,$email,$password,$rPassword,$fechaNacimiento,$dni,$celular,$conn){
  unset($_SESSION['FLASH']);
  $message = "";
  $retorno = true;

  //Email DB
  $sql = "SELECT email FROM usuarios WHERE email=? LIMIT 1";
  $consulta = $conn->prepare($sql);
  $consulta->execute([$email]);
  $emailRegistered = $consulta->fetch();//Devuelve FALSE si no existe

  $consulta = $conn->prepare("SELECT id FROM usuarios WHERE dni=(?) LIMIT 1");
  $consulta->execute([$dni]);
  $dniRegistered = $consulta->fetch();


  if(strlen($name) < 5) $message = "El nombre especificado no es v??lido";
  else if(strlen($email) < 5 || !str_contains($email,"@") || !str_contains($email,".")){
    $message = "El email especificado no es v??lido";
  }
  else if($emailRegistered) $message = "El email ingresado ya se encuentra registrado";
  else if(strlen($password) < 8) $message = "La contrase??a debe tener al menos 8 caracteres";
  else if(strcmp($password,$rPassword) != 0) $message = "Las contrase??as no coinciden";
  else if(!(strlen($fechaNacimiento) > 0)) $message = "La fecha de nacimiento es requerida";
  //Preguntar al porve si se necesita un minimo de edad
  else if(!is_numeric($dni)) $message = "El DNI especificado no es v??lido";
  else if($dniRegistered) $message = "El DNI especificado ya se encuentra registrado";
  else if(!is_numeric($celular)) $message = "El celular especificado no es v??lido";

  if($message != ""){
    $_SESSION['FLASH'] = [ //Flasheamos solo si hubo un error ($message!="")
      "nameValue" => $name,
      "emailValue" => $email,
      "passwordValue" => $password,
      "dniValue" => $dni,
      "fechaNacimiento" => $fechaNacimiento,
      "celular" => $celular,
      "numSocioValue" => $numSocio,
      "message" => $message
    ];
    $retorno = false;
    header('location:register.php');
  }
  return $retorno;
}
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/templateStyles.css">
    <link rel="stylesheet" href="css/formStyles.css">
    <title>Registrarse - El Porvenir</title>
  </head>
  <body>
      <div class="container container__register">
          <a href="./"> <img class="logo__link " src="addons/images/navImages/logoPorvenir.png" alt=""></a>
          <div class="background__form"> 
            <h2>Registrarse</h2>
          <form class="form__register" action="register.php" method="post">
            <div class="form--row">
              <div>
                <div class="form__line form__line__register">
                  <label class="form__text form__text__register" for="name">
                    Nombre completo
                    <input class="form__box form__box__register"  type="text" name="name" id="name" value="<?php
                    if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['nameValue'] ?>" required>
                  </label>
                </div>
                <div class="form__line form__line__register">
                  <label class="form__text form__text__register" for="email">
                    Email
                    <input class="form__box form__box__register" type="email" name="email" id="email" value="<?php
                    if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['emailValue'] ?>" required>
                  </label>
                </div>
                <div class="form__line form__line__register">
                  <label class="form__text form__text__register" for="password">
                    Contrase??a
                    <input class="form__box form__box__register" type="password" name="password" id="password" value="<?php
                    if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['passwordValue'] ?>" required>
                  </label>
                </div>
                <div class="form__line form__line__register">
                  <label class="form__text form__text__register" for="repeatPassword">
                    Confirmar contrase??a
                    <input class="form__box form__box__register" type="password" name="repeatPassword" id="repeatPassword" value="" required>
                  </label>
                </div>
              </div>
              <div>
                <div  class="form__line form__line__register">
                  <label class="form__text form__text__register" for="fechaNacimiento">
                    Fecha de nacimiento
                    <input class="form__box form__box__register" type="date" name="fechaNacimiento" id="fechaNacimiento" value="<?php
                      if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['fechaNacimiento'] ?>" required>
                  </label>
                </div>
                <div class="form__line form__line__register">
                  <label class="form__text form__text__register" for="dni">
                      DNI
                      <input class="form__box form__box__register" type="tel" name="dni" id="dni" value="<?php
                      if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['dniValue'] ?>" required>
                  </label>
                </div>
                <div class="form__line form__line__register">
                    <label class="form__text form__text__register" for="celular">
                      Celular
                      <input class="form__box form__box__register" type="tel" name="celular" id="celular" value="<?php
                      if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['celular'] ?>" required>
                    </label>
                </div>
                <div class="form__line form__line__register">
                    <label class="form__text form__text__register"  for="socio">
                      N?? de socio (opcional)
                      <input class="form__box form__box__register"  type="tel" name="numSocio" id="socio" value="<?php
                      if(!empty($_SESSION['FLASH'])){
                        echo $_SESSION['FLASH']['numSocioValue'];
                      } ?>">
                    </label>
                </div>
              </div>
            </div>
              <h4 class="errorMessage"><?php
                if(isset($_SESSION['FLASH'])){
                  echo $_SESSION['FLASH']['message'];
                  unset($_SESSION['FLASH']); //Eliminamos datos de sesion
                }
              ?></h4>
              <button type="submit" name="register" class="btn__form">Registrarme</button>
              </form>
          </div>
          <div class="form__info">
            <p class="info">Si usted tiene una cuenta, <a class="link__register" href="login.php">inicie sesi??n</a></p>
          </div>
      </div>
  </body>
</html>
