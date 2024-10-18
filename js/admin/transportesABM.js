function openPage(pageName,elmnt,color) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
    }
    document.getElementById(pageName).style.display = "block";
    elmnt.style.backgroundColor = color;
}

document.getElementById("defaultOpen").click();

function generar(pagina){
    const reng = document.createElement('div');
        reng.classList.add('renglon');
    /* cantidad de renglones */
    const reng_n = document.getElementsByClassName('cod_p');
    const cantr_n = reng_n.length;
    const padre = document.getElementsByClassName('destinos');
    /* ----------------Inicio Select */ 
    const select = document.createElement('select')
        select.classList.add('campo-form');
        select.id = 'localidad'+ cantr_n;
        select.name = 'localidad'+ cantr_n;
    const localidad = document.createElement('option');
        localidad.value = 1;
    localidad.innerText = 'Sunchales'
select.appendChild(localidad)
const localidad2 = document.createElement('option');
    localidad2.value = 2
    localidad2.innerText = 'Tacural'
select.appendChild(localidad2)
/* -----------------------fin select */
const btn_a_n = document.createElement('button');
    btn_a_n.classList.add('btn');
    btn_a_n.classList.add('add');
    btn_a_n.id = 'add'+ pagina
    btn_a_n.type = "button";
    btn_a_n.addEventListener('click', function(){generar(pagina)});
    btn_a_n.innerText = "+";
const nuevo_r = document.createElement('input');
    nuevo_r.classList.add('campo-form');
    nuevo_r.classList.add('cod_p');
    nuevo_r.id = "n_cp_" + cantr_n;
    nuevo_r.name = "n_cp_" + cantr_n;
reng.appendChild(nuevo_r);
reng.appendChild(select);
if(pagina == 1){
    const btn_a = document.querySelector('#add1');
        btn_a.remove();
    const btn_e = document.getElementsByClassName('btn_elim');
    let cant_b_e = btn_e.length;
    const btn_e_n = document.createElement('button');
    btn_e_n.classList.add('btn');
    btn_e_n.classList.add('btn_elim');
    btn_e_n.id = 'btn_e_' + cant_b_e;
    btn_e_n.type = "button";
    btn_e_n.innerText = "X";
    reng.appendChild(btn_e_n);
} 
else{
    const btn_a = document.querySelector('#add0');
        btn_a.remove();
}
reng.appendChild(btn_a_n);
padre[pagina].appendChild(reng);
}

/* function generar2(){
        const b_e = document.getElementsByClassName('btn_elim');
        let cant_b_e = b_e.length;
        const reng = document.createElement('div');
            reng.classList.add('renglon');
        const reng_n = document.getElementsByClassName('cod_p');
        const cantr_n = reng_n.length;
        const btn_e = document.querySelector('.add');
            btn_e.remove();
        const padre = document.getElementsByClassName('destinos');
        const select = document.createElement('select')
            select.classList.add('campo-form');
            select.id = 'localidad'+ cantr_n;
            select.name = 'localidad'+ cantr_n;
        const localidad = document.createElement('option');
            localidad.value = 1;
        localidad.innerText = 'Sunchales'
    select.appendChild(localidad)
    const localidad2 = document.createElement('option');
        localidad2.value = 2
        localidad2.innerText = 'Tacural'
    select.appendChild(localidad2)
    const btn_e_n = document.createElement('button');
        btn_e_n.classList.add('btn');
        btn_e_n.classList.add('btn_elim');
        btn_e_n.id = 'btn_e_' + cant_b_e;
        btn_e_n.type = "button";
        btn_e_n.innerText = "X";
    const btn_a_n = document.createElement('button');
        btn_a_n.classList.add('btn');
        btn_a_n.classList.add('add');
        btn_a_n.type = "button";
        btn_a_n.addEventListener('click', generar2);
        btn_a_n.innerText = "+";
    const nuevo_r = document.createElement('input');
        nuevo_r.classList.add('campo-form');
        nuevo_r.classList.add('cod_p');
        nuevo_r.id = "n_cp_" + cantr_n;
        nuevo_r.name = "n_cp_" + cantr_n;
    reng.appendChild(nuevo_r);
    reng.appendChild(select);
    reng.appendChild(btn_e_n);
    reng.appendChild(btn_a_n);
    padre[1].appendChild(reng);
};
 */
