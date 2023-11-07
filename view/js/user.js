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
}

async function Listar(){
    document.querySelector("#tblbodylista").innerHTML = "";
    try {
        let resp = await fetch("../controller/usercontroller.php?op=listar");
        json = await resp.json();
        if(json.status){
            let data = json.data;
            var i = 0;
            data.forEach((item) =>{
                i++;
                let newtr = document.createElement("tr");
                newtr.id = "row_"+item.Id_Usuario;
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="Codigo" class="rcab">${item.Cod_Usuario}</td>
                                    <td data-label="Nombre">${item.Nom_Usuario} ${item.Ape_Usuario}</td>
                                    <td data-label="Dirección">${item.Dir_Usuario}</td>
                                    <td data-label="Telefono">${item.Tel_Usuario}</td>
                                    <td data-label="Email">${item.Email_Usuario}</td>
                                    <td data-label="Usuario">${item.User_Usuario}</td>
                                    <td data-label="Tipo">${item.Desc_TipoUsuario}</td>
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
        console.log(error);
    }
}
async function GuardaryEditar(){
    let codigo = document.querySelector("#codigo").value;
    let nombre = document.querySelector("#nombre").value;
    let apellido = document.querySelector("#apellido").value;
    let telefono = document.querySelector("#telefono").value;
    let email = document.querySelector("#email").value;
    let direccion = document.querySelector("#direccion").value;
    let user = document.querySelector("#user").value;
    let password = document.querySelector("#password").value;
    let confipass = document.querySelector("#confipass").value;
    let idtipo = document.querySelector("#idtipo").value;
    if(codigo == "" || nombre == "" || apellido == "" || telefono == "" || email == "" || direccion == ""|| user == "" || password == "" || confipass == "" || idtipo == 0){
        document.querySelector(`#formulario-mensaje`).classList.add('formulario-mensaje-activo');
        return;
    }
    try {
        if(password === confipass){
            const data = new FormData(formulario);
            let resp = await fetch ('../controller/usercontroller.php?op=guardaryeditar',{
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if(json.status){
                
                window.location.href = 'user.php?exito=1&msg='+encodeURIComponent(json.msg);
                formulario.reset();
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: json.msg
                })
            }
        }
        else{
            Swal.fire({
                icon: 'warning',
                title: '¡Oh no!',
                text: 'Las contraseñas no coinsiden'
            })
        }
        
    } catch (error) {
        console.log(error)
    }

}
async function Mostrar(id){
    const formData = new FormData();
    formData.append('idusuario',id)
    try {
        let resp = await fetch ('../controller/usercontroller.php?op=mostrar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            document.querySelector("#id").value = json.data.Id_Usuario;
            document.querySelector("#codigo").value = json.data.Cod_Usuario;
            document.querySelector("#codigo").nextElementSibling.classList.add('fijar');
            document.querySelector("#nombre").value = json.data.Nom_Usuario;
            document.querySelector("#nombre").nextElementSibling.classList.add('fijar');
            document.querySelector("#apellido").value = json.data.Ape_Usuario;
            document.querySelector("#apellido").nextElementSibling.classList.add('fijar');
            document.querySelector("#telefono").value = json.data.Tel_Usuario;
            document.querySelector("#telefono").nextElementSibling.classList.add('fijar');
            document.querySelector("#email").value = json.data.Email_Usuario;
            document.querySelector("#email").nextElementSibling.classList.add('fijar');
            document.querySelector("#direccion").value = json.data.Dir_Usuario;
            document.querySelector("#direccion").nextElementSibling.classList.add('fijar');
            document.querySelector("#user").value = json.data.User_Usuario;
            document.querySelector("#user").nextElementSibling.classList.add('fijar');
            document.querySelector("#password").value = json.data.Pass_Usuario;
            document.querySelector("#password").nextElementSibling.classList.add('fijar');
            document.querySelector("#confipass").value = json.data.Pass_Usuario;
            document.querySelector("#confipass").nextElementSibling.classList.add('fijar');
            document.querySelector("#idtipo").value = json.data.Id_TipoUsuario;
            document.querySelector("#idtipo").nextElementSibling.classList.add('fijar');
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
    formData.append('idusuario',id);
    try {
        let resp = await fetch ('../controller/usercontroller.php?op=eliminar',{
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
        
        let resp = await fetch ('../controller/usercontroller.php?op=buscar',{
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
                newtr.id = "row_"+item.Id_Usuario;
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="Codigo" class="rcab">${item.Cod_Usuario}</td>
                                    <td data-label="Nombre">${item.Nom_Usuario} ${item.Ape_Usuario}</td>
                                    <td data-label="Dirección">${item.Dir_Usuario}</td>
                                    <td data-label="Telefono">${item.Tel_Usuario}</td>
                                    <td data-label="Email">${item.Email_Usuario}</td>
                                    <td data-label="Usuario">${item.User_Usuario}</td>
                                    <td data-label="Tipo">${item.Desc_TipoUsuario}</td>
                                    <td data-label="Acciones">
                                        <div class="data-action">
                                        <a href="userform.php?id=${item.Cod_Usuario}" class="fa-solid fa-arrow-rotate-left" title="Restaurar contraseña"> </a> 
                                        <a href="userform.php?id=${item.Cod_Usuario}" class="fa-solid fa-tags" title="Modificar"> </a>
                                        <a class="fa-solid fa-trash-can" onclick="Eliminar(${item.Cod_Usuario})" title="Eliminar"></a>
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
init()