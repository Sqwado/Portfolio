<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$message = new Message($database);

$messages = $message->getMessages();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Portfolio</title>
    <link rel="stylesheet" href="/css/messageadmin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
</head>

<body>
    <?php include "components/navadmin.php"; ?>
    <div class="top">
        <h2>Messages</h2>
    </div>
    <main>

        <div class="filter">

            <label for="email">Email</label>
            <input type="text" id="email" placeholder="Rechercher par email">

            <label for="read">A lire</label>
            <input type="checkbox" id="read">

        </div>

        <div class="top-message">
            <p>Email</p>
            <p>Date</p>
            <p>Lu</p>
            <p>Message</p>
            <p>Action</p>
        </div>

        <div class="container">
            <div class="messages">
                <?php foreach ($messages as $message) { ?>
                    <div class="message">
                        <div class="message-info">
                            <p class="message-email"><?= $message["email"] ?></p>
                            <p class="message-date"><?= $message["sending_date"] ?></p>
                            <p class="message-read"><?= $message["readed"] ?></p>
                        </div>
                        <p class="message-content"><?= $message["content"] ?></p>
                        <div class="message-action">
                            <a href="/messageadmin/<?= $message["id"] ?>/read">Lire</a>
                            <a href="/messageadmin/<?= $message["id"] ?>/delete">Supprimer</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>