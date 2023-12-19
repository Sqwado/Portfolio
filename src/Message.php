<?php

class Message
{

    public function __construct(
        public Database $database
    ) {
    }

    public function getMessage(int $id): array
    {
        $this->database->presql("SELECT * FROM Message WHERE id_message = :id_message");
        $this->database->bindParam(":id_message", $id);
        $this->database->execute();

        return $this->database->data;
    }

    public function getMessages(): array
    {
        $this->database->presql("SELECT * FROM Message ORDER BY sending_date DESC");
        $this->database->execute();

        return $this->database->data;
    }

    public function getMessagesUnread(): array
    {
        $this->database->presql("SELECT * FROM Message WHERE `read` = 0 ORDER BY sending_date DESC");
        $this->database->execute();

        return $this->database->data;
    }

    public function getMessagesRead(): array
    {
        $this->database->presql("SELECT * FROM Message WHERE `read` = 1 ORDER BY sending_date DESC");
        $this->database->execute();

        return $this->database->data;
    }

    public function createMessage(string $email, string $content): void
    {
        $this->database->presql("INSERT INTO Message (email, content, sending_date, readed) VALUES (:email, :content, Now(), 0)");
        $this->database->bindParam(":email", $email);
        $this->database->bindParam(":content", $content);

        try {
            $this->database->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création du message");
        }
    }

    public function updateMessage(int $id, string $email, string $content, string $sending_date, int $readed): void
    {
        $this->database->presql("UPDATE Message SET email = :email, content = :content, sending_date = :sending_date, readed = :readed WHERE id_message = :id_message");
        $this->database->bindParam(":id_message", $id);
        $this->database->bindParam(":email", $email);
        $this->database->bindParam(":content", $content);
        $this->database->bindParam(":sending_date", $sending_date);
        $this->database->bindParam(":readeds", $readed);

        $this->database->execute();
    }

    public function deleteMessage(int $id): void
    {
        $this->database->presql("DELETE FROM Message WHERE id_message = :id_message");
        $this->database->bindParam(":id_message", $id);
        $this->database->execute();
    }

    public function readMessage(int $id): void
    {
        $this->database->presql("UPDATE Message SET readed = 1 WHERE id_message = :id_message");
        $this->database->bindParam(":id_message", $id);
        $this->database->execute();
    }

    public function unreadMessage(int $id): void
    {
        $this->database->presql("UPDATE Message SET readed = 0 WHERE id_message = :id_message");
        $this->database->bindParam(":id_message", $id);
        $this->database->execute();
    }
}
