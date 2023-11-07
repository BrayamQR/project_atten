const formulario = document.getElementById('formulario');
const inputs = document.querySelectorAll('#formulario .input-content input');
const selects = document.querySelectorAll('#formulario .input-content select')

const expresiones = {
    codigo: /^[a-zA-Z0-9]{6}$/, //Letras y numeros
    producto: /^[a-zA-ZÀ-ÿ0-9\/\s]{1,50}$/, //letras,numeros,asentos y slash
    marca: /^[a-zA-ZÀ-ÿ0-9\s]{1,50}$/, //letras,numeros y espacios
	cantidad: /^[0-9]{1,5}$/, //numero de 1 a 5 digitos
	decimal: /^[0-9\.]{1,7}$/, //decimal
	ruc: /^[0-9]{11}$/, //numero de 11 digitos
	telefono: /^[0-9]{6,9}$/, //numero de 9 digitos
	proveedor: /^[a-zA-ZÀ-ÿ0-9\s]{1,50}$/, //letras, numeros y espacio
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/, // correo
	direccion: /^[a-zA-ZÀ-ÿ0-9\s]{1,150}$/, //letras, numeros y espacio
	texto: /^[a-zA-ZÀ-ÿ\s]{1,50}$/, //letras con acento y espacio
	dni: /^[0-9]{8}$/, //numero de 8 digitos
	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	password: /^.{4,12}$/, // 4 a 12 digitos
	// compra venta ruc telefono proveedor email direccion contacto cargo celular dni nombres apellidos celular email direccion user pass confipass
}
const campos ={
	codigo: false,
    producto: false,
    marca: false,
	cantidad: false,
	decimal: false,
	ruc: false, 
	telefono: false,
	proveedor: false, 
	email: false, 
	direccion: false, 
	texto: false,
	dni: false,
	usuario: false,
	password: false
}
const validarFormulario = (e) => {
	switch (e.target.name) {
		case "codigo":
			validarCampo(expresiones.codigo, e.target, 'codigo');
		break;
		case "producto":
			validarCampo(expresiones.producto, e.target, 'producto');
		break;
		case "marca":
			validarCampo(expresiones.marca, e.target, 'marca');
		break;
		case "cantidad":
			validarCampo(expresiones.cantidad,e.target,'cantidad');
		break;
		case "compra":
			validarCampo(expresiones.decimal,e.target,'compra');
		break;
		case "venta":
			validarCampo(expresiones.decimal,e.target,'venta');
		break;
		case "ruc":
			validarCampo(expresiones.ruc,e.target,'ruc');
		break;
		case "telefono":
			validarCampo(expresiones.telefono,e.target,'telefono');
		break;
		case "proveedor":
			validarCampo(expresiones.proveedor,e.target,'proveedor');
		break;
		case "email":
			validarCampo(expresiones.email,e.target,'email');
		break;
		case "direccion":
			validarCampo(expresiones.direccion,e.target,'direccion');
		break;
		case "contacto":
			validarCampo(expresiones.texto,e.target,'contacto');
		break;
		case "cargo":
			validarCampo(expresiones.texto,e.target,'cargo');
		break;
		case "celular":
			validarCampo(expresiones.telefono,e.target,'celular');
		break;
		case "dni":
			validarCampo(expresiones.dni,e.target,'dni');
		break;
		case "nombres":
			validarCampo(expresiones.texto,e.target,'nombres');
		break;
		case "apellidos":
			validarCampo(expresiones.texto,e.target,'apellidos');
		break;
		case "celular":
			validarCampo(expresiones.telefono,e.target,'celular');
		break;
		case "user":
			validarCampo(expresiones.usuario,e.target,'user');
		break;
		case "pass":
			validarCampo(expresiones.password,e.target,'pass');
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
		document.querySelector(`#grupo-${campo} .formulario-validacion-estado`).classList.add('fa-solid fa-check');
		document.querySelector(`#grupo-${campo} .formulario-validacion-estado`).classList.remove('fa-solid fa-xmark');
		document.querySelector(`#grupo-${campo} .formulario-input-error`).classList.remove('formulario-input-error-activo');
		campos[campo] = true;
	} else {
		document.getElementById(`grupo-${campo}`).classList.add('formulario-grupo-incorrecto');
		document.getElementById(`grupo-${campo}`).classList.remove('formulario-grupo-correcto');
		document.querySelector(`#grupo-${campo} .formulario-validacion-estado`).classList.add('fa-solid fa-xmark');
		document.querySelector(`#grupo-${campo} .formulario-validacion-estado`).classList.remove('fa-solid fa-check');
		document.querySelector(`#grupo-${campo} .formulario-input-error`).classList.add('formulario-input-error-activo');
		campos[campo]=false;
	}
}

const validarConfigPass = () => {
	const inputPassword1 = document.getElementById('pass');
	const inputPassword2 = document.getElementById('confipass');

	if(inputPassword1.value !== inputPassword2.value){
		document.getElementById(`grupo-confipass`).classList.add('formulario-grupo-incorrecto');
		document.getElementById(`grupo-confipass`).classList.remove('formulario-grupo-correcto');
		document.querySelector(`#grupo-confipass .formulario-validacion-estado`).classList.add('fa-solid fa-check');
		document.querySelector(`#grupo-confipass .formulario-validacion-estado`).classList.remove('fa-solid fa-xmark');
		document.querySelector(`#grupo-confipass .formulario-input-error`).classList.add('formulario-input-error-activo');
		campos[password]= false;
	} else {
		document.getElementById(`grupo-confipass`).classList.remove('formulario-grupo-incorrecto');
		document.getElementById(`grupo-confipass`).classList.add('formulario-grupo-correcto');
		document.querySelector(`#grupo-confipass .formulario-validacion-estado`).classList.remove('fa-solid fa-check');
		document.querySelector(`#grupo-confipass .formulario-validacion-estado`).classList.add('fa-solid fa-xmark');
		document.querySelector(`#grupo-confipass .formulario-input-error`).classList.remove('formulario-input-error-activo');
		campos[password]= true;
	}
}

inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});

formulario.addEventListener('submit', (e)=>{
	e.preventDefault();
	
})