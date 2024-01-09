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

            <div class="link">
                <a href="/newcompetenceadmin">Ajouter une competence</a>
            </div>

            <div class="competences">
                <?php foreach ($competences as $competence) : ?>
                    <div class="competence">
                        <div class="top_competence">
                            <img class="logo_competence" src="<?php echo $competence["logo"]; ?>" alt="<?php echo $competence["titre"]; ?>">
                            <p><?php echo $competence["titre"]; ?></p>
                        </div>
                        <p class="description"><?php echo $competence["description"]; ?></p>
                        <div class="link">
                            <a href="/modifycompetenceadmin/<?php echo $competence["id_competence"]; ?>">Modifier</a>
                            <object class="delete_comp not-selectable">
                                <span class="delete_but" id="<?php echo $competence["id_competence"] ?>">Delete</span>
                            </object>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </main>

    <script>
        let delete_but = document.getElementsByClassName("delete_but");

        Array.prototype.forEach.call(delete_but, function(element) {
            element.addEventListener("click", function() {
                event.preventDefault();
                let id_project = element.id;
                let confirm = window.confirm("Are you sure you want to delete this competence ?");
                if (confirm) {
                    window.location.href = "/competenceadmin/" + id_project + "/delete";
                }
            });
        });
    </script>

</body>

</html>