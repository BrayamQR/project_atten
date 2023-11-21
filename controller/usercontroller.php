<?php
require_once "../model/usermodel.php";
include('../config/session.php');
class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Usuario();
    }

    private function DataForm()
    {
        return array_map('trim', $_POST);
    }

    public function userMethod($op)
    {
        switch ($op) {
            case 'listar':
                $data = array();
                $arrayResponse = array('status' => false, 'data' => '');
                $rspta = $this->userModel->Listar();
                while ($obj = $rspta->fetch_object()) {
                    array_push($data, $obj);
                }
                if (!empty($data)) {
                    for ($i = 0; $i < count($data); $i++) {
                        $idusuario = $data[$i]->Id_Usuario;
                        $options = '
                            <a onclick ="RestaurarPassword(' . $idusuario . ')"class="fa-solid fa-arrow-rotate-left" title="Restaurar Contraseña"> </a> 
                            <a href="userform.php?id=' . $idusuario . '&rute=auser" class="fa-solid fa-tags" title="Modificar"> </a>
                            <a class="fa-solid fa-trash-can" onclick="Eliminar(' . $idusuario . ')" title="Eliminar"></a>';
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
                        if (empty($data["codigo"]) || empty($data["nombre"]) || empty($data["apellido"]) || empty($data["telefono"]) || empty($data["email"]) || empty($data["direccion"]) || empty($data["user"]) || empty($data["password"]) || empty($data["confipass"]) || empty($data["idtipo"])) {
                            $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                        } else {
                            unset($data['id']);
                            unset($data['confipass']);
                            unset($data['submit']);

                            $rspta = $this->userModel->Insertar(...$data);
                            if ($rspta) {
                                $arrayResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                            } else {
                                $arrayResponse = array('status' => false, 'msg' => 'Error al guardar los datos');
                            }
                        }
                    } else {
                        if (empty($data["codigo"]) || empty($data["nombre"]) || empty($data["apellido"]) || empty($data["telefono"]) || empty($data["email"]) || empty($data["direccion"]) || empty($data["user"]) || empty($data["password"]) || empty($data["confipass"]) || empty($data["idtipo"])) {
                            $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                        } else {
                            unset($data['confipass']);
                            unset($data['submit']);

                            $rspta = $this->userModel->Editar(...$data);
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
                    $idusuario = intval($_POST['idusuario']);
                    $rspta = $this->userModel->Mostrar($idusuario);
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
                    if (empty($_POST['idusuario'])) {
                        $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                    } else {
                        $idusuario = intval($_POST['idusuario']);
                        $rspta = $this->userModel->Eliminar($idusuario);
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
                        $rspta = $this->userModel->Buscar($search);
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
            case 'listarselect':
                $rspta = $this->userModel->ListarVigentes();
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
            case 'restaurarpassword':
                if ($_POST) {
                    $idusuario = intval($_POST['idusuario']);
                    $password = trim($_POST['password']);
                    $rspta = $this->userModel->RestaurarPassword($idusuario, $password);
                    if ($rspta) {
                        $arrayResponse = array('status' => true, 'msg' => 'Contraseña restaurada correctamente');
                    } else {
                        $arrayResponse = array('status' => false, 'msg' => 'Error al restaurada la contraseña');
                    }

                    echo json_encode($arrayResponse);
                }
                break;
        }
    }
}

$controller = new UserController();
$op = $_REQUEST["op"];

$controller->userMethod($op);
