<head>
    <link rel="stylesheet" href="/css/navadmin.css">
</head>

<header>
    <div class="TopBar">
        <h1>Admin</h1>
        <div class="dropnav">
            <p id="navdropbtn" class="dropbtn not-selectable">Menu</p>
            <div id="navcontent" class="dropnav-content not-selectable">
                <a href="/homeadmin" id="homeadmin" class="redirect">Home</a>
                <a href="/projectadmin" id="projectadmin" class="redirect">Projects</a>
                <a href="/articleadmin" id="articleadmin" class="redirect">Articles</a>
                <a href="/categorieadmin" id="categorieadmin" class="redirect">Categories</a>
                <a href="/messageadmin" id="messageadmin" class="redirect">Messages</a>
                <a href="/competenceadmin" id="competenceadmin" class="redirect">Competences</a>
            </div>
        </div>
        <a href="/logoutadmin" class="logout not-selectable"><img src="/assets/logout.svg" ></a>
    </div>

    <script>
        try {
            document.getElementById("<?php echo explode("/", $_SERVER["REQUEST_URI"])[1] ?>").classList.add("active");
        } catch (e) {
            console.log(e);
        }

        const navdropbtn = document.getElementById("navdropbtn");
        const navcontent = document.getElementById("navcontent");

        navdropbtn.addEventListener("click", () => {
            navcontent.style.display = navcontent.style.display == "flex" ? "none" : "flex";
            navdropbtn.classList.toggle("active");
        });
    </script>

</header>