function init(){
    if(document.querySelector('#formulario')){
        let formulario = document.querySelector("#formulario");
        formulario.onsubmit = function(e){
            e.preventDefault();
            Validar();
        }
    }
}
async function Validar(){
    let user = document.querySelector('#user').value;
    let password = document.querySelector('#password').value
    if(user == "" || password == ""){
        Swal.fire(
            "Oops...!",
            "Debe rellenar ambos campos para continuar",
            "info"
        );
        return;
    }
    try {
        const data = new FormData(formulario);
        let resp = await fetch("../controller/logincontroller.php?op=validar",{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if(json.status){
            window.location.href = 'home.php';
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
init();