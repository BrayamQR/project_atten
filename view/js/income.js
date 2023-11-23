let btnScanQR;
let video;
let canvasElement ;
let canvas ;
let scanning;

function init(){
    if(document.querySelector('#tblbodylista')){
        Listar();
    }
    if(document.querySelector('#scan-qr-content')){
        btnScanQR = document.getElementById("btn-scan-qr");
        video = document.createElement("video");
        canvasElement = document.getElementById("qr-canvas");
        canvas = canvasElement.getContext("2d");
        scanning = false;
        ScanQR();
        window.addEventListener('load', (e) => {
            EncenderCamara();
        });
    }
    if(document.querySelector('#form_search')){
        let inputsearch = document.querySelector("#search_input");
        inputsearch.addEventListener("keyup",InputSearch,true);
        let datesearch = document.querySelector("#search_date");
        datesearch.addEventListener("change",InputSearch,true);
    }
    if(document.querySelector('#form-search-autocomplete')){
        let inputsearch = document.querySelector("#search_input");
        inputsearch.addEventListener("keyup",autocomplete,true);
    }
    if(document.querySelector('#formulario-modal')){
        ListarAulas();
        HabilitarInputs();
        SelectTipoReporte();
        let inputsearch = document.querySelector("#search_student");
        inputsearch.addEventListener("keyup",autocompleteModal,true);
        var btnGenerarRAula = document.querySelector('#generar_reporte_aula'); 
        var btnGenerarRFecha = document.querySelector('#generar_reporte_fecha');
        var btnGenerarRAlumno = document.querySelector('#generar_reporte_alumno');
        btnGenerarRAula.addEventListener('click', function(e) {
            e.preventDefault();
            let tipoGeneracion;
            let radioaula = document.querySelectorAll('.input-radio_aula');
            let idaula = document.querySelector('#idaula').value;
            let fechainicio = document.querySelector('#fechainicio_aula').value;
            let fechafin = document.querySelector('#fechafin_aula').value;
            radioaula.forEach(function(e) {
                if (e.checked) {
                    tipoGeneracion = e.value;
                }
            });
            if(tipoGeneracion == 1){
                if(idaula == '' || fechainicio == '' || fechafin == ''){
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Ooh no!',
                        text: 'Los campos con (*) son obligatorios'
                    })
                    return;
                }
            }
            else if (tipoGeneracion == 2){
                if(idaula == '' || fechainicio == '' ){
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Ooh no!',
                        text: 'Los campos con (*) son obligatorios'
                    })
                    return;
                }
            }   
            else{
                Swal.fire({
                    icon: 'warning',
                    title: '¡Ooh no!',
                    text: 'Debe seleccionar una opción'
                })
                return;
            }
            var url = 'report/repasistenciabyaula.php?' +
                        'reporte_aula=' + encodeURIComponent(tipoGeneracion) +
                        '&idaula=' + encodeURIComponent(idaula) +
                        '&fechainicio=' + encodeURIComponent(fechainicio)
                        ;
            if (fechafin != '') {
                url += '&fechafin=' + encodeURIComponent(fechafin);
            }
            window.location.href = url;
        });
        btnGenerarRFecha.addEventListener('click', function(e){
            e.preventDefault();
            let tipoGeneracion;
            let radiofecha = document.querySelectorAll('.input-radio_fecha');
            let fechainicio = document.querySelector('#fechainicio_fecha').value;
            let fechafin = document.querySelector('#fechafin_fecha').value;
            radiofecha.forEach(function(e) {
                if (e.checked) {
                    tipoGeneracion = e.value;
                }
            });
            if(tipoGeneracion == 1){
                if(fechainicio == '' || fechafin == ''){
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Ooh no!',
                        text: 'Los campos con (*) son obligatorios'
                    })
                    return;
                }
            }
            else if (tipoGeneracion == 2){
                if(fechainicio == '' ){
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Ooh no!',
                        text: 'Los campos con (*) son obligatorios'
                    })
                    return;
                }
            }   
            else{
                Swal.fire({
                    icon: 'warning',
                    title: '¡Ooh no!',
                    text: 'Debe seleccionar una opción'
                })
                return;
            }
            var url = 'report/repasistenciabyfecha.php?' +
                        'reporte_fecha=' + encodeURIComponent(tipoGeneracion) +
                        '&fechainicio=' + encodeURIComponent(fechainicio)
                        ;
            if (fechafin != '') {
                url += '&fechafin=' + encodeURIComponent(fechafin);
            }
            window.location.href = url;
        });
        btnGenerarRAlumno.addEventListener('click', function(e){
            e.preventDefault();
            let radiofecha = document.querySelectorAll('.input-radio_alumno');
            let fechainicio = document.querySelector('#fechainicio_alumno').value;
            let student = document.querySelector('#search_student').value;
            let fechafin = document.querySelector('#fechafin_alumno').value;
            let idstudent = document.querySelector('#idstudent').value;
            radiofecha.forEach(function(e) {
                if (e.checked) {
                    tipoGeneracion = e.value;
                }
            });
            if(tipoGeneracion == 1){
                if(student == '' || fechainicio == '' || fechafin == ''){
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Ooh no!',
                        text: 'Los campos con (*) son obligatorios'
                    })
                    return;
                }
            }
            else if (tipoGeneracion == 2){
                if(student == '' || fechainicio == '' ){
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Ooh no!',
                        text: 'Los campos con (*) son obligatorios'
                    })
                    return;
                }
            }   
            else{
                Swal.fire({
                    icon: 'warning',
                    title: '¡Ooh no!',
                    text: 'Debe seleccionar una opción'
                })
                return;
            }
            var url = 'report/repasistenciabyalumno.php?' +
                        'id='+encodeURIComponent(idstudent)+
                        '&reporte_fecha=' + encodeURIComponent(tipoGeneracion) +
                        '&fechainicio=' + encodeURIComponent(fechainicio)
                        ;
            if (fechafin != '') {
                url += '&fechafin=' + encodeURIComponent(fechafin);
            }
            window.location.href = url;
        });
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
async function Listar(){
    document.querySelector("#tblbodylista").innerHTML = "";
    try {
        let resp = await fetch("../controller/incomecontroller.php?op=listar");
        json = await resp.json();
        if(json.status){
            let data = json.data;
            var i = 0;
            
            data.forEach((item) =>{
                i++;
                let estadoTexto = '';
                let newtr = document.createElement("tr");
                newtr.id = "row_"+item.Id_Ingreso;
                if(item.Tipo_Ingreso == 1){
                    estadoTexto = 'Asistió';
                }
                else if(item.Tipo_Ingreso == 2){
                    estadoTexto = 'Tardanza';
                }
                newtr.innerHTML = `<td class="opacity">${i}</td>
                                    ${item.Doc_Alumno !== null && item.Doc_Alumno !== '' ? `<td data-label="Identificador" class="rcab">${item.Doc_Alumno}</td>`:`<td data-label="Identificador">${item.Cod_Alumno}</td>`}
                                    <td data-label="Estudiante">${item.Nom_Alumno} ${item.Apa_Alumno} ${item.Ama_Alumno}</td>
                                    <td data-label="Grado y sección" >${item.Grado_Aula} - ${item.Seccion_Aula}</td>
                                    <td data-label="Fecha ingreso" >${FormatDate(item.Hora_Ingreso,item.Fecha_Ingreso)}</td>
                                    <td data-label="Fecha ingreso" >${FormatHora(item.Hora_Ingreso,item.Fecha_Ingreso)}</td>
                                    <td data-label="Estado"><span class="estado estado-${item.Tipo_Ingreso}">${estadoTexto}</span></td>
                                    `;
                document.querySelector("#tblbodylista").appendChild(newtr);
            })
        }
    } catch (error) {
        console.log(error)
    }
}
function ScanQR(){
    qrcode.callback = (respuesta) => {
        if (respuesta) {
            //console.log(respuesta);
            ElegirAlumno(respuesta);
            ActivarSonido();
            CerrarCamara();
            EncenderCamara();
        }
    };
}
const EncenderCamara = () => {
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function (stream) {
        scanning = true;
        btnScanQR.hidden = true;
        canvasElement.hidden = false;
        video.setAttribute("playsinline", true);
        video.srcObject = stream;
        video.play();
        tick();
        scan();
    });
}
function tick(){
    canvasElement.height = video.videoHeight;
    canvasElement.width = video.videoWidth;
    canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
    scanning && requestAnimationFrame(tick);
}
function scan(){
    try {
        qrcode.decode();
    } catch (e) {
        setTimeout(scan, 300);
    }
}
const CerrarCamara = () => {
    video.srcObject.getTracks().forEach((track) => {
        track.stop();
    });
    canvasElement.hidden = true;
    btnScanQR.hidden = false;
};
const ActivarSonido = () => {
    var audio = document.getElementById('audioscaner');
    audio.play();
}
async function ElegirAlumno(doc){
    const formData = new FormData();
    formData.append('doc',doc);
    try {
        let resp = await fetch ('../controller/incomecontroller.php?op=elegir',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            ValidarIngreso(json.data.Id_Alumno);
            document.querySelector('#info-student-scan').style.display = 'block';
            if(json.data.Doc_Alumno == null || json.data.Doc_Alumno == ''){
                document.querySelector('#identificador').textContent = json.data.Cod_Alumno;
            }
            else{
                document.querySelector('#identificador').textContent = json.data.Doc_Alumno;
            }
            document.querySelector('#nombre').textContent = json.data.Nom_Alumno;
            document.querySelector('#apellido').textContent = json.data.Apa_Alumno+" "+json.data.Ama_Alumno;
            document.querySelector('#grado').textContent = json.data.Grado_Aula;
            document.querySelector('#seccion').textContent = json.data.Seccion_Aula;
            if(json.data.Foto_Alumno == null || json.data.Foto_Alumno == ""){
                document.querySelector("#imagenmuestra").src = "../img/student.png";
            }
            else{
                document.querySelector("#imagenmuestra").src = "../src/img-student/"+json.data.Foto_Alumno;
            }
            setTimeout(function() {
                document.querySelector('#info-student-scan').style.display = 'none';
            }, 5000);
        }else{
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
async function ValidarIngreso(id){
    const formData = new FormData();
    formData.append('idalumno',id);
    try {
        let resp = await fetch ('../controller/incomecontroller.php?op=validar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            document.querySelector('#msg-exist-income').style.display = 'block';
            document.querySelector('#msg-config-income').style.display = 'none';
        }
        else{
            RegistrarIngreso(id);
        }
    } catch (error) {
        console.log(error);
    }
}
async function RegistrarIngreso(id){
    const formData = new FormData();
    formData.append('idalumno',id);
    try {
        let resp = await fetch ('../controller/incomecontroller.php?op=guardar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            document.querySelector('#msg-config-income').style.display = 'block';
            document.querySelector('#msg-exist-income').style.display = 'none';
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
        hour: 'numeric',
        minute: '2-digit',
        hour12: true,
        timeZone: 'America/Lima'
    }
    return new Date(fechaHoraISO).toLocaleString('es-ES', options);
}

async function autocomplete(){
    document.querySelector("#lst-student").innerHTML = "";
    let search = document.querySelector("#search_input").value;
    if(search == ""){
        document.querySelector('.content-autocomplete').style.display = 'none';
    }
    const formData = new FormData();
    formData.append('campo',search)
    try {
        let resp = await fetch("../controller/incomecontroller.php?op=autocomplete",{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            let data = json.data;
            document.querySelector('.content-autocomplete').style.display = 'block';
            data.forEach((item) =>{
                let identificador = "";
                let newli = document.createElement("li");
                newli.id = "lst_"+item.Id_Alumno;
                if(item.Doc_Alumno =="" || item.Doc_Alumno==null){
                    identificador = item.Cod_Alumno;
                }
                else{
                    identificador = item.Doc_Alumno
                }
                newli.onclick = ()=> clickListElement(identificador);
                newli.innerHTML = `${identificador} - ${item.Nom_Alumno} ${item.Apa_Alumno} ${item.Ama_Alumno}`;
                document.querySelector("#lst-student").appendChild(newli);
            });
        }
    } catch (error) {
        console.log(error);
    }
}
async function autocompleteModal(){
    document.querySelector("#lst-student").innerHTML = "";
    let search = document.querySelector("#search_student").value;
    if(search == ""){
        document.querySelector('.content-autocomplete').style.display = 'none';
    }
    const formData = new FormData();
    formData.append('campo',search)
    try {
        let resp = await fetch("../controller/incomecontroller.php?op=autocomplete",{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if(json.status){
            let data = json.data;
            document.querySelector('.content-autocomplete').style.display = 'block';
            data.forEach((item) =>{
                let identificador = "";
                let newli = document.createElement("li");
                newli.id = "lst_"+item.Id_Alumno;
                if(item.Doc_Alumno =="" || item.Doc_Alumno==null){
                    identificador = item.Cod_Alumno;
                }
                else{
                    identificador = item.Doc_Alumno
                }
                let lsttext = `${identificador} - ${item.Nom_Alumno} ${item.Apa_Alumno} ${item.Ama_Alumno}`;
                newli.onclick = ()=> clickListElementModal(item.Id_Alumno,lsttext);
                newli.innerHTML = `${lsttext}`;
                document.querySelector("#lst-student").appendChild(newli);
            });
        }
    } catch (error) {
        console.log(error);
    }
}
function clickListElement(doc){
    if(doc != null || doc != ''){
        ElegirAlumno(doc);
        document.querySelector("#search_input").value = "";
        document.querySelector("#search_input").nextElementSibling.classList.remove('fijar');
        document.querySelector('.content-autocomplete').style.display = 'none';
    }
}
function clickListElementModal(id,texto){
    if(id != null || id != '' && texto != null || texto != ''){
        document.querySelector("#search_student").value = texto;
        document.querySelector('#idstudent').value = id;
        document.querySelector("#search_student").nextElementSibling.classList.add('fijar');
        document.querySelector('.content-autocomplete').style.display = 'none';
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
            let resp = await fetch ('../controller/incomecontroller.php?op=buscar',{
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
                    if(item.Tipo_Ingreso == 1){
                        estadoTexto = 'Asistió';
                    }
                    else if(item.Tipo_Ingreso == 2){
                        estadoTexto = 'Tardanza';
                    }
                    newtr.innerHTML = `<td class="opacity">${i}</td>
                                        ${item.Doc_Alumno !== null && item.Doc_Alumno !== '' ? `<td data-label="Identificador" class="rcab">${item.Doc_Alumno}</td>`:`<td data-label="Identificador">${item.Cod_Alumno}</td>`}
                                        <td data-label="Estudiante">${item.Nom_Alumno} ${item.Apa_Alumno} ${item.Ama_Alumno}</td>
                                        <td data-label="Grado y sección" >${item.Grado_Aula} - ${item.Seccion_Aula}</td>
                                        <td data-label="Fecha ingreso" >${FormatDate(item.Hora_Ingreso,item.Fecha_Ingreso)}</td>
                                        <td data-label="Fecha ingreso" >${FormatHora(item.Hora_Ingreso,item.Fecha_Ingreso)}</td>
                                        <td data-label="Estado"><span class="estado estado-${item.Tipo_Ingreso}">${estadoTexto}</span></td>
                                        `;
                    document.querySelector("#tblbodylista").appendChild(newtr);
                });
            }
        } catch (error) {
            console.log(error);
        }
    }
}
function QuitarFiltro(){
    document.querySelector("#search_input").value = "";
    document.querySelector("#search_input").nextElementSibling.classList.remove('fijar');
    date = document.querySelector("#search_date").value = "";
    Listar();
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
function ShowModal(){
    let modal_export = document.getElementById('modal-export');
    let formulario_modal = document.getElementById('formulario-modal');
    formulario_modal.reset();
    modal_export.classList.add('modal-show');
    document.querySelector('#tiporeporte').value = 0;
    document.querySelector('#tiporeporte').nextElementSibling.classList.remove('fijar');
    document.getElementById('report-aula').style.display = 'none';
    document.getElementById('report-fecha').style.display = 'none';
    document.getElementById('report-alumno').style.display = 'none';
    document.querySelector('#idaula').value = 0;
    document.querySelector('#idaula').nextElementSibling.classList.remove('fijar');
}
function CloseModal(){
    let modal_export = document.getElementById('modal-export');
    modal_export.classList.remove('modal-show');
}
function HabilitarInputs(){
    var radioaula = document.querySelectorAll('.input-radio_aula');
    var radiofecha = document.querySelectorAll('.input-radio_fecha');
    var radiofecha = document.querySelectorAll('.input-radio_alumno');
    radioaula.forEach(function (e) {
        e.addEventListener("change", function () {
            if (e.checked) {
                if (e.value === '1') {
                    document.getElementById('idaula').disabled = false;
                    document.getElementById('fechainicio_aula').disabled = false;
                    document.getElementById('fechafin_aula').disabled = false;
                    document.getElementById('fechafin_aula').nextElementSibling.textContent += ' *';
                } else if (e.value === '2') {
                    document.getElementById('idaula').disabled = false;
                    document.getElementById('fechainicio_aula').disabled = false;
                    document.getElementById('fechafin_aula').disabled = true;
                    document.getElementById('fechafin_aula').nextElementSibling.textContent = document.getElementById('fechafin_aula').nextElementSibling.textContent.replace(' *', '');
                }
            }
        });
    });
    radiofecha.forEach(function (e) {
        e.addEventListener("change", function () {
            if (e.checked) {
                if (e.value === '1') {
                    document.getElementById('search_student').disabled=false;
                    document.getElementById('fechainicio_fecha').disabled = false;
                    document.getElementById('fechafin_fecha').disabled = false;
                    document.getElementById('fechafin_fecha').nextElementSibling.textContent += ' *';
                }else if (e.value === '2') {
                    document.getElementById('search_student').disabled=false;
                    document.getElementById('fechainicio_fecha').disabled = false;
                    document.getElementById('fechafin_fecha').disabled = true;
                    document.getElementById('fechafin_fecha').nextElementSibling.textContent = document.getElementById('fechafin_fecha').nextElementSibling.textContent.replace(' *', '');
                }
            }
        })
    })
    radiofecha.forEach(function (e) {
        e.addEventListener("change", function () {
            if (e.checked) {
                if (e.value === '1') {
                    document.getElementById('fechainicio_alumno').disabled = false;
                    document.getElementById('fechafin_alumno').disabled = false;
                    document.getElementById('fechafin_alumno').nextElementSibling.textContent += ' *';
                }else if (e.value === '2') {
                    document.getElementById('fechainicio_alumno').disabled = false;
                    document.getElementById('fechafin_alumno').disabled = true;
                    document.getElementById('fechafin_alumno').nextElementSibling.textContent = document.getElementById('fechafin_alumno').nextElementSibling.textContent.replace(' *', '');
                }
            }
        })
    })
}
function SelectTipoReporte(){
    document.getElementById('tiporeporte').addEventListener('change', function () {
        var selectedValue = this.value;
        
        if (selectedValue === '1') {
            document.getElementById('report-aula').style.display = 'block';
            document.getElementById('report-fecha').style.display = 'none';
            document.getElementById('report-alumno').style.display = 'none';
            document.querySelectorAll('.input-form-date').forEach(function(e) {
                e.disabled = true;
            });
            document.querySelector('#idaula').disabled = true;
            
        } else if (selectedValue === '2') {
            document.getElementById('report-fecha').style.display = 'block';
            document.getElementById('report-aula').style.display = 'none';
            document.getElementById('report-alumno').style.display = 'none';
            document.querySelectorAll('.input-form-date').forEach(function(e) {
                e.disabled = true;
            });
        }
        else if (selectedValue === '3') {
            document.getElementById('report-fecha').style.display = 'none';
            document.getElementById('report-aula').style.display = 'none';
            document.getElementById('report-alumno').style.display = 'block';
            document.querySelectorAll('.input-form-date').forEach(function(e) {
                e.disabled = true;
            });
            document.querySelector('#search_student').disabled = true;
        }
    });
}
init();