<?php
require_once '../model/ingresomodel.php';
class IncomeController
{
    private $incomeModel;
    public function __construct()
    {
        $this->incomeModel = new Ingreso();
    }
    public function IncomeMethod($op)
    {
        switch ($op) {
            case 'listar':
                $data = array();
                $arrayResponse = array('status' => false, 'data' => '');
                $rspta = $this->incomeModel->ListarIngreso();
                while ($obj = $rspta->fetch_object()) {
                    array_push($data, $obj);
                }
                if (!empty($data)) {
                    $arrayResponse = array('status' => true, 'found' => count($data), 'data' => $data);
                }
                echo json_encode($arrayResponse);
                break;
            case 'elegir':
                if ($_POST) {
                    $doc = $_POST['doc'];
                    $rspta = $this->incomeModel->ElegirAlumno($doc);
                    $rspta = $rspta->fetch_object();
                    if (empty($rspta)) {
                        $arrayResponse = array('status' => false, 'msg' => 'Datos no encontrados');
                    } else {
                        $arrayResponse = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $rspta);
                    }
                    echo json_encode($arrayResponse);
                }

                break;
            case 'validar':
                if ($_POST) {
                    $idalumno = intval($_POST['idalumno']);
                    $rspta = $this->incomeModel->ValidarIngreso($idalumno);
                    $rspta = $rspta->fetch_object();
                    if (empty($rspta)) {
                        $arrayResponse = array('status' => false, 'msg' => 'Datos no encontrados');
                    } else {
                        $arrayResponse = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $rspta);
                    }
                    echo json_encode($arrayResponse);
                }
                break;
            case 'guardar':
                if ($_POST) {
                    $idalumno = intval($_POST['idalumno']);
                    $rspta = $this->incomeModel->RegistrarIngreso($idalumno);
                    if ($rspta) {
                        $arrayResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                    } else {
                        $arrayResponse = array('status' => false, 'msg' => 'Error al guardar los datos');
                    }
                    echo json_encode($arrayResponse);
                }
                break;
            case 'autocomplete':
                if ($_POST) {
                    $data = array();
                    if (!empty($_POST["campo"])) {
                        $search = trim($_POST["campo"]);
                        $arrayResponse = array('status' => false, 'found' => 0, 'data' => '');
                        $rspta = $this->incomeModel->BuscarAlumno($search);
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
            case 'buscar':
                if ($_POST) {
                    $data = array();
                    if (empty($_POST['datotexto']) && empty($_POST['datofecha'])) {
                        $arrayResponse = array('status' => false, 'msg' => "Error de datos");
                    } else {
                        $datofecha = trim($_POST['datofecha']);
                        $datotexto = trim($_POST['datotexto']);
                        $arrayResponse = array('status' => false, 'found' => 0, 'data' => '');
                        $rspta = $this->incomeModel->Buscar($datotexto, $datofecha);
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
            case 'listarselectaula':

                $rspta = $this->incomeModel->ListarAulaVigente();
                $data = array();
                $arrayResponse = array('status' => false, 'data' => '');
                while ($obj = $rspta->fetch_object()) {
                    array_push($data, $obj);
                }
                if (!empty($data)) {
                    $arrayResponse = array('status' => true, 'found' => count($data), 'data' => $data);
                }
                echo json_encode($arrayResponse);
                break;
        }
    }
}
$controller = new IncomeController();
$op = $_REQUEST["op"];

$controller->IncomeMethod($op);
