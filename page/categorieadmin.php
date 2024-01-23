<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link rel="stylesheet" href="/css/categorie.css">
</head>

<body>

    <?php include "components/navadmin.php"; ?>

    <main>
        <div class="top">
            <h2>Categories</h2>
            <object>
                <a href="/newcategorieadmin" class="new_categorie not-selectable">New<img src="/assets/plus.svg"></a>
            </object>
        </div>

        <div class="content">
            <div class="categories">
                <?php 
                $categorie = new Categorie($database);
                $categories = $categorie->getCategories();
                foreach ($categories as $categorie) : ?>
                    <div class="categorie">
                        <div class="top_categorie">
                            <img class="categorie_img" src="<?php echo $categorie["logo"]; ?>" alt="">
                            <p><?php echo $categorie["nom"]; ?></p>
                        </div>
                        <div class="action">
                            <a href="/modifycategorieadmin/<?php echo $categorie["id_categorie"]; ?>">Modifier</a>
                            <a href="/categorieadmin/<?php echo $categorie["id_categorie"]; ?>/delete">Supprimer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </main>

    <script>

    </script>

</body>

</html>