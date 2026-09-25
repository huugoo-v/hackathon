<?php
session_start();

require_once __DIR__ . "/database.php";
require_once __DIR__ . "/../classes/taldea.php";
require_once __DIR__ . "/../classes/partaidea.php";

if (!isset($_SESSION["email"])) {
    $_SESSION["email"] = "";
}

function escapar(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

function mensaje(string $tipo, string $texto): void {
    $_SESSION["mensaje"] = [
        "tipo" => $tipo,
        "texto" => $texto
    ];
}

function mostrarMensaje(): void {
    if (isset($_SESSION["mensaje"])) {
        $mensaje = $_SESSION["mensaje"];
        echo '<div class="mensaje ' . escapar($mensaje["tipo"]) . '">'
            . escapar($mensaje["texto"])
            . '</div>';
        unset($_SESSION["mensaje"]);
    }
}

function guardarFavorito(int $taldeaId): void {
    setcookie("taldeGogokoena", (string)$taldeaId, time() + (60 * 60 * 24 * 30), "/");
    $_SESSION["taldeGogokoena"] = $taldeaId;
}

if (isset($_COOKIE["taldeGogokoena"]) && !isset($_SESSION["taldeGogokoena"])) {
    $_SESSION["taldeGogokoena"] = (int)$_COOKIE["taldeGogokoena"];
}
?>