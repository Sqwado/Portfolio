<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $hashedPassword = hashPassword($password);
}
else {
    $hashedPassword = null;
}

function hashPassword($password) {
    // Utiliser un algorithme de hachage sécurisé, comme password_hash en PHP
    $hashedPassword = password_hash(htmlspecialchars($password), PASSWORD_DEFAULT, ['cost' => 14]);
    return $hashedPassword;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hasher</title>
</head>
<body>
    <h1>Password Hasher</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="password">Enter Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Hash Password</button>
    </form>
    <?php if ($hashedPassword): ?>
        <p>Hashed Password: <?php echo $hashedPassword; ?></p>
    <?php endif; ?>
</body>
</html>