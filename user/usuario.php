<?php
    require_once '../conexion.php';
    session_start();
    $matricula = $_SESSION['matricula'];
    $link = Conectarse();
    $query = mysqli_query($link,"select matricula,nombre,telefono,carrera,correo,imagen from usuarios where matricula='$matricula';");
    $campo = mysqli_fetch_array($query);
    if($campo['carrera'] == 'LIC') $carrera = "Licenciatura en Ciencias de la Computación";
        else
            if($campo['carrera'] == 'ING') $carrera = "Ingeniería en Ciencias de la Computación";
                else
                    if($campo['carrera'] == 'ITI') $carrera = "Ingeniería en Tecnologías de la Información";

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
    <title>Mi Perfil</title>
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style-usuario.css">
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <img class="logo" src="../images/logo-FCC-2.png" alt="">
        <a class="btn-exit" href="salir.php">Salir</a>
    </div>

    <div class="body">
        <div class="box-menu">
            <div id="mostrar-nav"><span style='display:block;width:50%;text-align:center;background-color:red;border-radius:50%;float:right;color:white;'><?=$vendidos[0];?></span></div>
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

        <aside class="box-imagen">
            <a class="modal-imagen-foto" href="#modal-imagen">
                <div class="imagen-foto" style="background-image: url(../images/usuarios/<?=$campo['imagen']?>);"></div>
            </a>
            
            <div class="imagen-datos">
                <p class="nombre"><?=$campo['nombre'];?></p>
                <p><a class="facultad" target="_blank" href="https://www.cs.buap.mx/">Facultad de Ciencias de la Computación</a></p>
                <p><a class="carrera" target="_blank" href="https://secreacademica.cs.buap.mx/index.html"><?=$carrera;?></a></p>
            </div>
        </aside>
        
        <section class="box-datos">
            <div class="datos">
                <article class="d-matricula">
                    <div class="descripcion">
                        <span>Matricula</span>
                        <p><?=$campo['matricula'];?></p>
                    </div>
                </article>
                <article class="d-nombre">
                    <div class="descripcion">
                        <span>Nombre</span>
                        <p><?=$campo['nombre'];?></p>
                        <a class="modal-d-nombre" href="#modal-nombre">
                            <img class="editar" src="../images/icons/editar.svg">
                        </a>
                    </div>
                </article>
                <article class="d-correo">
                    <div class="descripcion">
                        <span>Correo</span>
                        <p><?=$campo['correo'];?></p>
                        <a class="modal-d-correo" href="#modal-correo">
                            <img class="editar" src="../images/icons/editar.svg">
                        </a>
                    </div>
                </article>
                <article class="d-carrera">
                    <div class="descripcion">
                        <span>Carrera</span>
                        <p><?=$carrera;?></p>
                        <!-- <img class="editar" src="../images/icons/editar.svg"> -->
                    </div>
                </article>
                <article class="d-telefono">
                    <div class="descripcion">
                        <span>Telefono</span>
                        <p><?=$campo['telefono'];?></p>
                        <a class="modal-d-telefono" href="#modal-telefono">
                            <img class="editar" src="../images/icons/editar.svg">
                        </a>
                    </div>
                </article>
            </div>
        </section>

        <!-- <a href="#modal">Modal con CSS</a> -->
        <div id="modal-imagen" class="Modal">
            <aside class="Modal-box">
                <h2>¿Quieres cambiar tu foto de perfil?</h2>
                <form action="validar.php" method="POST" enctype="multipart/form-data">
                    <label><p>Selecciona tu nueva imágen</p></label>
                    <input type="file" name="mod-imagen">
                    <input type="hidden" name="matricula" value="<?=$matricula?>">
                    <div>
                        <input type="submit" name="cambiarI" value=" Cambiar ">
                    </div>
                </form>
                <div>
                    <a class="cerrar-modal" href="#">Cerrar</a>
                </div>
            </aside>
        </div>
        <div id="modal-nombre" class="Modal">
            <aside class="Modal-box">
                <h2>¿Quieres modificar tu nombre?</h2>
                <form action="validar.php" method="POST" enctype="multipart/form-data">
                    <label><p>Escribe aqui</p></label>
                    <input type="text" name="mod-nombre" autocomplete="off" required pattern="[A-Za-z ]{2,100}">
                    <input type="hidden" name="matricula" value="<?=$matricula?>">
                    <div>
                        <input type="submit" name="cambiarN" value=" Cambiar ">
                    </div>
                </form>
                <div>
                    <a class="cerrar-modal" href="#">Cerrar</a>
                </div>
            </aside>
        </div>
        <div id="modal-correo" class="Modal">
            <aside class="Modal-box">
                <h2>¿Quieres cambiar tu correo?</h2>
                <form action="validar.php" method="POST" enctype="multipart/form-data">
                    <label><p>Escribe tu nuevo correo</p></label>
                    <input type="email" name="mod-correo" autocomplete="off">
                    <input type="hidden" name="matricula" value="<?=$matricula?>">
                    <div>
                        <input type="submit" name="cambiarC" value=" Cambiar ">
                    </div>
                </form>
                <div>
                    <a class="cerrar-modal" href="#">Cerrar</a>
                </div>
            </aside>
        </div>
        <div id="modal-telefono" class="Modal">
            <aside class="Modal-box">
                <h2>¿Quieres cambiar tu telefono?</h2>
                <form action="validar.php" method="POST" enctype="multipart/form-data">
                    <label><p>Escribe tu nuevo numero</p></label>
                    <input type="text" name="mod-telefono" autocomplete="off" maxlength="10" pattern="[0-9]{10,10}">
                    <input type="hidden" name="matricula" value="<?=$matricula?>">
                    <div>
                        <input type="submit" name="cambiarT" value=" Cambiar ">
                    </div>
                </form>
                <div>
                    <a class="cerrar-modal" href="#">Cerrar</a>
                </div>
            </aside>
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

    <div class="footer"></div>

    <script src="../js/script-usuario.js"></script>
</body>
</html>