<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$article = new Article($database);

$article_categories = new Article_categorie($database);

if (isset($parts[2]) && is_numeric($parts[2]) && isset($parts[3]) && $parts[3] == "delete") {
    $id = (int) $parts[2];
    $article->deleteArticle($id);
    header("Location: /articleadmin");
    exit();
} else if (isset($parts[2]) && $parts[2] == "categorie" && isset($parts[3]) && is_numeric($parts[3])) {
    $id_categorie = (int) $parts[3];
    $article_categories->join_article = true;
    $articles = $article_categories->getArticle_CategorieByCategorie($id_categorie);
    $categorie = new Categorie($database);
    $categorie = $categorie->getCategorie($id_categorie)[0];
    if (empty($categorie)) {
        header("Location: /articleadmin");
        exit();
    }
} else {
    $articles = $article->getArticles();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link rel="stylesheet" href="/css/article.css">
</head>

<body>

    <?php include "components/navadmin.php"; ?>

    <main>
        <div class="top">
            <h2>Articles</h2>
            <object>
                <a href="/newarticleadmin" class="new_article not-selectable">New<img src="/assets/plus.svg"></a>
            </object>
        </div>

        <div class="articles">
            <?php if (empty($articles)) : ?>
                <p>Aucun article</p>
            <?php endif; ?>
            <?php foreach ($articles as $article) : ?>
                <a href="/modifyarticleinfoadmin/<?php echo $article["id_article"]; ?>">
                    <div class="article">
                        <h3><?php echo $article["titre"]; ?></h3>
                        <div class="category_container">
                            <?php
                            $categorie = new Article_categorie($database);
                            $categorie->join_categorie = true;
                            $categories = $categorie->getArticle_CategorieByArticle($article["id_article"]);

                            if (!empty($categories)) {
                                foreach ($categories as $categorie) : ?>
                                    <div class="category not-selectable">
                                        <img class="logo_category" src="<?php echo $categorie["logo"]; ?>" alt="<?php echo $categorie["nom"]; ?>">
                                        <p><?php echo $categorie["nom"]; ?></p>
                                        <object>
                                            <a href="/articleadmin/categorie/<?php echo $categorie["id_categorie"]; ?>">
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

                        <object class="delete_art not-selectable">
                            <span class="delete_but" id="<?php echo $article["id_article"] ?>">Delete Article</span>
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
                let id_article = element.id;
                let confirm = window.confirm("Are you sure you want to delete this article ?");
                if (confirm) {
                    window.location.href = "/articleadmin/" + id_article + "/delete";
                }
            });
        });
    </script>

</body>

</html>