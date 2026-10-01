<?php

session_start();

require_once __DIR__ . "/database.php";
require_once __DIR__ . "/../classes/taldea.php";
require_once __DIR__ . "/../classes/partaidea.php";

function escapar(string $testua): string
{
    return htmlspecialchars($testua, ENT_QUOTES, "UTF-8");
}

function guardarFavorito(int $id): void
{
    setcookie(
        "taldea_favorita",
        (string)$id,
        time() + (60 * 60 * 24 * 30),
        "/"
    );

    $_SESSION["taldea_favorita"] = $id;
}

if (isset($_COOKIE["taldea_favorita"])) {
    $_SESSION["taldea_favorita"] = (int)$_COOKIE["taldea_favorita"];
}

function mostrarMensaje(): void
{
    if (isset($_SESSION["mezua"])) {
        echo "<p>" . escapar($_SESSION["mezua"]) . "</p>";
        unset($_SESSION["mezua"]);
    }
}
