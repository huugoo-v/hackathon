<?php

require_once __DIR__ . "/../config/init.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

$izena = trim($_POST["taldeIzena"] ?? "");
$puntuak = $_POST["taldePuntuak"] ?? "";

if ($izena === "" || $puntuak === "") {

    $_SESSION["mezua"] = "Eremu guztiak bete behar dira.";

    header("Location: ../index.php");
    exit;
}

if (!is_numeric($puntuak) || (int)$puntuak < 0) {

    $_SESSION["mezua"] = "Puntuak ez dira zuzenak.";

    header("Location: ../index.php");
    exit;
}

$db = (new Database())->conectar();

$taldea = new Taldea($db);

try {

    $taldea->sortu(
        $izena,
        (int)$puntuak
    );

    $_SESSION["mezua"] = "Taldea zuzen sortu da.";
} catch (PDOException $e) {

    $_SESSION["mezua"] = "Errorea taldea sortzean.";
}

header("Location: ../index.php");
exit;
