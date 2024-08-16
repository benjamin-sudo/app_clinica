<?php

namespace Config;

use CodeIgniter\Database\Config;
/**
 * Database Configuration
 */
class Database extends Config {
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to
     * use if no other is specified.
     */
    public string $defaultGroup = 'default';
    /**
     * The default database connection.
     */
    public array $default = [
        'DSN'           =>  '',
        'hostname'      =>  'mysql_6',
        'username'      =>  'ADMIN',
        'password'      =>  'SafeProd2024!',
        'database'      =>  'ADMIN',
        'DBDriver'      =>  'MySQLi',
        'DBPrefix'      =>  '',
        'pConnect'      =>  false,
        'DBDebug'       =>  true,
        'charset'       =>  'utf8',
        'DBCollat'      =>  'utf8_general_ci',
        'swapPre'       =>  '',
        'encrypt'       =>  false,
        'compress'      =>  false,
        'strictOn'      =>  false,
        'failover'      =>  [],
        'port'          =>  3306,
        'numberNative'  =>  false,
    ];

    public $oracle      =   [
        'DSN'           =>  '',
        'hostname'      =>  'oracle', // O 'oracle' si está en otro contenedor Docker
        'username'      =>  'ADMIN',
        'password'      =>  'SafeProd2024!',
        'database'      =>  'FREEPDB1',
        'DBDriver'      =>  'OCI8',
        'DBPrefix'      =>  '', // Ajusta según necesidad
        'pConnect'      =>  false,
        'DBDebug'       =>  (ENVIRONMENT !== 'production'),
        'charset'       =>  'utf8',
        'DBCollat'      =>  'utf8_general_ci',
        'port'          =>  6000, // Puerto mapeado en Docker
    ];

    public $oraclePDO   = [
        'DSN'           =>  'oci:dbname=//oracle:6000/FREEPDB1;charset=utf8', // Ajusta el DSN según tus necesidades
        'hostname'      =>  '', // No necesario para PDO
        'username'      =>  'ADMIN',
        'password'      =>  'SafeProd2024!',
        'database'      =>  '', // No necesario para PDO, ya que está en DSN
        'DBDriver'      =>  'PDO',
        'DBPrefix'      =>  '', // Ajusta según necesidad
        'pConnect'      =>  false,
        'DBDebug'       =>  (ENVIRONMENT !== 'production'),
        'charset'       =>  'utf8',
        'DBCollat'      =>  'utf8_general_ci',
        'port'          =>  6000, // No siempre es necesario para PDO, depende del DSN
    ];



    /**
     * This database connection is used when
     * running PHPUnit database tests.
     */
    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => 'utf8_general_ci',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
    ];

    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
