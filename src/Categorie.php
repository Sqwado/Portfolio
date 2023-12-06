<?php

class Categorie
{
    public function __construct(
        public Database $database
    ) {
    }

    public function getCategorie(int $id): array
    {
        $this->database->presql("SELECT * FROM Categorie WHERE id_categorie = :id_categorie");
        $this->database->bindParam(":id_categorie", $id);
        $this->database->execute();

        return $this->database->data;
    }

    public function getCategories(): array
    {
        $this->database->presql("SELECT * FROM Categorie");
        $this->database->execute();

        return $this->database->data;
    }

    public function createCategorie(string $nom, string $logo): void
    {
        $this->database->presql("INSERT INTO Categorie (nom, logo) VALUES (:nom, :logo)");
        $this->database->bindParam(":nom", $nom);
        $this->database->bindParam(":logo", $logo);
        $this->database->execute();
    }

    public function updateCategorie(int $id, string $nom, string $logo): void
    {
        $this->database->presql("UPDATE Categorie SET nom = :nom, logo = :logo WHERE id_categorie = :id_categorie");
        $this->database->bindParam(":id_categorie", $id);
        $this->database->bindParam(":nom", $nom);
        $this->database->bindParam(":logo", $logo);
        $this->database->execute();
    }

    public function deleteCategorie(int $id): void
    {
        $this->database->presql("DELETE FROM Categorie WHERE id_categorie = :id_categorie");
        $this->database->bindParam(":id_categorie", $id);
        $this->database->execute();
    }
}
