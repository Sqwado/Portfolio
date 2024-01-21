<?php

class Competence
{

    public function __construct(
        public Database $database
    ) {
    }

    public function getCompetence(int $id): array
    {
        $this->database->presql("SELECT * FROM Competence WHERE id_competence = :id_competence");
        $this->database->bindParam(":id_competence", htmlspecialchars($id));
        $this->database->execute();

        return $this->database->data;
    }

    public function getCompetences(): array
    {
        $this->database->presql("SELECT * FROM Competence ORDER BY titre");
        $this->database->execute();

        return $this->database->data;
    }

    public function createCompetence(string $titre, string $logo, string $description): void
    {
        $this->database->presql("INSERT INTO Competence (titre, description, logo) VALUES (:titre, :description, :logo)");
        $this->database->bindParam(":titre", htmlspecialchars($titre));
        $this->database->bindParam(":description", htmlspecialchars($description));
        $this->database->bindParam(":logo", htmlspecialchars($logo));
        $this->database->execute();
    }

    public function updateCompetence(int $id, string $titre, string $description, string $logo): void
    {
        $this->database->presql("UPDATE Competence SET titre = :titre, description = :description, logo = :logo WHERE id_competence = :id_competence");
        $this->database->bindParam(":id_competence", htmlspecialchars($id));
        $this->database->bindParam(":titre", htmlspecialchars($titre));
        $this->database->bindParam(":description", htmlspecialchars($description));
        $this->database->bindParam(":logo", htmlspecialchars($logo));
        $this->database->execute();
    }

    public function deleteCompetence(int $id): void
    {
        $this->database->presql("DELETE FROM Competence WHERE id_competence = :id_competence");
        $this->database->bindParam(":id_competence", htmlspecialchars($id));
        $this->database->execute();
    }
}
