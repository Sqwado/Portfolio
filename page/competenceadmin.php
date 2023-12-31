<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$competence = new Competence($database);

if (isset($parts[2]) && is_numeric($parts[2]) && isset($parts[3]) && $parts[3] == "delete") {
    $id = (int) $parts[2];
    $competence->deleteCompetence($id);
    header("Location: /competenceadmin");
    exit();
}

$competences = $competence->getCompetences();

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
            <h2>Competences</h2>
        </div>

        <div class="content">

            <?php

            foreach ($competences as $competence) {
                echo "<div class='competence'>";
                echo "<img class='main_img' src='" . $competence["logo"] . "' alt=''>";
                echo "<h3>" . $competence["titre"] . "</h3>";
                echo "<p>" . $competence["description"] . "</p>";
                echo "<a href='/competenceadmin/" . $competence["id_competence"] . "/delete'>Supprimer</a>";
                echo "</div>";
            }

            ?>

        </div>

    </main>

</body>