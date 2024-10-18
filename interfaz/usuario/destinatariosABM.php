<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    <link rel="stylesheet" href="../../css/usuario/destinatariosAbm.css">
    <link rel="stylesheet" href="../../css/uicons-solid-rounded.css">
    <title>ABM Destinatarios</title>
</head>
<body class="body_p">
    <?php
        include 'barraNavegacion.php';
        include '../../helper/usuarioValidar.php';
        include '../../modelo/destinatario.php';

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $destinatario = new destinatario();
        $pagina = isset($_GET["pag"]) ? (int)$_GET["pag"] : 1;

        $cantidadPaginas = $destinatario->cantidadPaginas(null);
        $listDest = $destinatario->obtenerDestinatariosPaginados($pagina,null);
        
        if($_POST){

            if(isset($_POST['btnCargar'])){
                $destinatario->guardarDestinatario($_POST['nombre'],$_POST['dni'],$_POST['mail']);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            if (isset($_POST['btnEliminar'])) {

                $idDestinatario = $_POST['id_destinatario'];
            
                $destinatario->eliminarDestinatario($idDestinatario);
            
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }

        if(isset($_POST['btnMod'])){

            $idDest = $_POST['destinatario_ID'];
            $nombre = $_POST['razon_soc'];
            $dni = $_POST['dniMod'];
            $mail = $_POST['mailMod'];

            $destinatario->modificarDestinatario($idDest,$nombre,$dni,$mail);

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }

    ?>
    
    <header class="cabecera">
        <div class="usuario">
            <span><?php echo $_SESSION["usuario"]?></span>
        </div>
        <div class="seccion">
            <span>ABM Destinatarios</span>
        </div>
        <div class = "contiene-carrito"></div>  
    </header>
    <div class="contenedor">
        <form class="content_form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form">
            <fieldset class="field1">
            <legend>Nuevo Destinatario:</legend>
                <div class="parte1">                
                    <div class="col1_t">
                        <label for="nombre">Nombre o Razón Social:<span class="obliga">*</span></label>
                        <input class="campo-form" id="nombre" name="nombre" placeholder="Nombre">
                        <!-- <input type="hidden" id="dest_ID" name="provId">
                        <datalist id="Destinatarios">
                            <option data-id=1 value="Pedrito">
                        </datalist> -->
                    </div>
                    <div class="col2_t">
                        <label for="dni">DNI / CUIT:<span class="obliga">*</span></label>
                        <input class="campo-form" id="dni" type="text" name= "dni" placeholder="DNI - CUIT" size="10" />
                    </div>
                    <div class="col3_t">
                        <label for="mail">Email:<span class="obliga">*</span></label>
                        <input class="campo-form" id="mail" type="email" name="mail" 
                                                placeholder="nombre@dominio" 
                                                size="20"
                                                pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
                                                            title="Por favor, ingrese un correo electrónico válido"/>
                    </div>
                    <div class="col4_t">
                        <button class="btn btn_graba" id="graba" type="submit" name = "btnCargar"
                                                    onclick="return checkCampos()" 
                                                    title="Agregar">
                                                    <i class="fi fi-rr-user-add"></i></button>
                        <button class="btn" title="Buscar"><i class="fi fi-br-search"></i></button>
                    </div>
                </div>
            </fieldset>
            <section class="parte2">
            <fieldset class="field2">
                <legend>Destinatarios:</legend>
                <table>
                    <tr>
                        <th class=" col_t_1">Nombre o Razón Social</th>
                        <th class=" col_t_2">DNI / Cuit</th>
                        <th class=" col_t_3" colspan="2">E-Mail</th>
                    </tr>
                    <tr>
                    <?php
                    foreach($listDest as $dest){
                    ?>
                        <tr>
                        <td class="col1"><?php echo $dest['razon_social'];?></td>
                        <td class="col2"><?php echo $dest['dni'];?></td>
                        <td  class="col3"><?php echo $dest['mail'];?></td>
                        <td  class="col4">
                            <button class="btn" title="Direcciones" type="button" 
                                            onclick="redireccionar(<?php echo $dest['id'] ?>)">
                                            <i class="fi fi-rr-house-chimney-user"></i>
                            </button>
                            <button class="btn" title="Editar Destinatario" type='button' 
                                            onclick="mostrarModalEditar(<?php echo $dest['id']; ?>, '<?php echo $dest['razon_social']; ?>',
                                             '<?php echo $dest['dni']; ?>', '<?php echo $dest['mail']; ?>')">
                                            <i class="fi fi-rr-user-pen"></i></button>
                            <button class="btn btn_borra" title="Eliminar Destinatario" type='button' 
                                            onclick="mostrarModalConfirmacion(<?php echo $dest['id']; ?>)">
                                            <i class="fi fi-rr-delete-user"></i></button>
                        </td>
                    </tr>
                    <?php }?>
                </table>
            </fieldset>      
            </div>
            <div class="pagination">
                <a href="destinatariosAbm.php?pag=1">&laquo;</a>
                <?php 
                    for($i=1; $i <= $cantidadPaginas; $i++) {
                ?>
                    <a <?php 
                            echo ($i == $pagina) ? "class='active'" : ""; ?> 
                         href="destinatariosAbm.php?pag=<?php echo $i ?>"><?php echo $i ?></a>
                <?php   
                    }
                ?>
                <a href="destinatariosAbm.php?pag=<?php echo $cantidadPaginas ?>">&raquo;</a>
            </div>
        <p class="obliga">* Los campos son Obligatorios</p>
        </form>
    </div>
     <div class="modal" id="modalEliminar">
        <span class="close" title="Close Modal" onclick="cerrarModal(0)">×</span>
            <div class="modal-content">
                <div class="container">
                <img src="../../assets/alerta.svg" alt="Alerta"> 
                <h1>ATENCIÓN</h1>
                <p>¿Está seguro que desea eliminar el Destinatario?</p>
                <form id="formEliminar" method="POST">
                    <input type="hidden" name="id_destinatario" id="id_destinatario">
                    <div class="clearfix">
                        <button type="button" class="btn" onclick="cancelar(0)">Cancelar</button>
                        <button type="submit" class="btn btn_elim" name="btnEliminar">Borrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="modalForm">
        <!-- <span class="close" title="Close Modal">×</span> -->
        <div class="modal-content">
    <form class="content_form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="container">
            <h3>Editar Destinatario</h3><br>
            <label for="nombre">Nombre o Razón Social:</label>
            
            <input class="campo-form" id="razon_soc" name="razon_soc" placeholder="Escriba para buscar...">
           
            <input type="hidden" id="destinatario_ID" name="destinatario_ID">
            
            <datalist id="Destinatarios">
                <option data-id="1" value="Pedrito">
            </datalist>

            <label for="dni">DNI / CUIT:</label>
                <input class="campo-form" id="dniMod" type="text" name="dniMod" placeholder="DNI - CUIT" size="10"/>
            <label for="mail">Email:</label>
                <input class="campo-form" id="mailMod" type="email" name="mailMod" placeholder="nombre@dominio"
                   size="20" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
                   title="Por favor, ingrese un correo electrónico válido"/>

            <div class="contiene_boton">
                <button type="button" class="btn" onclick="cancelar(1)">Cancelar</button>
                <button type="submit" class="btn btn_graba" name="btnMod">Grabar</button>
            </div>
        </div>
    </form>
</div>

    </div>
    <div id="snackbar">
        <button id="confirm" class="btn btn_graba" type="button" onclick="eliminar()">Aceptar</button>
        <button id="volver" class="btn btn_borra" type="button" onclick="ocultar()">Cancelar</button>
    </div>
    <script src="../../js/usuario/destinatariosABM.js"></script>    
</body>
</html>