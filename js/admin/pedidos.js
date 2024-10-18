function openPage(pageName,elmnt,color) {
    let i, tabcontent, tablinks;
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
    // Get the element with id="defaultOpen" and click on it
    var panelgral;
    var panelgral2;
    var panel;
    document.getElementById("defaultOpen").click();
    localStorage.setItem('activo', -1);
    localStorage.setItem('bandera', 1);
    let acc = document.getElementsByClassName("accordion");
    for (let i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            const activo_a = localStorage.getItem('activo');
            const bandera = localStorage.getItem('bandera');
            localStorage.setItem("activo2",i);
            if(activo_a!=i && bandera == 0){
                acc[activo_a].classList.toggle("active");
                moverpanel(acc[activo_a]);
            }
            if(activo_a == i){
                if (bandera == 1){
                    localStorage.setItem('bandera', 0)
                }else{
                localStorage.setItem('bandera', 1);
                }
            }else{
                localStorage.setItem('bandera', 0);
            }
            acc[i].classList.toggle("active");
            localStorage.setItem("activo", i)
            moverpanel(acc[i])
        });
    
        function moverpanel(param){
            panel = param.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } 
            else {
            panelgral=parseInt(panel.scrollHeight);
            panel.style.maxHeight = panel.scrollHeight + "px";
            }
        }
    }

    //Accordion
const acc2 = document.getElementsByClassName("accordion2");
const subi = localStorage.getItem('activo2');
console.log(subi)
for (i = 0; i < acc2.length; i++) {
    acc2[i].addEventListener("click", function() {
        this.classList.toggle("active");
        console.log(this)
        const flecha = this.querySelector('.arrow');
        const i_flecha = flecha.querySelector('img');
        const panel2 = this.nextElementSibling;
        if (panel2.style.maxHeight) {
            panel2.style.maxHeight = null;
            i_flecha.src ='../../assets/arrow_drop_down.svg'
        } 
        else {
            panelgral += parseInt(panel2.scrollHeight);
            panel2.style.maxHeight = panel2.scrollHeight + "px";
            const panelSup = this.parentNode.parentNode;
            panelSup.style.maxHeight = panelgral + "px"; 
            i_flecha.src = '../../assets/arrow_drop_up.svg'
        }
    }); 

const btn_a = document.getElementsByClassName('back')
btn_a[0].href = 'articulos.php'
}
function generar(){
    var subi = localStorage.getItem('activo2')
    const acc =  document.getElementsByClassName("accordion")
    const panel = acc[subi].nextElementSibling;
    const myInput = panel.querySelector("#cant-b");
    var cantr = myInput.value; 
    const table = panel.querySelector('dataTable');
    console.log(table)
    const tbody = panel.querySelector('tbody');
    var rowCount = tbody.rows.length;  
    var difrow = cantr - rowCount
    if (difrow > 0){
        let sub_i = rowCount
    // Agregar las nuevas filas
        for (let i = 0; i < difrow; i++) {
            const row = document.createElement('tr');
            for (let j = 0; j < 3; j++) {
                const cell = document.createElement('td');
                if(j== 0){
                    sub_i += 1
                    cell.innerHTML = '<select name="embalaje'+subi + sub_i+'" id="embalaje'+subi + sub_i+'" class="input input1">'+
                    '<option  value="0" disabled selected>Seleccionar tipo de bulto</option>'+
                    '<optgroup label="Caja">'+
                        '<option value="1">Caja Pequeña</option>'+
                        '<option value="2">Caja Mediana</option>'+
                        '<option value="3">Caja Grande</option>'+
                    '</optgroup>'+
                    "<optgroup label='Bolsa'>"+
                        "<option value='4'>Bolsa Pequeña</option>"+
                        "<option value='5'>Bolsa Mediana</option>"+
                        "<option value='6'>Bolsa Grande</option>"+
                    "<optgroup label='Otro'>"+
                        "<option value='7'>Otro</option>"+
                    "</optgroup>"+
                '</select>';
                }
                else if(j==1){
                    cell.innerHTML = '<input type="checkbox" id="especial'+subi + sub_i+'" name="especial'+subi + sub_i+'" value="especial">'
                }
                else{
                    cell.innerHTML = '<select name="peso'+subi + sub_i+'" id="peso'+subi + sub_i+'" class="input input1">'+
                    '<option  value="0" disabled selected>Seleccionar peso</option>'+
                    '<option value="1">5 KG</option>'+
                    '<option value="2">10 KG</option>'+
                    '<option value="3">15 KG</option>'+
                    '</select>';
                }
                row.appendChild(cell);
            }
            tbody.appendChild(row);
            
                
        }
    } else if(difrow < 0){
        difrow *= -1
        for(let i= 0; i<difrow; i++){
            rowCount =- 1
            tbody.deleteRow(rowCount)
        }
        
    }
    subi = localStorage.getItem('activo');
    panelgral=parseInt(panel.scrollHeight);
    panel.style.maxHeight = panel.scrollHeight + "px";
};

let tabs = document.tablinks
let botones = document.getElementsByClassName('btn')