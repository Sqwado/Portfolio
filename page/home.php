<?php

session_start();

$request_uri = explode(".", $_SERVER["REQUEST_URI"]);

$is_file = end($request_uri);

if ($is_file == "php" || $is_file == "html") {
    header("Location: /home");
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

if (isset($parts[2]) && !empty($parts[2]) && $parts[2] == "newmessage") {
    $token = htmlspecialchars($_POST['token']);

    if (!isset($_SESSION['token']) || $token != $_SESSION['token']) {
        $_SESSION["message"] = "Erreur lors de l'envoi du message";
        header("Location: /home");
        exit();
    }

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
} else {
    $_SESSION['token'] = bin2hex(random_bytes(35));
}

$project = new Project($database);

$projects = $project->getProjects();

$competence = new Competence($database);

$competences = $competence->getCompetences();

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
    <?php include("components/nav.php"); ?>
    <h1>Home</h1>

    <?php if (isset($_SESSION["message"]) && !empty($_SESSION["message"])) : ?>
        <div class="message">
            <h3><?php echo $_SESSION["message"]; ?></h3>
        </div>
    <?php
        unset($_SESSION["message"]);
    endif; ?>

    <div class="body_switch">
        <div>
            <h2>Présentation</h2>
            <div class="presentation">
                <div class="main_info">
                    <img class="profil_img" src="/assets/profil.jpg" alt="Photo de profil">
                    <div class="perso_info">
                        <h3 class="info_title">À PROPOS DE MOI</h3>
                        <hr>
                        <p>Hey, je suis Mateo Luque, Sqwado comme pseudo sur le web.
                            Je suis étudiant en informatique.
                            Actuellement en B2 informatique à Sophia Ynov Campus, je prépare un
                            Mastère Expert Informatique de septembre 2022 à septembre 2027.
                            Passionné par le fonctionnement des choses au sens logique,
                            je suis toujours curieux d'apprendre plus sur les nouvelles technologies et celles de demain.
                        </p>
                    </div>
                </div>
                <div class="social">
                    <a href="https://www.linkedin.com/in/mateo-luque-983a4a293/" target="_blank">
                        <img class="logo_social" src="/assets/linkedin.svg" alt="Logo Linkedin">
                    </a>
                    <a href="https://github.com/Sqwado" target="_blank">
                        <img class="logo_social" src="/assets/github.svg" alt="Logo Github">
                    </a>
                    <a href="/assets/CV_Mateo_Luque.pdf" target="_blank">
                        ↓ curriculum vitae
                    </a>
                </div>
            </div>
        </div>
        <div>
            <h2>Compétences</h2>
            <div class="competences">
                <?php foreach ($competences as $competence) : ?>
                    <div class="competence">
                        <div class="top_competence">
                            <img class="logo_competence" src="<?php echo $competence["logo"]; ?>" alt="<?php echo $competence["titre"]; ?>">
                            <p><?php echo $competence["titre"]; ?></p>
                        </div>
                        <p><?php echo $competence["description"]; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="body_switch">
        <div>
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
        </div>

        <div>
            <h2>Articles</h2>
            <div class="articles">
                <?php foreach ($articles as $article) : ?>
                    <a href="/article/<?php echo $article["id_article"]; ?>">
                        <div class="article">
                            <h3><?php echo $article["titre"]; ?></h3>
                            <div class="category_container">
                                <?php
                                $categorie = new Article_categorie($database);
                                $categorie->join_categorie = true;
                                $categories = $categorie->getArticle_CategorieByArticle($article["id_article"]);

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
                            <div class="main_img_article_container">
                                <img class="main_img_article" src="<?php echo $article["main_img"]; ?>" alt="<?php echo $article["titre"]; ?>">

                            </div>
                            <p class="description"><?php echo $article["description"]; ?></p>
                            <p><?php echo $article["publi_date"]; ?></p>

                        </div>
                    </a>
                <?php endforeach; ?>

            </div>
        </div>

    </div>

    <h3>Me contacter</h3>
    <div class="contact">
        <div class="contact_info">
            <p>Vous pouvez me contacter par mail à l'adresse suivante :
                <span class="email">
                    <a href="mailto:mateoluque@aol.com">mateoluque@aol.com</a>
                </span>
            </p>
            <p>Ou par téléphone au :
                <span class="phone">
                    <a href="tel:+33609604750">+336 09 60 47 50</a>
                </span>
            </p>
        </div>
        <form class="contact_form" action="/home/newmessage" method="post">
            <h4>Envoyer un message</h4>
            <p>Vous pouvez aussi m'envoyer un message directement depuis le system interne du site</p>
            <input type="email" name="email" placeholder="Email de recontact" required>
            <textarea name="content" placeholder="Message" required cols="40" rows="7"></textarea>
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
            <input type="submit" value="Envoyer">
        </form>
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