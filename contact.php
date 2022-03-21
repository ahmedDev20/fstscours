<?php
session_start();

// Email message feedback
if (isset($_SESSION['submitted'])) {
  unset($_SESSION['submitted']);
  if (isset($_GET['message_sent'])) {
    $failed = false;
    $feedback = "Message envoyé avec succés !";
    unset($_SESSION['nom']);
    unset($_SESSION['email']);
    unset($_SESSION['sujet']);
    unset($_SESSION['message']);
  } else if (isset($_GET['message_failed'])) {
    $failed = true;
    $feedback = "Echec de l'envoi de l'email !";
  }
}

// Email sending
if (isset($_POST["send"])) {
  $_SESSION['submitted'] = true;
  require 'includes/validation.php';

  $nom = validate($_POST['nom']);
  $email = validate($_POST['email']);
  $sujet = validate($_POST['sujet']);
  $message = strip_tags($_POST['message']);

  $_SESSION['nom'] = $nom;
  $_SESSION['email'] = $email;
  $_SESSION['sujet'] = $sujet;
  $_SESSION['message'] = $message;

  $errors = array();
  if (!$nom) $errors['nom'] = 'Champ requis.';
  if (!$email) $errors['email'] = 'Champ requis.';
  if (!$message) $errors['message'] = 'Champ requis.';

  if (!count($errors)) {
    if (!ctype_alpha($nom)) $errors['nom'] = 'Nom non valide.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Email non valide.';
    $failed = true;
    $feedback = "Echec de l'envoi de l'email !";
  }
  if (!count($errors)) {
    $to = 'youremailaddress@gmail.com';
    if ($sujet == '') $sujet = 'Contact des étudiants';
    $body = '
    <html>
    <body>
    <h3>FSTSCours contact message</h3>
    <table>
    <tr>
    <th style="text-align:left">Nom</th>
    <td>' . $nom . '</td>
    </tr>
    <tr>
    <th style="text-align:left">Sujet</th>
    <td>' . $sujet . '</td>
    </tr>
    <tr>
    <th style="text-align:left">Message</th>
    <td>' . $message . '</td>
    </tr>
    </table>
    </body>
    </html>
    ';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: <" . $email . ">" . "\r\n";

    if (mail($to, $sujet, $body, $headers)) {
      require 'db/connection.php';
      $query = 'INSERT INTO `mails`(`sender_name`, `sender_email`, `message_subject`, `message_body`) VALUES ("' . $nom . '", "' . $email . '", "' . $sujet . '", "' . $message . '")';
      $result = mysqli_query($connection, $query);

      header('Location: contact.php?message_sent');
    } else {
      header('Location: contact.php?message_failed');
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Contact</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/gif/png" href="images/assets/favicon.ico">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/contact.css" />
  <script src="js/main.js" defer></script>
</head>

<body>
  <div class="container">
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    <!-- ./Header -->

    <!-- Main -->
    <div class="row contact-section d-flex align-items-center m-0">
      <div class="col-md-6">
        <h1 class="title">Nous sommes prêts, parlons !</h1>
      </div>
      <div class="col-md-6">
        <form method="POST" class="p-3 form contact-form" id="mail-form">
          <div class="form-group mb-4">
            <div class="toast m-auto d-none" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
              <div class="toast-header">
                <strong class="mr-auto">FSTSCours</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="toast-body 
              <?php if (isset($failed)) {
                if ($failed) echo 'bg-danger';
                else echo 'bg-success';
              } ?> text-white">
                <?php if (isset($feedback)) echo $feedback ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <input type="text" name="nom" placeholder="Nom" class="form-control <?php if (isset($errors["nom"])) echo 'is-invalid'; ?>" value="<?php if (isset($_SESSION['nom'])) echo $_SESSION['nom']; ?>" required>
          </div>
          <div class="invalid-feedback">
            <?php if (isset($errors["nom"])) echo $errors['nom']; ?>
          </div>
          <div class="form-group">
            <input type="email" name="email" placeholder="Email" class="form-control <?php if (isset($errors["email"])) echo 'is-invalid'; ?>" value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?>" required>
          </div>
          <div class="invalid-feedback">
            <?php if (isset($errors["email"])) echo $errors['email']; ?>
          </div>
          <div class="form-group">
            <input type="text" name="sujet" placeholder="Sujet" class="form-control" value="<?php if (isset($_SESSION['sujet'])) echo $_SESSION['sujet']; ?>">
          </div>
          <div class="form-group">
            <textarea class="form-control" name="message" placeholder="Message" required><?php if (isset($_SESSION['message'])) echo $_SESSION['message']; ?></textarea>
          </div>
          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="send" value="Envoyer">
            <i class="fa fa-spinner fa-pulse fa-2x fa-fw d-none"></i>
          </div>
        </form>
      </div>
    </div>
    <!-- Main -->

    <!-- Footer -->
    <?php require 'includes/footer.php'; ?>
    <!-- ./Footer -->
  </div>
  <?php if (isset($failed)) : ?>
    <script>
      $(".toast").removeClass('d-none');
      $(".toast").toast('show');
    </script>
  <?php endif ?>
</body>

</html>