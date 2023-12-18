<?php

class Message{

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

    public function createMessage(string $sender, string $email_back, string $content): void
    {
        $this->database->presql("INSERT INTO Message (sender, email_back, content, sending_date, read) VALUES (:sender, :email_back, :content, Now(), 0)");
        $this->database->bindParam(":sender", $sender);
        $this->database->bindParam(":email_back", $email_back);
        $this->database->bindParam(":content", $content);

        try {
            $this->database->execute();
        } catch (PDOException $e) {
           throw new Exception("Erreur lors de la création du message");
        }
    }

    public function updateMessage(int $id, string $sender, string $email_back, string $content, string $sending_date, int $read): void
    {
        $this->database->presql("UPDATE Message SET sender = :sender, email_back = :email_back, content = :content, sending_date = :sending_date, `read` = :read WHERE id_message = :id_message");
        $this->database->bindParam(":id_message", $id);
        $this->database->bindParam(":sender", $sender);
        $this->database->bindParam(":email_back", $email_back);
        $this->database->bindParam(":content", $content);
        $this->database->bindParam(":sending_date", $sending_date);
        $this->database->bindParam(":read", $read);

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
        $this->database->presql("UPDATE Message SET `read` = 1 WHERE id_message = :id_message");
        $this->database->bindParam(":id_message", $id);
        $this->database->execute();
    }

}