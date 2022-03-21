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
      <a class="nav-item nav-link active" href="#" data-table="documents">Document</a>
      <a class="nav-item nav-link" href="#" data-table="articles">Articles</a>
      <a class="nav-item nav-link" href="#" data-table="filieres">Filieres</a>
    </div>
    <ul class="navbar-nav ml-auto">
      <li>
        <a class="nav-item nav-link active mr-2">Bienvenu,
          <?php if (isset($_SESSION['username'])) echo $_SESSION['username'];
          else echo "User" ?></a>
      </li>
      <li>
        <a class="btn btn-secondary" href="../login.php?logout"><i class="fa fa-sign-out"></i> Se déconnecter</a>
      </li>
    </ul>
  </div>
</nav>