<?php
require_once __DIR__ . "/../config/init.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

$izena = trim($_POST["izena"] ?? "");
$puntuakInput = trim($_POST["puntuak"] ?? "");

if ($izena === "" || $puntuakInput === "") {
    mensaje("error", "Eremu guztiak bete behar dira.");
    header("Location: ../index.php");
    exit;
}

if (!is_numeric($puntuakInput) || (int)$puntuakInput < 0) {
    mensaje("error", "Puntuak zenbaki positiboa izan behar du.");
    header("Location: ../index.php");
    exit;
}

$db = (new Database())->conectar();
$taldea = new taldea($db);

try {
    $taldea->sortu($izena, (int)$puntuakInput);
    mensaje("ok", "Taldea zuzen sortu da.");
} catch (PDOException $e) {
    mensaje("error", "Errorea taldea sortzean.");
}

header("Location: ../index.php");
exit;
?>