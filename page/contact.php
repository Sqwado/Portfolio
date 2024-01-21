<?php

session_start();

$request_uri = explode(".", $_SERVER["REQUEST_URI"]);

$is_file = end($request_uri);

if ($is_file == "php" || $is_file == "html") {
    header("Location: /contact");
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

if (isset($parts[2]) && !empty($parts[2]) && $parts[2] == "newmessage") {
    $token = htmlspecialchars($_POST['token']);

    if (!isset($_SESSION['token']) || $token != $_SESSION['token']) {
        $_SESSION["message"] = "Erreur lors de l'envoi du message";
        header("Location: /contact");
        exit();
    }

    if (isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["content"]) && !empty($_POST["content"])) {
        $message = new Message($database);

        try {
            $message->createMessage($_POST["email"], $_POST["content"]);
            $_SESSION["message"] = "Message envoyé";
        } catch (Exception $e) {
            $_SESSION["message"] = "Erreur lors de l'envoi du message";
        }
        header("Location: /contact");
        exit();
    } else {
        $_SESSION["message"] = "Erreur lors de l'envoi du message";
        header("Location: /contact");
        exit();
    }
} else {
    $_SESSION['token'] = bin2hex(random_bytes(35));
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/css/contact.css">
</head>

<body>
    <?php include("components/nav.php"); ?>
    <h1>Contact</h1>

    <?php if (isset($_SESSION["message"]) && !empty($_SESSION["message"])) : ?>
        <div class="message">
            <h3><?php echo $_SESSION["message"]; ?></h3>
        </div>
    <?php
        unset($_SESSION["message"]);
    endif; ?>



    <h3>Me contacter</h3>
    <div class="contact">
        <div class="social">
            <a href="https://www.linkedin.com/in/mateo-luque-983a4a293/" target="_blank">
                <img class="logo_social" src="/assets/linkedin.svg" alt="Logo Linkedin">
            </a>
            <a href="https://github.com/Sqwado" target="_blank">
                <img class="logo_social" src="/assets/github.svg" alt="Logo Github">
            </a>
            <a href="/assets/CV_Mateo_Luque.pdf" target="_blank">
                ↓ curriculum vitae
            </a>
        </div>
        <div class="contact_info">
            <p>Vous pouvez me contacter par mail à l'adresse suivante :
                <span class="email">
                    <a href="mailto:mateoluque@aol.com">mateoluque@aol.com</a>
                </span>
            </p>
            <p>Ou par téléphone au :
                <span class="phone">
                    <a href="tel:+33609604750">+336 09 60 47 50</a>
                </span>
            </p>
        </div>
        <form class="contact_form" action="/contact/newmessage" method="post">
            <h4>Envoyer un message</h4>
            <p>Vous pouvez aussi m'envoyer un message directement depuis le system interne du site</p>
            <input type="email" name="email" placeholder="Email de recontact" required>
            <textarea name="content" placeholder="Message" required cols="40" rows="7"></textarea>
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
            <input type="submit" value="Envoyer">
        </form>
    </div>

    <script>
        const message = document.querySelector(".message");

        if (message) {
            setTimeout(() => {
                message.style.display = "none";
            }, 5000);
        }
    </script>

</body>