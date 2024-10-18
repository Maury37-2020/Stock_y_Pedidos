# Registro de cambios (Changelog)

## [Unreleased]

### Added
- Se ha agregado la funcionalidad de autenticación de usuarios.
- Se ha implementado un nuevo sistema de notificaciones por correo electrónico.

### Changed
- Se ha actualizado la interfaz de usuario para mejorar la usabilidad.  

### Deleted
- Se borraron archivos del proyecto.

## [1.0.0] - 2024-02-15

### Added
- Se ha lanzado la versión 1.0.0 del proyecto.
- Se han añadido funcionalidades básicas para visualizacion de productos y stock en el FrontOffice.
- Se han agregado las funcionalidades basicas para la carga y mantenimiento de stock en el BackOffice. 


## Cambios en la interfaz de admin al actualizar articulos - 23/02/2024 (maxi)

### Changed
- Se realizaron cambios en los siguientes archivos. 
    /interfaz/admin/articulomodificar.php
    /interfaz/admin/articulomodificar.css

- Se agrego combo box para tipo de modificacion de stock

## Actualizacion de articulos - 23/02/2024 (diego)

## Changed
- Modificacion de la descripcion del articulo en la bbdd:
    /interfaz/admin/articulomodificar.php

## Actualizacion de articulos - 24/02/2024 (diego)
- Modificacion de la imagen del articulo en el file system y la bbdd:
    /interfaz/admin/articulomodificar.php
    /interfaz/admin/articulonuevo.php
    /modelo/articulo.php

## Modificacion de articulos - 25/02/2024 (diego)
- Actualizacion del nombre del css porque no se reconocia el css en el hosting
    /css/admin/articulomodificar.css

## Scaffolding inicial - 08/03/2024 (diego)
- Limpieza del proyecto anterior y creacion de un scaffoling inicial para 
para continuar con el desarrollo del sistema.

## Changed cambios en los nombres de los archivos y organizacion de carpetas- 12/03/2024 (maxi)
- Se aplico camelcase y se puso mismo nombre a archivos php relacionados con css y js.
- Se creo dentro de las carpetas de php,js,css una carpeta interna para separar admin y usuario

## Changed cmabios en nombre de archivos y orgainzacion de carpetas - 13/03/2004 (diego)
- se actualizaron los siguiente archivos/carpetas:
    deleted:    css/cambiar_contrasenia.css
    deleted:    css/usuario/cambiarPass.css
    modified:   helper/cambiarContrasenia.php
    modified:   interfaz/admin/articulos.php
    deleted:    interfaz/usuario/cambiarPass.php
    deleted:    js/articulosAdmin.js
    modified:   interfaz/usuario/barraNavegacion.php
    css/passwordCambiar.css
    css/usuario/passwordCambiar.css
    interfaz/usuario/passwordCambiar.php
    js/admin/

## Changed se realizaron cambios en la barra de navegacion - 21/03/2024 (Maxi).
- Se realizo cambio en la barra de navegacion. 
    css/usuario/barraNavegacion.css
- Se agrego btn de historial y se modificaron los siguentes archivos:
    interfaz/admin/articulos.php
    css/admin/articulos.css
    
### Added
- Se agregaron los siguientes archivos del lado del usuario:
    interfaz/usaurio/articulosDetalles.php
    css/usuario/articulosDetalles.css
    js/usuario/articulosDetalles.js
    ------------------------------
- Se agregaron los siguentes archivos del lado del admin:
    interfaz/admin/articuloHistorial.php
    css/admin/articuloHistorial.css

