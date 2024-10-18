let atras = document.getElementsByClassName('back')
atras[0].href = 'usuarioInicio.php'

var modal = document.getElementsByClassName('modal');

function cancelar(ventana){
    modal[ventana].style.visibility = "hidden";
}

function mostrarModalConfirmacion(idDestinatario){
    modal[0].style.visibility = "visible";
    console.log(idDestinatario);

    document.getElementById('id_destinatario').value = idDestinatario;
}

function mostrarModalEditar(id,nombre,dni,mail){
    modal[1].style.visibility = "visible";

    document.getElementById('destinatario_ID').value = id; // ID oculto
    document.getElementById('razon_soc').value = nombre; // Nombre o Razón Social
    document.getElementById('dniMod').value = dni; // DNI o CUIT
    document.getElementById('mailMod').value = mail; // Email*/
}

function mostrarModalEditarDirecciones(id,direccion,telefono,horaD,horaH){
    modal[1].style.visibility = "visible";

    document.getElementById('direccion_ID').value = id;
    document.getElementById('direccModal').value = direccion; // ID oculto
    document.getElementById('telefonoModal').value = telefono; // Nombre o Razón Social
    document.getElementById('horaDModal').value = horaD; // DNI o CUIT
    document.getElementById('horaHModal').value = horaH; // Email*/
}



function checkCampos(){
    let nombre = document.getElementById('nombre');
    let dni = document.getElementById('dni');
    let mail = document.getElementById('mail');

    if(nombre.value.trim() === ""){
        showSnackbar("Completar Nombre");
        nombre.focus()
      /*   nombre.style.border = 'none'
        bordeInvalido('nombre') */
        return false;
    }else if(dni.value.trim() === ""){
        showSnackbar("Completar DNI");
        dni.focus()
        return false;
    }else if(dni.value.length < 8){
        showSnackbar("Longitud de DNI incorrecto");
        dni.focus()
        return false;
    }else if(mail.value.trim() === ""){
        showSnackbar("Completar Email");
        mail.focus()    
        return false;
    }else{
        return true;
    }
}

function redireccionar(idDestinatario){
    window.location.href = "./destinatariosCiudades.php?id=" + idDestinatario;

}

function bordeInvalido(input){
    let nodo = document.getElementById(input)
    nodo.classList.add('invalido')
}

function showSnackbar(mensaje) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerText = mensaje;
    snackbar.className = "show";
    setTimeout(function() {
        snackbar.className = snackbar.className.replace("show", "");
    }, 3000);
}

const btn_a = document.getElementsByClassName('back')
btn_a[0].href = 'usuarioInicio.php'

function checkCampos2(){
    let provincia = document.getElementById('prov');
    let ciudad = document.getElementById('ciudad');
    let direccion = document.getElementById('direcc');
    let telefono = document.getElementById('tel');
    /* let te = document.getElementById('tel'); */
    if(provincia.value.trim() === ""){
        showSnackbar("Completar Provincia");
        provincia.focus();
        return false;
    }else if(ciudad.value.trim() === ""){
        showSnackbar("Completar Ciudad");
        ciudad.focus();
        return false;
    }else if(direccion.value.trim() === ""){
        showSnackbar("Completar Dirección");
        direccion.focus();  
        return false;
    }else if(telefono.value.trim() === ""){
        showSnackbar("Completar Telefono");  
        return false;
    }else{
        return true;
    }
}