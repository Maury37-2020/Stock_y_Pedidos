function limpiaForm(){
    document.getElementById("cod_p_c").value = "";
    document.getElementById("cod_p_l").value = "";
    document.getElementById("ciudad").value = "";
}
/* 
function confirmarEnvio(mensaje) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerText = mensaje;
    snackbar.className = "show";
}

function eliminar(){
    var snackbar = document.getElementById("snackbar");
    snackbar.className = "";
}
 */
function showSnackbar(mensaje) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerText = mensaje;
    snackbar.className = "show";
    setTimeout(function() {
        snackbar.className = snackbar.className.replace("show", "");
    }, 3000);
}

function checkCampos(){
    let provincia = document.getElementById('prov');
    let ciudad = document.getElementById('ciudad');
    let codp = document.getElementById('cod_p_l');

    if(provincia.value.trim() === ""){
        showSnackbar("Completar Provincia");
        provincia.focus();
        return false;
    }else if(ciudad.value.trim() === ""){
        showSnackbar("Completar Ciudad");
        ciudad.focus();
        return false;
    }else if(codp.value.trim() === ""){
        showSnackbar("Completar Código Postal");
        codp.focus();
        return false;
    }else{
        return true;
    }
}

const prov = document.getElementById('prov')
const ciudad = document.getElementById('ciudad')
var datalist = document.getElementById('Provincia');
var hiddenInput = document.getElementById('provId');
document.getElementById('prov').addEventListener('blur', function() {
    var selectedOption = Array.from(datalist.options).find(option => option.value === prov.value);
    if (selectedOption) {
        hiddenInput.value = selectedOption.getAttribute('data-id'); // Asignar el ID al campo oculto
    } else {
        hiddenInput.value = '';
    };
    console.log(hiddenInput.value)
    if (prov.value){
        ciudad.removeAttribute('readonly')
    }
    else{
        showSnackbar("Completar Provincia");
        return false
    }
    console.log(ciudad)
});

let atras = document.getElementsByClassName('back')
atras[0].href = 'usuarioInicio.php'