## Se actualizaron archivos para mostrar movimientos de stock y algunos ajuste
## de nombres- 23/03/2023 (diego)
## Changed 
-   css/admin/articuloHistorial.css
-   css/usuario/usuarioInicio.css
-   helper/usuarioValidar.php
-   interfaz/admin/articuloHistorial.php
-   interfaz/admin/articulomodificar.php
-   interfaz/admin/articulonuevo.php
-   interfaz/admin/articulos.php
-   interfaz/admin/usuariomodificar.php
-   interfaz/admin/usuarionuevo.php
-   interfaz/admin/usuarios.php
-   interfaz/usuario/articulos.php
-   interfaz/usuario/articulosDetalles.php
-   interfaz/usuario/barraNavegacion.php
-   interfaz/usuario/passwordCambiar.php
-   interfaz/usuario/passwordCambiar.php
-   interfaz/usuario/usuarioInicio.php
-   interfaz/usuario/usuariomodificar.php
-   interfaz/usuario/usuarionuevo.php
-   modelo/articulo.php
-   modelo/movimientosDescripcion.php
-   modelo/movimientosStock.php

## Fix de login por bug al ingreso como cliente 28/03/2024 (diego)
## changed
- login.php

## Fix de localizacion de fondo y ajuste consulta de descripcion de movimientos
## generar el registro de stock inicial cuando se crear el producto nuevo.
## 29/03/2024 (diego)
## changed
- css/usuario/usuarioInicio.css
- modelo/movimientosDescripcion.php
- interfaz/admin/articulonuevo.php
- modelo/articulo.php

## Fix mostrar el valor entero en el stock de los articulos 01/04/2024 (diego)
## changed
- interfaz/admin/articulos.php
- interfaz/usuario/articulos.php

## Se actualizó la página barraNavegación para añadirle un campo con el título de la sección actual en la que se encuentra el usuario y otro para que muestre el usuario. 13/04/2024 (Mauri)
## changed
- interfaz/usuario/barraNavegacion.php
- interfaz/usuario/barraNavegacion.css

## Se agregó la nueva sección de destinatario de envío. 26/04/2024 (Mauri)
## Added
- interfaz/usuario/destinatarioPedido.php
- interfaz/usuario/destinatarioPedido.css
- interfaz/usuario/destinatarioPedido.js

## Modificamos estructura de la página articulos.php  
## Added
- css/usuario/articulos.css
## changed
- interfaz/usuario/articulos.php

## Se crearon los 2 modales para el carrito y el detalle de los artículos y se agregó una barra de progreso al final, también se realizó control de cantidad para que no permita pedir más que el stock y además se va a pintar en rojo aquel stock que se encuentre por debajo del mínimo. 26/04/2024 (Mauri)
## Changed
    - css/usuario/articulos.css
    - interfaz/usuario/articulos.php

## Se creó la sección final de pedidos 30/04/2024 (Mauri)
- css/usuario/datosFinalesPedidos.css
- interfaz/usuario/datosFinalesPedidos.php

## Final pantalla 1 wizard carga de pedido 22/05/24 (diego)
# modificados:
    - interfaz/usuario/articulos.php
    - js/usuario/articulos.js
    - modelo/conexion.php
    - css/usuario/articulos.css
    - interfaz/usuario/articulos.php
    - modelo/articulo.php
    - interfaz/usuario/barraNavegacion.php
# borrados:
    - imagenes/productos/img1 - copia.webp
# nuevos:
    - modelo/carrito.php
    - modelo/destinatario.php

## Merging nivelatorio con el repositorio 07/06/2024 (Mauri)
# Modificados:
    - css/usuario/destinatarioPedidos.css
    - css/usuario/datosFinalesPedidos.css
    - interfaz/usuario/barraNavegacion.php

# Nuevos:
    -/interfaz/admin/pedidos.php
    -/css/admin/pedidos.css
    -/interfaz/admin/abmdestinatarios.php
    -/css/admin/abmdestinatarios.css

## Añadida la opción para elegir transporte en Pedidos  (Mauri)
# Modificados:
    -/interfaz/admin/pedidos.php
    -/css/admin/pedidos.css

## Creación interfaz para ABM Transportes 27/06/24 (Mauri)
## Nuevos:
    -/interfaz/admin/abmTransportes.php
    -/css/admin/abmTransportes.css
    -/js/admin/abmTransportes.js

