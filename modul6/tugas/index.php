<?php

require_once 'vendor/autoload.php';
require_once 'src/Config/config.php';

use Src\Config\Database;
use Src\Handler\StoreValueHandler;
use Src\Handler\SseHandler;
use Src\Handler\ViewHandler;
use Src\Route;

date_default_timezone_set("Asia/Jakarta");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');

$db = new Database;
$connection = $db->getConnection();

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$storeValueHandler = new StoreValueHandler($connection);
// $sseHandler = new SseHandler($connection);
$viewHandler = new ViewHandler;

$route = new Route;
$route->handle($method, $path, array(
    // [
    //     'method' => "GET",
    //     "path" => '/sse',
    //     'handler' => $sseHandler
    // ],
    [
        'method' => "POST",
        "path" => '/',
        'handler' => $storeValueHandler
    ],
    [
        'method' => "GET",
        "path" => '/',
        'handler' => $viewHandler
    ],
));

$db->close();
