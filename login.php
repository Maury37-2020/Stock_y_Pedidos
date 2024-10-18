<?php
    session_start();
    include("modelo/usuario.php");

    $error = false;

    if($_POST){

        $usuario = new Usuario(0,'',$_POST['mail'],$_POST['password'],'');
        
        if(!$usuario->existeUsuario()){
            $error = true;
        } else {
            $_SESSION["id"] = $usuario->getID();
            $_SESSION["usuario"] = $usuario->getNombre();
            if ($usuario->getRol() == "cliente"){
                header("Location: interfaz/usuario/usuarioInicio.php");
            } else {
                header("Location: interfaz/admin/pedidos.php");
            }      
        }
    }  
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/login.css">
        <link rel="icon" type="image/x-icon" href="assets/logo.jpg">
        <script src="https://kit.fontawesome.com/7568cd4100.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <div>
                <form class="custom-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <label class="label">Email <i class="fa-solid fa-envelope"></i></label>
                    <input class="form-control" type="text" name="mail" size="30"><br>
                    <label class="label">Password <i class="fa-solid fa-lock"></i></label>
                    <input class="form-control" type="password" name="password" size="30"><br>
                    <button class="submit" type="submit">Ingresar</button>
                </form>
                <?php
                    if($error){
                ?>
                    <div class="error">
                        Usuario o Contraseña incorrecto
                    </div>
                <?php        
                    }
                ?>
            </div>
        </div>    
    </body>
</html>