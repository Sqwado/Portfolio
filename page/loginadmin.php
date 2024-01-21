<?php

session_start();

if (isset($_SESSION["admin"]) && !empty($_SESSION["admin"])) {
    header("Location: /homeadmin");
    exit();
}

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

if (isset($parts[2]) && !empty($parts[2]) && $parts[2] == "login") {
    $token = htmlspecialchars($_POST['token']);

    if (!isset($_SESSION['token']) || $token != $_SESSION['token']) {
        $_SESSION["message"] = "Erreur de token";
        header("Location: /loginadmin");
        exit();
    }

    if (isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["password"])) {
        $admin = new Admin($database);

        try {
            $admin->login($_POST["email"], $_POST["password"]);
            header("Location: /homeadmin");
            exit();
        } catch (Exception $e) {
            $_SESSION["message"] = $e->getMessage();
        }
        header("Location: /loginadmin");
        exit();
    } else {
        $_SESSION["message"] = "Erreur lors de la connexion";
        header("Location: /loginadmin");
        exit();
    }
} else {
    $_SESSION['token'] = bin2hex(random_bytes(35));
}

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

        <div class="login-box">
            <p>Login</p>
            <?php
            if (isset($_SESSION["message"]) && !empty($_SESSION["message"])) {
                $message = $_SESSION["message"];
                echo "<p class='msg' id='message'>$message</p>";
                unset($_SESSION["message"]);
            }else{
                echo "<p class='msg' id='message'></p>";
            }
            ?>
            <form id="form_log" method="post" action='/loginadmin/login'>
                <div class="user-box">
                    <input required id="email" name="email" type="email">
                    <label>Email</label>
                </div>
                <div class="user-box">
                    <input required id="password" name="password" type="password">
                    <label>Password</label>
                </div>
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
                <a id="submit">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Submit
                    <input type="submit" hidden>
                </a>
            </form>
        </div>

    </div>
</body>

<script>
    const submit = document.getElementById("submit");
    const form = document.getElementById("form_log");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const message = document.getElementById("message");

    submit.addEventListener("click", () => {
        if (email.value == "" || password.value == "") {
            message.innerHTML = "Veuillez remplir tous les champs";
        } else {
            form.submit();
        }
    })
    
</script>

</html>
