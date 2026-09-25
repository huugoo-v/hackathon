<?php

require_once "config/database.php";

$database = new Database();
$conexion = $database->conectar();

$sql = "SELECT * FROM taldea ORDER BY puntuak DESC";
$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sailkapena</title>
</head>

<body>

    <h1>Sailkapena</h1>

    <table border="1">

        <tr>
            <th>ID</th>
            <th>Izena</th>
            <th>Puntuak</th>
            <th></th>
            <th></th>
        </tr>

        <?php while ($taldea = $resultado->fetch(PDO::FETCH_ASSOC)) { ?>

            <tr>

                <td>
                    <?= $taldea["id"] ?>
                </td>

                <td>
                    <a href="partaideak.php?taldea_id=<?= $taldea["id"] ?>">
                        <?= $taldea["izena"] ?>
                    </a>
                </td>

                <td>
                    <?= $taldea["puntuak"] ?>
                </td>

                <td>
                    <form action="puntuakAldatu.php" method="post">
                        <input type="hidden" name="id" value="<?= $taldea["id"] ?>">
                        <input type="number" name="puntuak" value="<?= $taldea["puntuak"] ?>">
                        <input type="submit" value="Aldatu">
                    </form>
                </td>

                <td>
                    <form action="taldeEzabatu.php" method="post">
                        <input type="hidden" name="id" value="<?= $taldea["id"] ?>">
                        <input type="submit" value="Ezabatu">
                    </form>
                </td>

            </tr>

        <?php } ?>

    </table>


    <h2>Gehitu taldea</h2>

    <form action="taldeSortu.php" method="post">

        Izena:
        <input type="text" name="taldeIzena">
        <br>
        <br>

        Puntuak:
        <input type="number" name="taldePuntuak">
        <br>
        <br>

        <input type="submit" name="taldeSortuBotoi" value="Sortu">

    </form>

</body>

</html>