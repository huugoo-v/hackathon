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

if (!$id) {
    $_SESSION["mezua"] = "Taldea ez da zuzena.";
    header("Location: ../index.php");
    exit;
}

$db = (new Database())->conectar();

$taldea = new Taldea($db);

if ($taldea->bilatu($id) === null) {
    $_SESSION["mezua"] = "Taldea ez da aurkitu.";
    header("Location: ../index.php");
    exit;
}

guardarFavorito($id);

$_SESSION["mezua"] = "Gogokoena gordeta.";

header("Location: ../index.php");
exit;
