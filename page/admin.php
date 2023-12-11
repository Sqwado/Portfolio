<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$admin = new Admin($database);

$admins = $admin->getAdminById($_SESSION["admin"]["id_admin"]);

if (empty($admins)) {
    header("Location: /loginadmin");
}

$admin = $admins[0];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>

<body>
    <h1>Admin</h1>

    <div class="container">
        <div class="admin">
            <h2><?php echo $admin["email"]; ?></h2>
            <div class="category_container">
                <object>
                    <a href="/logoutadmin">
                        <p>Logout</p>
                    </a>
                </object>
            </div>
        </div>
    </div>

    <script src="/js/admin.js"></script>
</body>

</html>