## Modificación estética en barra de navegación. 27/06/24 (Mauri) - Se agregó enlace a css externo para botón atrás y se corrigió un defecto por el cual no se veía correctamente el color. Se agregó clase "back" a dicho botón para luego recuperarlo en el js de cada pag. y configurar la página a la cual debe ir. Se agregaron 2 nuevos campos a mostrar en el apartado "proceso" de pedidos en Admin para que se muestre el codp y la localidad
# Modificados:
    - /interfaz/admin/barranavegacion.php
    - /interfaz/admin/pedidos.php
    - /js/admin/pedidos.js
    - /interfaz/usuario/barranavegacion.php

# Final pantalla de carga de destinatarios y datos finales 22/06/24 (diego)
# modifiados:   
    - css/login.css
    - css/usuario/articulos.css
    - css/usuario/datosFinalesPedido.css
    - css/usuario/destinatarioPedido.css
    - default.php
    - interfaz/usuario/articulos.php
    - interfaz/usuario/articulosDetalles.php
    - interfaz/usuario/datosFinalesPedido.php
    - interfaz/usuario/destinatarioPedido.php
    - js/usuario/destinatarioPedido.js
    - modelo/carrito.php
    - modelo/conexion.php
    - modelo/destinatario.php
# nuevos:
    - js/usuario/datosFinalesPedido.js

# Final del proceso de creacion de pedido y mover los articulos de carrito a pedidos 23/06/2024 (diego)
# modificados:
    - css/usuario/datosFinalesPedido.css
    - interfaz/usuario/datosFinalesPedido.php
    - modelo/carrito.php
# nuevos:
    - css/usuario/pedidoProcesar.css
    - interfaz/usuario/pedidoProcesar.php
        
## Merging nivelatorio con el repositorio 28/06/2024 (Mauri)

## Cambios en modificacion de usuarios 30/06/2024 (Maxi)

# Modificado: 
    - interfaz/admin/usuariomodificar.php

# Nuevo:
    - css/admin/usuariomodificar.css

## Cambios en funcionalidad de botones 06/07/2024 (Maxi)
    
# Modificado:
    - interfaz/usuarios/articulos.php
    - js/usuario/articulos.js

## Cambios en funcinalidad en boton continuar 07/07/2024 (Maxi)

# Modificado:
    - interfaz/usuarios/articulos.php
    - js/usuario/articulos.js
    - css/usuario/articulos.css

## Modificacion visual y compartamientos de boton en datosFinalesPedidos 08/07/2024 (Maxi)

# Modificado:
    - intefaz/usaruio/datosFinalesPedidos.php
    - js/usuario/datosFinalesPedido.js
    - css/usuario/datosFinalesPedido.css

    ## Modificacion en comportamiento de boton al para avanzar en wizard 08/07/2024 (Maxi)

# Modificado:
    - intefaz/usaruio/destianatrioPedido.php
    - js/usuario/destianatrioPedido.js
    - css/usuario/destianatrioPedido.css


## Modificacion al finalizar pedido 12/07/2024 (Maxi)

# Modificado:
    -   interfaz/usuario/pedidoProcesar.php
    -   css/usuario/pedidoProcesar.css

## Se agregó el menú lateral para pedidos y el wizard, se recuperó la vieja página de artículos como articulosdetalles, se renombró el ABM Transportes y se realizaron correcciones varias 12/07/2024 (Mauri)
# Modificado:
    - interfaz/usuarios/transportesABM.php
    - js/usuario/transportesABM.js
    - css/usuario/transportesABM.css
    - interfaz/usuarios/barraNavegacion.php
    - js/usuario/menu.js
    - css/usuario/barraNavegacion.css
# Agregado
    - interfaz/usuarios/articulosDetalles.php
    - js/usuario/articulosDetalles.js
    - css/usuario/articulosDetalles.


## Se agrego historial de pedidos y se inicio el funcionamiento del proceso en pedidos admin.

# Modificado: 
    - interfaz/admin/pedido.php
    - interfaz/usuario/barraNavegacion.php
    - interfaz/usuario/datosPedido.php

