<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Accueil</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/gif/png" href="images/assets/favicon.ico" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" defer></script>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/index.css" />
  </head>

  <body>
    <div class="container">
      <!-- Header -->
      <?php require 'includes/header.php'; ?>
      <!-- ./Header -->

      <!-- Main -->
      <div class="row banner-section">
        <div class="col-md-6">
          <div class="banner-img m-auto">
            <img src="images/assets/my_files.svg" alt="" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="banner-title mt-4 m-auto">
            <h1>Inscrivez vous et téléchargez plus de 10 000 support !</h1>
            <?php if (!isset($_SESSION['id_user'])) : ?>
            <a href="register.php" class="btn btn-outline-info mt-2 mr-3 text-white">S'inscire</a>
            <a href="login.php" class="btn btn-primary mt-2">Se connecter</a>
            <?php endif ?>
          </div>
        </div>
      </div>
      <!-- ./Main -->

      <!-- Footer -->
      <?php require 'includes/footer.php'; ?>
      <!-- ./Footer -->
    </div>
  </body>
</html>
