<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$message = new Message($database);

if (isset($parts[2]) && is_numeric($parts[2]) && isset($parts[3]) && $parts[3] == "read") {
    $id = (int) $parts[2];
    $message->readMessage($id);
    header("Location: /messageadmin");
    exit();
}

$messages = $message->getMessages();

$unread = [];

foreach ($messages as $message) {
    if ($message["readed"] == 0) {
        $unread[] = $message;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="/css/messageadmin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
</head>

<body>
    <?php include "components/navadmin.php"; ?>

    <main>
        <div class="top">
            <h2>Messages</h2>
            <p>Vous avez reçu <?= count($unread) ?> messages</p>
        </div>

        <div class="content">

            <div class="filter">

                <div>
                    <label for="email">Email :</label>
                    <input type="text" id="email" placeholder="Rechercher par email">
                </div>

                <br>

                <div>
                    <label for="read">A lire :</label>
                    <input type="checkbox" id="read">
                </div>

                <div>
                    <button id="reload">Reload</button>
                </div>

            </div>

            <div class="top-message">
                <p>Email</p>
                <p>Date</p>
                <p>Lu</p>
                <p>Message</p>
                <p>Action</p>
            </div>

            <div class="messages" id="messages_conteneur">
                <?php foreach ($messages as $message) { ?>
                    <div class="message">
                        <p class="message-email"><?= $message["email"] ?></p>
                        <p class="message-date"><?= $message["sending_date"] ?></p>
                        <p class="message-read"><?php if ($message["readed"]  == 0) echo "non";
                                                else echo "oui"; ?></p>
                        <p class="message-content"><?= $message["content"] ?></p>
                        <div class="message-action">
                            <?php if ($message["readed"] == 0) { ?>
                                <a href="/messageadmin/<?= $message["id_message"] ?>/read">Lire</a>
                            <?php } ?>
                            <a href="/messageadmin/<?= $message["id_message"] ?>/delete">Supprimer</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <script>
        const messages_conteneur = document.getElementById("messages_conteneur");
        const email = document.getElementById("email");
        const read = document.getElementById("read");
        const reload = document.getElementById("reload");

        let messages = <?= json_encode($messages) ?>;
        let unread = <?= json_encode($unread) ?>;

        email.addEventListener("keyup", () => {
            loadmessage();
        });

        read.addEventListener("change", () => {
            loadmessage();
        });

        reload.addEventListener("click", () => {
            fetchmessage()
        });

        function loadmessage() {
            let value = email.value;
            messages_conteneur.innerHTML = "";

            if (value == "") {

                if (read.checked) {
                    for (let message of unread) {
                        addmessage(message);
                    }
                } else {
                    for (let message of messages) {
                        addmessage(message);
                    }
                }
            } else {

                if (read.checked) {
                    for (let message of unread) {
                        if (message.email.includes(value)) {
                            addmessage(message);
                        }
                    }
                } else {
                    for (let message of messages) {
                        if (message.email.includes(value)) {
                            addmessage(message);
                        }
                    }
                }
            }

        }

        function addmessage(message) {
            let message_content = ""
            message_content += `
                        <div class="message">
                            <p class="message-email">${message.email}</p>
                            <p class="message-date">${message.sending_date}</p>
                            <p class="message-read">${message.readed == 0 ? "non" : "oui"}</p>

                            <p class="message-content">${message.content}</p>
                            <div class="message-action">
                                <a href="/messageadmin/${message.id_message}/read">Lire</a>`
            if (message.readed == 0) {
                message_content += `
                                <a href="/messageadmin/${message.id_message}/delete">Supprimer</a>`
            }
            message_content += `
                            </div>
                        </div>
                    `;
            messages_conteneur.innerHTML += message_content;
        }

        async function fetchmessage() {
            let response = await fetch(window.location.origin + "/api/getmessage", {
                method: "GET",
                headers: {
                    Accept: "application/json",
                    "Content-type": "application/json; charset=UTF-8",
                },
            }).then((response) => {
                if (response.ok) {
                    response.json().then((data) => {
                        messages = data;
                        setunread();
                        loadmessage();
                    });
                }
            });
        }

        function setunread() {
            unread = [];

            for (let message of messages) {
                if (message.readed == 0) {
                    unread.push(message);
                }
            }
        }
    </script>

</body>

</html>