<?php

$request_uri = explode(".", $_SERVER["REQUEST_URI"]);

$is_file = end($request_uri);

if($is_file == "php" || $is_file == "html") {
    header("Location: /home");
}

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$project = new Project($database);

$projects = $project->getProjects();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="/css/home.css">
</head>

<body>
    <h1>Home</h1>

    <div class="container">
        <h2>Projects</h2>
        <div class="projects">
            <?php foreach ($projects as $project) : ?>
                <a href="/project/<?php echo $project["id_project"]; ?>">
                    <div class="project">
                        <h3><?php echo $project["titre"]; ?></h3>
                        <div class="category_container">
                            <?php
                            $categorie = new Project_categorie($database);
                            $categorie->join_categorie = true;
                            $categories = $categorie->getProject_CategorieByProject($project["id_project"]);

                            if (!empty($categories)) {
                                foreach ($categories as $categorie) : ?>
                                    <div class="category">
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
                    </div>
                </a>
            <?php endforeach; ?>

        </div>

        <div class="articles">
            <h2>Articles</h2>

        </div>
    </div>

</body>