# Nuevo:
    - interfaz/usuario/misPedidos.php
    - modelo/pedido.php
    - css/usuario/misPedidos.css

## Se modificaron los nombres de datosPedidos por pedidoDatos.php, y destinatarioPedido por pedidoDestinatario.php y se corrigió tanto el menú como como pedidoDatos.php para que redireccionen correctamente
# Modificado: 
    - interfaz/usuario/barraNavegacion.php
    - interfaz/usuario/pedidoDatos.php
    - interfaz/usuario/pedidoDestinatario.php


## Solucion de problemas encontrados en test

# Modificado:
    - interfaz/usuario/articulos.php
    - interfaz/usaurio/pedidoDestinatario.php

## Corregidos los "backpage" del wizzard y la flecha en la barra de menú - 22/7/24 (Mauri)
# Modificado:
    - js/usuario/articulos.js
    - js/usuario/datosFinalesPedidos.js
    - js/usuario/destinatarioPedido.js
    - interfaz/usuario/pedidoProcesar.php
    - css/barraNavegacion.css

## Correcciones varias en el wizzard, se quitó CSS repetido y se unificó en un único css que luego se importa según se requira. Se agregó el required a los campos obligatorios del modal para agregar destinatario. Se acomodó también la barra de progreso para que quede siempre al fondo de la página. - 23/07/2024 (Mauri)
# Modificado:
    - interfaz/usuario/articulos.php
    - interfaz/usuario/barraNavegacion.php
    - interfaz/usuario/destinatariosABM.php
    - interfaz/usuario/pedidoDatos.php
    - interfaz/usuario/pedidoDestinatario.php
    - interfaz/usuario/pedidoProcesar.php
    - interfaz/usuario/pedidosHistorial.php
    - css/barraNavegacion.css
    - css/usuario/articulos.css
    - css/usuario/datosFinalesPedido.css
    - css/usuario/destinatarioPedido.css
    - js/usuario/destinatarioPedido.js
# Nuevo:
    - css/genericos.css

## Correcciones menores - 24/07/2024 (Mauri)
# Modificado:
    - interfaz/usuario/articulosDetalles.php
    - interfaz/usuario/pedidoDatos.php
    - interfaz/usuario/pedidoProcesar.php
    - css/barraNavegacion.css
    - css/usuario/articulos.css
    - css/usuario/destinatarioPedido.css
    - css/genericos.css
    - js/menu.js


## Cambios para mantener datos en wizard 25/07/2024 (Maxi)

# Modificado
   - /interfaz/usuario/pedidosDatos.php
   - /interfaz/usuario/pedidosDestinatario.php
   - /interfaz/usuario/pedidoProcesar.php
   - /interfaz/usuario/pedidosHistorial.php
   - /modelo/carrito.php
   - /modelo/pedido.php

## Correcciones varias en la rama Usuario, actualización titles - 29/07/2024 (Mauri)

# Modificadas todas pantallas:
    - js/menu.js (eliminado)
# Nuevo:
    - js/usuario/menu.js
    - js/admin/menu.js

## Correcciones en las vistas de Pedidos del Administrador y corrección en nombres de usuarioModificar y usuarioNuevo 31/07/2024 (Mauricio)

# Modificado:
- /interfaz/admin/pedidos.php
- /interfaz/usuarioNuevo.php
- /interfaz/usuarioMdificar.php
- /css/admin/pedidos.css
- /js/admin/pedidos.js

# Agregado ícono pdf en assets

<<< Deploy en test (31/07/2024) >>>

## Agregando funcionalidades al wizar de admin y creacion de carpeta BBDD ----- Modificacion para mantener fecha en wizard USUARIO. 04/08/2024 (MAXI)
# IMPORTANTE! EJECUTAR SCRIPT EN BBDD. SCRIPT : 04-08-2024.sql

# Modificado ADMIN: 
    - interfaz/admin/Pedidos.php
    - modelo/pedido.php
    - js/admin/pedidos.js

