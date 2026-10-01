<?php

// konfigurazio orokorra eta behar diren klaseak kargatzen dira.
require_once __DIR__ . "/../config/init.php";

// formularioaren bidez bidalitako eskaerak bakarrik onartzen dira.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

// formulariotik jasotako taldearen id-a eta partaidearen datuak irakurtzen dira.
$taldeaId = filter_input(
    INPUT_POST,
    "taldea_id",
    FILTER_VALIDATE_INT
);

$izena = trim($_POST["izena"] ?? "");
$herrialdea = trim($_POST["herrialdea"] ?? "");

// taldearen identifikatzailea zuzena ez bada, sailkapenera itzultzen da.
if (!$taldeaId) {

    $_SESSION["mezua"] = "Taldea ez da zuzena.";

    header("Location: ../index.php");
    exit;
}

// izena edo herrialdea hutsik badago, errore-mezua gordetzen da.
if ($izena === "" || $herrialdea === "") {

    $_SESSION["mezua"] = "Eremu guztiak bete behar dira.";

    header(
        "Location: ../partaideak.php?taldea_id=" . $taldeaId
    );

    exit;
}

// datu-basearekin konexioa sortzen da eta behar diren objektuak prestatzen dira.
$db = (new Database())->conectar();

$taldea = new Taldea($db);
$partaidea = new Partaidea($db);

// egiaztatzen da aukeratutako taldea datu-basean dagoela.
if ($taldea->bilatu($taldeaId) === null) {

    $_SESSION["mezua"] = "Taldea ez da aurkitu.";

    header("Location: ../index.php");
    exit;
}

// partaidea gordetzen saiatzen da eta emaitzaren arabera mezua erakusten da.
try {

    $partaidea->sortu(
        $izena,
        $herrialdea,
        $taldeaId
    );

    $_SESSION["mezua"] = "Partaidea zuzen sortu da.";

    header(
        "Location: ../partaideak.php?taldea_id=" . $taldeaId
    );

    exit;
} catch (PDOException $e) {

    echo "<h2>Errorea</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
