<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$competence = new Competence($database);

if (isset($_POST["titre"]) && !empty($_POST["titre"]) && isset($_POST["description"]) && !empty($_POST["description"]) && isset($_POST["logo"]) && !empty($_POST["logo"])) {
    $token = htmlspecialchars($_POST['token']);

    if (!isset($_SESSION['token']) || $token != $_SESSION['token']) {
        $_SESSION["message"] = "Erreur lors de l'envoi du message";
        header("Location: /contact");
        exit();
    }

    $titre = htmlspecialchars($_POST["titre"]);
    $description = htmlspecialchars($_POST["description"]);
    $logo = htmlspecialchars($_POST["logo"]);

    try {
        $competence->createCompetence($titre, $logo, $description);
        $_SESSION["message"] = "Competence ajoutée";
    } catch (Exception $e) {
        $_SESSION["message"] = "Erreur lors de l'ajout de la competence";
    }

    header("Location: /competenceadmin");
    exit();
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
    <title>Portfolio</title>
    <link rel="stylesheet" href="/css/competenceadmin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
</head>

<body>
    <?php include "components/navadmin.php"; ?>

    <main>
        <div class="top">
            <h2>New Competence</h2>
        </div>

        <div class="content new">

            <div class="back">
                <a href="/competenceadmin">Retour</a>
            </div>

            <form action="/newcompetenceadmin" method="POST" enctype="multipart/form-data">
                <div class="form">
                    <div class="input">
                        <label for="logo">Logo Path</label>
                        <input type="text" name="logo" id="logo" required>
                    </div>
                    <div class="input">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" required>
                    </div>
                    <div class="input">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" required></textarea>
                    </div>
                    <div class="input">
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
                        <input type="submit" value="Ajouter">
                    </div>
                </div>
            </form>

        </div>

    </main>

</body>