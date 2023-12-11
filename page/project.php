<?php

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$project = new Project($database);

$parts = explode("/", $_SERVER["REQUEST_URI"]);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Projects</title>
    <link rel="stylesheet" href="/css/project.css">
</head>

<?php

if (isset($parts[2]) && is_numeric($parts[2])) {
    $id = (int) $parts[2];
    $projects = $project->getProject($id);

    if (empty($projects)) {
        header("Location: /project");
    } else {
        $project = $projects[0];
?>

        <body>
            <h1><?php echo $project["titre"]; ?></h1>

            <div class="container">
                <div class="project">
                    <h2><?php echo $project["titre"]; ?></h2>
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

                    <!-- <p><?php echo $project["content"]; ?></p> -->
                </div>
            </div>
        </body>

    <?php
    }
} else {
    $projects = $project->getProjects();

    ?>

    <body>
        <h1>Projects</h1>

        <div class="container">
            <div class="projects">
                <h2>Projects</h2>
                <?php foreach ($projects as $project) : ?>
                    <a href="/project/<?php echo $project["id_project"]; ?>">
                        <div class="project">
                            <h3><?php echo $project["titre"]; ?></h3>
                            <img class="main_img_project" src="<?php echo $project["main_img"]; ?>" alt="<?php echo $project["titre"]; ?>">
                            <p><?php echo $project["description"]; ?></p>
                            <p><?php echo $project["publi_date"]; ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>

            </div>
        </div>
    </body>

<?php

}
