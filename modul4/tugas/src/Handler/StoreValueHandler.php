<?php

namespace Src\Handler;

use PDO;

class StoreValueHandler
{

    public $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke()
    {
        $x_value = $_POST['x'];
        $y_value = $_POST['y'];
        $z_value = $_POST['z'];
        $tilt = $_POST['t'];

        $sql = "INSERT INTO mpus VALUES (NULL, :x_value, :y_value, :z_value, :tilt, now())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':x_value', $x_value, PDO::PARAM_INT);
        $stmt->bindParam(':y_value', $y_value, PDO::PARAM_INT);
        $stmt->bindParam(':z_value', $z_value, PDO::PARAM_INT);
        $stmt->bindParam(':tilt', $tilt, PDO::PARAM_STR);

        if ($stmt->execute()) {
            http_response_code(201);
            echo 'success';
        } else {
            http_response_code(400);
            echo 'error';
        }
    }
}
