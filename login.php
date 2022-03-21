<?php
session_start();
if (isset($_SESSION['id_user']))
  header('Location: index.php');

if (isset($_GET['logout'])) {
  session_unset();
  session_destroy();
}

if (isset($_POST["signin"])) {
  $errors = array();

  require 'includes/validation.php';
  $login = validate($_POST['login']);
  $pass = md5(validate($_POST['password']));

  $_SESSION['login'] = $login;


  require 'db/connection.php';
  $query = 'SELECT * FROM `users` WHERE (`username` = "' . $login . '"  OR `email` = "' . $login . '")';
  $result = mysqli_query($connection, $query);
  $rows = mysqli_num_rows($result);

  //If the Email or the Username is correct we'll check for the password
  if ($rows) {
    $query =  'SELECT * FROM `users` WHERE (`username` = "' . $login . '"  OR `email` = "' . $login . '") AND `password` = "' . $pass . '"';
    $result = mysqli_query($connection, $query);
    $rows = mysqli_num_rows($result);
    $user = mysqli_fetch_array($result);
    //If both are correct, the user is redirected to the documents page 
    if ($rows) {
      if (!$user['admin']) {
        $_SESSION['login'] = "";
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        header('location: index.php');
      } else {
        $_SESSION['login'] = "";
        $_SESSION['id_admin'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        header('location:admin/index.php');
      }
    } else $errors['pass'] = "Mot de passe incorrect.";
  } else $errors['login'] = "Email ou nom d'utlisateur est incorrect.";
}

?>
<html lang="en">

<head>
  <title>Login</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/gif/png" href="images/assets/favicon.ico">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" defer></script>

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/login.css" />
  <script src="js/main.js" defer></script>
</head>

<body>
  <div class="container">
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    <!-- ./Header -->

    <!-- Main -->
    <div class="row login-section d-flex align-items-center m-0">
      <div class="col-md-6">
        <h1 class="title">
          Bienvenu ! <br />
          Connectez vous.
        </h1>
      </div>
      <div class="col-md-6">
        <form method="POST" class="form login-form">
          <div class="form-group">
            <input type="text" name="login" class="form-control <?php if (isset($errors['login'])) echo 'is-invalid'; ?>" value="<?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?>" placeholder="E-mail ou Nom d'utilisateur" required />
            <div class="invalid-feedback">
              <?php if (isset($errors['login'])) echo $errors['login']; ?>
            </div>
          </div>

          <div class="form-group password-group">
            <input type="password" name="password" class="form-control <?php if (isset($errors["pass"])) echo 'is-invalid'; ?>" id="password" placeholder="Mot de passe" required />
            <i class="fa fa-eye" id="show-hide"></i>
            <div class="invalid-feedback">
              <?php if (isset($errors["pass"])) echo $errors['pass']; ?>
            </div>
          </div>

          <div class="form-group ml-auto" style="width: fit-content;width: -moz-fit-content;">
            <a href="forgot.php">mot de passe oublié ?</a>
          </div>

          <div class="form-group">
            <input type="submit" name="signin" value="Se connecter !" class="btn btn-primary" />
            <i class="fa fa-spinner fa-pulse fa-2x fa-fw d-none"></i>
          </div>
        </form>
      </div>
    </div>
    <!-- ./Main -->

    <!-- Footer -->
    <?php require 'includes/footer.php'; ?>
    <!-- ./Footer -->
  </div>
</body>

</html>