<?php

class Article_categorie
{
    public $join_categorie = false;
    public $join_article = false;

    public function __construct(
        public Database $database
    ) {
    }

    public function getArticle_Categorie(int $id): array
    {
        switch (true) {
            case $this->join_categorie && $this->join_article:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie JOIN Article ON Article_categorie.id_article = Article.id_article WHERE id_art_cat = :id_art_cat");
                break;
            case $this->join_categorie:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie WHERE id_art_cat = :id_art_cat");
                break;
            case $this->join_article:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Article ON Article_categorie.id_article = Article.id_article WHERE id_art_cat = :id_art_cat");
                break;
            default:
                $this->database->presql("SELECT * FROM Article_categorie WHERE id_art_cat = :id_art_cat");
                break;
        }
        $this->database->bindParam(":id_art_cat", htmlspecialchars($id));
        $this->database->execute();

        return $this->database->data;
    }

    function getArticle_CategorieByArticle(int $id_article): array
    {
        switch (true) {
            case $this->join_categorie && $this->join_article:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie JOIN Article ON Article_categorie.id_article = Article.id_article WHERE Article_categorie.id_article = :id_article");
                break;
            case $this->join_categorie:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie WHERE Article_categorie.id_article = :id_article");
                break;
            case $this->join_article:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Article ON Article_categorie.id_article = Article.id_article WHERE Article_categorie.id_article = :id_article");
                break;
            default:
                $this->database->presql("SELECT * FROM Article_categorie WHERE Article_categorie.id_article = :id_article");
                break;
        }
        $this->database->bindParam(":id_article", htmlspecialchars($id_article));
        $this->database->execute();

        return $this->database->data;
    }

    function getArticle_CategorieByCategorie(int $id_categorie): array
    {
        switch (true) {
            case $this->join_categorie && $this->join_article:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie JOIN Article ON Article_categorie.id_article = Article.id_article WHERE Article_categorie.id_categorie = :id_categorie");
                break;
            case $this->join_categorie:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie WHERE Article_categorie.id_categorie = :id_categorie");
                break;
            case $this->join_article:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Article ON Article_categorie.id_article = Article.id_article WHERE Article_categorie.id_categorie = :id_categorie");
                break;
            default:
                $this->database->presql("SELECT * FROM Article_categorie WHERE Article_categorie.id_categorie = :id_categorie");
                break;
        }
        $this->database->bindParam(":id_categorie", htmlspecialchars($id_categorie));
        $this->database->execute();

        return $this->database->data;
    }

    public function getArticle_Categories(): array
    {
        switch (true) {
            case $this->join_categorie && $this->join_article:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie JOIN Article ON Article_categorie.id_article = Article.id_article");
                break;
            case $this->join_categorie:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Categorie ON Article_categorie.id_categorie = Categorie.id_categorie");
                break;
            case $this->join_article:
                $this->database->presql("SELECT * FROM Article_categorie JOIN Article ON Article_categorie.id_article = Article.id_article");
                break;
            default:
                $this->database->presql("SELECT * FROM Article_categorie");
                break;
        }
        $this->database->execute();

        return $this->database->data;
    }

    public function createArticle_Categorie(int $id_article, int $id_categorie): void
    {
        $this->database->presql("INSERT INTO Article_categorie (id_article, id_categorie) VALUES (:id_article, :id_categorie)");
        $this->database->bindParam(":id_article", htmlspecialchars($id_article));
        $this->database->bindParam(":id_categorie", htmlspecialchars($id_categorie));
        $this->database->execute();
    }

    public function updateArticle_Categorie(int $id, int $id_article, int $id_categorie): void
    {
        $this->database->presql("UPDATE Article_categorie SET id_article = :id_article, id_categorie = :id_categorie WHERE id_art_cat = :id_art_cat");
        $this->database->bindParam(":id_art_cat", htmlspecialchars($id));
        $this->database->bindParam(":id_article", htmlspecialchars($id_article));
        $this->database->bindParam(":id_categorie", htmlspecialchars($id_categorie));
        $this->database->execute();
    }

    public function deleteArticle_Categorie(int $id): void
    {
        $this->database->presql("DELETE FROM Article_categorie WHERE id_art_cat = :id_art_cat");
        $this->database->bindParam(":id_art_cat", htmlspecialchars($id));
        $this->database->execute();
    }
}
