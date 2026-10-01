<?php
// klase honek partaideak bilatu eta datu-basean gordetzen ditu.
class partaidea
{
    // datu-basearekiko konexioa gordetzen da.
private PDO $db;

    // konexioa jasotzen da objektua sortzean.
public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // talde jakin bateko partaide guztiak izenaren arabera bilatzen dira.
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

    // partaide berri bat sartzen da aukeratutako taldean.
public function sortu(string $izena, string $herrialdea, int $taldeaId): bool
    {
        $sql = "INSERT INTO partaideak (izena, herrialdea, taldea_id)
                VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$izena, $herrialdea, $taldeaId]);
    }
}
