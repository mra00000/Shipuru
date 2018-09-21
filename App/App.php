<?php
namespace App;

use App\Core\Configuration\ConfigurationManager;
use App\Core\Model\Connection\MysqlConnection;
use App\Core\Model\Connection\PDOMysqlConnection;

class App {
    public static function create() {
        $config = include 'etc/env.php';
        $configManager = ObjectManager::getObject(ConfigurationManager::class);

        $dbConfig = $config['databaseConnection'];
        $connectionType = array_shift($dbConfig);
        $dbInstance = null;

        switch ($connectionType) {
            case 'Mysql':
                $dbInstance = new MysqlConnection(...array_values($dbConfig));
                break;
            case 'PDO':
                $dbInstance = new PDOMysqlConnection(
                    "mysql:host={$dbConfig['host']}:{$dbConfig['port']};dbName={$dbConfig['dbName']}",
                    $dbConfig['user'], $dbConfig['pass']
                );
                break;
        }
        ObjectManager::initObject(Core\Model\Connection::class, $dbInstance);

        Routers::route();
    }
}