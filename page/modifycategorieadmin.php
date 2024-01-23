<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$categories = new Categorie($database);

if (isset($parts[2]) && !empty($parts[2])) {
    $id = $parts[2];
    $categorie = $categories->getCategorie($id)[0];
} else {
    header("Location: /categorieadmin");
    exit();
}

if (isset($_POST["titre"]) && !empty($_POST["titre"]) && isset($_POST["logo"]) && !empty($_POST["logo"])) {
    $token = htmlspecialchars($_POST['token']);

    if (!isset($_SESSION['token']) || $token != $_SESSION['token']) {
        $_SESSION["message"] = "Erreur lors de l'envoi du message";
        header("Location: /contact");
        exit();
    }

    $titre = htmlspecialchars($_POST["titre"]);
    $logo = htmlspecialchars($_POST["logo"]);

    try {
        $categories->updateCategorie($id, $titre, $logo);
        $_SESSION["message"] = "Categorie modifiée";
    } catch (Exception $e) {
        $_SESSION["message"] = "Erreur lors de la modification de la categorie";
    }

    header("Location: /categorieadmin");
    exit();
} else {
    $_SESSION['token'] = bin2hex(random_bytes(35));
}

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
            <h2>New Categorie</h2>
        </div>

        <div class="content">
            <form action="/newcategorieadmin" method="POST">
                <div class="form">
                    <div class="input">
                        <label for="logo">Logo Path</label>
                        <input type="text" name="logo" id="logo" required value="<?php echo $categorie["logo"] ?>">
                    </div>
                    <div class="input">
                        <label for="titre">Nom</label>
                        <input type="text" name="titre" id="titre" required value="<?php echo $categorie["nom"] ?>">
                    </div>
                    <div class="input">
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
                        <input type="submit" value="Ajouter">
                    </div>
                </div>
            </form>

        </div>

    </main>

    <script>

    </script>

</body>

</html>