<?php

declare(strict_types=1);

error_log(print_r("test log", TRUE));

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

switch ($parts[1]) {
    case "api":
        include("api_redirect.php");
        break;
    case "home":
        include("page/home.php");
        break;
    case "project":
        include("page/project.php");
        break;
    case "article":
        include("page/article.php");
        break;
    case "loginadmin":
        include("page/loginadmin.php");
        break;
    case "logoutadmin":
        include("page/logoutadmin.php");
        break;
    case "homeadmin":
        include("page/homeadmin.php");
        break;
    case "projectadmin":
        include("page/projectadmin.php");
        break;
    case "newprojectadmin":
        include("page/newprojectadmin.php");
        break;
    case "modifyprojectinfoadmin":
        include("page/modifyprojectinfoadmin.php");
        break;
    case "modifyprojectcontentadmin":
        include("page/modifyprojectcontentadmin.php");
        break;
    case "messageadmin":
        include("page/messageadmin.php");
        break;
    case "competenceadmin":
        include("page/competenceadmin.php");
        break;
    case "newcompetenceadmin":
        include("page/newcompetenceadmin.php");
        break;
    case "modifycompetenceadmin":
        include("page/modifycompetenceadmin.php");
        break;
    case "articleadmin":
        include("page/articleadmin.php");
        break;
    case "newarticleadmin":
        include("page/newarticleadmin.php");
        break;
    case "modifyarticleadmin":
        include("page/modifyarticleadmin.php");
        break;
    default:
        header("Location: /home");
}
