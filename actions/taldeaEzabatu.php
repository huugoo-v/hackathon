<?php

require_once "../config/init.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

if (!isset($_POST["id"])) {
    header("Location: ../index.php");
    exit;
}

$id = (int)$_POST["id"];

$database = new Database();
$db = $database->conectar();

$taldea = new Taldea($db);

if ($taldea->bilatu($id) === null) {
    $_SESSION["mezua"] = "Taldea ez da aurkitu.";
    header("Location: ../index.php");
    exit;
}

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
