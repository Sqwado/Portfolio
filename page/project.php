<?php

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$project = new Project($database);

$parts = explode("/", $_SERVER["REQUEST_URI"]);

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
            <?php include("components/nav.php"); ?>

            <div class="content">
                <div class="showcase">
                    <div class="project_show">

                        <div class="first_img">
                            <img class="first_main_img" src="<?php echo $project["main_img"]; ?>" alt="<?php echo $project["titre"]; ?>">
                        </div>

                        <div class="first_content">
                            <div class="category_container">
                                <?php $categorie = new Project_categorie($database);
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
                                <?php
                                    endforeach;
                                } else {
                                    echo "<p class='category'>Aucune catégorie</p>";
                                } ?>
                            </div>
                            <h2><?php echo $project["titre"]; ?></h2>
                            <p class="description"><?php echo $project["description"]; ?></p>
                            <p><?php echo $project["publi_date"]; ?></p>
                        </div>
                    </div>
                    <div>
                        <div class="project_content">
                            <?php echo $project["content"]; ?>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        <script>
            document.title = "<?php echo $project["titre"]; ?>";
        </script>

    <?php
    }
} else {
    $projects = $project->getProjects();

    ?>

    <body>
        <?php include("components/nav.php"); ?>
        <h2>Projects</h2>

        <small class="zigzag">
            Latest posts
            <svg role="img" viewBox="0 0 136 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.525 1.525a3.5 3.5 0 014.95 0L20 15.05 33.525 1.525a3.5 3.5 0 014.95 0L52 15.05 65.525 1.525a3.5 3.5 0 014.95 0L84 15.05 97.525 1.525a3.5 3.5 0 014.95 0L116 15.05l13.525-13.525a3.5 3.5 0 014.95 4.95l-16 16a3.5 3.5 0 01-4.95 0L100 8.95 86.475 22.475a3.5 3.5 0 01-4.95 0L68 8.95 54.475 22.475a3.5 3.5 0 01-4.95 0L36 8.95 22.475 22.475a3.5 3.5 0 01-4.95 0l-16-16a3.5 3.5 0 010-4.95z"></path>
            </svg> </small>

        <?php
        $project = $projects[0] ?>
        <a class="project_first" href="/project/<?php echo $project["id_project"]; ?>">

            <div class="first_img">
                <img class="first_main_img" src="<?php echo $project["main_img"]; ?>" alt="<?php echo $project["titre"]; ?>">
            </div>

            <div class="first_content">
                <?php $categorie = new Project_categorie($database);
                $categorie->join_categorie = true;
                $categories = $categorie->getProject_CategorieByProject($project["id_project"]);

                if (!empty($categories)) {
                    $categorie = $categories[0] ?>
                    <div class="category">
                        <img class="logo_category" src="<?php echo $categorie["logo"]; ?>" alt="<?php echo $categorie["nom"]; ?>">
                        <p><?php echo $categorie["nom"]; ?></p>
                        <object>
                            <a href="/home/<?php echo $categorie["id_categorie"]; ?>">
                                <span class="link"></span>
                            </a>
                        </object>
                    </div>
                <?php
                } else {
                    echo "<p class='category'>Aucune catégorie</p>";
                } ?>
                <h2><?php echo $project["titre"]; ?></h2>
                <p class="description"><?php echo $project["description"]; ?></p>
                <p><?php echo $project["publi_date"]; ?></p>
            </div>
        </a>

        <?php array_shift($projects); ?>

        <div class="projects">
            <?php
            if (empty($projects)) {
                echo "<p>Aucun projet</p>";
            } else {
                foreach ($projects as $project) : ?>
                    <a class="project" href="/project/<?php echo $project["id_project"]; ?>">

                        <div class="main_img_project_container">
                            <img class="main_img_project" src="<?php echo $project["main_img"]; ?>" alt="<?php echo $project["titre"]; ?>">
                        </div>

                        <div class="main_content">
                            <div class="title_content">
                                <h3><?php echo $project["titre"]; ?></h3>
                            </div>

                            <div class="bottom_part">
                                <?php $categorie = new Project_categorie($database);
                                $categorie->join_categorie = true;
                                $categories = $categorie->getProject_CategorieByProject($project["id_project"]);

                                if (!empty($categories)) {
                                    $categorie = $categories[0] ?>
                                    <div class="category">
                                        <img class="logo_category" src="<?php echo $categorie["logo"]; ?>" alt="<?php echo $categorie["nom"]; ?>">
                                        <p><?php echo $categorie["nom"]; ?></p>
                                        <object>
                                            <a href="/home/<?php echo $categorie["id_categorie"]; ?>">
                                                <span class="link"></span>
                                            </a>
                                        </object>
                                    </div>
                                <?php
                                } else {
                                    echo "<p class='category'>Aucune catégorie</p>";
                                } ?>
                            </div>
                        </div>
                    </a>
            <?php endforeach;
            } ?>

        </div>
    </body>

<?php

}
