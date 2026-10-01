<?php

class taldea
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function guztiak(): array
    {
        $sql = "SELECT id, izena, puntuak
                FROM taldea
                ORDER BY puntuak DESC, izena ASC";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bilatu(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT id, izena, puntuak
             FROM taldea
             WHERE id = ?"
        );

        $stmt->execute([$id]);

        $taldea = $stmt->fetch(PDO::FETCH_ASSOC);

        return $taldea ?: null;
    }

    public function sortu(string $izena, int $puntuak): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO taldea (izena, puntuak)
             VALUES (?, ?)"
        );

        return $stmt->execute([
            $izena,
            $puntuak
        ]);
    }

    public function eguneratuPuntuak(
        int $id,
        int $puntuak
    ): bool {
        $stmt = $this->db->prepare(
            "UPDATE taldea
             SET puntuak = ?
             WHERE id = ?"
        );

        return $stmt->execute([
            $puntuak,
            $id
        ]);
    }

    public function ezabatu(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM taldea
             WHERE id = ?"
        );

        return $stmt->execute([$id]);
    }
}
