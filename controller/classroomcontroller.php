<?php
require_once '../model/aulamodel.php';

class classroomController
{
    private $classroomModel;
    public function __construct()
    {
        $this->classroomModel = new Aula();
    }
    private function DataForm()
    {
        return array_map('trim', $_POST);
    }
    public function classroomMethod($op)
    {
        switch ($op) {
            case 'listar':
                $data = array();
                $arrayResponse = array('status' => false, 'data' => '');
                $rspta = $this->classroomModel->Listar();
                while ($obj = $rspta->fetch_object()) {
                    array_push($data, $obj);
                }
                if (!empty($data)) {
                    for ($i = 0; $i < count($data); $i++) {
                        $idclassroom = $data[$i]->Id_Aula;
                        $options = '<a href="classroomform.php?id=' . $idclassroom . '&rute=aclassroom" class="fa-solid fa-tags" title="Modificar"> </a> 
                        <a class="fa-solid fa-trash-can" onclick="Eliminar(' . $idclassroom . ')" title="Eliminar"></a>
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
                    if (empty($data["id"])) {
                        if (empty($data["grado"]) || empty($data["seccion"]) || empty($data["nivel"]) || empty($data["tutor"])) {
                            $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                        } else {
                            unset($data['id']);
                            unset($data['submit']);
                            $rspta = $this->classroomModel->Insertar(...$data);
                            if ($rspta) {
                                $arrayResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                            } else {
                                $arrayResponse = array('status' => false, 'msg' => 'Error al guardar los datos');
                            }
                        }
                    } else {
                        if (empty($data["grado"]) || empty($data["seccion"]) || empty($data["nivel"]) || empty($data["tutor"])) {
                            $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                        } else {
                            unset($data['submit']);
                            $rspta = $this->classroomModel->Editar(...$data);
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
                    $idaula = intval($_POST['idaula']);
                    $rspta = $this->classroomModel->Mostrar($idaula);
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
                    if (empty($_POST['idaula'])) {
                        $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                    } else {
                        $idaula = intval($_POST['idaula']);
                        $rspta = $this->classroomModel->Eliminar($idaula);
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
                        $rspta = $this->classroomModel->Buscar($search);
                        while ($obj = $rspta->fetch_object()) {
                            array_push($data, $obj);
                        }
                        if (!empty($data)) {
                            $arrayResponse = array('status' => true, 'found' => count($data), 'data' => $data);
                        }
                    }
                    echo json_encode($arrayResponse);
                }
        }
    }
}
$controller = new classroomController();
$op = $_REQUEST["op"];

$controller->classroomMethod($op);
