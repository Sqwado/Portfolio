<?php

session_start();

if (isset($_SESSION["admin"]) && !empty($_SESSION["admin"])) {
    header("Location: /homeadmin");
    exit();
}

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$admin = new Admin($database);

if (!isset($_SESSION["logAdmin"])) {
    $_SESSION["logAdmin"] = 0;
}

if (isset($_POST) && !empty($_POST)) {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        showinput("Please fill all the fields");
        clear();
        exit();
    } else {
        try {
            $admin->login(htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["password"]));
        } catch (Exception $e) {
            showinput($e->getMessage());
            clear();
            exit();
        }
        clear();
        header("Location: /homeadmin");
        exit();
    }
} else {
    showinput("");
    clear();
}

function showinput($message)
{

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="/css/loginadmin.css">

        <title>Login Admin</title>
    </head>

    <body>
        <a href="/home"><img src="/assets/left_arrow.svg" alt="" class="return"></a>
        <h1>Login Admin</h1>
        <div class=contain>

            <form method="post" action='<?php echo $_SERVER["REQUEST_URI"]; ?>'>
                <?php
                if (isset($message)) {
                    echo "<p class='msg'>$message</p>";
                }
                ?>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required class="input" placeholder="Email"><br><br>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required class="input" placeholder="password"><br><br>

                <div class="btn">
                    <input type="submit" value="Done" class="button-60" id="button">
                </div>

            </form>

        </div>
    </body>

    </html>
    <script src="/style/script.js"></script>

<?php
    $_SESSION["logAdmin"] = 0;
}

function clear()
{
    if ($_SESSION["logAdmin"] != 1) {
        empty($_POST);
        unset($_POST);
    }
}

?>