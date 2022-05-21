<?php
    require_once '../conexion.php';
    
    $link = Conectarse();

    if (isset($_POST['editarL'])) {

        $matricula = $_POST['matricula'];
        $id_libro = $_POST['id-libro'];
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
            $directorio = '../images/libros/';
    
            $imagen_tam = $_FILES['mod-imagen-libro']['size'];
            $imagen_tipo = $_FILES['mod-imagen-libro']['type'];
            $imagen_ruta = $_FILES['mod-imagen-libro']['tmp_name'];
    
            $ruta_archivo = $directorio.basename($id_libro)."_".basename($matricula).".".basename($imagen_tipo);
            $ruta_archivo_2 = $id_libro."_".$matricula.".".basename($imagen_tipo);
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
                move_uploaded_file($imagen_ruta, $ruta_archivo);

                $query = mysqli_query($link,"update libros set tipo='$tipo_libro', nombre='$nombre_libro', descripcion='$descripcion_libro', estado='$estado_libro', costo='$precio_libro' where id='$id_libro'");                
                mysqli_close($link);
                echo "<h1>Modificando Libro...</h1>";
            } else {
                mysqli_close($link);
                var_dump($id_libro);
                echo "Algo salio mal, intenta nuevamente";
            }
                // header('location: usuario.php');
                //exit();
        }
    } else {
        if (isset($_POST['delL'])) {
            $id_libro = $_POST['id-libro'];
            $query = mysqli_query($link,"delete from libros where id='$id_libro'");
            echo "<h1>Eliminando Libro...</h1>";
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
            window.location.href= 'mislibros.php';
        }, 2000);
    </script>
</body>
</html>