<?php

// saioa abiarazten da mezuak eta gogoko taldea gordetzeko.
session_start();

// datu-basearen klasea eta aplikazioko beste klaseak kargatzen dira.
require_once __DIR__ . "/database.php";
require_once __DIR__ . "/../classes/taldea.php";
require_once __DIR__ . "/../classes/partaidea.php";

// html-n erakutsi aurretik testua seguru bihurtzen da.
function escapar(string $testua): string
{
    return htmlspecialchars($testua, ENT_QUOTES, "UTF-8");
}

// gogoko taldea cookiean eta saioan gordetzen da.
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

// cookiean gordetako gogoko taldea saioan kargatzen da.
if (isset($_COOKIE["taldea_favorita"])) {
    $_SESSION["taldea_favorita"] = (int)$_COOKIE["taldea_favorita"];
}

// saioan gordetako mezua erakutsi eta gero ezabatzen da.
function mostrarMensaje(): void
{
    if (isset($_SESSION["mezua"])) {
        echo "<p>" . escapar($_SESSION["mezua"]) . "</p>";
        unset($_SESSION["mezua"]);
    }
}
