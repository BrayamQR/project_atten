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
        let inputsearch = document.querySelector("#search_input");
        inputsearch.addEventListener("keyup",InputSearch,true)
    }
}
async function Listar(){
    document.querySelector("#tblbodylista").innerHTML = "";
    try {
        let resp = await fetch("../controller/classroomcontroller.php?op=listar");
        json = await resp.json();
        if(json.status){
            let data = json.data;
            var i = 0;
            data.forEach((item) =>{
                i++;
                let newtr = document.createElement("tr");
                newtr.id = "row_"+item.Id_Aula;
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="Grado" class="rcab">${item.Grado_Aula}</td>
                                    <td data-label="Sección">${item.Seccion_Aula}</td>
                                    <td data-label="Nivel" >${item.Nivel_Aula}</td>
                                    <td data-label="Tutor">${item.Tutor_Aula}</td>
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
async function GuardaryEditar(){
    let grado = document.querySelector("#grado").value;
    let seccion = document.querySelector("#seccion").value;
    let nivel = document.querySelector("#nivel").value;
    let tutor = document.querySelector("#tutor").value;
    if(grado == 0 || seccion == 0 || nivel == 0 || tutor == ""){
        Swal.fire({
            icon: 'warning',
            title: '¡Ooh no!',
            text: 'Los campos con (*) son ogligatorios'
        })
        return;
    }
    try {
        const data = new FormData(formulario);
        let resp = await fetch ('../controller/classroomcontroller.php?op=guardaryeditar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if(json.status){
            window.location.href = 'classroom.php?exito=1&msg='+encodeURIComponent(json.msg)+'&rute=mclassroom';
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
    formData.append('idaula',id)
    try {
        let resp = await fetch ('../controller/classroomcontroller.php?op=mostrar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            document.querySelector("#id").value = json.data.Id_Aula;
            document.querySelector("#grado").value = json.data.Grado_Aula;
            document.querySelector("#grado").nextElementSibling.classList.add('fijar');
            document.querySelector("#seccion").value = json.data.Seccion_Aula;
            document.querySelector("#seccion").nextElementSibling.classList.add('fijar');
            document.querySelector("#nivel").value = json.data.Nivel_Aula;
            document.querySelector("#nivel").nextElementSibling.classList.add('fijar');
            document.querySelector("#tutor").value = json.data.Tutor_Aula;
            document.querySelector("#tutor").nextElementSibling.classList.add('fijar');
        }   

    } catch (error) {
        console.log(error);
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
    formData.append('idaula',id);
    try {
        let resp = await fetch ('../controller/classroomcontroller.php?op=eliminar',{
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
        let formData = new FormData(form_search);
        
        let resp = await fetch ('../controller/classroomcontroller.php?op=buscar',{
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
                newtr.id = "row_"+item.Id_Aula;
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="Grado" class="rcab">${item.Grado_Aula}</td>
                                    <td data-label="Sección">${item.Seccion_Aula}</td>
                                    <td data-label="Nivel" >${item.Nivel_Aula}</td>
                                    <td data-label="Tutor">${item.Tutor_Aula}</td>
                                    <td data-label="Acciones">
                                        <div class="data-action">
                                            <a href="studentform.php?id=${item.Id_Aula}&rute=mclassroom" class="fa-solid fa-tags" title="Modificar"> </a>
                                            <a class="fa-solid fa-trash-can" onclick="Eliminar(${item.Id_Aula})" title="Eliminar"></a>
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
init();