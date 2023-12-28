<?php

namespace Src\Handler;

use Hhxsv5\SSE\Event;
use Hhxsv5\SSE\SSE;
use Hhxsv5\SSE\StopSSEException;

use PDO;

class SseHandler
{

    public $lastFetchedId;
    public $pdo;

    public function __construct(PDO $pdo)
    {
        $this->lastFetchedId = 0;
        $this->pdo = $pdo;
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
                $stmt = $this->pdo->query('SELECT * FROM modul6');
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            $stmt = $this->pdo->prepare('SELECT * FROM modul6 LIMIT 1 ORDER BY `datetime`');
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

            return json_encode($data[0]);
        };
        (new SSE(new Event($callback, 'mpus')))->start();
    }
}
