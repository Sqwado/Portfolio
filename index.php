<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

require "DB_Credentials.php";

$parts = explode("/", $_SERVER["REQUEST_URI"]);

// gestion des redirections

if ($parts[1] == "home") {
    include("page/home.php");
} elseif ($parts[1] == "newproject") {
    include("page/newproject.php");
} elseif ($parts[1] == "loginadmin") {
    include("page/loginadmin.php");
} elseif ($parts[1] == "logoutadmin") {
    include("page/logoutadmin.php");
} elseif ($parts[1] == "admin") {
    include("page/admin.php");
} else {
    header("Location: /home");
}
