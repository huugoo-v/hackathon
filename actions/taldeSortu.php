<?php

// konfigurazioa eta klaseak kargatzen dira.
require_once __DIR__ . "/../config/init.php";

// formulario bidez bidalitako eskaerak bakarrik prozesatzen dira.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

// taldearen izena eta hasierako puntuazioa jasotzen dira.
$izena = trim($_POST["taldeIzena"] ?? "");
$puntuak = $_POST["taldePuntuak"] ?? "";

// eremu guztiak bete direla egiaztatzen da.
if ($izena === "" || $puntuak === "") {

    $_SESSION["mezua"] = "Eremu guztiak bete behar dira.";

    header("Location: ../index.php");
    exit;
}

// puntuazioa zenbakia dela eta negatiboa ez dela egiaztatzen da.
if (!is_numeric($puntuak) || (int)$puntuak < 0) {

    $_SESSION["mezua"] = "Puntuak ez dira zuzenak.";

    header("Location: ../index.php");
    exit;
}

// datu-basearekin konektatzen da eta taldearen objektua sortzen da.
$db = (new Database())->conectar();

$taldea = new Taldea($db);

// taldea gordetzen saiatzen da eta emaitza saioan gordetzen du.
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
