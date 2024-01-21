<?php

class Article
{
    public function __construct(
        public Database $database
    ) {
    }

    public function getArticle(int $id): array
    {
        $this->database->presql("SELECT * FROM Article WHERE id_article = :id_article");
        $this->database->bindParam(":id_article", htmlspecialchars($id));
        $this->database->execute();

        return $this->database->data;
    }

    public function getArticles(): array
    {
        $this->database->presql("SELECT * FROM Article ORDER BY publi_date DESC");
        $this->database->execute();

        return $this->database->data;
    }

    public function createArticle(string $titre, string $main_img, string $description, string $publi_date, string $content): void
    {
        $this->database->presql("INSERT INTO Article (titre, main_img, description, publi_date, content) VALUES (:titre, :main_img, :description, :publi_date, :content)");
        $this->database->bindParam(":titre", htmlspecialchars($titre));
        $this->database->bindParam(":main_img", htmlspecialchars($main_img));
        $this->database->bindParam(":description", htmlspecialchars($description));
        $this->database->bindParam(":publi_date", htmlspecialchars($publi_date));
        $this->database->bindParam(":content", $content);
        $this->database->execute();
    }

    public function updateArticle(int $id, string $titre, string $main_img, string $description, string $publi_date, string $content): void
    {
        $this->database->presql("UPDATE Article SET titre = :titre, main_img = :main_img, description = :description, publi_date = :publi_date, content = :content WHERE id_article = :id_article");
        $this->database->bindParam(":id_article", htmlspecialchars($id));
        $this->database->bindParam(":titre", htmlspecialchars($titre));
        $this->database->bindParam(":main_img", htmlspecialchars($main_img));
        $this->database->bindParam(":description", htmlspecialchars($description));
        $this->database->bindParam(":publi_date", htmlspecialchars($publi_date));
        $this->database->bindParam(":content", $content);
        $this->database->execute();
    }

    public function deleteArticle(int $id): void
    {
        $this->database->presql("DELETE FROM Article WHERE id_article = :id_article");
        $this->database->bindParam(":id_article", htmlspecialchars($id));
        $this->database->execute();
    }
}
