<?php

session_start();

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$database->getConnection();

if (isset($_SESSION["Id_admin"]) && !empty($_SESSION["Id_admin"])) {
    header("Location: /adminlivre");
    exit();
}

if (!isset($_SESSION["logAdmin"])) {
    $_SESSION["logAdmin"] = 0;
}

if (isset($_POST) && !empty($_POST)) {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        showinput("Please fill all the fields");
    } else {
        $database->prepare("SELECT * FROM Admin WHERE email = :Email");
        $database->bindParam(":Email", htmlspecialchars($_POST["email"]));
        $database->execute();
        if (!empty($database->data)) {
            if (password_verify(htmlspecialchars($_POST["password"]), $database->data[0]["Password"])) {
                $_SESSION["logAdmin"] += 1;
                $_SESSION["Id_admin"] = $database->data[0]["Id_admin"];
                $_SESSION["Email_admin"] = $database->data[0]["email"];
                $_SESSION["Password_admin"] = $database->data[0]["Password"];
                header("Location: /adminlivre");
            } else {
                showinput("Wrong password");
            }
        } else {
            showinput("Email not found");
        }
    }
} else {
    showinput("");
}

function showinput($message)
{

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="/style/login.css">

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

if ($_SESSION["logAdmin"] != 1) {
    empty($_POST);
    unset($_POST);
}

?>