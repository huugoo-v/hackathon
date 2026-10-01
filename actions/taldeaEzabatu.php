<?php

// konfigurazioa eta klaseak kargatzen dira.
require_once "../config/init.php";

// ezabatzea formulario bidez bakarrik egiten da.
// ezabatutako taldea gogokoena bazen, gogokoaren datuak kentzen dira.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

// taldearen id-a bidali den egiaztatzen da.
if (!isset($_POST["id"])) {
    header("Location: ../index.php");
    exit;
}

// bidalitako id-a zenbaki oso bihurtzen da.
$id = (int)$_POST["id"];

// datu-basearekin konektatzen da eta taldearen objektua sortzen da.
$database = new Database();
$db = $database->conectar();

$taldea = new Taldea($db);

// taldea existitzen dela egiaztatzen da ezabatu aurretik.
if ($taldea->bilatu($id) === null) {
    $_SESSION["mezua"] = "Taldea ez da aurkitu.";
    header("Location: ../index.php");
    exit;
}

// taldea ezabatzen da; datu-baseko cascade erlazioak partaideak ere ezaba ditzake.
$taldea->ezabatu($id);

if (
    isset($_SESSION["taldea_favorita"]) &&
    $_SESSION["taldea_favorita"] === $id
) {
    unset($_SESSION["taldea_favorita"]);
    setcookie("taldea_favorita", "", time() - 3600, "/");
}

$_SESSION["mezua"] = "Taldea ezabatuta.";

header("Location: ../index.php");
exit;
