<?php
    require_once 'conexion.php';

    if(isset($_POST['registrar'])) {
        
        define("CLAVE_SECRETA", "6LfFQvgUAAAAAMyUCtAYlCccsbgAMeUstUGlxIgx");

        if (!isset($_POST["g-recaptcha-response"]) || empty($_POST["g-recaptcha-response"])) {
            // header("Location:login.php");
            // exit("Debes completar el captcha");
            $_SESSION['mensaje'] = 'Debes completar el captcha';
        }

        $token = $_POST["g-recaptcha-response"];
        $verificado = verificarToken($token, CLAVE_SECRETA);
        # Si no ha pasado la prueba
        if ($verificado) {

            $matricula = $_POST['usermat'];
            $nombre = $_POST['username'];
            $correo = $_POST['useremail'];
            $pass1 = $_POST['password'];
            $pass2 = $_POST['password-confirm'];
            $carrera = $_POST['carrera'];

            $password = md5($pass1);
            $password2 = md5($pass2);

            $link=Conectarse();

            if($matricula==NULL|$nombre==NULL|$correo==NULL|$password==NULL|$password2==NULL|$carrera==NULL) {
                mysqli_close($link);
                $_SESSION['mensaje'] = 'Un campo esta vacio';
            } else {
                // �Coinciden las contrase&ntilde;as?
                if($password != $password2) {
                    mysqli_close($link);
                    $_SESSION['mensaje'] = 'Las contraseñas no coinciden';
                } else {
                    // Comprobamos si la matricula o la cuenta de correo ya existian
                    $checkMatricula = mysqli_query($link,"SELECT matricula FROM usuarios WHERE matricula='$matricula'");
                    $matricula_exist = mysqli_num_rows($checkMatricula);
                                    
                    $checkEmail = mysqli_query($link,"SELECT correo FROM usuarios WHERE correo='$correo'");
                    $email_exist = mysqli_num_rows($checkEmail);
                                    
                    if ($email_exist>0|$matricula_exist>0) {
                        mysqli_close($link);
                        $_SESSION['mensaje'] = 'La matricula o el correo ya estan en uso';
                    } else {
                        // Ingresamos los datos a la DB
                        $query = 'INSERT INTO usuarios (matricula, nombre, correo, carrera, password)
                        VALUES (\''.$matricula.'\',\''.$nombre.'\',\''.$correo.'\',\''.$carrera.'\',\''.$password.'\');';
                        
                        //mysqli_query($link,$query) or die(mysqli_error());
                        ////////
                        if (mysqli_query($link,$query)) {
                            mysqli_close($link);
                            $_SESSION['mensaje'] = 'Registro exitoso, ahora puedes iniciar sesión';
                        } else {
                            mysqli_close($link);
                            $_SESSION['mensaje'] = 'Algo salio mal, intenta nuevamente';
                        }
                        ////////
                        // echo '<p>'.$nombre.' has sido registrado de manera satisfactoria.</p>';
                        // echo '<p>Ahora puedes entrar ingresando tu matricula y contraseña.</p>';
                        // header("location:error/okRegistro.php");
                
                    }
                }
            }
        }
    } else {
        //exit("Lo siento, parece que eres un robot");
        //header("location:error/errorRegistro.php");
    }

    function verificarToken($token, $claveSecreta) {
        # La API en donde verificamos el token
        $url = "https://www.google.com/recaptcha/api/siteverify";
        # Los datos que enviamos a Google
        $datos = [
            "secret" => $claveSecreta,
            "response" => $token,
        ];
        // Crear opciones de la petición HTTP
        $opciones = array(
            "http" => array(
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($datos), # Agregar el contenido definido antes
            ),
        );
        # Preparar petición
        $contexto = stream_context_create($opciones);
        # Hacerla
        $resultado = file_get_contents($url, false, $contexto);
        # Si hay problemas con la petición (por ejemplo, que no hay internet o algo así)
        # entonces se regresa false. Este NO es un problema con el captcha, sino con la conexión
        # al servidor de Google
        if ($resultado === false) {
            # Error haciendo petición
            return false;
        }

        # En caso de que no haya regresado false, decodificamos con JSON
        # https://parzibyte.me/blog/2018/12/26/codificar-decodificar-json-php/

        $resultado = json_decode($resultado);
        # La variable que nos interesa para saber si el usuario pasó o no la prueba
        # está en success
        $pruebaPasada = $resultado->success;
        # Regresamos ese valor, y listo (sí, ya sé que se podría regresar $resultado->success)
        return $pruebaPasada;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style-signup.css">
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="header">
        <a href="index.php"><img class="logo" src="images/logo-FCC-2.png" alt="Logo"></a>
    </div>

    <div class="class-body">
        <div class="bg-signup"></div>
        <div class="box-signup">
            <div class="title-signup">
                <h1>Registro</h1>
                <p>Por favor ingrese sus datos para generar su cuenta</p>
            </div>
<!--  -->
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
            <!-- <div><p style="
                        position:fixed;
                        width:50%;
                        color:white;
                        z-index:5;
                        top:80px;
                        text-align:center;
                        font-size:2em;
                        padding-rigth:100%;
                        background-color: #04bbe7;">
                        Registro Exitoso</p></div> -->
<!--  -->
            <form action="#" method="POST">
                <div class="data-signup">
                    <div class="box-form-text-label">
                        <input class="form-text" type="text" name="usermat" id="usermat" autocomplete="off" required maxlength="9" pattern="[0-9]{9,9}">
                        <label class="form-label" for="usermat">Ingresa tu matrícula</label>
                    </div>
                    <div class="box-form-text-label">
                    <!-- pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" -->
                    <!-- title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" -->
                        <input class="form-text" type="text" name="username" id="username" autocomplete="off" required pattern="[A-Za-z ]{2,100}">
                        <label class="form-label" for="username">Ingresa tu nombre y apellidos</label>
                    </div>
                    <div class="box-form-text-label">
                        <input class="form-text" type="email" name="useremail" id="useremail" autocomplete="off" required>
                        <label class="form-label" for="useremail">Ingresa tu correo</label>
                    </div>
                    <div class="box-form-text-label">
                        <input class="form-text" type="password" name="password" id="password" required>
                        <label class="form-label" for="password">Ingresa tu contraseña</label>
                    </div>
                    <div class="box-form-text-label">
                        <input class="form-text" type="password" name="password-confirm" id="password-confirm" required>
                        <label class="form-label" for="password-confirm">Ingresa nuevamente tu contraseña</label>
                    </div>
                    <div class="box-form-text-label">
                        <label class="form-text-2">Selecciona tu carrera</label>
                        <select class="form-text" name="carrera" id="carrera">
                            <option class="form-label" value="LIC">Lic. en Cs. de la Computación</option>
                            <option class="form-label" value="ING">Ing. en Cs. de la Computación</option>
                            <option class="form-label" value="ITI">Ing. en Tecnologías de la Inf.</option>
                        </select>
                    </div>
                </div>

                <div class="g-recaptcha" data-sitekey="6LfFQvgUAAAAAAijmvLjHa_SE3Gw8TLn6GykWHhO"></div>
                
                <div class="btns-signup">
                    <!-- <a class="btn-login" href="">Registrarme</a> -->
                    <button class="btn-login" type="submit" name="registrar">Registrarme</button>
                    <a class="btn-signup" href="login.php">Entrar</a>
                </div>
            </form>

        </div>
    </div>
</body>
</html>