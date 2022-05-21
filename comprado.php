<?php
    require_once 'conexion.php';
    

    if (isset($_POST['comprar-buy'])) {
        $id_libro=$_POST['id-libro'];
        $matricula=$_POST['usermat-buy'];
        $telefono=$_POST['tel-buy'];
        $email=$_POST['useremail-buy'];
        $carrera=$_POST['carrera-buy'];
        $lugar=$_POST['lugar-buy'];

        if($matricula==NULL|$telefono==NULL|$email==NULL|$carrera==NULL|$lugar==NULL) {
            echo "Un campo esta vacio";
        } else {
            $link = Conectarse();

            $query = 'INSERT INTO compras (matricula, carrera, telefono, correo, lugar, id_libro)
                        VALUES (\''.$matricula.'\',\''.$carrera.'\',\''.$telefono.'\',\''.$email.'\',\''.$lugar.'\',\''.$id_libro.'\')';
            
            //mysqli_query($link,$query) or die(mysqli_error());
            if (mysqli_query($link,$query)) {
                $query = mysqli_query($link,"update libros set vendido=1 where id='$id_libro';");
                mysqli_close($link);
                echo "<h1>Enviando tu informacion...</h1>";
            } else {
                mysqli_close($link);
                echo "Algo salio mal, intenta nuevamente";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracias</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style-books.css">
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
<script>
        // Usando setTimeout para ejecutar una función después de 5 segundos.
        setTimeout(function () {
            // Redirigir con JavaScript
            window.location.href= 'index.php';
        }, 2000);
    </script>
</body>
</html>