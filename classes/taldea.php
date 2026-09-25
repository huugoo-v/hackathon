<?php
class taldea {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function guztiak(): array {
        $sql = "SELECT id, izena, puntuak FROM taldea ORDER BY puntuak DESC, izena ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bilatu(int $id): ?array {
        $sql = "SELECT id, izena, puntuak FROM taldea WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $taldea = $stmt->fetch(PDO::FETCH_ASSOC);

        return $taldea ?: null;
    }

    public function sortu(string $izena, int $puntuak = 0): bool {
        $sql = "INSERT INTO taldea (izena, puntuak) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$izena, $puntuak]);
    }

    public function eguneratuPuntuak(int $id, int $puntuak): bool {
        $sql = "UPDATE taldea SET puntuak = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$puntuak, $id]);
    }

    public function ezabatu(int $id): bool {
        $sql = "DELETE FROM taldea WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>