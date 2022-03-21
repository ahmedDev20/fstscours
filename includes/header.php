  <div class="jumbotron mb-0">
    <div class="text-left">
      <h1 style="float: center; font-size: 40px; color: white; font-weight: 600;">
        FSTSCours...
      </h1>
      <h1 style="font-size: 40px; color: white;">Cours, TDs et TPs à votre disposition.</h1>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">FSTSCours</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link" href="index.php">Accueil</a>
        <a class="nav-item nav-link" href="articles.php">Articles</a>
        <a class="nav-item nav-link 
        <?php if (basename($_SERVER['PHP_SELF']) === "documents.php") echo "active";
        else echo ""  ?>" href="filieres.php">Filieres</a>
        <a class="nav-item nav-link" href="contact.php">Contact</a>
        <a class="nav-item nav-link" href="about.php">L'équipe</a>
      </div>
      <ul class="navbar-nav ml-auto">
        <?php if (!isset($_SESSION['id_user'])) : ?>
          <?php if ($_SERVER['PHP_SELF'] != "/dakir/index.php") : ?>
            <li>
              <a class="btn btn-secondary" href="register.php"><i class="fa fa-user"></i> S'insrire</a>
            </li>
            <li>
              <a class="btn btn-primary btn-login ml-2" href="login.php"><i class="fa fa-sign-in"></i> Se connecter</a>
            </li>
          <?php endif ?>
        <?php else : ?>
          <li>
            <a class="nav-item nav-link active mr-2">Bienvenu, <?php if (isset($_SESSION['username'])) echo $_SESSION['username'] ?></a>
          </li>
          <li>
            <a class="btn btn-secondary" href="login.php?logout"><i class="fa fa-sign-out"></i> Se déconnecter</a>
          </li>
        <?php endif ?>
      </ul>
    </div>
  </nav>

  <script>
    const link = window.location.pathname.split("/").pop();
    const menuItems = document.querySelectorAll(".nav-link");
    menuItems.forEach((item) => {
      if (item.href.split("/").pop() === link) item.classList.add("active");
    });
  </script>