function init(){
    if(document.querySelector('#tblbodylista')){
        Listar();
    }
    if(document.querySelector('#formulario')){
        let formulario = document.querySelector("#formulario");
        formulario.onsubmit = function(e){
            e.preventDefault();
            GuardaryEditar();
        }
    }
    if(document.querySelector('#form_search')){
        let form_search = document.querySelector("#form_search");
        form_search.onsubmit = function(e){
            e.preventDefault();

            
            let search = document.querySelector("#search_input").value;
            if(search == ""){
                Listar();
            }
            else{
                Buscar();
            }
        }
        let inputsearch = document.querySelector("#search_input");
        inputsearch.addEventListener("keyup",InputSearch,true)
    }
    SelectImage();  
}
async function Listar(){
    document.querySelector("#tblbodylista").innerHTML = "";
    try {
        let resp = await fetch("../controller/studentcontroller.php?op=listar");
        json = await resp.json();
        if(json.status){
            let data = json.data;
            var i = 0;
            data.forEach((item) =>{
                i++;
                let newtr = document.createElement("tr");
                newtr.id = "row_"+item.Id_Alumno;
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="DNI" class="rcab">${item.Dni_Alumno}</td>
                                    <td data-label="Nombre">${item.Nom_Alumno} ${item.Ape_Alumno}</td>
                                    <td data-label="Grado" >${item.Grado_Aula}</td>
                                    <td data-label="Sección">${item.Seccion_Aula}</td>
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
    let dni = document.querySelector("#dni").value;
    let nombre = document.querySelector("#nombre").value;
    let apellido = document.querySelector("#apellido").value;
    let idaula = document.querySelector("#idaula").value;
    let imagenactual = document.querySelector("#imagenactual").value;
    if(dni == "" || nombre == "" || apellido == "" || idaula == 0){
        document.querySelector(`#formulario-mensaje`).classList.add('formulario-mensaje-activo');
        return;
    }
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
            window.location.href = 'student.php?exito=1&msg='+encodeURIComponent(json.msg);
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
            document.querySelector("#dni").value = json.data.Dni_Alumno;
            document.querySelector("#dni").nextElementSibling.classList.add('fijar');
            document.querySelector("#nombre").value = json.data.Nom_Alumno;
            document.querySelector("#nombre").nextElementSibling.classList.add('fijar');
            document.querySelector("#apellido").value = json.data.Ape_Alumno;
            document.querySelector("#apellido").nextElementSibling.classList.add('fijar');
            document.querySelector("#idaula").value = json.data.Id_Aula;
            document.querySelector("#idaula").nextElementSibling.classList.add('fijar');
            document.querySelector("#imagenactual").value = json.data.Foto_Alumno;
            if(json.data.Foto_Alumno == null || json.data.Foto_Alumno == ""){
                document.querySelector("#imagenmuestra").src = "../img/student.png";
            }
            else{
                document.querySelector("#imagenmuestra").src = "../src/img-student/"+json.data.Foto_Alumno;
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
    
    try {
        let formData = new FormData(form_search);
        
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
            data.forEach((item)=>{
                i++;
                let newtr = document.createElement("tr");
                newtr.id = "row_"+item.Id_Alumno;
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="DNI" class="rcab">${item.Dni_Alumno}</td>
                                    <td data-label="Nombre">${item.Nom_Alumno} ${item.Ape_Alumno}</td>
                                    <td data-label="Grado" class="rcab">${item.Grado_Aula}</td>
                                    <td data-label="Sección" class="rcab">${item.Seccion_Aula}</td>
                                    <td data-label="Acciones">
                                        <div class="data-action">
                                            ${item.Qr_Alumno === null || item.Qr_Alumno === "" ? `<a href="userform.php?id=${item.Id_Alumno}" class="fa-solid fa-tags" title="Generar QR"> </a>`:`<a href="userform.php?id=${item.Id_Alumno}" class="fa-solid fa-tags" title="Ver codigo QR"> </a>`} 
                                            <a href="userform.php?id=${item.Id_Alumno}" class="fa-solid fa-tags" title="Modificar"> </a>
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
init();