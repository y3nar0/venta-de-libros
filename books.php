<?php
    require_once 'conexion.php';
    $link = Conectarse();

    $query = mysqli_query($link,"select * from libros where vendido=0 order by tipo");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTA DE LIBROS</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style-books.css">
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <a href="index.php"><img class="logo" src="images/logo-FCC-2.png" alt="Logo"></a>
        <a class="btn-signup" href="signup.php">Registrarse</a>
        <a class="btn-sesion-start" href="login.php">Iniciar sesión</a>
    </div>
    <!-- FIN HEADER -->

    <!-- BODY -->
    <div class="class-body">
        <!-- FONDO -->
        <div class="bg">
            <!-- CONTENEDOR PARA EL CONTENIDO -->
            <section class="box-books">
                <?php
                //var_dump($query->num_rows);
                    if($query->num_rows > 0) {
                        while($row=mysqli_fetch_array($query)) {
                            $id_libro=$row['id'];
                            $campo_tipo=$row['tipo'];
                            $imagen=$row['imagen'];
                            $nombre=$row['nombre'];
                            $descripcion=$row['descripcion'];
                            $estado=$row['estado'];
                            $costo=$row['costo'];
                            $propietario=$row['propietario'];

                            if($campo_tipo == 'computacion') $tipo = "COMPUTACIÓN"; else
                            if($campo_tipo == 'hardware') $tipo = "HARDWARE"; else
                            if($campo_tipo == 'matematicas') $tipo = "MATEMÁTICAS"; else
                            if($campo_tipo == 'fisica') $tipo = "FÍSICA"; else
                            if($campo_tipo == 'otros') $tipo = "OTROS";

                            echo
                                    "<div class='split-article'>
                                        <article class='article'>
                                            <div class='article-bg'>
                                                <div class='article-tipo'><p>$tipo</p></div>
                                                <div class='article-libro'>
                                                    <div class='article-imagen' style='background-image:url(images/libros/$imagen);'></div>
                                                    <div class='article-nombre' style='text-transform:uppercase;'><p>$nombre</p></div>
                                                    <div class='article-descripcion'><p>$descripcion</p></div>
                                                    <div class='article-estado'>$estado</div>
                                                    <div class='article-costo'><p>$$costo</p></div>
                                                    <a id='comprar' class='article-comprar' href='compra.php?a=$id_libro'>COMPRAR</a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>";
                        }

                    } else {
                        echo "LO SENTIMOS AUN NO HAY LIBROS EN VENTA";
                    }
                    mysqli_close($link);
                ?>
            </section>

        </div>
    </div>
</body>
</html>




<!-- <div class="split-article">
    <article class="article">
        <div class="article-bg">
            <div class="article-tipo"><p>MATEMATICAS</p></div>
            <div class="article-libro">
                <div class="article-imagen"></div>
                <div class="article-nombre"><p>ALGEBRA DE BALDOR</p></div>
                <div class="article-descripcion"><p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Amet perferendis neque et iste. Cumque, nemo?</p></div>
                <div class="article-estado">NUEVO</div>
                <div class="article-costo"><p>$ 150.00</p></div>
                <a class="article-comprar" href="">COMPRAR</a>
            </div>
        </div>
    </article>
</div> -->