# ADD:
    - modelo/bultos.php
    - BBDD/27-07-2024.sql
    - BDD/04-08-2024

# Modificado USUARIO:
    - modelo/carrito.php
    - interfaz/usuario/pedidoDatos.php

## Coreccion de duplicidad de carga cunado se actualiza la pagina. 05/08/2024 (Maxi)

# Modificado: 
    - interfaz/usuario/articulos.php

## Cambios en wizard admin. Se agrego backend para mostrar nombre de ciudad 05/08/2024 (Maxi)

# Modificado:
    - modelo/pedido.php
    - interfaz/admin/Pedidos.php

## Merging con los cambios de Maxi y cambios realizados en el ABM Destinatarios 08/08/2024 (Mauri)
    
# Modificado:
    - interfaz/usuario/destinatariosABM.php
    - css/usuario/abmdestinatarios.css
    - js/usuario/destinatariosABM.js

## Cambios en wizard destinatarios. Mantener el dato del destinatario y la direccion cargada
## en el carrito cuando se sale y vuelve a ingresar al carrito - 10/08/2024 (Diego) 

# Modificado:
    - interfaz/usuario/articulos.php
    - interfaz/usuario/pedidoDatos.php
    - interfaz/usuario/pedidoDestinatario.php
    - modelo/destinatario.php

<<< Deploy en test (11/08/2024) >>>

## Corrección fallo en los accordiones de los pedidos en Admin y se agregó una flechita al accordion2 para indicar que es un desplegable. También se cambió el color del Accorion 2 para que se diferencie un poco del resto. Se corrigieron las columnas en la tercer pestaña. Se realizó el merging con los cambios que se subieron a testing. Mauricio (11/08/2024) 

# Modificado:
    - css/admin/Pedidos.css
    - js/admin/Pedidos.js


## Cambios varios en wizard admin y wizard usr. 13/08/2024 (Maxi)
# IMPORTANTE! EJECUTAR SCRIPT EN BBDD. SCRIPT : 13-08-2024.sql

# Backend - Al cargar un destinatario salta un error de razon (Undefined array key "razon" in /h) No lo carga
# BackEnd - agregar horarios de visitas

# Se agrega librearia FPDF. Faltan detalles sobre el manejo de los pdf pero se sube una primera parte.

# Modificado:
 - interfaz/admin/Pedidos.php
 - interfaz/usuarios/pedidosDestinatarios.php
 - js/admin/pedidos.js
 - modelo/destinatario.php
 - modelo/pedido.php


# Nuevo:
- 13-08-2024.sql
- fpdf186 (carpeta de la libreria)


## Cambio de nombre en ABM destinatarios y transporte, actualización links en barra lateral por falla en testing.
## FrontEnd - Agregar marca que indique que un articulo ya esta en el carrito
## FrontEnd - Dehabilitar el campo donde se carga la cantidad de un articulo cuando un articulo esta en el carrito

# Modificado:
    - css/admin/articulos.css
    - js/admin/articulos.js
    - interfaz/usuario/articulos.php
    - interfaz/usuario/destinatariosAbm.php
    - interfaz/usuario/barraNavegacion.php
    - interfaz/admin/transportesAbm.php
    - interfaz/admin/barraNavegacion.php


## Cambios en carga de destinatarios para controlar la carga de razon social y dni en blanco 13/08/2024 (Maxi).

# Tareas trello
- FrontEnd - Controlar que el DNI no este vacio
- BackEnd - Controlar que que DNI no este vacio.

# Modificado:
  - interfaz/usuario/pedidoDestinatario.php
  - modelo/destinatario.php

## Agregados campos Mail, Ciudad y Horario de visita al ABM Destinatarios. Se renombró el css correspondiente. 20/08/2024 (Mauricio)

# Modificado:
    - interfaz/usuario/destinatariosAbm.php
    - css/usuario/destinatariosAbm.css

## Modificacion en estrucutra de la BBDD y modficiacion de querys afectadas por este cambio / Generar pdf (ADMIN). 21/08/2024 (Maxi).

