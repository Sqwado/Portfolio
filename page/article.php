<?php

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$article = new Article($database);

$parts = explode("/", $_SERVER["REQUEST_URI"]);

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

<?php

if (isset($parts[2]) && is_numeric($parts[2])) {
    $id = (int) $parts[2];
    $articles = $article->getArticle($id);

    if (empty($articles)) {
        header("Location: /article");
    } else {
        $article = $articles[0];
?>

        <body>
            <?php include("components/nav.php"); ?>
            <?php include("components/back.php"); ?>
            <div class="content">
                <div class="showcase">
                    <div class="article_show">

                        <div class="first_img">
                            <img class="first_main_img" src="<?php echo $article["main_img"]; ?>" alt="<?php echo $article["titre"]; ?>">
                        </div>

                        <div class="first_content">
                            <div class="category_container">
                                <?php $categorie = new Article_categorie($database);
                                $categorie->join_categorie = true;
                                $categories = $categorie->getArticle_CategorieByArticle($article["id_article"]);

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
                            <h2><?php echo $article["titre"]; ?></h2>
                            <p class="description"><?php echo $article["description"]; ?></p>
                            <p><?php echo $article["publi_date"]; ?></p>
                        </div>
                    </div>
                    <div>
                        <div class="article_content">
                            <?php echo $article["content"]; ?>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        <script>
            document.title = "<?php echo $article["titre"]; ?>";
        </script>

    <?php
    }
} else {
    $articles = $article->getArticles();

    ?>

    <body>
        <?php include("components/nav.php"); ?>
        <h2>Articles</h2>

        <small class="zigzag">
            Latest posts
            <img src="/assets/zigzag.svg" alt="zigzag">
        </small>

        <?php
        $article = $articles[0] ?>
        <a class="article_first" href="/article/<?php echo $article["id_article"]; ?>">

            <div class="first_img">
                <img class="first_main_img" src="<?php echo $article["main_img"]; ?>" alt="<?php echo $article["titre"]; ?>">
            </div>

            <div class="first_content">
                <?php $categorie = new Article_categorie($database);
                $categorie->join_categorie = true;
                $categories = $categorie->getArticle_CategorieByArticle($article["id_article"]);

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
                <h2><?php echo $article["titre"]; ?></h2>
                <p class="description"><?php echo $article["description"]; ?></p>
                <p><?php echo $article["publi_date"]; ?></p>
            </div>
        </a>

        <?php array_shift($articles); ?>

        <div class="articles">
            <?php
            if (empty($articles)) {
                echo "<p>Aucun article</p>";
            } else {
                foreach ($articles as $article) : ?>
                    <a class="article" href="/article/<?php echo $article["id_article"]; ?>">

                        <div class="main_img_article_container">
                            <img class="main_img_article" src="<?php echo $article["main_img"]; ?>" alt="<?php echo $article["titre"]; ?>">
                        </div>

                        <div class="main_content">
                            <div class="title_content">
                                <h3><?php echo $article["titre"]; ?></h3>
                            </div>

                            <div class="bottom_part">
                                <?php $categorie = new Article_categorie($database);
                                $categorie->join_categorie = true;
                                $categories = $categorie->getArticle_CategorieByArticle($article["id_article"]);

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
