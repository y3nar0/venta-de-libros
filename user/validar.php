<?php
    require_once '../conexion.php';
    
    $link = Conectarse();

    // $query = mysqli_query($link,"select max(id) from libros;");
    // var_dump($query->num_rows);
    // $ultimo = mysqli_fetch_array($query);
    // var_dump($ultimo);
    // var_dump($ultimo[0]);

    if (isset($_POST['guardarL'])) {

        $matricula = $_POST['matricula'];
        $tipo_libro = $_POST['mod-tipo-libro'];
        $nombre_libro = $_POST['mod-nombre-libro'];
        $descripcion_libro = $_POST['mod-descripcion-libro'];
        $estado_libro = $_POST['mod-estado-libro'];
        $precio_libro = $_POST['mod-precio-libro'];
        $im = $_FILES['mod-imagen-libro'];

        if($tipo_libro==NULL|$nombre_libro==NULL|$descripcion_libro==NULL|$estado_libro==NULL|$precio_libro==NULL|$im==NULL) {
            mysqli_close($link);
            echo "Un campo esta vacio";
        } else {
            $query = mysqli_query($link,"select max(id) from libros;");
            $ultimo = mysqli_fetch_array($query);

            if($ultimo[0] != NULL) {
                $ultimo[0] = $ultimo[0] + 1;
            } else {
                $ultimo[0] = 1;
            }

            $directorio = '../images/libros/';
    
            $imagen_tam = $_FILES['mod-imagen-libro']['size'];
            $imagen_tipo = $_FILES['mod-imagen-libro']['type'];
            $imagen_ruta = $_FILES['mod-imagen-libro']['tmp_name'];
    
    
            $ruta_archivo = $directorio.basename($ultimo[0])."_".basename($matricula).".".basename($imagen_tipo);
            $ruta_archivo_2 = $ultimo[0]."_".$matricula.".".basename($imagen_tipo);
            $tipo_archivo = strtolower(pathinfo($ruta_archivo, PATHINFO_EXTENSION));
    
            $valido = 3;

            if ($imagen_tam > 1048576) {
                echo "<h1>ERROR: La imagen es muy grande</h1>";
                $valido = $valido-1;
                mysqli_close($link);
            }
            if ($tipo_archivo != "jpg" && $tipo_archivo != "png" && $tipo_archivo != "gif" && $tipo_archivo != "jpeg") {
                echo "<h1>ERROR: La imagen no tiene un formato valido</h1>";
                $valido = $valido-1;
                mysqli_close($link);
            }

            if ($valido == 3) {
                $query = mysqli_query($link,"select id from usuarios where matricula='$matricula';");
                $propietario = mysqli_fetch_array($query);

                $query = 'INSERT INTO libros (tipo, nombre, descripcion, estado, costo, imagen, propietario)
                        VALUES (\''.$tipo_libro.'\',\''.$nombre_libro.'\',\''.$descripcion_libro.'\',\''.$estado_libro.'\',\''.$precio_libro.'\',\''.$ruta_archivo_2.'\',\''.$propietario[0].'\');';

                //mysqli_query($link,$query) or die(mysqli_error());
                if (mysqli_query($link,$query)) {
                    move_uploaded_file($imagen_ruta, $ruta_archivo);
                    mysqli_close($link);
                    echo "<h1>Guardando Libro...</h1>";
                } else {
                    mysqli_close($link);
                    echo "Algo salio mal, intenta nuevamente";
                }

                // header('location: usuario.php');
                //exit();
            }
        }
    } else {
        if (isset($_POST['cambiarI'])) {
            $directorio = '../images/usuarios/';

            $matricula = $_POST['matricula'];
            $imagen_tam = $_FILES['mod-imagen']['size'];
            $imagen_tipo = $_FILES['mod-imagen']['type'];
            $imagen_ruta = $_FILES['mod-imagen']['tmp_name'];

            // $ruta_archivo = $directorio.basename($matricula).".".basename($imagen_tipo);
            $ruta_archivo = $directorio.basename($matricula).".".basename($imagen_tipo);
            $ruta_archivo_2 = $matricula.".".basename($imagen_tipo);
            $tipo_archivo = strtolower(pathinfo($ruta_archivo, PATHINFO_EXTENSION));

            $valido = 3;
            if ($imagen_tam > 1048576) {
                echo "<h1>ERROR: El archivo es muy grande</h1>";
                $valido = $valido-1;
            }
            if ($tipo_archivo != "jpg" && $tipo_archivo != "png" && $tipo_archivo != "gif" && $tipo_archivo != "jpeg") {
                echo "<h1>ERROR: El archivo no tiene un formato valido</h1>";
                $valido = $valido-1;
                mysqli_close($link);
            }
            // if( file_exists($ruta_archivo) ) {
            //     echo "<h1>ERROR: El nombre del archivo ya existe</h1>";
            //     $valido = $valido-1;
            // }

            if ($valido == 3) {
                move_uploaded_file($imagen_ruta, $ruta_archivo);

                $query = mysqli_query($link,"update usuarios set imagen='$ruta_archivo_2' where matricula='$matricula';");
                mysqli_close($link);
                echo "<h1>Actualizando dato...</h1>";
                // header('location: usuario.php');
                //exit();
            }


        } else {
            if (isset($_POST['cambiarN'])) {
                $matricula = $_POST['matricula'];
                $nombre = $_POST['mod-nombre'];
        
                $query = mysqli_query($link,"update usuarios set nombre='$nombre' where matricula='$matricula';");
                mysqli_close($link);
                echo "<h1>Actualizando dato...</h1>";
            } else {
                if (isset($_POST['cambiarC'])) {
                    $matricula = $_POST['matricula'];
                    $correo = $_POST['mod-correo'];

                    $checkEmail = mysqli_query($link,"SELECT correo FROM usuarios WHERE correo='$correo'");
                    $email_exist = mysqli_num_rows($checkEmail);
                    if ($email_exist>0) {
                        mysqli_close($link);
                        echo '<h1>ERROR: El correo ya esta en uso</h1>';
                    } else {
                        $query = mysqli_query($link,"update usuarios set correo='$correo' where matricula='$matricula';");
                        mysqli_close($link);
                        echo "<h1>Actualizando dato...</h1>";
                    }
                } else {
                    if (isset($_POST['cambiarT'])) {
                        $matricula = $_POST['matricula'];
                        $telefono = $_POST['mod-telefono'];
                
                        $query = mysqli_query($link,"update usuarios set telefono='$telefono' where matricula='$matricula';");
                        mysqli_close($link);
                        echo "<h1>Actualizando dato...</h1>";
                    } else {
                        if (isset($_POST['cambiarP'])) {
                            $matricula = $_POST['matricula'];
                            $pass1 = $_POST['mod-password-1'];
                            $pass2 = $_POST['mod-password-2'];

                            if($pass1==NULL|$pass2==NULL) {
                                mysqli_close($link);
                                echo '<h1>ERROR: Un campo esta vacio</h1>';
                            } else {
                                if($pass1 != $pass2) {
                                    mysqli_close($link);
                                    echo '<h1>ERROR: Las contraseñas no coinciden</h1>';
                                } else {
                                    $password = md5($pass1);
                                    $query = mysqli_query($link,"update usuarios set password='$password' where matricula='$matricula';");
                                    mysqli_close($link);
                                    echo "<h1>Actualizando dato...</h1>";
                                }
                            }
                        } else {
                            if (isset($_POST['darseDeBaja'])) {
                                $matricula = $_POST['matricula'];
                                $query = mysqli_query($link,"delete from usuarios where matricula='$matricula';");
                                mysqli_close($link);
                                header('Location: ../index.php');
                            }
                        }
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificando</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style-books.css">
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <script>
        // Usando setTimeout para ejecutar una función después de 5 segundos.
        setTimeout(function () {
            // Redirigir con JavaScript
            window.location.href= 'usuario.php';
        }, 2000);
    </script>
</body>
</html>