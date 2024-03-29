<?php

session_start();

if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
    header("Location: /loginadmin");
    exit();
}

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

$articles = new Article($database);

if (isset($parts[2]) && is_numeric($parts[2])) {
    $id = (int) $parts[2];
    $article = $articles->getArticle($id)[0];
    if (empty($article)) {
        header("Location: /articleadmin");
        exit();
    }

    if (isset($parts[3]) && $parts[3] == "save") {
        $token = htmlspecialchars($_POST['token']);

        if (!isset($_SESSION['token']) || $token != $_SESSION['token']) {
            header("Location: /modifyarticlecontentadmin/$id");
            exit();
        }

        $content = $_POST["content"];
        $content = str_replace("<?php%?>", htmlspecialchars("<?php%?>"), $content);
        $content = str_replace("<script%>", htmlspecialchars("<script>"), $content);
        $content = str_replace("<script>", htmlspecialchars("<script>"), $content);
        $content = str_replace("</script>", htmlspecialchars("</script>"), $content);
        $articles->updateArticle($id, $article["titre"], $article["main_img"], $article["description"], $article["publi_date"], $content);
        header("Location: /modifyarticlecontentadmin/$id");
        exit();
    }else{
        $_SESSION['token'] = bin2hex(random_bytes(35));
    }
} else {
    header("Location: /articleadmin");
    exit();
}

$code = $article["content"];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="/css/newarticleadmin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark-dimmed.css">
</head>

<body>
    <?php include "components/navadmin.php"; ?>
    <main>
        <div class="top">
            <h3>Modify Article</h3>
            <a href="/modifyarticleinfoadmin/<?php echo $id; ?>" class="change_content not-selectable">Modify info</a>
        </div>

        <div class="content">
            <div class="code">
                <h3>Code</h3>

                <form action=<?php echo $_SERVER["REQUEST_URI"] . "/save"; ?> method="post">
                    <pre>
                    <code class="language-html" contenteditable="true" spellcheck='false'><?php echo htmlspecialchars($code); ?></code>
                 </pre>

                    <input type="hidden" name="content" id="code_value" value="<?php echo htmlspecialchars($code); ?>">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">

                    <input type="submit" value="Envoyer">
                </form>

                <button id="add_img">Ajouter une image</button>
                <button id="add_paragraph">Ajouter un paragraphe</button>
                <button id="clean_code">Beautify</button>

            </div>

            <div class="show">
                <h3>Preview</h3>
                <div class="preview">
                    <?php echo $code; ?>
                </div>
            </div>
        </div>
    </main>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.14.11/beautify-html.js"></script>

    <script>
        console.log(<?php echo json_encode($code); ?>);

        const code = document.querySelector("code");
        const preview = document.querySelector(".preview");
        const code_value = document.querySelector("#code_value");
        const add_img = document.querySelector("#add_img");
        const add_paragraph = document.querySelector("#add_paragraph");
        const clean_code = document.querySelector("#clean_code");

        beautify();

        code.addEventListener("input", () => {
            update_code();
        });

        clean_code.addEventListener("click", () => {
            beautify();
        });

        function update_code() {
            preview.innerHTML = code.textContent;
            code_value.value = code.textContent;
        }

        function beautify() {
            code.textContent = html_beautify(code.textContent);
            update_code();
            delete code.dataset.highlighted;
            hljs.highlightAll();
            code.focus();
        }

        add_img.addEventListener("click", () => {
            insertTextAtCaret(`<div class="img_wrapper">
        <img src="https://picsum.photos/1920/1080">
        </div>`)
            beautify();
        });

        add_paragraph.addEventListener("click", () => {
            insertTextAtCaret(`<div class="text_wrapper">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.
            </p>
        </div>`)
            beautify();
        });

        function insertTextAtCaret(text) {
            var sel, range;
            if (window.getSelection) {
                sel = window.getSelection();
                if (sel.getRangeAt && sel.rangeCount) {
                    range = sel.getRangeAt(0);
                    range.deleteContents();
                    range.insertNode(document.createTextNode(text));
                }
            } else if (document.selection && document.selection.createRange) {
                document.selection.createRange().text = text;
            }
        }
    </script>

</body>

</html>

<?php

?>