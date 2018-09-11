<?php
namespace App;

use App\Core\Configuration\ConfigurationManager;

class App {
    public static function create() {
        $config = include 'etc/env.php';
        $configManager = ObjectManager::getObject(ConfigurationManager::class);

        $dbConfig = $config['databaseConnection'];
        $connectionType = array_shift($dbConfig);
        $dbClassName = "\\App\\Core\\Model\\Connection\\{$connectionType}Connection";
        $dbInstance = new $dbClassName(...array_values($dbConfig));
        ObjectManager::initObject(\App\Core\Model\Connection::class, $dbInstance);

        \App\Routers::route();
    }
}