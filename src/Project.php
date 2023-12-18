<?php

class Project
{
    public function __construct(
        public Database $database
    ) {
    }

    public function getProject(int $id): array
    {
        $this->database->presql("SELECT * FROM Project WHERE Id_project = :Id_project");
        $this->database->bindParam(":Id_project", $id);
        $this->database->execute();

        return $this->database->data;
    }

    public function getProjects(): array
    {
        $this->database->presql("SELECT * FROM Project ORDER BY publi_date DESC");
        $this->database->execute();

        return $this->database->data;
    }

    public function createProject(string $titre, string $main_img, string $description, string $publi_date, string $content): void
    {
        $this->database->presql("INSERT INTO Project (titre, main_img, description, publi_date, content) VALUES (:titre, :main_img, :description, :publi_date, :content)");
        $this->database->bindParam(":titre", $titre);
        $this->database->bindParam(":main_img", $main_img);
        $this->database->bindParam(":description", $description);
        $this->database->bindParam(":publi_date", $publi_date);
        $this->database->bindParam(":content", $content);
        $this->database->execute();
    }

    public function updateProject(int $id, string $titre, string $main_img, string $description, string $publi_date, string $content = null): void
    {
        $this->database->presql("UPDATE Project SET titre = :titre, main_img = :main_img, description = :description, publi_date = :publi_date, content = :content WHERE id_project = :id_project");
        $this->database->bindParam(":id_project", $id);
        $this->database->bindParam(":titre", $titre);
        $this->database->bindParam(":main_img", $main_img);
        $this->database->bindParam(":description", $description);
        $this->database->bindParam(":publi_date", $publi_date);
        if ($content != null) $this->database->bindParam(":content", $content);
        else $this->database->bindParam(":content", "");
        $this->database->execute();
    }

    public function deleteProject(int $id): void
    {
        $this->database->presql("DELETE FROM Project WHERE id_project = :id_project");
        $this->database->bindParam(":id_project", $id);
        $this->database->execute();
    }
}
