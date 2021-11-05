<?php
require_once 'conexiones.inc.php';
ini_set("session.cookie_lifetime", 120);

session_start();

if(isset($_SESSION["login"])){
    //Los headers siempre tienen que ir antes que cualquier html, o no funcionarán.
    header("Location: http://localhost/DUWES/login_session/tienda.php");
    
    //Si se pulsó el botón aceptar (después de haber rellenado el formulario, se recargará esta página).
} else if (isset($_POST["aceptar"])) {
    $con = conecta();
    $consulta = $con -> prepare("SELECT  login, password FROM login WHERE login=:login");
    $consulta -> bindParam(":login", $param_login);
    $param_login = $_POST["login"];
    $consulta -> execute();
    if ($registro = $consulta -> fetch()){
        //Por defecto, fetch devuelve un array clave/valor con los campos de la consulta.
        $hashedPassword = md5($_POST["password"]);
        
        if (strcmp($hashedPassword, $registro["password"]) == 0){
            //Devuelve <0 si str1 es menor que str2. >0 al revés. Cero si son iguales.
           
            $_SESSION["login"] = $registro["login"];
            header("Location: http://localhost/DUWES/login_session/tienda.php");
        }
    } else {
        echo "<br/>Ese usuario no existe<br/>";
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <?php
        
        echo '<form action="'.$_SERVER["PHP_SELF"].'"method = "post">';
        
        echo 'Login <input type="text" name="login"></br>';
        echo 'Password <input type="password" name="password"></br>';
        
        echo '<input value="Entrar" type="submit" name="aceptar">';
        
        echo '</form>';
        ?>
    </body>
</html>
