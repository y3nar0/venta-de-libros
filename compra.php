<?php
    $id_libro = $_GET['a'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TERMINA TU COMPRA</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style-compra.css">
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <a href="index.php"><img class="logo" src="images/logo-FCC-2.png" alt="Logo"></a>
        <a class="btn-signup" href="signup.php">Registrarse</a>
        <a class="btn-sesion-start" href="login.php">Iniciar sesión</a>
    </div>

    <div class="class-body">
        <div class="box-signup">
            <h1>FINALIZA TU COMPRA</h1>
            <h2>Enviaremos tus datos al usuario para que te pueda contactar</h2>
        
            <form action="comprado.php" method="POST">
                <div class="data-signup">
                    <div class="box-form-text-label">
                        <input class="form-text" type="text" name="usermat-buy" id="usermat-buy" autocomplete="off" required maxlength="9" pattern="[0-9]{9,9}">
                        <label class="form-label" for="usermat-buy">Ingresa tu matrícula</label>
                    </div>
                    <div class="box-form-text-label">
                        <input class="form-text" type="text" name="tel-buy" id="tel-buy" autocomplete="off" required maxlength="10" pattern="[0-9]{10,10}">
                        <label class="form-label" for="tel-buy">Ingresa tu telefono</label>
                    </div>
                    <div class="box-form-text-label">
                        <input class="form-text" type="email" name="useremail-buy" id="useremail-buy" autocomplete="off" required>
                        <label class="form-label" for="useremail-buy">Ingresa tu correo</label>
                    </div>
                    <div class="box-form-text-label">
                        <label class="form-text-2">Selecciona tu carrera</label>
                        <select class="form-text" name="carrera-buy" id="carrera">
                            <option class="form-label" value="LIC">Lic. en Cs. de la Computación</option>
                            <option class="form-label" value="ING">Ing. en Cs. de la Computación</option>
                            <option class="form-label" value="ITI">Ing. en Tecnologías de la Inf.</option>
                        </select>
                    </div>
                    <div class="box-form-text-label">
                        <label class="lugar-buy-label" for="lugar-buy">Lugar de entrega acordado</label>
                        <input class="form-text" type="text" name="lugar-buy" id="lugar-buy" autocomplete="off" required>
                    </div>
                </div>

                <!-- <div class="g-recaptcha" data-sitekey="6LfFQvgUAAAAAAijmvLjHa_SE3Gw8TLn6GykWHhO"></div> -->
                
                <div class="btns-buy">
                    <input type="hidden" name="id-libro" value="<?=$id_libro?>">
                    <input class="btn-buy" type="submit" name="comprar-buy" value="Comprar">
                </div>
            </form>
        </div>
    </div>
</body>
</html>