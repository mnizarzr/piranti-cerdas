<?php

require_once 'vendor/autoload.php';
require_once 'src/Config/config.php';

use Hhxsv5\SSE\Event;
use Hhxsv5\SSE\SSE;
use Hhxsv5\SSE\StopSSEException;

date_default_timezone_set("Asia/Jakarta");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: *');

use Src\Config\Database;

class SseHandler
{

    public $lastFetchedId;
    public $pdo;

    public function __construct()
    {
        $db = new Database;
        $this->pdo = $db->getConnection();
    }

    public function __invoke()
    {
        header("X-Accel-Buffering: no");
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        $callback = function () {

            $data = [];

            $stmt = $this->pdo->query('SELECT * FROM modul6 ORDER BY `datetime` DESC LIMIT 1');
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($data)) {
                return false;
            }

            $shouldStop = false;
            if ($shouldStop) {
                throw new StopSSEException();
            }

            return json_encode($data[0]);
        };
        (new SSE(new Event($callback, 'mpus', 1000)))->start();
    }
}

$sseHandler = new SseHandler;
$sseHandler();