# IMPORTANTE: EJECUTAR SCRIPT 21-08-2024.sql

# Tareas trello: 
  - BBDD - Tablas
  - BBDD - Realaciones
  - BBDD - Restricciones
  - Modelo - crear entitdad ciudades
  - Imprimir PDF pedidos para armar
  - Pestania en proceso faltan caracteristicas de embalaje
  - Mostrar datos en pestanña enviado
  - Ajustar el modelo para mail ciudad y hora de visita
  - Agregar horarios de visitas
  
# Modificado 
  - interfaz/usuario/destinatariosAbm.php
  - interfaz/usuario/pedidoDestinatarios.php
  - modelo/destinatarios.php
  - modelo/pedido.php

# Nuevo
  - 21-08-2024.sql
  - modelo/localidad.php  


 ## Backend - Agregar campania en el historial de pedidos 21/08/2024 (Maxi) 

 # Modificado
  - interfaz/usuario/pedidosHistorial.php
  - modelo/pedido.php

## Backend - No trae las direcciones del destinatarios cuando lo selecciono 23/08/2024 (Maxi)
# Se agrego LEFT a querys.
# Modificado:
 - modelo/destinatario.php
 - modelo/pedido.php

 <<< Deploy en test (25/08/2024) >>>

 ## FrontEnd - Agregado favicon en todas las páginas, cambios en ABM Destinatarios (a revisar con Maxi) y merging 26/08/24 (Mauricio)

# Modificado:
 - interfaz/usuario/destinatariosAbm.php
 - css/usuario/destinatariosAbm.css

## FrontEnd - Creación ABM Ciudades y modificación de nombres de los archivos JS y CSS de pedidoDatos.php. Modificación del ABM Destinatarios 28/08/24 (Mauricio)

# Modificado:
    - interfaz/usuario/pedidoDatos.php
    - css/usuario/pedidoDatos.css
    - js/usuario/pedidoDatos.js
    - interfaz/usuario/destinatariosAbm.php
    - css/usuario/destinatariosAbm.css
    - js/usuario/destinatariosABM.js

# Creado:
    - interfaz/usuario/ciudadesAbm.php
    - css/usuario/ciudadesAbm.css
    - js/usuario/ciudadesAbm.js

## FrontEnd - Modificación ABM Destinatarios, añadido snackbar a articulosDetalles.php, añadido acceso al abmCiudadaes en barra de Navegación. 06/09/2024 (Mauri)
# Modificado:
    - interfaz/usuario/destinatariosAbm.php
    - css/usuario/destinatariosAbm.css
    - interfaz/usuario/barraNavegacion.php
    - css/barraNavegacion.css
    - css/genericos.css

## Backend - Paginacion en historial de pedidos 29/08/2024 (maxi)

# Modificado 
  - css/usuarios/misPedidos.css (NO TIENE EL MISMO NOMBRE QUE EL ARCHIVOS PHP (pedidosHistorial.php))
  - interfaz/usuario/pedidosHistorial.php
  - modelo/pedido.php

## FrontEnd - Agregada paginación al ABM Destinatarios. 06/09/2024 (Mauri)

# Modificado:
    - interfaz/usuario/destinatariosAbm.php
    - css/genericos.css

## FrontEnd - Agregado modal para modificar datos de un destinatario y mensaje de confirmación para eliminar uno. En ambos casos está fallando (se abre y se cierra inmediatamente) pero no encuentro la falla.

# Modificado:
    - interfaz/usuario/destinatariosAbm.php
    - js/usuario/destinatariosABM.js
    - css/usuario/destinatariosAbm.css
    - css/genericos.css
# Agregado
    - assets/alerta.svg

## FrontEnd - finalizados los ABM de destinatarios y direcciones (vista para relacionar destinatarios con ciudades)
# Modificado:
    - interfaz/usuario/destinatariosAbm.php
    - js/usuario/destinatariosABM.js
    - css/usuario/destinatariosAbm.css
    - css/genericos.css
