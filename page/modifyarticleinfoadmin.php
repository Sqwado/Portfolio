<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$articles = new Article($database);

$categories = new Categorie($database);

$article_categories = new Article_categorie($database);
$article_categories->join_categorie = true;

if (isset($parts[2]) && is_numeric($parts[2])) {
    $id = (int) htmlspecialchars($parts[2]);
    $article = $articles->getArticle($id)[0];
    if (empty($article)) {
        header("Location: /articleadmin");
        exit();
    }

    if (isset($parts[3]) && $parts[3] == "deletecat" && isset($parts[4]) && is_numeric($parts[4])) {
        $id_categorie = (int) $parts[4];
        $article_categories->deleteArticle_Categorie($id_categorie);
        header("Location: /modifyarticleinfoadmin/$id");
        exit();
    } else if (isset($parts[3]) && $parts[3] == "addcat") {
        $id_categorie = (int) $_POST["categorie"];
        $article_categories->createArticle_Categorie($id, $id_categorie);
        header("Location: /modifyarticleinfoadmin/$id");
        exit();
    } else if (isset($parts[3]) && $parts[3] == "save") {
        $token = htmlspecialchars($_POST['token']);

        if (!isset($_SESSION['token']) || $token != $_SESSION['token']) {
            header("Location: /modifyarticleinfoadmin/$id");
            exit();
        }

        $articles->updateArticle($id, $_POST["titre"], $_POST["main_img"], $_POST["description"], $_POST["publi_date"], $article["content"]);
        header("Location: /modifyarticleinfoadmin/$id");
        exit();
    } else {
        $_SESSION['token'] = bin2hex(random_bytes(35));
    }
} else {
    header("Location: /articleadmin");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="/css/newarticleadmin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark-dimmed.css">
</head>

<body>
    <?php include "components/navadmin.php"; ?>
    <main>
        <div class="top">
            <h2>Modify Article</h2>
            <a href="/modifyarticlecontentadmin/<?php echo $id; ?>" class="change_content not-selectable">Modify content</a>
        </div>

        <div class="content">
            <div class="show">
                <form action=<?php echo $_SERVER["REQUEST_URI"] . "/save"; ?> method="post">
                    <div class="container">
                        <div class="article">
                            <h3>Informations</h3>
                            <div class="input_wrapper">
                                <label for="titre">Titre</label>
                                <input type="text" name="titre" id="titre" value="<?php echo $article["titre"]; ?>">
                            </div>
                            <div class="input_wrapper">
                                <label for="main_img">Image principale</label>
                                <input type="text" name="main_img" id="main_img" value="<?php echo $article["main_img"]; ?>">
                            </div>
                            <div class="input_wrapper">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="10"><?php echo $article["description"]; ?></textarea>
                            </div>
                            <div class="input_wrapper">
                                <label for="publi_date">Date de publication</label>
                                <input type="date" name="publi_date" id="publi_date" value="<?php echo $article["publi_date"]; ?>">
                            </div>
                        </div>
                        <input type="submit" value="Save">
                    </div>
                </form>
            </div>
            <div class="show">
                <h3>Preview</h3>
                <div class="article">
                    <h3 id="tire_show"><?php echo $article["titre"]; ?></h3>
                    <img id="main_img_show" class="main_img_article" src="<?php echo $article["main_img"]; ?>" alt="">
                    <p id="description_show"><?php echo $article["description"]; ?></p>
                    <p id="publi_date_show"><?php echo $article["publi_date"]; ?></p>
                </div>
            </div>
            <div class="show">
                <h3>Catégorie</h3>
                <div class="categories">
                    <?php
                    $categories = $categories->getCategories();
                    $article_categories = $article_categories->getArticle_CategorieByArticle($id);
                    foreach ($article_categories as $category) {
                    ?>
                        <div class="categorie">
                            <p><?php echo $category["nom"]; ?></p>
                            <a href="/modifyarticleinfoadmin/<?php echo $id; ?>/deletecat/<?php echo $category["id_art_cat"]; ?>">Delete</a>
                        </div>
                    <?php } ?>
                    <div class="add_categorie">
                        <form action="/modifyarticleinfoadmin/<?php echo $id; ?>/addcat" method="post">
                            <select name="categorie" id="categorie">
                                <?php
                                foreach ($categories as $category) {
                                    if (in_array($category["id_categorie"], array_column($article_categories, "id_categorie"))) {
                                        continue;
                                    }
                                ?>
                                    <option value="<?php echo $category["id_categorie"]; ?>"><?php echo $category["nom"]; ?></option>
                                <?php } ?>
                            </select>
                            <input type="submit" value="Add">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>


    <script>
        const tire = document.getElementById("titre");
        const main_img = document.getElementById("main_img");
        const description = document.getElementById("description");
        const publi_date = document.getElementById("publi_date");

        const tire_show = document.getElementById("tire_show");
        const main_img_show = document.getElementById("main_img_show");
        const description_show = document.getElementById("description_show");
        const publi_date_show = document.getElementById("publi_date_show");

        tire.addEventListener("input", () => {
            tire_show.innerHTML = tire.value;
        });

        main_img.addEventListener("input", () => {
            main_img_show.src = main_img.value;
        });

        description.addEventListener("input", () => {
            description_show.innerHTML = description.value;
        });

        publi_date.addEventListener("input", () => {
            publi_date_show.innerHTML = publi_date.value;
        });
    </script>

</body>

</html>

<?php

?>