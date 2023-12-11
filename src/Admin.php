<?php

class Admin
{
    public function __construct(
        public Database $database
    ) {
    }

    public function getAdminById(int $id): array
    {
        $this->database->presql("SELECT * FROM Admin WHERE id_admin = :id_admin");
        $this->database->bindParam(":id_admin", $id);
        $this->database->execute();

        return $this->database->data;
    }

    public function getAdminByEmail(string $email): array
    {
        $this->database->presql("SELECT * FROM Admin WHERE email = :email");
        $this->database->bindParam(":email", $email);
        $this->database->execute();

        return $this->database->data;
    }

    public function getAdmins(): array
    {
        $this->database->presql("SELECT * FROM Admin");
        $this->database->execute();

        return $this->database->data;
    }

    public function createAdmin(string $email, string $password): void
    {
        $this->getAdminByEmail($email);
        if (!empty($this->database->data)) {
            throw new Exception("Email already used");
        } else {
            $options = [
                'cost' => 14,
            ];
            $password = password_hash($password, PASSWORD_DEFAULT, $options);

            $this->database->presql("INSERT INTO Admin (email, password) VALUES (:email, :password)");
            $this->database->bindParam(":email", $email);
            $this->database->bindParam(":password", $password);
            $this->database->execute();
        }
    }

    public function updateAdmin(int $id, string $email, string $password): void
    {
        $this->database->presql("UPDATE Admin SET email = :email, password = :password WHERE id_admin = :id_admin");
        $this->database->bindParam(":id_admin", $id);
        $this->database->bindParam(":email", $email);
        $this->database->bindParam(":password", $password);
        $this->database->execute();
    }

    public function deleteAdmin(int $id): void
    {
        $this->database->presql("DELETE FROM Admin WHERE id_admin = :id_admin");
        $this->database->bindParam(":id_admin", $id);
        $this->database->execute();
    }

    public function login(string $email, string $password): void
    {
        $this->getAdminByEmail($email);
        if (empty($this->database->data)) {
            throw new Exception("Email not found");
        } else {
            $admin = $this->database->data[0];
            if (password_verify($password, $admin["password"])) {
                $_SESSION["admin"] = $admin;
            } else {
                throw new Exception("Wrong password");
            }
        }
    }
}
