function init(){
    
    if(document.querySelector('#tblbodylista')){
        Listar();
    }
    if(document.querySelector('#formulario')){
        ListarAulas();
        SelectImage();
        let formulario = document.querySelector("#formulario");
        formulario.onsubmit = function(e){
            e.preventDefault();
            let codigo = document.querySelector("#codigo").value;
            let nombre = document.querySelector("#nombre").value;
            let apaterno = document.querySelector("#apaterno").value;
            let amaterno = document.querySelector("#amaterno").value;
            let fechanacimiento = document.querySelector("#fechanacimiento").value;
            let idestado = document.querySelector("#idestado").value;
            let sexo = document.querySelector("#sexo").value;
            let idaula = document.querySelector("#idaula").value;
            if(codigo == "" || nombre == "" || apaterno == "" ||amaterno == "" || fechanacimiento == "" || idestado == 0 || sexo == "" || idaula == 0){
                Swal.fire({
                    icon: 'warning',
                    title: '¡Ooh no!',
                    text: 'Los campos con (*) son obligatorios'
                })
                return;
            }
            GuardaryEditar();
        }
    }
    if(document.querySelector('#form_search')){
        let inputsearch = document.querySelector("#search_input");
        inputsearch.addEventListener("keyup",InputSearch,true)
    }
}
async function Listar(){
    
    document.querySelector("#tblbodylista").innerHTML = "";
    try {
        let resp = await fetch("../controller/studentcontroller.php?op=listar");
        json = await resp.json();
        if(json.status){
            let data = json.data;
            var i = 0;
            let estadoamtricula = "";
            data.forEach((item) =>{
                i++;
                let newtr = document.createElement("tr");
                newtr.id = "row_"+item.Id_Alumno;
                if(item.Est_Matricula == 1){
                    estadoamtricula = "DEFINITIVA";
                }
                else if(item.Est_Matricula == 2){
                    estadoamtricula = "TRASLADADO";
                }
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="Documento" class="rcab">${item.Doc_Alumno}</td>
                                    <td data-label="Código">${item.Cod_Alumno}</td>
                                    <td data-label="Nombre">${item.Nom_Alumno} ${item.Apa_Alumno} ${item.Ama_Alumno}</td>
                                    <td data-label="Fecha Nacimiento" >${FormatDate(item.Fecha_Nacimiento)}</td>
                                    <td data-label="Estado Matricula" >${estadoamtricula}</td>
                                    <td data-label="Aula" >${item.Grado_Aula} - ${item.Seccion_Aula}</td>
                                    <td data-label="Acciones">
                                        <div class="data-action">
                                            ${item.options}
                                        </div>
                                    </td>`;
                document.querySelector("#tblbodylista").appendChild(newtr);
            });
        }
    } catch (error) {
        console.log(error)
    }
}
async function ListarAulas(){
    document.querySelector("#idaula").innerHTML = "";
    try {
        let resp = await fetch("../controller/studentcontroller.php?op=listarselectaula");
        json = await resp.json();
        if(json.status){
            let data = json.data;
            let initialOption = document.createElement("option");
            initialOption.value = ""; 
            initialOption.disabled = true;
            initialOption.selected = true;
            document.querySelector("#idaula").appendChild(initialOption);
            data.forEach((item) =>{
                let newop = document.createElement("option");
                newop.value = item.Id_Aula;
                newop.innerHTML = `${item.Grado_Aula} - ${item.Seccion_Aula}`;
                document.querySelector("#idaula").appendChild(newop);
            });
        }
    } catch (error) {
        console.log(error);
    }
}
async function GuardaryEditar(){
    try {
        const data = new FormData(formulario);
        let resp = await fetch ('../controller/studentcontroller.php?op=guardaryeditar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if(json.status){
            window.location.href = 'student.php?exito=1&msg='+encodeURIComponent(json.msg)+'&rute=mstudent';
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
        console.log(error)
    }
}
async function Mostrar(id){
    const formData = new FormData();
    formData.append('idalumno',id)
    try {
        let resp = await fetch ('../controller/studentcontroller.php?op=mostrar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            document.querySelector("#id").value = json.data.Id_Alumno;
            document.querySelector("#idtipodocumeto").value = json.data.Tipo_Documento;
            document.querySelector("#idtipodocumeto").nextElementSibling.classList.add('fijar');
            document.querySelector("#documento").value = json.data.Doc_Alumno;
            document.querySelector("#documento").nextElementSibling.classList.add('fijar');
            document.querySelector("#codigo").value = json.data.Cod_Alumno;
            document.querySelector("#codigo").nextElementSibling.classList.add('fijar');
            document.querySelector("#nombre").value = json.data.Nom_Alumno;
            document.querySelector("#nombre").nextElementSibling.classList.add('fijar');
            document.querySelector("#apaterno").value = json.data.Apa_Alumno;
            document.querySelector("#apaterno").nextElementSibling.classList.add('fijar');
            document.querySelector("#amaterno").value = json.data.Ama_Alumno;
            document.querySelector("#amaterno").nextElementSibling.classList.add('fijar');
            document.querySelector("#fechanacimiento").value = json.data.Fecha_Nacimiento;
            document.querySelector("#fechanacimiento").nextElementSibling.classList.add('fijar');
            document.querySelector("#idestado").value = json.data.Est_Matricula;
            document.querySelector("#idestado").nextElementSibling.classList.add('fijar');
            document.querySelector("#sexo").value = json.data.Sexo_Alumno;
            document.querySelector("#sexo").nextElementSibling.classList.add('fijar');
            document.querySelector("#idaula").value = json.data.Id_Aula;
            document.querySelector("#idaula").nextElementSibling.classList.add('fijar');
            document.querySelector("#imagenactual").value = json.data.Foto_Alumno;
            if(json.data.Foto_Alumno == null || json.data.Foto_Alumno == ""){
                document.querySelector("#imagenmuestra").src = "../img/student.png";
            }
            else{
                document.querySelector("#imagenmuestra").src = "../src/img-student/"+json.data.Foto_Alumno;
            }
            document.querySelector("#qr").value = json.data.Qr_Alumno;
            if(json.data.Qr_Alumno === null || json.data.Qr_Alumno === ""){
                document.querySelector('.content-qr').classList.remove('content-qr-active');
            }
            else{
                document.querySelector('.content-qr').classList.add('content-qr-active');
                document.querySelector("#qrmuestra").src = "../src/qr-student/"+json.data.Qr_Alumno;
            }
        }
    } catch (error) {
        console.log(error)
    }
}
function Eliminar(id){
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
    formData.append('idalumno',id);
    try {
        let resp = await fetch ('../controller/studentcontroller.php?op=eliminar',{
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
    document.querySelector("#tblbodylista").innerHTML = "";
    let search = document.querySelector("#search_input").value;
    if(search == ""){
        Listar();
    }
    try {
        let formData = new FormData();
        formData.append('search_input',search)
        let resp = await fetch ('../controller/studentcontroller.php?op=buscar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        console.log(resp);
        json = await resp.json();
        if(json.status){
            let data = json.data;
            var i = 0;
            let estadoamtricula = "";
            data.forEach((item)=>{
                i++;
                let newtr = document.createElement("tr");
                newtr.id = "row_"+item.Id_Alumno;
                if(item.Est_Matricula == 1){
                    estadoamtricula = "DEFINITIVA";
                }
                else if(item.Est_Matricula == 2){
                    estadoamtricula = "TRASLADADO";
                }
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="Documento" class="rcab">${item.Doc_Alumno}</td>
                                    <td data-label="Código">${item.Cod_Alumno}</td>
                                    <td data-label="Nombre">${item.Nom_Alumno} ${item.Apa_Alumno} ${item.Ama_Alumno}</td>
                                    <td data-label="Fecha Nacimiento" >${FormatDate(item.Fecha_Nacimiento)}</td>
                                    <td data-label="Estado Matricula" >${estadoamtricula}</td>
                                    <td data-label="Aula" >${item.Grado_Aula} - ${item.Seccion_Aula}</td>
                                    <td data-label="Acciones">
                                        <div class="data-action">
                                            ${item.Qr_Alumno !== null && item.Qr_Alumno !== '' ? `<a href="report/carnet.php?id=${item.Id_Alumno}&rute=astudent" class="fa-solid fa-file-pdf" title="Generar Carnet"> </a>`: `<a class="fa-solid fa-qrcode" title="Generar QR"> </a>`}
                                            <a href="studentform.php?id=${item.Id_Alumno}&rute=astudent" class="fa-solid fa-tags" title="Modificar"> </a>
                                            <a class="fa-solid fa-trash-can" onclick="Eliminar(${item.Id_Alumno})" title="Eliminar"></a>
                                        </div>
                                    </td>`;
                document.querySelector("#tblbodylista").appendChild(newtr);
            });
        }
        
    } catch (error) {
        console.log(error);
    }
}
function InputSearch(){
    let searchBus = document.querySelector("#search_input").value;
    if(searchBus == ""){
        Listar();
    }
    else{
        Buscar();
    }
}
function SelectImage(){
    const defaultFile = '../img/student.png';
    const file = document.getElementById('foto');
    const img = document.getElementById('imagenmuestra');
    file.addEventListener('change', e=>{
        if(e.target.files[0]){
            const reader = new FileReader();
            reader.onload = function(e){
                img.src = e.target.result; 
            }
            reader.readAsDataURL(e.target.files[0])
        }
        else{
            img.src = defaultFile
        }

    })
}

