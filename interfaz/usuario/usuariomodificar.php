<!DOCTYPE html>
  <html>
    <head>
      <title>Administrador - compostela</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
      <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
      <style>
        body {
          font-family: "Segoe UI", sans-serif;
          font-size:100%;
        }

        .menu {
          background:#333;
          width:100%;
          height: 100%;
          left: 10px;
        }

        .sidebar {
          position: fixed;
          top: -10px;
          bottom: 10px;
          left: 0px ;
          z-index: 1;
        }

        .sidebar ul, .sidebar li {
          margin:0;
          padding:0;
          margin-left: 10px ;
          list-style:none inside;
        }

        .sidebar ul {
          margin: 4rem auto;
          display: block;
          width: 80%;
          min-width:120px;
        }

        .sidebar a {
          display: block;
          font-size: 120%;
          color: #fff;
          text-decoration: none;
        }

        .sidebar a:hover{
          color:#fff;
          background-color: #f90;
          border-radius: 5px;
          padding-left: 5px;
        }

        .sidebar .menusel{
          color:#fff;
          background-color: #f90;
          border-radius: 5px;
          padding-left: 5px;
        }

        input[type=text], input[type=file], input[type=number]{
          width:99%;
          padding: 12px 20px;
          margin: 8px 8px;
          display:inline-block;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
        }

        /* Style the submit button */
        input[type=submit] {
          width: 99%;
          background-color: #f90;
          color: white;
          padding: 14px 20px;
          margin: 8px 8px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }

        /* Fondo modal: negro con opacidad al 50% */
        .modal {
            display: none; /* Por defecto, estará oculto */
            position: fixed; /* Posición fija */
            z-index: 1; /* Se situará por encima de otros elementos de la página*/
            padding-top: 200px; /* El contenido estará situado a 200px de la parte superior */
            left: 0;
            top: 0;
            width: 100%; /* Ancho completo */
            height: 100%; /* Algura completa */
            overflow: auto; /* Se activará el scroll si es necesario */
            background-color: rgba(0,0,0,0.5); /* Color negro con opacidad del 50% */
          }

          .contenido-modal {
            position: relative; /* Relativo con respecto al contenedor -modal- */
            background-color: white;
            margin: auto; /* Centrada */
            padding: 20px;
            width: 60%;
            -webkit-animation-name: animarsuperior;
            -webkit-animation-duration: 0.5s;
            animation-name: animarsuperior;
            animation-duration: 0.5s;
          }
          /* Add Animation */
          @keyframes animatetop {
            from {top:-300px; opacity:0} 
            to {top:0; opacity:1}
          }
          @keyframes animarsuperior {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
          }
      </style>
    </head>
    <body>
      <!-- Ventana modal, por defecto no visiblel -->
      <div id="modalactualizarusuario" class="modal">
        <div class="contenido-modal">
          <p>Se actualizo el usuario.</p>
        </div>
      </div>
      <?php
        include '../../modelo/usuario.php';
        include '../../helper/usuarioValidar.php';
        include '../../modelo/clases.php';

        $usuario = new usuario();
        $actualizacion=false;
        
        if($_POST){

          $usuario->setID($_POST['idactualizar']);
          $usuario->setNombre($_POST['nombre']);
          $usuario->setMail($_POST['mail']);
          $usuario->setPassword($_POST["password"]);
          $usuario->setRol($_POST['opcion_seleccionada']);

          $usuario->modificarUsuario();

          $actualizacion=true;
        }

        if($_GET){
          $usuario->setID($_GET['id']);
        }

        $dataUsuario = mysqli_fetch_array($usuario->seleccionarUsuario());

      ?>
      <div class='Container'>
        <div class='row'>
          <div class="col-12">
            <header class="d-flex flex-wrap py-3 mb-5 border-bottom">
              <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <div class="container">
                  <a class="navbar-brand" href="#"><?php echo $_SESSION["usuario"] ?></a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                      aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../../login.php">Cerrar</a>                    
                      </li>
                    </ul>
                  </div>
                </div>
              </nav>
            </header>
          </div>
        </div>
      
        <div class="row">
          <div class="col-1">
            <div id="sidebar" class="sidebar">
              <ul class="menu">
                <li><a href="pedidos.php?tipo=prep">Pedidos</a></li>
                <li><a href="articulos.php">Articulos</a></li>
                <li><a class="menusel" href="usuarios.php">Usuarios</a></li>
                <li><a href="reportes.php">Reportes</a></li>
                <li><a href="#">Transporte</a></li>
              </ul>
            </div>
          </div>
          <div class="col-11">
            <div class='Container'>
              <h1>Modificar usuario</h1>
              <div class="row">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" 
                      enctype="multipart/form-data">
                  <input type="hidden" name='idactualizar' value='<?php echo $dataUsuario['id']; ?>'>
                  <label for="nombre">Nombre:</label>
                  <input type="text" id="nombre" name="nombre" placeholder="Sin nombre" 
                      value='<?php echo $dataUsuario['nombre'];?>'>
                  <label for="mail">Mail:</label>
                  <input type="text" id="mail" name="mail" placeholder="Sin mail" 
                      value='<?php echo $dataUsuario['email'];?>'>
                  <label for="password">Password:</label>
                  <input type="text" id="password" name="password" placeholder="Sin password" 
                      value='<?php echo $dataUsuario['password'];?>'>
                  <label for="rol">Rol:</label>
                  <input type="hidden" id="opcion_seleccionada" name="opcion_seleccionada"  
                      value='<?php echo $dataUsuario['rol'];?>'>
                  <select class="form-select" id='rol' name='rol'>
                    <option value="cliente" <?php if($dataUsuario['rol']=='cliente'){echo 'selected';} ?>>Cliente</option>
                    <option value="admin" <?php if($dataUsuario['rol']=='admin'){echo 'selected';} ?>>Administrador</option>
                  </select>
                  <input type="submit" id="cargar" name="modificar" value="modificar">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        // Obtener referencia al select y al input hidden
        const select = document.getElementById('rol');
        const inputHidden = document.getElementById('opcion_seleccionada');

        // Agregar un event listener para el evento 'change' del select
        select.addEventListener('change', function() {
            // Obtener el valor seleccionado del select
            const selectedValue = select.value;

            // Asignar el valor seleccionado del select al input hidden
            inputHidden.value = selectedValue;

        });
    </script>
      <script language="javascript">
        <?php
          if($actualizacion){
            echo "let mimodal = document.getElementById('modalactualizarusuario');" ;
            echo "mimodal.style.display='block';" ;
            echo "setTimeout(function() {" ;
            echo "let mimodal = document.getElementById('modalactualizarusuario');" ;
            echo "mimodal.style.display='none';" ;
            echo "}, 2000); ";
          }
        ?>  
        const atras = document.querySelector('.back')
        atras.href = "usuarioInicio.php"
      </script>
        </script>
    </body>
</html> 
