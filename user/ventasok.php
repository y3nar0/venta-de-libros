<?php
    require_once '../conexion.php';
    session_start();
    $matricula = $_SESSION['matricula'];
    $link = Conectarse();

    $l = $_GET['a'];
    $o = $_GET['b'];

    if($o == 1)
        $query = mysqli_query($link,"update libros set baja=1 where id='$l' and propietario=(select id from usuarios where matricula='$matricula');");
    if($o == 2) {
        $query = mysqli_query($link,"update libros set vendido=0 where id='$l' and propietario=(select id from usuarios where matricula='$matricula');");
        $query = mysqli_query($link,"delete from compras where id_libro='$l';");
    }
    mysqli_close($link);
    header('Location:ventas.php');
?>
