<?php
    require_once '../conexion.php';
    session_start();
    $matricula = $_SESSION['matricula'];
    $link = Conectarse();

    $query = mysqli_query($link,"select count(vendido) from libros where vendido=1 and baja=0 and propietario=(select id from usuarios where matricula='$matricula')");
    $vendidos = mysqli_fetch_array($query);
    //$vendidos[0] = 0;
    if ($vendidos[0] == 0) $vendidos[0] = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Ventas</title>
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style-ventas.css">
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .tabla { display: table; border: 1px solid black; color: white; margin-left: 80px;}
        .encabezado {
            background-color: #002D4C;
            display: table-row;
            text-align: center;
        }
        .fila { display: table-row;background-color: #246f9c; }
        .celda {
            text-align: center;
            display: table-cell;
            border: solid;
            border-width: thin;
            padding: 0 .5em;
            vertical-align: middle;
        }
        .v, .c {
            display: block;
            padding: 1em 2em;
            color: white;
            margin: 1em;
        }
        .v {background: #002D4C;}
        .v:hover {background: blue;}
        .c {background: #aa0000;}
        .c:hover {background: red;}
    </style>
</head>
<body>
    <div class="header">
        <img class="logo" src="../images/logo-FCC-2.png" alt="">
        <a class="btn-exit" href="salir.php">Salir</a>
    </div>

    <div class="class-body">
        <div class="box-menu">
            <div id="mostrar-nav" style="position:fixed;top:15%;"><span style='display:block;width:50%;text-align:center;background-color:red;border-radius:50%;float:right;color:white;'><?=$vendidos[0];?></span></div>
            <nav>
                <ul class="menu">
                    <li><a href="usuario.php">Mis Datos</a></li>
                    <li><a href="mislibros.php">Mis Libros</a></li>
                    <li><a href="#modal-add-book">Agregar Libro</a></li>
                    <li><a href="otroslibros.php">Ver Otros Libros</a></li>
                    <li><a href="ventas.php">Mis Ventas <span style='display:block;width:20%;text-align:center;background-color:red;border-radius:50%;float:right;color:white;'><?=$vendidos[0];?></span></a></li>
                    <li><a href="#modal-password">Cambiar Contraseña</a></li>
                    <li><a href="salir.php">Salir</a></li>
                    <li class="baja"><a href="#modal-baja">Darse de baja</a></li>
                </ul>
            </nav>
        </div>
        <h1 style="color:#002D4C;text-align:center;padding:0 3em;margin-top:2em">PONTE EN CONTACTO CON EL COMPRADOR O ANOTA SUS DATOS ANTES DE DAR CLICK EN VENDER</h1>
        <div class="bg">
            <section class="box-books">
            <div class="tabla">
                <?php
                    $query = mysqli_query($link,"select l.id, l.imagen, l.nombre, l.costo, c.matricula, c.carrera, c.telefono, c.correo, c.lugar from libros as l, compras as c where l.id=c.id_libro and vendido=1 and baja=0 and propietario = (select id from usuarios where matricula = '$matricula')");

                    echo 
                    '<div class="encabezado">
                        <div class="celda"><p>Libro</p></div>
                        <div class="celda">Titulo</div>
                        <div class="celda">Precio</div>
                        <div class="celda">Matricula del comprador</div>
                        <div class="celda">Carrera del comprador</div>
                        <div class="celda">Telefono del comprador</div>
                        <div class="celda">Correo del comprador</div>
                        <div class="celda">Lugar Acordado</div>
                        <div class="celda">Opcion</div>
                    </div>';
                    
                    if($query->num_rows > 0) {
                        while($row=mysqli_fetch_array($query)) {
                            $id_libro=$row['id'];
                            $imagen=$row['imagen'];
                            $nombre=$row['nombre'];
                            $costo=$row['costo'];
                            //$propietario=$row['propietario'];
                            $mat_comp=$row['matricula'];
                            $c_comp=$row['carrera'];
                            $tel_comp=$row['telefono'];
                            $cor_comp=$row['correo'];
                            $lug_comp=$row['lugar'];

                            if($c_comp == 'LIC') $car_comp = "Licenciatura en Ciencias de la Computación";
                                else
                                    if($c_comp == 'ING') $car_comp = "Ingeniería en Ciencias de la Computación";
                                        else
                                            if($c_comp == 'ITI') $car_comp = "Ingeniería en Tecnologías de la Información";

                            echo 
                                    "<div class='fila'>
                                        <div class='celda' style='background:url(../images/libros/$imagen);background-size:100% 100%;width:150px;height:200px'></div>
                                        <div class='celda' style='text-transform:uppercase;'>$nombre</div>
                                        <div class='celda'>$ $costo</div>
                                        <div class='celda'>$mat_comp</div>
                                        <div class='celda'>$car_comp</div>
                                        <div class='celda'>$tel_comp</div>
                                        <div class='celda'>$cor_comp</div>
                                        <div class='celda'>$lug_comp</div>
                                        <div class='celda'>
                                            <a class='v' href='ventasok.php?a=$id_libro&b=1'>Vender</a>
                                            <a class='c' href='ventasok.php?a=$id_libro&b=2'>Cancelar</a>
                                        </div>
                                    </div>";
                        }

                    } else {
                        echo "POR EL MOMENTO NO TIENES VENTAS";
                    }
                    mysqli_close($link);
                ?>
            </section>
        </div>

        <div id="modal-password" class="Modal">
            <aside class="Modal-box">
                <h2>¿Quieres cambiar tu contraseña?</h2>
                <form action="validar.php" method="POST" enctype="multipart/form-data">
                    <label><p>Escribe tu nueva contraseña</p></label>
                    <input type="password" name="mod-password-1">
                    <label><p>Escribe tu nueva contraseña</p></label>
                    <input type="password" name="mod-password-2">
                    <input type="hidden" name="matricula" value="<?=$matricula?>">
                    <div>
                        <input type="submit" name="cambiarP" value=" Cambiar ">
                    </div>
                </form>
                <div>
                    <a class="cerrar-modal" href="#">Cerrar</a>
                </div>
            </aside>
        </div>

        <div id="modal-baja" class="Modal">
            <aside class="Modal-box">
                <h2>¿Quieres dar de baja tu cuenta?</h2>
                <form action="validar.php" method="POST" enctype="multipart/form-data">
                    <!-- <label><p>Escribe tu nueva contraseña</p></label> -->
                    <!-- <input type="password" name="mod-password-1"> -->
                    <!-- <label><p>Escribe tu nueva contraseña</p></label> -->
                    <!-- <input type="password" name="mod-password-2"> -->
                    <input type="hidden" name="matricula" value="<?=$matricula?>">
                    <div>
                        <input type="submit" name="darseDeBaja" value=" SI ">
                    </div>
                </form>
                <div>
                    <a class="cerrar-modal" href="#">NO</a>
                </div>
            </aside>
        </div>

        <div id="modal-add-book" class="Modal-libro">
            <aside class="Modal-box-libro">
                <!-- <h2>¿Quieres dar de baja tu cuenta?</h2> -->
                <form action="validar.php" method="POST" enctype="multipart/form-data">
                    <label><p>Categoria del libro:</p></label>
                    <select name="mod-tipo-libro">
                        <option value="computacion">COMPUTACIÓN</option>
                        <option value="hardware">HARDWARE</option>
                        <option value="matematicas">MATEMÁTICAS</option>
                        <option value="fisica">FÍSICA</option>
                        <option value="otros">OTRA CATEGORÍA</option>
                    </select>
                    <label><p>Nombre:</p><input type="text" name="mod-nombre-libro" size="30%" autocomplete="off" required></label>
                    <!-- <label><p>Escriba una pequeña descripcion del libro</p></label> -->
                    <br>
                    <textarea name="mod-descripcion-libro" cols="40" rows="5" placeholder="Escriba una pequeña descripcion..." required style="color:#00548C"></textarea>
                    <br>
                    <label><input type="radio" name="mod-estado-libro" value="NUEVO" checked>Nuevo</label>
                    <label><input type="radio" name="mod-estado-libro" value="IMPECABLE">Impecable</label>
                    <label><input type="radio" name="mod-estado-libro" value="REGULAR">Regular</label>
                    <label><input type="radio" name="mod-estado-libro" value="MALTRATADO">Maltratado</label>
                    <br>
                    <label><p>Precio: </p><input type="number" name="mod-precio-libro" autocomplete="off" required pattern="[0-9]"></label>
                    <label><p>Portada del Libro </p></label>
                    <input type="file" name="mod-imagen-libro" required>
                    <input type="hidden" name="matricula" value="<?=$matricula?>">
                    <div>
                        <input type="submit" name="guardarL" value=" Guardar ">
                    </div>
                </form>
                <div>
                    <a class="cerrar-modal" href="#">Cerrar</a>
                </div>
            </aside>
        </div>

    </div>

    <script src="../js/script-mislibros.js"></script>
</body>
</html>