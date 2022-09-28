<?php
require_once "tools/connection.php";
session_start(); //Eliminar y ponerlo en el Nav, incluir el mismo en los documentos

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
  $celular = !empty($_POST['celular']) ? $_POST['celular'] : $celular = "";
  $dni = !empty($_POST['dni']) ? $_POST['dni'] : "";
  $numSocio = !empty($_POST['numSocio']) ? $_POST['numSocio'] : $numSocio = null;

  //Reemplazamos caracteres no numericos
  str_replace(" ","",$celular);
  str_replace("-","",$celular);
  str_replace(" ","",$dni);

  //Se le pasan las variables a validate (tambien $conn porque si no no la toma)
  if(validate($name,$email,$password,$rPassword,$dni,$celular,$conn)){

    $password = password_hash($password,PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre,email,password,celular,dni,numeroSocio) VALUES (:name,:email,:password,:phone,:dni,:numSocio)";
    $consulta = $conn->prepare($sql);
    $consulta->execute(array(
      "name" => $name,
      "email" => $email,
      "password" => $password,
      "phone" => $celular,
      "dni" => $dni,
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
      "numSocio" => $numSocio,
      "ultimaReserva" => 0
    ];
    header('location:./');
  }
  else header('location:register.php');

  die(); //Deja de ejecutarse
}

function validate($name,$email,$password,$rPassword,$dni,$celular,$conn){
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

  if(strlen($name) < 5) $message = "El nombre especificado no es válido";
  else if(strlen($email) < 5 || !str_contains($email,"@") || !str_contains($email,".")){
    $message = "El email especificado no es válido";
  }
  else if($emailRegistered) $message = "El email ingresado ya se encuentra registrado";
  else if(strlen($password) < 8) $message = "La contraseña debe tener al menos 8 caracteres";
  else if(strcmp($password,$rPassword) != 0) $message = "Las contraseñas no coinciden";
  else if(!is_numeric($dni)) $message = "El DNI especificado no es válido";
  else if($dniRegistered) $message = "El DNI especificado ya se encuentra registrado";
  else if(!is_numeric($celular)) $message = "El celular especificado no es válido";

  if($message != ""){
    $_SESSION['FLASH'] = [ //Flasheamos solo si hubo un error ($message!="")
      "nameValue" => $name,
      "emailValue" => $email,
      "passwordValue" => $password,
      "dniValue" => $dni,
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
    <title>Registrarse - Porvenir</title>
  </head>
  <body>
    <form style="display:flex;flex-direction:column" action="register.php" method="post">
      <label for="name">
        Nombre completo
        <input type="text" name="name" id="name" value="<?php
         if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['nameValue'] ?>" required>
      </label>
      <label for="email">
        Email
        <input type="email" name="email" id="email" value="<?php
         if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['emailValue'] ?>" required>
      </label>
      <label for="password">
        Contraseña
        <input type="password" name="password" id="password" value="<?php
         if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['passwordValue'] ?>" required>
      </label>
      <label for="repeatPassword">
        Confirmar contraseña
        <input type="password" name="repeatPassword" id="repeatPassword" value="" required>
      </label>
      <label for="dni">
        DNI
        <input type="tel" name="dni" id="dni" value="<?php
         if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['dniValue'] ?>" required>
      </label>
      <label for="celular">
        Celular
        <input type="tel" name="celular" id="celular" value="<?php
         if(!empty($_SESSION['FLASH'])) echo $_SESSION['FLASH']['celular'] ?>" required>
      </label>
      <label for="socio">
        N° de socio (opcional)
        <input type="tel" name="numSocio" id="socio" value="<?php
         if(!empty($_SESSION['FLASH'])){
          echo $_SESSION['FLASH']['numSocioValue'];
        }  ?>">
      </label>
      <h4 style="color:red"><?php
        if(isset($_SESSION['FLASH'])){
          echo $_SESSION['FLASH']['message'];
          unset($_SESSION['FLASH']); //Eliminamos datos de sesion
        }
       ?></h4>
      <button type="submit" name="register">Registrarme</button>
    </form>
  </body>
</html>
