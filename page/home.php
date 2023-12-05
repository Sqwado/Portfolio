<?php

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
        <div class="projects">
            <h2>Projects</h2>
            <?php foreach ($projects as $project) : ?>
                <div class="project">
                    <h3><?php echo $project["titre"]; ?></h3>
                    <img class="main_img_project" src="<?php echo $project["main_img"]; ?>" alt="<?php echo $project["titre"]; ?>">
                    <p><?php echo $project["description"]; ?></p>
                    <p><?php echo $project["publi_date"]; ?></p>
                </div>
            <?php endforeach; ?>

        </div>

        <div class="articles">
            <h2>Articles</h2>

        </div>
    </div>