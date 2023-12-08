<?php 
namespace App\Models;

use CodeIgniter\Model;

class ModelLogin extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function hola_mundo(){
       return "Hola mundo";
    }

    public function test(){
        $db = db_connect();
        $query = $db->table('ADMIN.HO_LISTA_TOTEMANGOL')->select('*')->get(); // Nombre de tu tabla
        $result = $query->getResultArray(); // Obtiene los resultados
        return $result; // Devuelve los resultados
    }

    public function isDbConnected(){
        $db     =   db_connect();
        try {
            // Ejecuta una consulta simple (por ejemplo, seleccionar la hora actual)
            $db->query("SELECT 1 FROM dual");
            return true; // La conexión es exitosa
        } catch (\Exception $e) {
            // Maneja la excepción si ocurre algún error
            return false; // La conexión falló
        }
    }
} 
