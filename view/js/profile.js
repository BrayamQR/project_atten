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
    if(document.querySelector('#formulario-perfil')){
        let btn_addperfil = document.querySelector('#btn-insert-perfil');
        btn_addperfil.addEventListener('click', function(e) {
            e.preventDefault();
            InsertarPerfil();
        });
    }
}
async function Listar(){
    document.querySelector("#tblbodylista").innerHTML = "";
    try {
        let resp = await fetch("../controller/profilecontroller.php?op=listar");
        json = await resp.json();
        if(json.status){
            let data = json.data;
            var i = 0;
            let estado 
            data.forEach((item) =>{
                i++;
                if(item.Vigente == 1){
                    estado = true;
                }
                else{
                    estado = false;
                }
                let newtr = document.createElement("tr");
                newtr.id = "row_"+item.Id_TipoUsuario;
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    <td data-label="Perfil" class="rcab">${item.Desc_TipoUsuario}</td>
                                    <td data-label="Estado">
                                        <input type="checkbox" class="btn-switch" name="estado" id="btn-switch-${item.Id_TipoUsuario}" ${estado ? 'checked' : ''} onchange="CambiarEstado(${item.Id_TipoUsuario})">
                                        <label for="btn-switch-${item.Id_TipoUsuario}"
                                        class="lbl-switch"></label>
                                    </td>
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
async function CambiarEstado(id){
    let estado = document.querySelector('#btn-switch-'+id).checked;

    Swal.fire({
        title: '¿Estás seguro?',
        text: "El cambiara el estado del usuario",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, cambiar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            ConfirmChange(id,estado)
        }
        else{
            Listar();
        }
    })
}
async function ConfirmChange(id,estado){
    let formData = new FormData();
    formData.append('idtipousuario',id);
    formData.append('estado',estado);
    try {
        let resp = await fetch ('../controller/profilecontroller.php?op=cambiarestado',{
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
        console.log(resp);
    } catch (error) {
        console.log.error
    }
}
async function GuardaryEditar(){
    try {
        const data = new FormData(formulario);
        data.append('student', document.querySelector('#student').checked,);
        data.append('classroom', document.querySelector('#classroom').checked,);
        data.append('income', document.querySelector('#income').checked);
        data.append('activity', document.querySelector('#activity').checked);
        data.append('user', document.querySelector('#user').checked);
        data.append('profile', document.querySelector('#profile').checked);
        let resp = await fetch ('../controller/profilecontroller.php?op=guardaryeditar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        console.log(json);
        if(json.status){
            Swal.fire(
                "¡Exito!",
                json.msg,
                "success"
            );
            formulario.reset();
            document.querySelector('#content-lst-access').style.display = 'none';
        }
        else{
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: json.msg
            });
        }
    } catch (error) {
        console.log(error)
    }
}
async function MostrarPermisos(id){
    
    const formData = new FormData();
    formData.append('idtipo',id);
    try {
        let resp = await fetch ('../controller/profilecontroller.php?op=mostrarpermisos',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(e) {
                e.disabled = true;
            });
            document.querySelector('#submit').style.display = 'none';
            document.querySelector('#btn-editar').style.display = 'block';
            document.querySelector('#content-lst-access').style.display = 'block';
            document.querySelector('#id').value=json.data.Id_Permiso;
            document.querySelector('#idtipo').value=id;
            document.querySelector('#student').checked = (json.data.Act_Estudiante == 1);
            document.querySelector('#classroom').checked = (json.data.Act_Aula == 1);
            document.querySelector('#income').checked = (json.data.Act_Asistencia == 1);
            document.querySelector('#activity').checked = (json.data.Act_Actividad == 1);
            document.querySelector('#user').checked = (json.data.Act_Usuarios == 1);
            document.querySelector('#profile').checked = (json.data.Act_Perfiles == 1);
        }
        else{

            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(e) {
                e.disabled = true;
            });
            document.querySelector('#content-lst-access').style.display = 'block';
            document.querySelector('#id').value='';
            document.querySelector('#idtipo').value=id;
            document.querySelector('#submit').style.display = 'none';
            document.querySelector('#btn-editar').style.display = 'block';
            document.querySelector('#student').checked = null;
            document.querySelector('#classroom').checked = null;
            document.querySelector('#income').checked = null;
            document.querySelector('#activity').checked = null;
            document.querySelector('#user').checked = null;
            document.querySelector('#profile').checked = null;
        }
    } catch (error) {
        console.log(error);
    }
}
function HabilitarCampos(){
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function(e) {
        e.disabled = false;
    });
    document.querySelector('#submit').style.display = 'block';
    document.querySelector('#btn-editar').style.display = 'none';
}
function OcultarFormulario(){
    document.querySelector('#content-lst-access').style.display = 'none';
}
function MostrarCamposHijos(){
    var licheckboxes = document.querySelectorAll('.content-profile-padre input[type="checkbox"]');
    console.log(licheckboxes.target.name);
}
async function InsertarPerfil(){
    let perfil = document.querySelector('#txt_perfil').value;
    if(perfil ==''){
        Swal.fire(
            "Oops...!",
            "Debe rellenar el campo perfil para registrarlo",
            "warning"
        );
        return;
    }
    try {
        const formData = new FormData();
        formData.append('perfil',perfil);
        let resp = await fetch ('../controller/profilecontroller.php?op=guardarperfil',{
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
            );
            Listar();
        }
        else{
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: json.msg
            });
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
    formData.append('idtipo',id);
    try {
        let resp = await fetch ('../controller/profilecontroller.php?op=eliminarperfil',{
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
/*
function CheckedPadre(checkbox){
    var checkboxes = document.querySelectorAll("input[type = 'checkbox']");
    if(checkbox.checked == true){
        checkboxes.forEach(function(e){
            if(e.id.includes("_"+checkbox.id)){
                e.checked = true;
            }
        })
    }
    else{
        checkboxes.forEach(function(e){
            if(e.id.includes("_"+checkbox.id)){
                e.checked = false;
            }
        })
    }    
}
function CheckedHijo(checkbox){
    var partesID = checkbox.id.split('_'); 
    var checkboxes = document.querySelectorAll("input[type = 'checkbox']");
    if(checkbox.checked == true){
        checkboxes.forEach(function(e){
            if(e.id==partesID[1]){
                e.checked = true;
            }
        });
    }
}
*/
init();