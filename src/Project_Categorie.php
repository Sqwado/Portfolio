<?php

class Project_categorie
{
    public $join_categorie = false;
    public $join_project = false;

    public function __construct(
        public Database $database
    ) {
    }

    public function getProject_Categorie(int $id): array
    {
        switch (true) {
            case $this->join_categorie && $this->join_project:
                $this->database->presql("SELECT * FROM Project_categorie JOIN Categorie ON Project_categorie.id_categorie = Categorie.id_categorie JOIN Project ON Project_categorie.id_project = Project.id_project WHERE id_pro_cat = :id_pro_cat");
                break;
            case $this->join_categorie:
                $this->database->presql("SELECT * FROM Project_categorie JOIN Categorie ON Project_categorie.id_categorie = Categorie.id_categorie WHERE id_pro_cat = :id_pro_cat");
                break;
            case $this->join_project:
                $this->database->presql("SELECT * FROM Project_categorie JOIN Project ON Project_categorie.id_project = Project.id_project WHERE id_pro_cat = :id_pro_cat");
                break;
            default:
                $this->database->presql("SELECT * FROM Project_categorie WHERE id_pro_cat = :id_pro_cat");
                break;
        }
        $this->database->bindParam(":id_pro_cat", htmlspecialchars($id));
        $this->database->execute();

        return $this->database->data;
    }

    function getProject_CategorieByProject(int $id_project): array
    {
        switch (true) {
            case $this->join_categorie:
                $this->database->presql("SELECT * FROM Project_categorie JOIN Categorie ON Project_categorie.id_categorie = Categorie.id_categorie WHERE id_project = :id_project");
                break;
            default:
                $this->database->presql("SELECT * FROM Project_categorie WHERE id_project = :id_project");
                break;
        }
        $this->database->bindParam(":id_project", htmlspecialchars($id_project));
        $this->database->execute();

        return $this->database->data;
    }

    function getProject_CategorieByCategorie(int $id_categorie): array
    {
        switch (true) {
            case $this->join_project:
                $this->database->presql("SELECT * FROM Project_categorie JOIN Project ON Project_categorie.id_project = Project.id_project WHERE id_categorie = :id_categorie");
                break;
            default:
                $this->database->presql("SELECT * FROM Project_categorie WHERE id_categorie = :id_categorie");
                break;
        }
        $this->database->bindParam(":id_categorie", htmlspecialchars($id_categorie));
        $this->database->execute();

        return $this->database->data;
    }

    public function getProject_Categories(): array
    {
        switch (true) {
            case $this->join_categorie && $this->join_project:
                $this->database->presql("SELECT * FROM Project_categorie JOIN Categorie ON Project_categorie.id_categorie = Categorie.id_categorie JOIN Project ON Project_categorie.id_project = Project.id_project");
                break;
            case $this->join_categorie:
                $this->database->presql("SELECT * FROM Project_categorie JOIN Categorie ON Project_categorie.id_categorie = Categorie.id_categorie");
                break;
            case $this->join_project:
                $this->database->presql("SELECT * FROM Project_categorie JOIN Project ON Project_categorie.id_project = Project.id_project");
                break;
            default:
                $this->database->presql("SELECT * FROM Project_categorie");
                break;
        }
        $this->database->execute();

        return $this->database->data;
    }

    public function createProject_Categorie(int $id_project, int $id_categorie): void
    {
        $this->database->presql("INSERT INTO Project_categorie (id_project, id_categorie) VALUES (:id_project, :id_categorie)");
        $this->database->bindParam(":id_project", htmlspecialchars($id_project));
        $this->database->bindParam(":id_categorie", htmlspecialchars($id_categorie));
        $this->database->execute();
    }

    public function updateProject_Categorie(int $id, int $id_project, int $id_categorie): void
    {
        $this->database->presql("UPDATE Project_categorie SET id_project = :id_project, id_categorie = :id_categorie WHERE id_pro_cat = :id_pro_cat");
        $this->database->bindParam(":id_pro_cat", htmlspecialchars($id));
        $this->database->bindParam(":id_project", htmlspecialchars($id_project));
        $this->database->bindParam(":id_categorie", htmlspecialchars($id_categorie));
        $this->database->execute();
    }

    public function deleteProject_Categorie(int $id): void
    {
        $this->database->presql("DELETE FROM Project_categorie WHERE id_pro_cat = :id_pro_cat");
        $this->database->bindParam(":id_pro_cat", htmlspecialchars($id));
        $this->database->execute();
    }
}
