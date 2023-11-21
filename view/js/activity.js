function init(){
    const fechasys = new Date();
    const año = fechasys.getFullYear();
    const mes = (fechasys.getMonth() + 1).toString().padStart(2, '0');
    const dia = fechasys.getDate().toString().padStart(2, '0');
    const horasys = fechasys.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    if(document.querySelector('#tblbodylista')){
        Listar();
    }
    if(document.querySelector('#formulario')){
        let formulario = document.querySelector("#formulario");
        document.getElementById('fechafin').disabled = true;
        document.getElementById('fechainicio').disabled = true;
        document.getElementById('hora').disabled = true;
        document.getElementById('descripcion').disabled = true;
        document.getElementById('motivo').disabled = true;
        document.getElementById('fechafin').value = `${año}-${mes}-${dia}`;
        document.getElementById('fechainicio').value = `${año}-${mes}-${dia}`;
        document.getElementById('hora').value = horasys;
        HabilitarInputs();
        formulario.onsubmit = function(e){
            e.preventDefault();
            let radioButtons = document.querySelectorAll(".input-radio");
            let fechainicio = document.querySelector("#fechainicio").value;
            let fechafin = document.querySelector("#fechafin").value;
            let hora = document.querySelector("#hora").value;
            let motivo = document.querySelector("#motivo").value;
            let tipoactividad;
            radioButtons.forEach(function(radioButton) {
                if (radioButton.checked) {
                    tipoactividad = radioButton.value;
                }
            });
        
            if(tipoactividad == 1){
                if(fechainicio == "" || hora == "" || motivo == "" || fechafin == ""){
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Ooh no!',
                        text: 'Los campos con (*) son obligatorios'
                    })
                    return;
                }
            }
            else if(tipoactividad == 2){
                if(fechainicio == "" || hora == "" || motivo == ""){
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Ooh no!',
                        text: 'Los campos con (*) son obligatorios'
                    })
                    return;
                }
            }
            else{
                if(document.querySelector("#id").value == null || document.querySelector("#id").value == ""){
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Ooh no!',
                        text: 'Debe seleccionar un tipo de actividad'
                    })
                    return;
                }
            }
            
            GuardaryEditar();
        }
    }
    if(document.querySelector('#form_search')){
        let inputsearch = document.querySelector("#search_input");
        inputsearch.addEventListener("keyup",InputSearch,true);
        let datesearch = document.querySelector("#search_date");
        datesearch.addEventListener("change",InputSearch,true);
    }
}
async function Listar(){
    document.querySelector("#tblbodylista").innerHTML = "";
    try {
        let resp = await fetch("../controller/activitycontroller.php?op=listar");
        json = await resp.json();
        if(json.status){
            let data = json.data;
            var i = 0;
            data.forEach((item) =>{
                i++;
                
                let newtr = document.createElement("tr");
                newtr.id = "row_"+item.Id_Actividad;
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="Fecha" class="rcab">${FormatDate(item.Hora_Actividad,item.Fecha_Actividad)}</td>
                                    <td data-label="Hora de ingreso">${FormatHora(item.Hora_Actividad,item.Fecha_Actividad)}</td>
                                    <td data-label="Motivo" class="rcab">${item.Mot_Actividad}</td>
                                    <td data-label="Descripción" class="rcab">${item.Desc_Actividad}</td>
                                    <td data-label="Acciones">
                                        <div class="data-action">
                                            ${item.options}
                                        </div>
                                    </td>`;
                document.querySelector("#tblbodylista").appendChild(newtr);
            });
        }
        console.log(json);
    } catch (error) {
        console.log(error)
    }
}
async function GuardaryEditar(){
    try {
        const data = new FormData(formulario);
        let resp = await fetch ('../controller/activitycontroller.php?op=guardaryeditar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if(json.status){        
            window.location.href = 'activity.php?exito=1&msg='+encodeURIComponent(json.msg)+'&rute=mactivity';
            formulario.reset();
        }
        else{
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: json.msg
            })
        }
        
    } catch (error) {
        console.log(error);
    }
}

async function Mostrar(id){
    const formData = new FormData();
    formData.append('idactividad',id)
    try {
        let resp = await fetch ('../controller/activitycontroller.php?op=mostrar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            document.querySelector("#id").value = json.data.Id_Actividad;
            document.querySelector("#periodica").disabled = true;
            document.querySelector("#programada").disabled = true;
            document.querySelector("#fechainicio").value = json.data.Fecha_Actividad;
            document.querySelector("#fechainicio").disabled = false;
            document.querySelector("#fechafin").disabled = true;
            document.querySelector("#hora").disabled = false;
            document.querySelector("#hora").value = json.data.Hora_Actividad;
            document.querySelector("#motivo").value = json.data.Mot_Actividad;
            document.querySelector("#motivo").disabled = false;
            document.querySelector("#motivo").nextElementSibling.classList.add('fijar');
            document.querySelector("#descripcion").value = json.data.Desc_Actividad;
            document.querySelector("#descripcion").disabled = false;
            document.querySelector("#descripcion").nextElementSibling.classList.add('fijar');
        }
    } catch (error) {
        console.log(error);
    }
}
async function Eliminar(id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El registro sera eliminado definitivamente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            ConfigDelete(id)
        }
    })
}
async function ConfigDelete(id){
    let formData = new FormData();
    formData.append('idactividad',id);
    try {
        let resp = await fetch ('../controller/activitycontroller.php?op=eliminar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            Swal.fire(
                "¡Exito!",
                json.msg,
                "success"
            )
            Listar();
        }
        else{
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: json.msg
            })
        }   
    } catch (error) {
        console.log(error)
    }  
}
async function Buscar(){
    let search = document.querySelector("#search_input").value;
    let date = document.querySelector("#search_date").value;
    if(search == "" && date ==""){
        Listar()
    }
    else{
        document.querySelector("#tblbodylista").innerHTML = "";
        const formData = new FormData();
        formData.append('datotexto',search)
        formData.append('datofecha',date)
        try {
            let resp = await fetch ('../controller/activitycontroller.php?op=buscar',{
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                let data = json.data;
                var i = 0;
                data.forEach((item)=>{
                    i++;
                    let newtr = document.createElement("tr");
                    newtr.id = "row_"+item.Id_Actividad;
                    newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="Fecha" class="rcab">${FormatDate(item.Hora_Actividad,item.Fecha_Actividad)}</td>
                                    <td data-label="Hora de ingreso">${FormatHora(item.Hora_Actividad,item.Fecha_Actividad)}</td>
                                    <td data-label="Motivo" class="rcab">${item.Mot_Actividad}</td>
                                    <td data-label="Descripción" class="rcab">${item.Desc_Actividad}</td>
                                    <td data-label="Acciones">
                                        <div class="data-action">
                                            <a href="activityform.php?id=${item.Id_Actividad}&rute=auser" class="fa-solid fa-tags" title="Modificar"> </a>
                                            <a class="fa-solid fa-trash-can" onclick="Eliminar(${item.Id_Actividad})" title="Eliminar"></a>
                                        </div>
                                    </td>`;
                    document.querySelector("#tblbodylista").appendChild(newtr);
                });
            }
        } catch (error) {
            console.log(error);
        }
    }
}
async function InputSearch(){
    let search = document.querySelector("#search_input").value;
    let date = document.querySelector("#search_date").value;
    if(search == "" && date == ""){
        Listar();
    }
    else{
        Buscar();
    }
}
function QuitarFiltro(){
    document.querySelector("#search_input").value = "";
    document.querySelector("#search_input").nextElementSibling.classList.remove('fijar');
    date = document.querySelector("#search_date").value = "";
    Listar();
}
function HabilitarInputs(){
    var radio = document.querySelectorAll('.input-radio');
    radio.forEach(function (radioButton) {
        radioButton.addEventListener("change", function () {
            if (radioButton.checked) {
                if (radioButton.value === '1') {
                    document.getElementById('fechafin').disabled = false;
                    document.getElementById('fechainicio').disabled = false;
                    document.getElementById('hora').disabled = false;
                    document.getElementById('descripcion').disabled = false;
                    document.getElementById('motivo').disabled = false;
                    document.getElementById('fechafin').nextElementSibling.textContent += ' *';
                } else if (radioButton.value === '2') {
                    document.getElementById('fechafin').disabled = true;
                    document.getElementById('fechainicio').disabled = false;
                    document.getElementById('hora').disabled = false;
                    document.getElementById('descripcion').disabled = false;
                    document.getElementById('motivo').disabled = false;
                    document.getElementById('fechafin').nextElementSibling.textContent = document.getElementById('fechafin').nextElementSibling.textContent.replace(' *', '');
                }
            }
            else{
            }
        });
    });
}
function FormatDate(time,date){
    const  fechaHoraISO = `${date}T${time}`;
    const options ={
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        timeZone: 'America/Lima'
    }
    return new Date(fechaHoraISO).toLocaleString('es-ES', options).replace(/\//g, '-');
}
function FormatHora(time,date){
    const  fechaHoraISO = `${date}T${time}`;
    const options = {
        hour: '2-digit',
        minute: '2-digit',
        timeZone: 'America/Lima',
        hour12: true
    }
    return new Date(fechaHoraISO).toLocaleString('es-ES', options);
}

init();