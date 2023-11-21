<?php
require_once "../model/activitymodel.php";
class activityController
{
    private $activityModel;
    public function __construct()
    {
        $this->activityModel = new Actividad();
    }
    private function DataForm()
    {
        return array_map('trim', $_POST);
    }
    public function activityMethod($op)
    {
        switch ($op) {
            case 'listar':
                $data = array();
                $arrayResponse = array('status' => false, 'data' => '');
                $rspta = $this->activityModel->Listar();
                while ($obj = $rspta->fetch_object()) {
                    array_push($data, $obj);
                }
                if (!empty($data)) {
                    for ($i = 0; $i < count($data); $i++) {
                        $idactivity = $data[$i]->Id_Actividad;
                        $options = '
                        <a href="activityform.php?id=' . $idactivity . '&rute=aactivity" class="fa-solid fa-tags" title="Modificar"> </a>
                        <a class="fa-solid fa-trash-can" onclick="Eliminar(' . $idactivity . ')" title="Eliminar"></a>
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
                        if (empty($data["tipoactividad"]) || empty($data["fechainicio"]) || empty($data["hora"]) || empty($data["motivo"])) {
                            $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                        } else {
                            if ($data['tipoactividad'] == 2) {
                                $data['fechafin'] = $data['fechainicio'];
                            }
                            unset($data['id']);
                            unset($data['submit']);
                            $rspta = $this->activityModel->Insertar(...$data);
                            if ($rspta) {
                                $arrayResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                            } else {
                                $arrayResponse = array('status' => false, 'msg' => 'Error al guardar los datos');
                            }
                        }
                    } else {
                        if (empty($data["fechainicio"]) || empty($data["hora"]) || empty($data["motivo"])) {
                            $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                        } else {
                            unset($data['submit']);
                            unset($data['tipoactividad']);
                            unset($data['fechafin']);
                            $rspta = $this->activityModel->Editar(...$data);
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
                    $idalumno = intval($_POST['idactividad']);
                    $rspta = $this->activityModel->Mostrar($idalumno);
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
                    if (empty($_POST['idactividad'])) {
                        $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                    } else {
                        $idactividad = intval($_POST['idactividad']);
                        $rspta = $this->activityModel->Eliminar($idactividad);
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
                    if (empty($_POST['datotexto']) && empty($_POST['datofecha'])) {
                        $arrayResponse = array('status' => false, 'msg' => "Error de datos");
                    } else {
                        $datofecha = trim($_POST['datofecha']);
                        $datotexto = trim($_POST['datotexto']);
                        $arrayResponse = array('status' => false, 'found' => 0, 'data' => '');
                        $rspta = $this->activityModel->Buscar($datotexto, $datofecha);
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
$controller = new activityController();
$op = $_REQUEST["op"];

$controller->activityMethod($op);
