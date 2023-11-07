<?php
require_once "../model/studentmodel.php";
class studentController
{
    private $studentModel;
    public function __construct()
    {
        $this->studentModel = new Estudiante();
    }
    private function DataForm()
    {
        return array_map('trim', $_POST);
    }
    public function studentMethod($op)
    {
        switch ($op) {
            case 'listar':
                $data = array();
                $arrayResponse = array('status' => false, 'data' => '');
                $rspta = $this->studentModel->Listar();
                while ($obj = $rspta->fetch_object()) {
                    array_push($data, $obj);
                }
                $options = '';
                if (!empty($data)) {
                    for ($i = 0; $i < count($data); $i++) {
                        $idstudent = $data[$i]->Id_Alumno;
                        $options = '';
                        if ($data[$i]->Qr_Alumno === null || $data[$i]->Qr_Alumno === "") {
                            $options .= '<a href="studentform.php?id=' . $idstudent . '" class="fa-solid fa-tags" title="Generar QR"> </a>';
                        } else {
                            $options .= '<a href="studentform.php?id=' . $idstudent . '" class="fa-solid fa-tags" title="Ver codigo QR"> </a>';
                        }
                        $options .= '
                        <a href="studentform.php?id=' . $idstudent . '" class="fa-solid fa-tags" title="Modificar"> </a> 
                        <a class="fa-solid fa-trash-can" onclick="Eliminar(' . $idstudent . ')" title="Eliminar"></a>
                        ';
                        $data[$i]->options  = $options;
                    }
                    $arrayResponse['status'] = true;
                    $arrayResponse['data'] = $data;
                }
                echo json_encode($arrayResponse);
                break;
            case 'guardaryeditar':
                if ($_POST) {
                    $data = $this->DataForm();
                    if (!file_exists($_FILES['foto']['tmp_name']) || !is_uploaded_file($_FILES['foto']['tmp_name'])) {
                        $data['imagenactual'] = null;
                    } else {
                        $ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                        if ($_FILES['foto']['type'] == "image/jpg" || $_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png") {
                            $data['imagenactual'] = "photo_" . $data['dni'] . ".jpg";
                            move_uploaded_file($_FILES["foto"]["tmp_name"], "../src/img-student/" . $data['imagenactual']);
                        }
                    }
                    if (empty($data["id"])) {
                        if (empty($data["dni"]) || empty($data["nombre"]) || empty($data["apellido"]) || empty($data["idaula"])) {
                            $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                        } else {
                            unset($data['id']);
                            unset($data['submit']);
                            $data['qr'] = null;
                            $rspta = $this->studentModel->Insertar(...$data);
                            if ($rspta) {
                                require "../lib/phpqrcode/qrlib.php";
                                $data['qr'] = "qr_" . $data['dni'] . ".png";
                                QRcode::png($data['dni'], "../src/qr-student/" . $data['qr'], "L", 10, 5);
                                $this->studentModel->GenerarQR($data['dni'], $data['qr']);
                                $arrayResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                            } else {
                                $arrayResponse = array('status' => false, 'msg' => 'Error al guardar los datos');
                            }
                        }
                    } else {
                        if (empty($data["dni"]) || empty($data["nombre"]) || empty($data["apellido"]) || empty($data["idaula"])) {
                            $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                        } else {
                            unset($data['submit']);
                            unset($data['foto']);
                            $rspta = $this->studentModel->Editar(...$data);
                            if ($rspta) {
                                $arrayResponse = array('status' => true, 'msg' => 'Datos modificados correctamente');
                            } else {
                                $arrayResponse = array('status' => false, 'msg' => 'Error al modificar los datos');
                            }
                        }
                    }
                    echo json_encode($arrayResponse);
                }
                break;
            case 'mostrar':
                if ($_POST) {
                    $idalumno = intval($_POST['idalumno']);
                    $rspta = $this->studentModel->Mostrar($idalumno);
                    $rspta = $rspta->fetch_object();
                    if (empty($rspta)) {
                        $arrayResponse = array('status' => false, 'msg' => 'Datos no encontrados');
                    } else {
                        $arrayResponse = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $rspta);
                    }
                    echo json_encode($arrayResponse);
                }
                break;
            case 'eliminar':
                if ($_POST) {
                    if (empty($_POST['idalumno'])) {
                        $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                    } else {
                        $idalumno = intval($_POST['idalumno']);
                        $rspta = $this->studentModel->Eliminar($idalumno);
                        if ($rspta) {
                            $arrayResponse = array('status' => true, 'msg' => 'Registro eliminado exitosamente');
                        } else {
                            $arrayResponse = array('status' => false, 'msg' => 'No se puedo eliminar el registro');
                        }
                    }
                    echo json_encode($arrayResponse);
                }
                break;
            case 'buscar':
                if ($_POST) {
                    $data = array();
                    if (empty($_POST["search_input"])) {
                        $arrayResponse = array('status' => false, 'msg' => "Error de datos");
                    } else {
                        $search = trim($_POST["search_input"]);
                        $arrayResponse = array('status' => false, 'found' => 0, 'data' => '');
                        $rspta = $this->studentModel->Buscar($search);
                        while ($obj = $rspta->fetch_object()) {
                            array_push($data, $obj);
                        }
                        if (!empty($data)) {
                            $arrayResponse = array('status' => true, 'found' => count($data), 'data' => $data);
                        }
                    }
                    echo json_encode($arrayResponse);
                }
                break;
        }
    }
}
$controller = new studentController();
$op = $_REQUEST["op"];

$controller->studentMethod($op);
