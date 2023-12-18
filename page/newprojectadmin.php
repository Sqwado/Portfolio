<?php

$code = <<< EOT
<h6>test</h6>
<div class="img_wrapper">
    <img src="https://picsum.photos/1920/1080">
</div>
<div class="img_wrapper">
    <img src="https://picsum.photos/1900/1080">
</div>
<hr>
<h6>test</h6>
<div class="img_wrapper">
    <img src="https://picsum.photos/920/600">
</div>
EOT;

if (isset($_POST) && !empty($_POST)) {
    $code = $_POST["code"];
}

unset($_POST);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Portfolio</title>
    <link rel="stylesheet" href="/css/newprojectadmin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark-dimmed.css">
</head>

<body>
    <?php include "components/navadmin.php"; ?>
    <main>
        <div class="code">
            <h3>Code</h3>

            <form action=<?php echo $_SERVER["REQUEST_URI"]; ?> method="post">
                <pre>
                    <code class="language-html" contenteditable="true" spellcheck='false'><?php echo htmlspecialchars($code); ?></code>
                 </pre>

                <input type="hidden" name="code" id="code_value" value="<?php echo htmlspecialchars($code); ?>">

                <input type="submit" value="Envoyer">
            </form>

            <button id="add_img">Ajouter une image</button>
            <button id="clean_code">Beautify</button>
        </div>

        <div class="show">
            <h3>Preview</h3>
            <div class="preview">
                <?php echo $code; ?>
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