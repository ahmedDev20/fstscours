<?php
session_start();

require 'db/connection.php';
$query = ("SELECT * FROM `filieres`");
$filieres = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Accueil</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/gif/png" href="images/assets/favicon.ico" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" defer></script>

    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/articles.css" />
</head>

<body>
    <div class="container">
        <!-- Header -->
        <?php require 'includes/header.php'; ?>
        <!-- ./Header -->

        <!-- Main -->
        <div class="articles">
            <?php if (!isset($_SESSION["id_user"])) : ?>
                <h2 class="text-center mb-5 border p-3">Connectez-vous pour accéder au documents.</h2>
            <?php endif ?>
            <div class="row">
                <?php while ($filiere = mysqli_fetch_array($filieres)) : ?>
                    <div class='col-md-4 mb-3'>
                        <div class='card card-primary'>
                            <h5 class='card-header'>LST-<?= $filiere['abrev_fil'] ?> </h5>
                            <div class='card-body'>
                                <img class="card-img-top card-img" src="images/filieres/<?= $filiere['image'] ?>" alt="">
                                <h5 class="text-center mt-3 "><?= $filiere['intitule_fil'] ?></h5>
                            </div>
                            <div class='card-footer d-flex justify-content-center'>
                                <a class='btn btn-primary <?php if (!isset($_SESSION["id_user"])) echo 'disabled' ?>' href='<?php if (isset($_SESSION["id_user"])) echo 'documents.php?fil=' . $filiere["abrev_fil"]; ?>'>
                                    Voir les documents</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile ?>
            </div>
        </div>
        <!-- ./Main -->

        <!-- Footer -->
        <?php require 'includes/footer.php'; ?>
        <!-- ./Footer -->
    </div>
</body>

</html>