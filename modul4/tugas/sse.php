<?php

require_once 'vendor/autoload.php';
require_once 'src/Config/config.php';

use Hhxsv5\SSE\Event;
use Hhxsv5\SSE\SSE;
use Hhxsv5\SSE\StopSSEException;

date_default_timezone_set("Asia/Jakarta");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');

use Src\Config\Database;

class SseHandler
{

    public $lastFetchedId;
    public $pdo;

    public function __construct()
    {
        $this->lastFetchedId = 0;
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

            if ($this->lastFetchedId == 0) {
                $stmt = $this->pdo->query('SELECT * FROM mpus');
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            $stmt = $this->pdo->prepare('SELECT * FROM mpus WHERE id > :lastId');
            $stmt->bindParam(':lastId', $this->lastFetchedId, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($data)) {
                return false;
            }

            $shouldStop = false;
            if ($shouldStop) {
                throw new StopSSEException();
            }

            $this->lastFetchedId = $data[count($data) - 1]['id'];

            return json_encode($data);
        };
        (new SSE(new Event($callback, 'mpus')))->start();
    }
}

$sseHandler = new SseHandler;
$sseHandler();
