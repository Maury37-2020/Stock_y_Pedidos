var slideIndex = 1;

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function mostrarModalImagenes(imagen1, imagen2){
    // Obtener el modal
    var modal = document.getElementById("imagenesModal");
    var img1 = document.getElementById("imgModal1");
    var img2 = document.getElementById("imgModal2");

    img1.src = '../../imagenes/productos/' + imagen1
    img2.src = '../../imagenes/productos/' + imagen2

    modal.style.display = "block";
}
function ocultarModalImagenes(){
    var modal = document.getElementById("imagenesModal");
    modal.style.display = "none";
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

const atras = document.querySelector('.back')
atras.href = "usuarioInicio.php"
