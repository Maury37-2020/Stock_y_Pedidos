function showSnackbar(mensaje) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerText = mensaje;
    snackbar.className = "show";
    setTimeout(function() {
        snackbar.className = snackbar.className.replace("show", "");
    }, 3000);
}

function checkCampos(){
  let btn = document.getElementById('btn-enviar');
  let campania = document.getElementById('campania').value;
  let fecha = document.getElementById('fechaL').value;
  let radioButons = document.getElementsByName('prioridad');
  let radioSelected = false;

  for(let i = 0; i < radioButons.length; i++){
    if(radioButons[i].checked){
      radioSelected = true;
      break;
    }
  }

  if(!radioSelected){
    showSnackbar("Seleccionar prioridad");
    return false;
  }else if(fecha.trim() === ""){
    showSnackbar("Seleccionar fecha");
    return false;
  }else if(campania.trim() === ""){
    showSnackbar("Seleccionar campaña");
    return false;
  }else{
      return true;
  }
}

let atras = document.getElementsByClassName('back')
atras[0].href = 'usuarioinicio.php'