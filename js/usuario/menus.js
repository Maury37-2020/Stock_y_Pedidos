
/* document.addEventListener('DOMContentLoaded', function() { */
    const subm = document.querySelector('.subm');
    const menuArticulos = document.getElementById('menu-articulos');
    if(subm){
        subm.addEventListener('click', function(event) {
            event.preventDefault(); // Evitar el comportamiento por defecto del enlace
            menuArticulos.classList.toggle('mostrar');
        });
    };
/* }); */

/* document.getElementById("btn_open").addEventListener("click",open_close_menu) */

var side_menu = document.getElementById("menu_side");
var btn_open = document.getElementById("btn_open");
var body = document.getElementById("body");

//Evento

function open_close_menu(){
    body.classList.toggle("body_move");
    side_menu.classList.toggle("menu__side_move");
}

const clase = document.getElementsByClassName('mostrar')
const menu = document.getElementById('menu-articulos');
const abuelo = document.querySelector('.subm');
const padre = abuelo.children[0];
const hijo = padre.children[0];
window.onclick = function(event) {
    if (event.target != hijo) {
        if(clase.length>0){
            menu.classList.toggle('mostrar')
        }
    } 
};

document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input[required]');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (input.checkValidity()) {
                    input.classList.remove('invalido');
                    input.classList.add('valido');
                } else {
                    input.classList.remove('valido');
                    input.classList.add('invalido');
                }
            });

            input.addEventListener('blur', function() {
                if (!input.checkValidity()) {
                    input.classList.add('invalido');
                } else {
                    input.classList.remove('invalido');
                    input.classList.add('valid');
                }
            });
        });
});
