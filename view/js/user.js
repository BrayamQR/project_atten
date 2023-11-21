function init(){
    if(document.querySelector('#tblbodylista')){
        Listar();
    }
    if(document.querySelector('#formulario')){
        let formulario = document.querySelector("#formulario");
        const inputs = document.querySelectorAll('#formulario .input-content input');
        const select = document.querySelector("#idtipo")
        inputs.forEach((input) => {
            input.addEventListener('keyup', validarFormulario);
            input.addEventListener('blur', validarFormulario);
        });
        select.addEventListener('click', () =>{
            validarSelect(select);
        })
        select.addEventListener('blur', () => {
            validarSelect(select);
        });

        ListarTipoUsuario()
        formulario.onsubmit = function(e){
            e.preventDefault();
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
                Swal.fire({
                    icon: 'warning',
                    title: '¡Ooh no!',
                    text: 'Los campos con (*) son obligatorios'
                })
                return;
            }
            else if(campos.codigo && campos.nombre && campos.apellido && campos.telefono && campos.email && campos.direccion && campos.user && campos.password){
                GuardaryEditar();
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Existen credenciales incorrectas'
                })
                return;
            }
        }
    }
    if(document.querySelector('#form_search')){
        let inputsearch = document.querySelector("#search_input");
        inputsearch.addEventListener("keyup",InputSearch,true);
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
                                        <td data-label="Código" class="rcab">${item.Cod_Usuario}</td>
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
async function ListarTipoUsuario(){
    document.querySelector("#idtipo").innerHTML = "";
    try {
        let resp = await fetch("../controller/usercontroller.php?op=listarselect");
        json = await resp.json();
        if(json.status){
            let data = json.data;

            let initialOption = document.createElement("option");
            initialOption.value = ""; 
            initialOption.disabled = true;
            initialOption.selected = true;
            document.querySelector("#idtipo").appendChild(initialOption);

            data.forEach((item) =>{
                let newop = document.createElement("option");
                newop.value = item.Id_TipoUsuario;
                newop.innerHTML = item.Desc_TipoUsuario;
                
                document.querySelector("#idtipo").appendChild(newop);
            });
        }
    } catch (error) {
        console.log(error);
    }
}
async function GuardaryEditar(){

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
                
                window.location.href = 'user.php?exito=1&msg='+encodeURIComponent(json.msg)+'&rute=muser';
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
    let search = document.querySelector("#search_input").value;
    if(search == ""){
        Listar();
    }
    document.querySelector("#tblbodylista").innerHTML = "";
    try {
        let formData = new FormData();
        formData.append('search_input',search)
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
                                        <td data-label="Código" class="rcab">${item.Cod_Usuario}</td>
                                        <td data-label="Nombre">${item.Nom_Usuario} ${item.Ape_Usuario}</td>
                                        <td data-label="Dirección">${item.Dir_Usuario}</td>
                                        <td data-label="Telefono">${item.Tel_Usuario}</td>
                                        <td data-label="Email">${item.Email_Usuario}</td>
                                        <td data-label="Usuario">${item.User_Usuario}</td>
                                        <td data-label="Tipo">${item.Desc_TipoUsuario}</td>
                                        <td data-label="Acciones">
                                            <div class="data-action">
                                            <a href="#?id=${item.Cod_Usuario}" class="fa-solid fa-arrow-rotate-left" title="Restaurar contraseña"> </a> 
                                            <a href="userform.php?id=${item.Cod_Usuario}&rute=auser" class="fa-solid fa-tags" title="Modificar"> </a>
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
const expresiones = {
    codigo: /^[0-9]{8}$/, //numero de 8 digitos
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,50}$/,//letras con acento y espacio
	apellido: /^[a-zA-ZÀ-ÿ\s]{1,50}$/,//letras con acento y espacio
	telefono: /^[0-9]{6,9}$/, //numero de 9 digitos
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/, // correo
	direccion: /^[a-zA-ZÀ-ÿ0-9\s]{1,150}$/, //letras, numeros y espacio
	user: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	password: /^.{4,12}$/, // 4 a 12 digitos
}
const campos ={
	codigo: false,
    nombre: false,
    apellido: false,
	telefono: false,
	email: false,
	direccion: false, 
	user: false,
	password: false,
}
const validarFormulario = (e) => {
    switch (e.target.name) {
        case "codigo":
            validarCampo(expresiones.codigo, e.target, 'codigo');
            break;
        case "nombre":
            validarCampo(expresiones.nombre, e.target, 'nombre');
            break;
        case "apellido":
            validarCampo(expresiones.apellido, e.target, 'apellido');
            break;
        case "telefono":
            validarCampo(expresiones.telefono, e.target, 'telefono');
            break;
        case "email":
            validarCampo(expresiones.email, e.target, 'email');
            break;
        case "direccion":
            validarCampo(expresiones.direccion, e.target, 'direccion');
                break;
        case "user":
            validarCampo(expresiones.user, e.target, 'user');
            break;
        case "password":
            validarCampo(expresiones.password, e.target, 'password');
            validarConfigPass();
            break;
        case "confipass":
            validarConfigPass();
            break;
    }
}
const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
		document.getElementById(`grupo-${campo}`).classList.remove('formulario-grupo-incorrecto');
		document.getElementById(`grupo-${campo}`).classList.add('formulario-grupo-correcto');
		document.querySelector(`#grupo-${campo} .formulario-validacion-estado`).classList.add('fa-check');
		document.querySelector(`#grupo-${campo} .formulario-validacion-estado`).classList.remove('fa-xmark');
		document.querySelector(`#grupo-${campo} .formulario-input-error`).classList.remove('formulario-input-error-activo');
		campos[campo] = true;
	} else {
		document.getElementById(`grupo-${campo}`).classList.add('formulario-grupo-incorrecto');
		document.getElementById(`grupo-${campo}`).classList.remove('formulario-grupo-correcto');
		document.querySelector(`#grupo-${campo} .formulario-validacion-estado`).classList.add('fa-xmark');
		document.querySelector(`#grupo-${campo} .formulario-validacion-estado`).classList.remove('fa-check');
		document.querySelector(`#grupo-${campo} .formulario-input-error`).classList.add('formulario-input-error-activo');
		campos[campo]=false;
	}
}