# Agregado
    - interfaz/usuario/destinatariosCiudades.php
    - css/usuario/destinatariosCiudades.css

## FrontEnd - Modificado pedidos.php, se agregó paginación y botoón ver más para la primer y tercer pestañas.
# Modificado:
    - interfaz/admin/pedidos.php

## BackEnd - Código soporte para relación entre ciudades y destinatarios (13/09/2024) MAXI
# Nuevo:
    - intefaz/admin/destinatariosAbm (SE VOLVIO A AGREGAR YA QUE NO SE ENCONTRABA EN GIT).

# Modificado:
    - modelo/destinatario.php
    - modelo/localidad.php
    - js/usuario/destintarioABM.js
    - interfaz/usuario/destinatariosCiudades.php
    - interfaz/usuario/ciudadesAbm
    - .gitignore (SE QUITO DE GITIGNORE intefaz/usuario/destintarioAbm.php).

## BackEnd - Código soporte para relación entre ciudades y destinatarios (14/09/2024) MAXI

# Modificado:
    - interfaz/usuario/destinatarioCiudades.php
    - js/usuario/destinatariosABM.js
    - modelo/desinatario.php


## BackEnd - Funcionalidad para cargar direcciones desde modal (15/09/2024) MAXI

# Modificado:
    - interfaz/usuario/pedidoDestinatario.php

## BackEnd - Paginacion en pedidos (ADMIN) (15/09/2024) MAXI

# Modificado:
    - modelo/pedido.php
    - interfaz/admin/pedidos.php
    -css/admin/pedidos.css


## BackEnd - Error en icon PDF y redireccion de login (ADMIN) (15/09/2024) MAXI

# Modificado:
    - login.php
    - fpdf186/generarPdf.php

<<< Deploy en test (15/09/2024) >>>
# FrontEnd - Solución problema Modal 15/09/24 (Mauri)
# Modificado:
    - css/genericos.css
    - css/usuario/destinatarioPedido.css
    - css/usuario/destinatariosAbm.css
    - css/usuario/destinatariosCiudades.css
    - interfaz/usuario/pedidoDestinatario.php
    - interfaz/usuario/destinatariosAbm.php
    - interfaz/usuario/destinatariosCiudades.php
    - interfaz/admin/pedidos.php
    - js/usuario/destinatarioPedido.js
    - js/usuario/destinatariosABM.js

FrontEnd - Solución problema con campo Ciudad que estaba como solo lectura y cambios en el JS para que si no se ingresó nada en un campo obligatorio, se posicione el foco sobre el mismo. Pulido de código en ABM destinatarios y pequeña corrección en pedidos.js 16/09/2024 (Mauri)

# Modificado:
    - css/usuario/ciudadesAbm.css
    - interfaz/usuario/ciudadesAbm.php
    - interfaz/usuario/destinatariosAbm.php
    - js/usuario/ciudadesAbm.js
    - js/usuario/destinatariosABM.js
    - js/admin/pedidos.js

# Agregar:
    - assets/arrow_drop_down.svg
    - assets/arrow_drop_up.svg
    - assets/comprobacion-del-carrito-de-la-compra.svg

FrontEnd - agregado segundo botón en pedidos finalizados y actualización de estilos 16/09/24 (Mauri)

# Modificado:
    - Interfaz/admin/pedidos.css
    - css/admin/pedidos.css
    - css/genericos.css


## BackEnd - Modificacion para generar pdf y funcionalidad caratulas (16/09/2024) MAXI

# Modificado: 
    - fpdf186/generarPdf.php
    - interfaz/admin/pedidos.php
    - modelo/pedido.php

# Nuevo: 
    - fpdf186/logoSSalud.jpg
    - interfaz/admin/pdfs.php    

## FrontEnd - Correccion snackbar en carga de direcciones (17/09/2024) MAXI

# Modificado : 
    - interfaz/usuario/destinatariosCiudades.php
    - js/usuario/destinatariosABM.js