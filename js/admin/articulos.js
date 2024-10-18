function mostrar(nro,texto){
            
    //asgino el texto al caption
    document.getElementById("caption" + nro).innerHTML = texto;
    // hago visible el modal
    document.getElementById("imgModal" + nro).style.display="block";

  };

  function ocultar(elemento){
    document.getElementById(elemento).style.display="none";
  }

  function modalEliminacion(idborrar){
    document.getElementById("id"+idborrar).style.display="block";
  }
