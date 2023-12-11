<?php
session_start();
if (isset($_SESSION["admin"]) && !empty($_SESSION["admin"])) {
    empty($_SESSION["admin"]);
    session_unset();
    session_destroy();
    header("Location: /loginadmin");
    exit();
} else {
    header("Location: /loginadmin");
}
