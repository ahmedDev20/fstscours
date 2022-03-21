<?php
session_start();

$filiere = "";


/* Pagination handling */
require 'db/connection.php';

// Dynamic limit
$limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 6;

// Get total records
$query = "SELECT count(*) AS total FROM articles";
$sql = mysqli_query($connection, $query);
$result = mysqli_fetch_array($sql);
$allRecrods = $result['total'];

// Calculate total pages
$totalPages = ceil($allRecrods / $limit);

// Current pagination page number
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

// Prev + Next
$prev = $page - 1;
$next = $page + 1;

// Offset
$paginationStart = ($page - 1) * $limit;

// Limit query
$query = "SELECT * FROM articles LIMIT $paginationStart, $limit";
$articles = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Accueil</title>
  <meta charset="utf-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/gif/png" href="images/assets/favicon.ico">
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
      <div class="row">
        <?php while ($article = mysqli_fetch_array($articles)) : ?>
          <div class='col-sm-4 mb-3'>
            <div class='card card-primary'>
              <h5 class='card-header'><?php echo $article['titre'] ?></h5>
              <div class='card-body'>
                <img class='card-img-top card-img' src='images/articles/<?= $article['image'] ?>' alt='Image' />
              </div>
              <div class='card-footer'>
                <a class='btn btn-primary' target='_blank' href="<?= $article['lien'] ?>">Visiter</a>
              </div>
            </div>
          </div>
        <?php endwhile ?>
      </div>

      <!-- Pagination -->
      <div class="col-12 d-flex flex-column align-items-center mt-2">
        <?php include 'includes/pagination.php' ?>
      </div>
      <!-- ./Pagination -->
    </div>
    <!-- ./Main -->

    <!-- Footer -->
    <?php require 'includes/footer.php'; ?>
    <!-- ./Footer -->
  </div>
</body>

</html>