function SearchByDni(){
    try {
        documento = document.getElementById('documento').value;
        $.ajax({
            url : '../config/api_reniec.php',
            type: 'post',
            data: 'dni='+documento,
            dataType: 'json',
            success: function(e){
                if(e.numeroDocumento == documento){
                    document.querySelector("#nombre").nextElementSibling.classList.add('fijar');
                    document.querySelector("#nombre").value = e.nombres;
                    document.querySelector("#apaterno").nextElementSibling.classList.add('fijar');
                    document.querySelector("#apaterno").value = e.apellidoPaterno;
                    document.querySelector("#amaterno").nextElementSibling.classList.add('fijar');
                    document.querySelector("#amaterno").value = e.apellidoMaterno;
                }
                else{
                    Swal.fire(
                        "¡Ocurrio un error!",
                        "No se encontro a la persona",
                        "warning"
                    )
                }
            } 
        })
    } catch (error) {
        console.log(error)
    }
}
function FormatDate(date){
    const  fechaISO = `${date}`;
    const options ={
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        timeZone: 'America/Lima'
    }
    return new Date(fechaISO).toLocaleString('es-ES', options).replace(/\//g, '-');
}
async function GenerarQR(id){
    let formData = new FormData();
    formData.append('idalumno',id);
    try {
        let resp = await fetch ('../controller/studentcontroller.php?op=mostrar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            if(json.data.Doc_Alumno == null || json.data.Doc_Alumno == ''){
                formData.append('infoqr',json.data.Cod_Alumno);
            }
            else{
                formData.append('infoqr',json.data.Doc_Alumno);
            }
            let resp = await fetch ('../controller/studentcontroller.php?op=generarqr',{
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
        }
    } catch (error) {
        console.log(error)
    }
}
init();