<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="/css/homeadmin.css">
</head>

<body>

    <?php include "components/navadmin.php"; ?>

    <main>
        <div class="container">
            <div class="admin">

            </div>
        </div>
    </main>

</body>

</html>