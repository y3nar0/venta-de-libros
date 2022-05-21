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
    <title>Mis Libros</title>
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style-mislibros.css">
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500;600;700;800;900&display=swap" rel="stylesheet">
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

        <div class="bg">
            <section class="box-books">
                <?php
                    $query = mysqli_query($link,"select * from libros where vendido=0 and baja=0 and propietario = (select id from usuarios where matricula = '$matricula') order by tipo");
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
                                        <article class='article' value='$id_libro'>
                                            <div class='article-bg'>
                                                <div class='article-tipo'><p>$tipo</p></div>
                                                <div class='article-libro'>
                                                    <div class='article-imagen' style='background-image:url(../images/libros/$imagen);'></div>
                                                    <div class='article-nombre' style='text-transform:uppercase;'><p>$nombre</p></div>
                                                    <div class='article-descripcion'><p>$descripcion</p></div>
                                                    <div class='article-estado'>$estado</div>
                                                    <div class='article-costo'><p>$$costo</p></div>
                                                    <a class='article-editar' href='#modal-edit-book'>EDITAR</a>
                                                    <a class='article-borrar' href='#modal-del-book'>BORRAR</a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>";
                        }

                    } else {
                        echo "NO TIENES LIBROS EN VENTA";
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

<!-- FALTA EDITAR EL LIBRO -->
        <div id="modal-edit-book" class="Modal-libro">
            <aside class="Modal-box-libro">
                <!-- <h2>¿Quieres dar de baja tu cuenta?</h2> -->
                <form action="validar2.php" method="POST" enctype="multipart/form-data">
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
                    <input id="oculto-e" type="hidden" name="id-libro" value="0">
                    <div>
                        <input type="submit" name="editarL" value=" Editar ">
                    </div>
                </form>
                <div>
                    <a class="cerrar-modal" href="#">Cerrar</a>
                </div>
            </aside>
        </div>

        <div id="modal-del-book" class="Modal">
            <aside class="Modal-box">
                <h2>¿Quieres eliminar el libro?</h2>
                <form action="validar2.php" method="POST" enctype="multipart/form-data">
                    <!-- <label><p>Escribe tu nueva contraseña</p></label> -->
                    <!-- <input type="password" name="mod-password-1"> -->
                    <!-- <label><p>Escribe tu nueva contraseña</p></label> -->
                    <!-- <input type="password" name="mod-password-2"> -->
                    <input type="hidden" name="matricula" value="<?=$matricula?>">
                    <input id="oculto-b" type="hidden" name="id-libro" value="0">
                    <div>
                        <input type="submit" name="delL" value=" SI ">
                    </div>
                </form>
                <div>
                    <a class="cerrar-modal" href="#">NO</a>
                </div>
            </aside>
        </div>

    </div>

    <script src="../js/script-mislibros.js"></script>
</body>
</html>