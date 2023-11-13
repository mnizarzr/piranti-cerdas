<?php

$servername = "127.0.0.1";
$port = 3306;
$username = "root";
$password = "root";
$dbname = "pirdas_modul4";
$dsn = "mysql:host=$servername;dbname=$dbname;port=$port";

$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET["ldr_value"])) {
    $ldr_value = $_GET["ldr_value"];
}

try {
    $sql = "INSERT INTO data_cahaya(ldr_value) VALUES (:ldr_value)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ldr_value', $ldr_value, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "DATA LDR VALUE BERHASIL DITAMBAH";
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->errorInfo()[2];
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$pdo = NULL;

exit();
