<?php

// klase honek taldeak kontsultatu, sortu, eguneratu eta ezabatzen ditu.
class taldea
{
    // datu-basearekiko konexioa gordetzen da.
private PDO $db;

    // konexioa jasotzen da objektua sortzean.
public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // talde guztiak puntuazioaren arabera ordenatuta lortzen dira.
public function guztiak(): array
    {
        $sql = "SELECT id, izena, puntuak
                FROM taldea
                ORDER BY puntuak DESC, izena ASC";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    // id jakin bateko taldea bilatzen da.
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

    // talde berri bat datu-basean gordetzen da.
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

    // talde baten puntuazioa aldatzen da.
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

    // id horretako taldea ezabatzen da.
public function ezabatu(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM taldea
             WHERE id = ?"
        );

        return $stmt->execute([$id]);
    }
}
