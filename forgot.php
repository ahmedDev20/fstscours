<?php
session_start();
if (isset($_SESSION['id_user']))
  header('Location: index.php');

// Confirmation mail
if (isset($_POST["send"])) {
  $errors = array();

  require 'includes/validation.php';
  $email = validate($_POST['email']);

  require 'db/connection.php';
  $query = 'SELECT * FROM `users` WHERE `email` = "' . $email . '"';
  $result = mysqli_query($connection, $query);
  $rows = mysqli_num_rows($result);

  //If the Email or the Username is correct we'll check for the password
  if ($rows) {
    $_SESSION['correct_code'] = mt_rand(100000, 999999);
    $to = $email;
    $sujet = 'Réinitialisation du mot de passe';
    $body = '
      <html>
        <body>
          <div style="margin:0 auto;text-align:center;border:2px solid #eee;border-radius:10px;width:50%;">
            <h3>FSTSCours - Réinitialisation du mot de passe</h3>
            <p>Voici votre code de vérification :</p>
            <h2 style="margin:10px auto;">' . $_SESSION['correct_code'] . '</h2>
            <p>Entrer ce code pour vérifier votre identité.</p>
          </div>
        </body>
      </html>
      ';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: <webmaster@FSTSCours.ma>" . "\r\n";

    if (mail($to, $sujet, $body, $headers)) {
      $_SESSION['mail_sent'] = true;
      $_SESSION['login'] = $email;
      header('Location: forgot.php?mail_sent');
    } else {
      header('Location: forgot.php?mail_failed');
    }
    //If both are correct, the user is redirected to the documents page 
  } else $errors['email'] = "Email incorrect.";
}

// Confirmation code
if (isset($_POST["valid"])) {
  $user_code = $_POST['code'];
  if ($user_code == $_SESSION['correct_code']) {
    unset($_SESSION['correct_code']);
    $_SESSION['change_pass'] = true;
    header('Location: forgot.php?change_pass');
  } else {
    $errors['code'] = "Code incorrect, ressayer.";
  }
}

// Reset password
if (isset($_POST["confirm"])) {
  require 'includes/validation.php';
  $pass = validate($_POST['pass']);
  $confirm_pass = validate($_POST['confirm_pass']);

  $errors = array();
  if (!$pass || !ctype_alnum($pass) || strlen($pass) > 20 || strlen($pass) < 4)
    $errors['pass'] = "Mot de passe non valide.";

  if (!$confirm_pass || $confirm_pass != $pass)
    $errors['confirm_pass'] = "Mots de passes non identiques !";

  if (count($errors) == 0) {
    $pass = md5($pass);
    require 'db/connection.php';
    $query = 'UPDATE `users` SET `password` = "' . $pass . '" WHERE `email` = "' . $_SESSION['login'] . '"';
    if (mysqli_query($connection, $query)) {
      unset($_SESSION['change_pass']);
      unset($_SESSION['mail_sent']);
      header('location:login.php');
    }
  }
}
?>

<html lang="en">

<head>
  <title>Mot de passe oublié</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/gif/png" href="images/assets/favicon.ico">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" defer></script>

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/forgot.css" />
  <script src="js/main.js" defer></script>
</head>

<body>
  <div class="container">
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    <!-- ./Header -->

    <!-- Main -->
    <div class="row forgot-section d-flex align-items-center m-0">
      <?php if (!isset($_SESSION['mail_sent'])) : ?>
        <!-- Verification e-mail -->
        <form method="POST" class="form forgot-form m-auto w-50">
          <h3>Récupération du compte</h3>
          <div class="form-group">
            <label for="email">Entrer votre addresse e-mail</label>
            <input type="email" name="email" class="form-control <?php if (isset($errors['email'])) echo 'is-invalid'; ?>" required />
            <div class="invalid-feedback">
              <?php if (isset($errors['email'])) echo $errors['email']; ?>
            </div>
          </div>

          <div class="form-group">
            <input type="submit" name="send" value="Envoyer" class="btn btn-primary" />
            <i class="fa fa-spinner fa-pulse fa-2x fa-fw d-none"></i>
          </div>
        </form>
      <?php elseif (isset($_SESSION['change_pass'])) : ?>
        <!-- Reset password form -->
        <form method="POST" class="form forgot-form m-auto w-50">
          <h3>Récupération du compte</h3>
          <div class="form-group">
            <label for="">Nouveau mot de passe</label>
            <input type="password" minlength="4" maxlength="20" name="pass" class="form-control <?php if (isset($errors['pass'])) echo 'is-invalid'; ?>" required />
            <div class="invalid-feedback">
              <?php if (isset($errors['pass'])) echo $errors['pass']; ?>
            </div>
          </div>
          <div class="form-group">
            <label for="">Confirmation du nouveau mot de passe</label>
            <input type="password" minlength="4" maxlength="20" name="confirm_pass" class="form-control <?php if (isset($errors['confirm_pass'])) echo 'is-invalid'; ?>" required />
            <div class="invalid-feedback">
              <?php if (isset($errors['confirm_pass'])) echo $errors['confirm_pass']; ?>
            </div>
          </div>

          <div class="form-group">
            <input type="submit" name="confirm" value="Confirmer" class="btn btn-primary" />
            <i class="fa fa-spinner fa-pulse fa-2x fa-fw d-none"></i>
          </div>
        </form>
      <?php else : ?>
        <!-- Verification code -->
        <form method="POST" class="form forgot-form m-auto w-50">
          <h3>Récupération du compte</h3>
          <div class="form-group">
            <label for="email">Entrer le code de 6 chiffres de vérification</label>
            <input type="text" minlength="6" pattern="\d*" maxlength="6" name="code" class="form-control <?php if (isset($errors['code'])) echo 'is-invalid'; ?>" required />
            <div class="invalid-feedback">
              <?php if (isset($errors['code'])) echo $errors['code']; ?>
            </div>
          </div>

          <div class="form-group">
            <input type="submit" name="valid" value="Valider" class="btn btn-primary" />
            <i class="fa fa-spinner fa-pulse fa-2x fa-fw d-none"></i>
          </div>
        </form>
      <?php endif ?>
    </div>
    <!-- Main -->

    <!-- Footer -->
    <?php require 'includes/footer.php'; ?>
    <!-- ./Footer -->
  </div>
</body>

</html>