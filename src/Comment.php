<?php

class Comment
{

    public function __construct(
        public Database $database
    ) {
    }

    public function getComment(int $id): array
    {
        $this->database->presql("SELECT * FROM Comment WHERE id_comment = :id_comment");
        $this->database->bindParam(":id_comment", $id);
        $this->database->execute();

        return $this->database->data;
    }

    public function getCommentByArticle(int $id_article): array
    {
        $this->database->presql("SELECT * FROM Comment WHERE id_article = :id_article ORDER BY publi_date DESC");
        $this->database->bindParam(":id_article", $id_article);
        $this->database->execute();

        return $this->database->data;
    }

    public function getComments(): array
    {
        $this->database->presql("SELECT * FROM Comment Order by publi_date DESC");
        $this->database->execute();

        return $this->database->data;
    }

    public function createComment(string $pseudo, int $id_article, string $content): void
    {
        $this->database->presql("INSERT INTO Comment (pseudo, id_article, publi_date, content) VALUES (:pseudo, :id_article, NOW(), :content)");
        $this->database->bindParam(":pseudo", $pseudo);
        $this->database->bindParam(":id_article", $id_article);
        $this->database->bindParam(":content", $content);
        $this->database->execute();
    }

    public function updateComment(int $id, string $pseudo, int $id_article, string $content): void
    {
        $this->database->presql("UPDATE Comment SET pseudo = :pseudo, id_project = :id_project, publi_date = NOW(), content = :content WHERE id_comment = :id_comment");
        $this->database->bindParam(":id_comment", $id);
        $this->database->bindParam(":pseudo", $pseudo);
        $this->database->bindParam(":id_project", $id_article);
        $this->database->bindParam(":content", $content);
        $this->database->execute();
    }

    public function deleteComment(int $id): void
    {
        $this->database->presql("DELETE FROM Comment WHERE id_comment = :id_comment");
        $this->database->bindParam(":id_comment", $id);
        $this->database->execute();
    }
}
