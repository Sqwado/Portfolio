<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$project = new Project($database);

if (isset($parts[2]) && is_numeric($parts[2]) && isset($parts[3]) && $parts[3] == "delete") {
    $id = (int) $parts[2];
    $project->deleteProject($id);
    header("Location: /projectadmin");
    exit();
}

$projects = $project->getProjects();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="/css/project.css">
</head>

<body>

    <?php include "components/navadmin.php"; ?>

    <main>
        <div class="top">
            <h2>Projects</h2>
            <object>
                <a href="/newprojectadmin" class="new_project not-selectable">New<img src="/assets/plus.svg"></a>
            </object>
        </div>

        <div class="projects">
            <?php if (empty($projects)) : ?>
                <p>Aucun projet</p>
            <?php endif; ?>
            <?php foreach ($projects as $project) : ?>
                <a href="/modifyprojectinfoadmin/<?php echo $project["id_project"]; ?>">
                    <div class="project">
                        <h3><?php echo $project["titre"]; ?></h3>
                        <div class="category_container">
                            <?php
                            $categorie = new Project_categorie($database);
                            $categorie->join_categorie = true;
                            $categories = $categorie->getProject_CategorieByProject($project["id_project"]);

                            if (!empty($categories)) {
                                foreach ($categories as $categorie) : ?>
                                    <div class="category not-selectable">
                                        <img class="logo_category" src="<?php echo $categorie["logo"]; ?>" alt="<?php echo $categorie["nom"]; ?>">
                                        <p><?php echo $categorie["nom"]; ?></p>
                                        <object>
                                            <a href="/home/<?php echo $categorie["id_categorie"]; ?>">
                                                <span class="link"></span>
                                            </a>
                                        </object>
                                    </div>
                            <?php endforeach;
                            } else {
                                echo "<p>Aucune catégorie</p>";
                            }
                            ?>
                        </div>
                        <div class="main_img_project_container">
                            <img class="main_img_project" src="<?php echo $project["main_img"]; ?>" alt="<?php echo $project["titre"]; ?>">
                        </div>
                        <p class="description"><?php echo $project["description"]; ?></p>
                        <p><?php echo $project["publi_date"]; ?></p>

                        <object class="delete_proj not-selectable">
                            <span class="delete_but" id="<?php echo $project["id_project"] ?>">Delete Project</span>
                        </object>

                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    </main>

    <script>
        let delete_but = document.getElementsByClassName("delete_but");

        Array.prototype.forEach.call(delete_but, function(element) {
            element.addEventListener("click", function() {
                event.preventDefault();
                let id_project = element.id;
                let confirm = window.confirm("Are you sure you want to delete this project ?");
                if (confirm) {
                    window.location.href = "/projectadmin/" + id_project + "/delete";
                }
            });
        });
    </script>

</body>

</html>