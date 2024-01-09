<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$competence = new Competence($database);

if(!isset($parts[2]) || !is_numeric($parts[2])){
    header("Location: /competenceadmin");
    exit();
}else{
    $id = (int) $parts[2];
    $competences = $competence->getCompetence($id)[0];
}

if (isset($_POST["titre"]) && !empty($_POST["titre"]) && isset($_POST["description"]) && !empty($_POST["description"]) && isset($_POST["logo"]) && !empty($_POST["logo"])) {
    $titre = htmlspecialchars($_POST["titre"]);
    $description = htmlspecialchars($_POST["description"]);
    $logo = htmlspecialchars($_POST["logo"]);

    try {
        $competence->updateCompetence($id, $titre, $logo, $description);
        $_SESSION["message"] = "Competence modifiée";
    } catch (Exception $e) {
        $_SESSION["message"] = "Erreur lors de la modification de la competence";
    }

    header("Location: /competenceadmin");
    exit();
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
            <h2>Modify Competence</h2>
        </div>

        <div class="content new">

            <div class="back">
                <a href="/competenceadmin">Retour</a>
            </div>

            <form action="/newcompetenceadmin" method="POST" enctype="multipart/form-data">
                <div class="form">
                    <div class="input">
                        <label for="logo">Logo Path</label>
                        <input type="text" name="logo" id="logo" value="<?php echo $competences["logo"] ?>" required>
                    </div>
                    <div class="input">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" value="<?php echo $competences["titre"] ?>" required>
                    </div>
                    <div class="input">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" required><?php echo $competences["description"] ?></textarea>
                    </div>
                    <div class="input">
                        <input type="submit" value="Modifier">
                    </div>
                </div>
            </form>

        </div>

    </main>

</body>