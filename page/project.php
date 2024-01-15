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

                    <p><?php echo $project["content"]; ?></p>
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
        </div>

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
