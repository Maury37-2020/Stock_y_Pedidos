// Funcionalidad del slideshow
var slideIndex = 1;

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}
/* let div_p = document.querySelector('div.options__menu');
let ancla = document.createElement('a');
ancla.href='http://localhost/compostela/interfaz/usuario/usuarioInicio.php';
ancla.alt='selected'

let div = document.createElement('div');
div.className = 'option';

let icon = document.createElement('i');
icon.className = 'fi fi-sr-left';
icon.title = 'Atrás';

div.appendChild(icon);
ancla.appendChild(div);
div_p.appendChild(ancla); */

function mostrarModalImagenes(imagen1, imagen2){
    // Obtener el modal
    var modal = document.getElementById("imagenesModal");
    var img1 = document.getElementById("imgModal1");
    var img2 = document.getElementById("imgModal2");

    img1.src = '../../imagenes/productos/' + imagen1
    img2.src = '../../imagenes/productos/' + imagen2

    showSlides(slideIndex);
    modal.style.visibility = "visible";
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "block";
}

function mostrarModalCarrito(){
    var modal = document.getElementById("modalCarrito");
    modal.style.visibility = "visible";
}
function ocultarModalImagenes(){
    var modal = document.getElementById("imagenesModal");
    modal.style.visibility = "hidden";
}
function ocultarModalCarrito(){
    var modal = document.getElementById("modalCarrito");
    modal.style.visibility = "hidden";
}

function controlaLimiteStock(stockActual, idCantidad){
    console.log("stockActual" + stockActual)
    var cantidad = document.getElementById("cantidad"+idCantidad)
    console.log("pedido: " + cantidad.value)

    if(cantidad.value > stockActual){
        cantidad.style.backgroundColor = "#FFCCCC";
        cantidad.focus();
    }else{
        cantidad.style.backgroundColor = "white";
    }
}

function activarDesactivarBtn(event, stock, btnId, enCarrito){
    let valor = event.target.value;
    let btnPedir = document.getElementById(btnId);

    if (enCarrito) {
        btnPedir.disabled = true;
        return; 
    }

    if (valor == 0 ) {
        btnPedir.classList.remove('btn-pedido');
        btnPedir.classList.add('btn-disabled');
        btnPedir.disabled = true;
    } else if(valor > stock){
        btnPedir.classList.remove('btn-pedido');
        btnPedir.classList.add('btn-disabled');
        btnPedir.disabled = true;
        showSnackbar("La cantidad supera al stock")
    } else {
        btnPedir.classList.remove('btn-disabled');
        btnPedir.classList.add('btn-pedido');
        btnPedir.disabled = false;
    }
}

function activarDesactivarBtnContinuar(carrito){
    let btn = document.getElementById('btn-confirm_add');
    let link = document.getElementById('idRedireccionBtnContinuar');
    
    if(carrito == 0){
        btn.classList.remove('btn-continuar');
        btn.classList.add('btn-continuarDisabled');
        link.disabled = true;
        btn.disabled = true;

    }else{
        btn.classList.remove('btn-continuarDisabled');
        btn.classList.add('btn-continuar');
        link.disabled = false;
        btn.disabled = false;
    }
}

function snackbarBtnContinuar(carrito){
    if(carrito == 0){
        showSnackbar("Debes ingresar un articulo al carrito");
    }
}

function showSnackbar(mensaje) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerText = mensaje;
    snackbar.className = "show";
    setTimeout(function() { snackbar.className = snackbar.className.replace("show", ""); }, 3000);
}



document.addEventListener("DOMContentLoaded", function() {
    
    var span = document.getElementById("carrito");  

    // Obtener el valor numérico del span
    var valorNumerico = parseInt(span.textContent);

    // Verificar si el valor es mayor que cero y cambiar el color
    if (valorNumerico > 0) {
        span.classList.add("positivo"); // Agregar la clase "positive"
    }

    var spanCant = document.getElementById("cant-art"); 
    var cantidad = parseInt(spanCant.textContent); //Obtengo el valor de span de la col 3

    var myInput=document.getElementById("cantidad-1"); //Obtengo el input

});
const btn_a = document.getElementsByClassName('back')
btn_a[0].href = 'pedidoDestinatario.php'