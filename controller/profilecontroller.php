<?php
require_once "../model/profilemodel.php";
class profileController
{
    private $profileModel;
    public function __construct()
    {
        $this->profileModel = new Perfil();
    }
    private function DataForm()
    {
        return array_map('trim', $_POST);
    }
    public function profileMethod($op)
    {
        switch ($op) {
            case 'listar':
                $data = array();
                $arrayResponse = array('status' => false, 'data' => '');
                $rspta = $this->profileModel->Listar();
                while ($obj = $rspta->fetch_object()) {
                    array_push($data, $obj);
                }
                if (!empty($data)) {
                    for ($i = 0; $i < count($data); $i++) {
                        $idtipousuario = $data[$i]->Id_TipoUsuario;
                        $options = '
                        <a class="fa-solid fa-eye" onclick="MostrarPermisos(' . $idtipousuario . ')" title="Ver permisos"> </a> 
                        <a class="fa-solid fa-trash-can" onclick="Eliminar(' . $idtipousuario . ')" title="Eliminar"></a>
                        ';
                        $data[$i]->options  = $options;
                    }
                    $arrayResponse['status'] = true;
                    $arrayResponse['data'] = $data;
                }
                echo json_encode($arrayResponse);
                break;
            case 'cambiarestado':
                if ($_POST) {
                    if (empty($_POST['idtipousuario'])) {
                        $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                    } else {
                        $idtipousuario = intval($_POST['idtipousuario']);
                        $estado = $_POST['estado'];
                        if ($estado)
                            $rspta = $this->profileModel->CambiarEstado($idtipousuario, $estado);
                        if ($rspta) {
                            $arrayResponse = array('status' => true, 'msg' => 'Se cambio el estado exitosamente');
                        } else {
                            $arrayResponse = array('status' => false, 'msg' => 'No se puedo cambiar el estado');
                        }
                    }
                    echo json_encode($arrayResponse);
                }
                break;
            case 'guardaryeditar':
                if ($_POST) {
                    $data = $this->DataForm();
                    if (empty($data['id'])) {
                        unset($data['id']);
                        unset($data['submit']);
                        $rspta = $this->profileModel->InsertarPermisos(...$data);
                        if ($rspta) {
                            $arrayResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                        } else {
                            $arrayResponse = array('status' => false, 'msg' => 'Error al guardar los datos');
                        }
                    } else {
                        unset($data['submit']);
                        unset($data['idtipo']);
                        $rspta = $this->profileModel->EditarPermisos(...$data);
                        if ($rspta) {
                            $arrayResponse = array('status' => true, 'msg' => 'Datos modificados correctamente');
                        } else {
                            $arrayResponse = array('status' => false, 'msg' => 'Error al modificar los datos');
                        }
                    }
                    echo json_encode($arrayResponse);
                }

                break;
            case 'mostrarpermisos':
                if ($_POST) {
                    $idtipo = intval($_POST['idtipo']);
                    $rspta = $this->profileModel->MostrarPermisos($idtipo);
                    $rspta = $rspta->fetch_object();
                    if (empty($rspta)) {
                        $arrayResponse = array('status' => false, 'msg' => 'Datos no encontrados');
                    } else {
                        $arrayResponse = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $rspta);
                    }
                    echo json_encode($arrayResponse);
                }
                break;
            case 'guardarperfil':
                if ($_POST) {
                    if (empty($_POST['perfil'])) {
                        $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                    } else {
                        $perfil = trim($_POST['perfil']);
                        $rspta = $this->profileModel->InsertarPerfil($perfil);
                        if ($rspta) {
                            $arrayResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                        } else {
                            $arrayResponse = array('status' => false, 'msg' => 'Error al guardar los datos');
                        }
                    }
                    echo json_encode($arrayResponse);
                }
                break;
            case 'eliminarperfil':
                if ($_POST) {
                    if (empty($_POST['idtipo'])) {
                        $arrayResponse = array('status' => false, 'msg' => 'Error de datos');
                    } else {
                        $idtipo = intval($_POST['idtipo']);
                        $rspta = $this->profileModel->EliminarPerfil($idtipo);
                        if ($rspta) {
                            $arrayResponse = array('status' => true, 'msg' => 'Registro eliminado exitosamente');
                        } else {
                            $arrayResponse = array('status' => false, 'msg' => 'No se puedo eliminar el registro');
                        }
                    }
                    echo json_encode($arrayResponse);
                }
                break;
        }
    }
}
$controller = new profileController();
$op = $_REQUEST["op"];

$controller->profileMethod($op);
