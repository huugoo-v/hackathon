<?php

require_once __DIR__ . "/../config/init.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

$id = filter_input(
    INPUT_POST,
    "id",
    FILTER_VALIDATE_INT
);

$puntuak = filter_input(
    INPUT_POST,
    "puntuak",
    FILTER_VALIDATE_INT
);

if (!$id || $puntuak === false || $puntuak < 0) {

    $_SESSION["mezua"] = "Puntuak ez dira zuzenak.";

    header("Location: ../index.php");
    exit;
}

$db = (new Database())->conectar();

$taldea = new Taldea($db);

if ($taldea->eguneratuPuntuak($id, $puntuak)) {

    $_SESSION["mezua"] = "Taldearen puntuazioa aldatu da.";
} else {

    $_SESSION["mezua"] = "Ezin izan da puntuazioa aldatu.";
}

header("Location: ../index.php");
exit;
