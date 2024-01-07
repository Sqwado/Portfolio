<head>
    <link rel="stylesheet" href="/css/nav.css">
</head>

<div class="dropnav">
    <h3 id="navdropbtn" class="dropbtn not-selectable">Menu</h3>
    <div id="navcontent" class="dropnav-content not-selectable">
        <a href="/home" id="home" class="redirect">Home</a>
        <a href="/project" id="project" class="redirect">Projects</a>
        <a href="/article" id="article" class="redirect">Articles</a>
        <a href="/categorie" id="article" class="redirect">Categories</a>
        <a href="/contact" id="contact" class="redirect">Contact</a>
    </div>
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