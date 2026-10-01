<?php
class partaidea
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function taldekoak(int $taldeaId): array
    {
        $sql = "SELECT id, izena, herrialdea, taldea_id
                FROM partaideak
                WHERE taldea_id = ?
                ORDER BY izena ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$taldeaId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sortu(string $izena, string $herrialdea, int $taldeaId): bool
    {
        $sql = "INSERT INTO partaideak (izena, herrialdea, taldea_id)
                VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$izena, $herrialdea, $taldeaId]);
    }
}
