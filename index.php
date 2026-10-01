<?php

require_once __DIR__ . "/config/init.php";

$db = (new Database())->conectar();

$taldeaObj = new Taldea($db);

$taldeak = $taldeaObj->guztiak();

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
    <title>Sailkapena</title>
</head>

<body>

    <h1>Sailkapena</h1>

    <?php mostrarMensaje(); ?>

    <table border="1">

        <tr>
            <th>ID</th>
            <th>Izena</th>
            <th>Puntuak</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>

        <?php foreach ($taldeak as $taldea): ?>

            <tr>

                <td>
                    <?= (int)$taldea["id"] ?>
                </td>

                <td>
                    <a href="partaideak.php?taldea_id=<?= (int)$taldea["id"] ?>">
                        <?= escapar($taldea["izena"]) ?>
                    </a>
                </td>

                <td>
                    <form action="actions/puntuakEguneratu.php" method="post">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= (int)$taldea["id"] ?>">

                        <input
                            type="number"
                            name="puntuak"
                            value="<?= (int)$taldea["puntuak"] ?>"
                            min="0">

                        <input type="submit" value="Aldatu">

                    </form>
                </td>

                <td>
                    <form action="actions/taldeaEzabatu.php" method="post">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= (int)$taldea["id"] ?>">

                        <input type="submit" value="Ezabatu">

                    </form>
                </td>

                <td>
                    <form action="actions/taldeFavoritoa.php" method="post">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= (int)$taldea["id"] ?>">

                        <input type="submit" value="Gogokoena">

                    </form>
                </td>

            </tr>

        <?php endforeach; ?>

    </table>

    <h2>Gehitu taldea</h2>

    <form action="actions/taldeSortu.php" method="post">

        Izena:
        <input
            type="text"
            name="taldeIzena"
            required>

        <br>
        <br>

        Puntuak:
        <input
            type="number"
            name="taldePuntuak"
            min="0"
            required>

        <br>
        <br>

        <input
            type="submit"
            name="taldeSortuBotoi"
            value="Sortu">

    </form>

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