<?php
// klase honek mysql datu-basearekiko konexioa kudeatzen du.
class database
{
    // datu-basearen zerbitzariaren eta sarbidearen datuak gordetzen dira.
private string $host = "localhost";
    private string $db = "hackaton";
    private string $user = "wesuser";
    private string $pass = "123456";
    private ?PDO $conexion = null;

    // datu-basearekin konexioa sortu edo lehendik dagoena itzultzen du.
public function conectar(): PDO
    {
        if ($this->conexion === null) {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4",
                $this->user,
                $this->pass
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $this->conexion;
    }
}
