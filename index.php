<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

# use the following line to switch between local and remote database
$db_local = false;

if ($db_local) {
    require "DB_Credentials_local.php";
} else {
    require "DB_Credentials.php";
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

// gestion des redirections

if ($parts[1] == "api") {
    include("api_redirect.php");
    exit();
}

if ($parts[1] == "home") {
    include("page/home.php");
} elseif ($parts[1] == "project") {
    include("page/project.php");
} elseif ($parts[1] == "article") {
    include("page/article.php");
} elseif ($parts[1] == "loginadmin") {
    include("page/loginadmin.php");
} elseif ($parts[1] == "logoutadmin") {
    include("page/logoutadmin.php");
} elseif ($parts[1] == "homeadmin") {
    include("page/homeadmin.php");
} elseif ($parts[1] == "projectadmin") {
    include("page/projectadmin.php");
} elseif ($parts[1] == "newprojectadmin") {
    include("page/newprojectadmin.php");
} elseif ($parts[1] == "modifyprojectinfoadmin") {
    include("page/modifyprojectinfoadmin.php");
} elseif ($parts[1] == "modifyprojectcontentadmin") {
    include("page/modifyprojectcontentadmin.php");
} elseif ($parts[1] == "messageadmin") {
    include("page/messageadmin.php");
} else {
    header("Location: /home");
}
