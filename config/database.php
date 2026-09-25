<?php
class database {
    private string $host = "localhost";
    private string $db = "hackaton";
    private string $user = "wesuser";
    private string $pass = "123456";
    private ?PDO $conexion = null;

    public function conectar(): PDO {
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
?>