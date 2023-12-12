<?php

class Article_categorie
{
    public $join_categorie = false;

    public function __construct(
        public Database $database
    ) {
    }

    public function getArticle_Categorie(int $id): array
    {
        if ($this->join_categorie) {
            $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie WHERE id_art_cat = :id_art_cat");
        } else {
            $this->database->presql("SELECT * FROM Article_categorie WHERE id_art_cat = :id_art_cat");
        }
        $this->database->bindParam(":id_art_cat", $id);
        $this->database->execute();

        return $this->database->data;
    }

    function getArticle_CategorieByArticle(int $id_article): array
    {
        if ($this->join_categorie) {
            $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie WHERE id_article = :id_article");
        } else {
            $this->database->presql("SELECT * FROM Article_categorie WHERE id_article = :id_article");
        }
        $this->database->bindParam(":id_article", $id_article);
        $this->database->execute();

        return $this->database->data;
    }

    function getArticle_CategorieByCategorie(int $id_categorie): array
    {
        if ($this->join_categorie) {
            $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie WHERE id_categorie = :id_categorie");
        } else {
            $this->database->presql("SELECT * FROM Article_categorie WHERE id_categorie = :id_categorie");
        }
        $this->database->bindParam(":id_categorie", $id_categorie);
        $this->database->execute();

        return $this->database->data;
    }

    public function getArticle_Categories(): array
    {
        if ($this->join_categorie) {
            $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie");
        } else {
            $this->database->presql("SELECT * FROM Article_categorie");
        }
        $this->database->execute();

        return $this->database->data;
    }

    public function createArticle_Categorie(int $id_article, int $id_categorie): void
    {
        $this->database->presql("INSERT INTO Article_categorie (id_article, id_categorie) VALUES (:id_article, :id_categorie)");
        $this->database->bindParam(":id_article", $id_article);
        $this->database->bindParam(":id_categorie", $id_categorie);
        $this->database->execute();
    }

    public function updateArticle_Categorie(int $id, int $id_article, int $id_categorie): void
    {
        $this->database->presql("UPDATE Article_categorie SET id_article = :id_article, id_categorie = :id_categorie WHERE id_art_cat = :id_art_cat");
        $this->database->bindParam(":id_art_cat", $id);
        $this->database->bindParam(":id_article", $id_article);
        $this->database->bindParam(":id_categorie", $id_categorie);
        $this->database->execute();
    }

    public function deleteArticle_Categorie(int $id): void
    {
        $this->database->presql("DELETE FROM Article_categorie WHERE id_art_cat = :id_art_cat");
        $this->database->bindParam(":id_art_cat", $id);
        $this->database->execute();
    }
}
