<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;

class Home extends BaseController {

    private $usersModel;

    public function __construct() {
        $this->usersModel = new UserModel();
    }

    public function index() : string {
        return view('login');
    }

    public function arr_login(){
        #return redirect()->to('administrador');
        if ($this->request->isAJAX()){ }
        $arr = [];
        $arr = $this->usersModel->ini_contendido();
        $data = [
                    'css' => ['administrador/css/style.css'],
                    'js' => ['administrador/js/javascript.js'],
                    'respuesta' => $arr 
                ];
        return view('administrador',$data);
    }

    public function administrador() {
        #if($this->request->isAJAX()){ }
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        #var_dump($username);
        $arr = [];
        $arr = $this->usersModel->ini_contendido();
        $data = [
                    'css' => ['administrador/css/style.css'],
                    'js' => ['administrador/js/javascript.js'],
                    'respuesta' => $arr 
                ];
        return view('administrador',$data);
    }

    public function buscaExtArch(){
        if ($this->request->isAJAX()){  }
        $status =  true;
        $rutaactual =  $this->request->getPost('rutaactual');
        $aData =  $this->usersModel->buscaExtArch(array('rutaactual'=>$rutaactual));
        if (count($aData) >0 ){
            $status =  false;
        }
        echo json_encode(array(
            'status' => $status,
            'aData' => $aData,
        ));
    }

    public function arr_login_(){
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        //return redirect()->to('administrador');
        /*
        $session = session();
        $session->set([
            'username' => '16869726'
            'isLoggedIn' => true,
        ]);
        */
        //return redirect()->to('administrador');
        /*
        $user = $this->usersModel->where('username', $username)->first();
        if ($user && password_verify($password, $user['password'])) {
            // Aquí puedes configurar la sesión del usuario
            $session = session();
            $session->set([
                'username' => $user['username'],
                'isLoggedIn' => true,
            ]);
            return redirect()->to('/auth/administrador');
        } else {
            // Si la autenticación falla, redirigir al login con un mensaje de error
            return redirect()->back()->with('error', 'Usuario o contraseña incorrectos');
        }
        */
    }


    public function grabraExt() {
        if ($this->request->isAJAX()){  }
        $status                 =   true;    
        $tip                    =   $this->request->getPost("extension_principal");
        $rutaactual             =   strtolower($this->request->getPost("nomArch"));    
        $aData                  =   $this->usersModel->grabarExt($_POST);
        //**********************************************************************
        $fileControllCreado     =   'Controlador no Creado';
        $fileView               =   'Vista no Creada';
        $fileModel              =   'Modelo no Creado';
        $fileCss                =   'CSS no Creado';
        $fileJs                 =   'JavaScript no Creado';
        $files                  =   '<br>';
        $parentPath             =   '';
        if ($tip == 2)  { //Solo Crea los Directorios Cuando el Padre es Sub-Menu
            //Crea Archivo del Controller
            $file1              =   APPPATH."Controllers/".ucwords($rutaactual).'.php';
            $fileController     =   fopen($file1, "w+");
            $contController     =  '<?php' . PHP_EOL .
                                    'namespace App\Controllers;' . PHP_EOL . PHP_EOL .
                                    'use CodeIgniter\Controller;' . PHP_EOL . PHP_EOL .
                                    'use App\Models\UserModel; ' . PHP_EOL . PHP_EOL .
                                    'class ' . $rutaactual . ' extends Controller {' . PHP_EOL . PHP_EOL .
                                    '   var $empresa;' . PHP_EOL . PHP_EOL .
                                    '   function __construct() {' . PHP_EOL .
                                    '       parent::__construct();' . PHP_EOL .
                                    '   }' . PHP_EOL . PHP_EOL .
                                    '   public function index() {' . PHP_EOL .
                                    '       echo view("' . $rutaactual . '/' . $rutaactual . '_view");' . PHP_EOL .
                                    '   }' . PHP_EOL . PHP_EOL .
                                    '}' . PHP_EOL;

            fwrite($fileController, $contController);
            fclose($fileController);
            
            if(file_exists($file1)){
                $fileControllCreado     =   $file1;
            }
            //Crea Archivo del Modelo
            $file2          =   APPPATH.'Models/' . ucwords($rutaactual) . '_model.php';
            $fileModel      =   fopen($file2, "w+");
            $contModel      = '<?php' . PHP_EOL .
                                ' namespace App\Models;' . PHP_EOL . PHP_EOL .
                                ' use CodeIgniter\Model;' . PHP_EOL . PHP_EOL .
                                ' class ' . $rutaactual . '_model extends Model {' . PHP_EOL . PHP_EOL .
                                '   var $own    = "ADMIN";' . PHP_EOL .
                                '   var $ownGu  = "GUADMIN";' . PHP_EOL . PHP_EOL .
                                '   public function __construct() {' . PHP_EOL . PHP_EOL .
                                '       parent::__construct();' . PHP_EOL . PHP_EOL .
                                '   }' . PHP_EOL . PHP_EOL .
                                '}' . PHP_EOL;

            fwrite($fileModel, $contModel);
            fclose($fileModel);
            if (file_exists($file2)){
                $fileModel = $file2;
            }

            //Crea Archivo de la Vista
            mkdir(APPPATH."Views/$rutaactual",0700);
            $file3      =   APPPATH.'Views/' . $rutaactual . '/' . $rutaactual . '_view.php';
            $fileView   =   fopen($file3, "w+");
            $contView   =   ' Vista ' . $rutaactual . '.';
            fwrite($fileView,$contView);
            fclose($fileView);
            if (file_exists($file3)) {
                $fileView = $file3;
            }

            $parentPath     = dirname(APPPATH)."/public/";
            mkdir($parentPath."assets/$rutaactual", 0700);
            mkdir($parentPath."assets/$rutaactual/css", 0700);
            mkdir($parentPath."assets/$rutaactual/js", 0700);
            mkdir($parentPath."assets/$rutaactual/img", 0700);

            $file4      = $parentPath.'assets/' . $rutaactual . '/css/styles.css';
            $fileCss    = fopen($file4, "w+");
            $contCss    = ' /*Contenido CSS de la Extensión ' . $rutaactual . '.*/';
            fwrite($fileCss,$contCss);
            fclose($fileCss);
            if(file_exists($file4)) {
                $fileCss =  $file4;
            }
            $file5      =   $parentPath.'assets/' . $rutaactual . '/js/javascript.js';
            $fileJs     =   fopen($file5, "w+");
            $contJs     =   '//Contenido JS de la Extensión ' . $rutaactual . '.' . PHP_EOL . PHP_EOL .
                            '$(function () {' . PHP_EOL . PHP_EOL .
                            '   console.log("SYSDATE"); ' . PHP_EOL .
                            '});' . PHP_EOL ;
            fwrite($fileJs, $contJs);
            fclose($fileJs);
            if(file_exists($file5)){
                $fileJs = $file5;
            }

            $files .= 'Archivos Creados:<br>';
            $files .= $fileControllCreado . '<br>';
            $files .= $fileView . '<br>';
            $files .= $fileModel . '<br>';
            $files .= $fileCss . '<br>';
            $files .= $fileJs . '<br>';
        }
        echo json_encode(array(
            'post' => $_POST,
            'return' => $aData,
            'status' => $status,
            'tip' => $tip,
            'files' => $files,
            'parentPath' => $parentPath,
        ));
    }

