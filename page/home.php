<?php

session_start();

$request_uri = explode(".", $_SERVER["REQUEST_URI"]);

$is_file = end($request_uri);

if ($is_file == "php" || $is_file == "html") {
    header("Location: /home");
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

if (isset($parts[2]) && !empty($parts[2])) {
    if ($parts[2] == "newmessage") {
        if (isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["content"]) && !empty($_POST["content"])) {
            $message = new Message($database);

            try {
                $message->createMessage($_POST["email"], $_POST["content"]);
                $_SESSION["message"] = "Message envoyé";
            } catch (Exception $e) {
                $_SESSION["message"] = "Erreur lors de l'envoi du message";
            }
            header("Location: /home");
            exit();
        } else {
            $_SESSION["message"] = "Erreur lors de l'envoi du message";
            header("Location: /home");
            exit();
        }
    }
}

$project = new Project($database);

$projects = $project->getProjects();

$article = new Article($database);

$articles = $article->getArticles();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/css/home.css">
</head>

<body>
    <h1>Home</h1>

    <?php if (isset($_SESSION["message"]) && !empty($_SESSION["message"])) : ?>
        <div class="message">
            <h3><?php echo $_SESSION["message"]; ?></h3>
        </div>
    <?php
        unset($_SESSION["message"]);
    endif; ?>

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
                                            <a href="/categorie/<?php echo $categorie["id_categorie"]; ?>">
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

        <h2>Articles</h2>
        <div class="articles">


        </div>

        <h3>Me contacter</h3>
        <div class="container">
            <form class="contact" action="<?php echo $_SERVER["REQUEST_URI"]; ?>/newmessage" method="post">
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="content" placeholder="Message" required cols="40" rows="7"></textarea>
                <input type="submit" value="Envoyer">
            </form>
        </div>

    </div>

    <script>
        const message = document.querySelector(".message");

        if (message) {
            setTimeout(() => {
                message.style.display = "none";
            }, 5000);
        }
    </script>

</body>