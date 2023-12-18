<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$projects = new Project($database);

if (isset($parts[2]) && is_numeric($parts[2])) {
    $id = (int) $parts[2];
    $project = $projects->getProject($id)[0];
    if (empty($project)) {
        header("Location: /projectadmin");
        exit();
    }

    if (isset($parts[3]) && $parts[3] == "save") {
        $projects->updateProject($id, $_POST["titre"], $_POST["main_img"], $_POST["description"], $_POST["publi_date"], $project["content"]);
        header("Location: /modifyprojectinfoadmin/$id");
        exit();
    }
} else {
    header("Location: /projectadmin");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Portfolio</title>
    <link rel="stylesheet" href="/css/newprojectadmin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark-dimmed.css">
</head>

<body>
    <?php include "components/navadmin.php"; ?>
    <main>

        <form action=<?php echo $_SERVER["REQUEST_URI"] . "/save"; ?> method="post">
            <div class="top">
                <h2>Modify Project</h2>
            </div>

            <div class="container">
                <div class="project">
                    <h3>Informations</h3>
                    <div class="input_wrapper">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" value="<?php echo $project["titre"]; ?>">
                    </div>
                    <div class="input_wrapper">
                        <label for="main_img">Image principale</label>
                        <input type="text" name="main_img" id="main_img" value="<?php echo $project["main_img"]; ?>">
                    </div>
                    <div class="input_wrapper">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" value="<?php echo $project["description"]; ?>">
                    </div>
                    <div class="input_wrapper">
                        <label for="publi_date">Date de publication</label>
                        <input type="date" name="publi_date" id="publi_date" value="<?php echo $project["publi_date"]; ?>">
                    </div>
                </div>
                <input type="submit" value="Save">
            </div>
        </form>


    </main>


    <script>

    </script>

</body>

</html>

<?php

?>