    public function creaPrivilegio() {
        if ($this->request->isAJAX()){  }
        $status     =   true;
        $nombre     =   $this->request->getPost("nombre");
        $return     =   $this->usersModel->creaPrivilegio($nombre);
        echo json_encode(array(
            'nombre'          =>  $nombre,
            'status'          =>  $status,
        ));
    }

    public function actualiza_privilegio() {
        if ($this->request->isAJAX()){  }
        $status = true;
        $PER_ID = $this->request->getPost("PER_ID");
        $v_bool = $this->request->getPost("v_bool");
        $return = $this->usersModel->actualiza_Privilegio([
            'PER_ID' =>  $PER_ID,
            'v_bool' =>  $v_bool
        ]);
        echo json_encode(array(
            'status' =>  $status,
            'return' =>  $return
        ));
    }

    public function fn_valida_cuenta_esissan() {
        if ($this->request->isAJAX()){  }
        $status = true;
        $data_return = [];
        $data_return = $this->usersModel->valida_cuenta_esissan_anatomia([
            'run' => $this->request->getPost("run"),
            'dv' => $this->request->getPost("dv")
        ]);
        echo json_encode([
            'status' => $status,
            'return_bd' => $data_return,
        ]);            
    }

    public function fn_gestion_perfil(){
        if ($this->request->isAJAX()){  }
        $data_return =   [];    
        $status =   true;
        $data_return =   $this->usersModel->grabaUsu(['post'=>$this->request->getPost()]);
        echo json_encode([
            'data_return' =>  $data_return,
            'status' =>  $status,
            'post' =>  $_POST,
        ]);   
    }

    public function buscaEditar(){
        if ($this->request->isAJAX()){  }
        $status = true;    
        $idMen = $this->request->getPost("idMen");
        $ind_tipo_menu = $this->request->getPost("ind_tipo_menu");
        $data_return = $this->usersModel->buscaExtEdit(['idMen'=>$idMen]);
        echo json_encode([
            'arr_bd' => $data_return,
            'idMen' => $idMen,
            'status' => $status,
        ]); 
    }

    public function editExtension() {
        $postData = $this->request->getPost();
        // Log para depuración
        // log_message('debug', 'Post data: ' . json_encode($postData));
        // Verifica si los datos necesarios están presentes
        /*
        if (!isset($postData['idMen']) || !isset($postData['nombre']) || !isset($postData['listarMenup']) || !isset($postData['extension_principal']) || !isset($postData['check']) || !isset($postData['arrPrivilegios']) || !isset($postData['bool_checked'])) {
            echo json_encode([
                'status' => false,
                'message' => 'Faltan datos necesarios en la solicitud.',
                'postData' => $postData
            ]);
            return;
        }
        */
        $data_return = $this->usersModel->editando_extension_last(['post' => $postData]);
        echo json_encode([
            'status' => $data_return['status'],
            'data_return' => $data_return,
        ]);
    }
    
}