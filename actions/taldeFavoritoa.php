<?php

// konfigurazioa eta klaseak kargatzen dira.
require_once __DIR__ . "/../config/init.php";

// gogokoena formulario bidez aukeratu behar da.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

// gogoko gisa aukeratutako taldearen id-a jasotzen da.
$id = filter_input(
    INPUT_POST,
    "id",
    FILTER_VALIDATE_INT
);

// id-a baliogabea bada, eskaera baztertzen da.
if (!$id) {
    $_SESSION["mezua"] = "Taldea ez da zuzena.";
    header("Location: ../index.php");
    exit;
}

// datu-basearekin konektatzen da.
$db = (new Database())->conectar();

$taldea = new Taldea($db);

// aukeratutako taldea existitzen dela egiaztatzen da.
if ($taldea->bilatu($id) === null) {
    $_SESSION["mezua"] = "Taldea ez da aurkitu.";
    header("Location: ../index.php");
    exit;
}

// taldea cookiean eta saioan gordetzen da.
guardarFavorito($id);

$_SESSION["mezua"] = "Gogokoena gordeta.";

header("Location: ../index.php");
exit;