const validarConfigPass = () => {
	const inputPassword1 = document.getElementById('password');
	const inputPassword2 = document.getElementById('confipass');

	if(inputPassword1.value !== inputPassword2.value){
		document.getElementById(`grupo-confipass`).classList.add('formulario-grupo-incorrecto');
		document.getElementById(`grupo-confipass`).classList.remove('formulario-grupo-correcto');
		document.querySelector(`#grupo-confipass .formulario-validacion-estado`).classList.add('fa-xmark');
		document.querySelector(`#grupo-confipass .formulario-validacion-estado`).classList.remove('fa-check');
		document.querySelector(`#grupo-confipass .formulario-input-error`).classList.add('formulario-input-error-activo');
		campos[password]= false;
	} else {
		document.getElementById(`grupo-confipass`).classList.remove('formulario-grupo-incorrecto');
		document.getElementById(`grupo-confipass`).classList.add('formulario-grupo-correcto');
		document.querySelector(`#grupo-confipass .formulario-validacion-estado`).classList.remove('fa-xmark');
		document.querySelector(`#grupo-confipass .formulario-validacion-estado`).classList.add('fa-check');
		document.querySelector(`#grupo-confipass .formulario-input-error`).classList.remove('formulario-input-error-activo');
		campos[password]= true;
	}
}
const validarSelect = (select) => {
    if (select.value == 0) {
        document.getElementById(`grupo-${select.id}`).classList.add('formulario-grupo-incorrecto');
        document.getElementById(`grupo-${select.id}`).classList.remove('formulario-grupo-correcto');
        document.querySelector(`#${`grupo-${select.id}`} .formulario-validacion-estado`).classList.add('fa-xmark');
        document.querySelector(`#${`grupo-${select.id}`} .formulario-validacion-estado`).classList.remove('fa-check');
        document.querySelector(`#${`grupo-${select.id}`} .formulario-input-error`).classList.add('formulario-input-error-activo');
        return false; 
    } else {
        document.getElementById(`grupo-${select.id}`).classList.remove('formulario-grupo-incorrecto');
        document.getElementById(`grupo-${select.id}`).classList.add('formulario-grupo-correcto');
        document.querySelector(`#${`grupo-${select.id}`} .formulario-validacion-estado`).classList.remove('fa-xmark');
        document.querySelector(`#${`grupo-${select.id}`} .formulario-validacion-estado`).classList.add('fa-check');
        document.querySelector(`#${`grupo-${select.id}`} .formulario-input-error`).classList.remove('formulario-input-error-activo');
        return true; 
    }
};
init()