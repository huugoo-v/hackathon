<?php

require_once __DIR__ . "/../config/init.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

$taldeaId = filter_input(
    INPUT_POST,
    "taldea_id",
    FILTER_VALIDATE_INT
);

$izena = trim($_POST["izena"] ?? "");
$herrialdea = trim($_POST["herrialdea"] ?? "");

if (!$taldeaId) {

    $_SESSION["mezua"] = "Taldea ez da zuzena.";

    header("Location: ../index.php");
    exit;
}

if ($izena === "" || $herrialdea === "") {

    $_SESSION["mezua"] = "Eremu guztiak bete behar dira.";

    header(
        "Location: ../partaideak.php?taldea_id=" . $taldeaId
    );

    exit;
}

$db = (new Database())->conectar();

$taldea = new Taldea($db);
$partaidea = new Partaidea($db);

if ($taldea->bilatu($taldeaId) === null) {

    $_SESSION["mezua"] = "Taldea ez da aurkitu.";

    header("Location: ../index.php");
    exit;
}

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
