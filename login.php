<?php
if(isset($_POST['entrar'])) {

    session_start();
    require_once 'conexion.php';

    $matricula=$_POST['usermat'];
    $password=$_POST['password'];

    $link=Conectarse();
        
    $query = mysqli_query($link,"select rol,matricula,password from usuarios where matricula='$matricula';");

    if($row = mysqli_fetch_array($query)){
        if( $row['matricula'] == $matricula && $row['password'] == md5($password) ){
            $_SESSION["matricula"]=$matricula;
            $_SESSION["rol"]=$row['rol'];

            if( $row['rol']==2) {
                header("Location:user/usuario.php");
            } else {
            header("Location:listarlibros.php");
            }
        } else {
            $_SESSION['mensaje'] = 'La matricula o la contraseña no es valida';
        }
    } else {
        $_SESSION['mensaje'] = 'La matricula o la contraseña no es valida';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style-login.css">
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <a href="index.php"><img class="logo" src="images/logo-FCC-2.png" alt=""></a>
    </div>

    <div class="class-body">
        <div class="bg-login"></div>
        <div class="box-login">
            <div class="title-login">
                <h1>Acceso</h1>
                <p>¡Bienvenido!, por favor ingrese sus datos</p>
            </div>

            <?php
                if( isset($_SESSION['mensaje'])) {
                    echo "<div><p style='
                                        position:fixed;
                                        width:50%;
                                        color:white;
                                        z-index:5;
                                        top:80px;
                                        text-align:center;
                                        font-size:2em;
                                        padding-rigth:100%;
                                        background-color: #04bbe7;
                                        '>".$_SESSION['mensaje']."</p></div>";
                }
            ?>

            <form action="#" method="POST">
                <div class="data-login">
                    <div class="box-form-text-label">
                        <input class="form-text" type="text" name="usermat" id="usermat" autocomplete="off" required>
                        <label class="form-label" for="usermat">Ingresa tu matrícula</label>
                    </div>
                    <div class="box-form-text-label">
                        <input class="form-text" type="password" name="password" id="password" required>
                        <label class="form-label" for="password">Ingresa tu contraseña</label>
                    </div>
                </div>
                <div class="btns-login">
                    <!-- <a class="btn-login" href="">Entrar</a> -->
                    <button class="btn-login" type="submit" name="entrar">Entrar</button>
                    <a class="btn-signup" href="signup.php">Registrarme</a>
                </div>
            </form>
        </div>
    </div>

    
</body>
</html>




