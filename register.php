<?php
session_start();
if (isset($_SESSION['id_user']))
    header('Location: index.php');

if (isset($_POST["register"])) {
    require 'includes/validation.php';
    require 'db/connection.php';
    $fname = validate($_POST['fname']);
    $lname = validate($_POST['lname']);
    $username = validate($_POST['username']);
    $email = validate($_POST['email']);
    $pass = validate($_POST['pass']);
    $confirm_pass = validate($_POST['confirm_pass']);

    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;

    //Form validation
    $errors = array();

    if (!$fname || !ctype_alpha($fname) || strlen($fname) > 15)
        $errors['fname'] = "Prénom non valide.";

    if (!$lname || !ctype_alpha($lname) || strlen($lname) > 25)
        $errors['lname'] = "Nom de famille non valide.";

    if (!$username || !ctype_alnum($username) || strlen($username) < 2)
        $errors['username'] = "Nom d'utilisateur non valide.";

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['email'] = "E-mail non valide.";

    if (!$pass || !ctype_alnum($pass) || strlen($pass) > 20 || strlen($pass) < 4)
        $errors['pass'] = "Mot de passe non valide.";

    if (!$confirm_pass || $confirm_pass != $pass)
        $errors['confirm_pass'] = "Mots de passes non identiques !";

    // Check if this username already exist
    $uname_existed = mysqli_query($connection, "SELECT * FROM `users` WHERE username = '$username'");
    if (mysqli_num_rows($uname_existed))
        $errors['uname_existed'] = "Ce nom d'utilisateur existe déjà.";

    // Check if this email already exist
    $email_existed = mysqli_query($connection, "SELECT * FROM `users` WHERE email = '$email'");
    if (mysqli_num_rows($email_existed))
        $errors['email_existed'] = "Cet email existe déjà.";


    if (!count($errors)) {
        $pass = md5($pass);
        $query = "INSERT INTO `users`(`id_user`, `first_name`, `last_name`, `username`, `email`, `password`) VALUES (NULL, '$fname', '$lname', '$username', '$email', '$pass')";
        if (mysqli_query($connection, $query)) {
            header('location:login.php');
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/gif/png" href="images/assets/favicon.ico">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" defer></script>

    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/register.css" />
    <script src="js/main.js"></script>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <?php include 'includes/header.php'; ?>
        <!-- ./Header -->

        <!-- Main -->
        <div class="row register-section d-flex align-items-center m-0">
            <div class="col-md-6">
                <h1 class="title">S'inscrire pour télécharger tous les documents disponibles sans limite !</h1>
            </div>
            <div class="col-md-6">
                <form method="POST" class=" form register-form mr-2 ml-auto w-75">
                    <div class="form-group">
                        <input type="text" name="fname" placeholder="Prénom" class="form-control <?php if (isset($errors["fname"])) echo 'is-invalid'; ?>" value="<?php if (isset($_POST["register"])) echo $_SESSION['fname']; ?>" required>
                        <div class="invalid-feedback">
                            <?php if (isset($_POST["register"])) echo $errors['fname']; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="lname" placeholder="Nom de famille" class="form-control <?php if (isset($errors["lname"])) echo 'is-invalid'; ?>" value="<?php if (isset($_POST["register"])) echo $_SESSION['lname']; ?>" required>
                        <div class="invalid-feedback">
                            <?php if (isset($_POST["register"])) echo $errors['lname']; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" placeholder="Nom d'utilisateur" class="form-control <?php if (isset($errors["username"]) || isset($errors['uname_existed'])) echo 'is-invalid'; ?>" value="<?php if (isset($_POST["register"])) echo $_SESSION['username']; ?>" required>
                        <div class="invalid-feedback">
                            <?php if (isset($_POST["register"]) && isset($errors['username'])) echo $errors['username']; ?>
                        </div>
                        <div class="invalid-feedback">
                            <?php if (isset($_POST["register"]) && isset($errors['uname_existed'])) echo $errors['uname_existed']; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="E-mail" class="form-control <?php if (isset($errors["email"]) || isset($errors['email_existed'])) echo 'is-invalid'; ?>" value="<?php if (isset($_POST["register"])) echo $_SESSION['email']; ?>" required>
                        <div class="invalid-feedback">
                            <?php if (isset($_POST["register"]) && isset($errors['email'])) echo $errors['email']; ?>
                        </div>
                        <div class="invalid-feedback">
                            <?php if (isset($_POST["register"]) && isset($errors['email_existed'])) echo $errors['email_existed']; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" name="pass" placeholder="Mot de passe" class="form-control <?php if (isset($errors["pass"])) echo 'is-invalid'; ?>" required>
                        <div class="invalid-feedback">
                            <?php if (isset($_POST["register"])) echo $errors['pass']; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirm_pass" placeholder="Confirmer le mot de passe" class="form-control <?php if (isset($errors["confirm_pass"])) echo 'is-invalid'; ?>" required>
                        <div class="invalid-feedback">
                            <?php if (isset($_POST["register"])) echo $errors['confirm_pass']; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="register" value="S'inscrire !" required>
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