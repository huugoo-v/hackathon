<?php

// konfigurazioa eta klaseak kargatzen dira.
require_once __DIR__ . "/../config/init.php";

// formulario batetik datorren eskaera dela egiaztatzen da.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

// taldearen id-a eta puntuazio berria jasotzen dira.
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

// datuak baliagarriak direla egiaztatzen da.
if (!$id || $puntuak === false || $puntuak < 0) {

    $_SESSION["mezua"] = "Puntuak ez dira zuzenak.";

    header("Location: ../index.php");
    exit;
}

// datu-basearekin konektatu eta taldearen objektua sortzen da.
$db = (new Database())->conectar();

$taldea = new Taldea($db);

// puntuazioa eguneratzen da eta emaitzaren mezua prestatzen da.
if ($taldea->eguneratuPuntuak($id, $puntuak)) {

    $_SESSION["mezua"] = "Taldearen puntuazioa aldatu da.";
} else {

    $_SESSION["mezua"] = "Ezin izan da puntuazioa aldatu.";
}

header("Location: ../index.php");
exit;
