<?php

require_once __DIR__ . "/config/init.php";

$db = (new Database())->conectar();

$taldeaObj = new Taldea($db);
$partaideaObj = new Partaidea($db);

$taldeaId = filter_input(
    INPUT_GET,
    "taldea_id",
    FILTER_VALIDATE_INT
);

if (!$taldeaId) {
    header("Location: index.php");
    exit;
}

$taldea = $taldeaObj->bilatu($taldeaId);

if ($taldea === null) {
    header("Location: index.php");
    exit;
}

$partaideak = $partaideaObj->taldekoak($taldeaId);

$favoritoa = $_SESSION["taldea_favorita"] ?? null;
$favoritoaTaldea = null;

if ($favoritoa !== null) {
    $favoritoaTaldea = $taldeaObj->bilatu((int)$favoritoa);
}

?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <title>Partaideak</title>
</head>

<body>

    <h1><?= escapar($taldea["izena"]) ?> - Partaideak</h1>

    <?php mostrarMensaje(); ?>

    <table border="1">

        <tr>
            <th>ID</th>
            <th>Izena</th>
            <th>Herrialdea</th>
        </tr>

        <?php foreach ($partaideak as $partaidea): ?>

            <tr>

                <td>
                    <?= (int)$partaidea["id"] ?>
                </td>

                <td>
                    <?= escapar($partaidea["izena"]) ?>
                </td>

                <td>
                    <?= escapar($partaidea["herrialdea"]) ?>
                </td>

            </tr>

        <?php endforeach; ?>

    </table>

    <h2>Gehitu partaidea</h2>

    <form action="actions/partaideaSortu.php" method="post">

        <input
            type="hidden"
            name="taldea_id"
            value="<?= (int)$taldeaId ?>">

        Izena:
        <input
            type="text"
            name="izena"
            required>

        <br>

        Herrialdea:
        <input
            type="text"
            name="herrialdea"
            required>

        <br>

        <input
            type="submit"
            value="Gehitu">

    </form>

    <p>
        <a href="index.php">Itzuli sailkapenera</a>
    </p>

    <?php if ($favoritoaTaldea !== null): ?>

        <p>
            Zure talde favoritoa:

            <a href="partaideak.php?taldea_id=<?= (int)$favoritoaTaldea["id"] ?>">
                <?= escapar($favoritoaTaldea["izena"]) ?>
            </a>
        </p>

    <?php endif; ?>

</body>

</html>