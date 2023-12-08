
<?php 

namespace App\Models;

use CodeIgniter\Model;

class Administrador_model {

	public function __construct() {
		parent::__construct();
	}

	public function test(){
        //$db = db_connect('oracle');
        //var_dump($db );
        /*
        $extensions = get_loaded_extensions();
        foreach ($extensions as $ext) {
            echo $ext . "<br>";
        }
        if (extension_loaded('oci8')) {
            echo "La extensión oci8 está instalada.";
        } else {
            echo "La extensión oci8 no está instalada.";
        }
        echo "<br>";
        if (extension_loaded('MySQLi')) {
            echo "La extensión MySQLi está instalada.";
        } else {
            echo "La extensión MySQLi no está instalada.";
        }
        echo "<br>";
        if (extension_loaded('PDO')) {
            echo "La extensión PDO está instalada.";
        } else {
            echo "La extensión PDO no está instalada.";
        }
        */
        return date("d-m-Y");
    }

}

