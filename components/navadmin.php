<head>
    <link rel="stylesheet" href="/css/navadmin.css">
</head>

<header>
    <div class="TopBar">
        <h1>Admin</h1>
        <object>
            <a href="/logoutadmin" class="logout">Log Out</a>
        </object>
    </div>
    <div class="nav">
        <a href="/homeadmin" id="homeadmin" class="redirect">Home</a>
        <a href="/projectadmin" id="projectadmin" class="redirect">Projects</a>
        <a href="/articleadmin" id="articleadmin" class="redirect">Articles</a>
        <a href="/categorieadmin" id="articleadmin" class="redirect">Categories</a>
        <a href="/messageadmin" id="messageadmin" class="redirect">Messages</a>
        <a href="/competenceadmin" id="competenceadmin" class="redirect">Competences</a>
    </div>

    <script>
        try {
            document.getElementById("<?php echo explode("/", $_SERVER["REQUEST_URI"])[1] ?>").classList.add("active");
        } catch (e) {
            console.log(e);
        }
    </script>

</header>