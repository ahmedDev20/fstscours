<?php
session_start();
if (!isset($_SESSION['id_user']))
    header('Location: login.php');

$filiere = $_GET['fil'];

/* Pagination handling */
require 'db/connection.php';

// Dynamic limit
$limit = 6;

// Get total records
$query = "SELECT count(*) AS total FROM documents WHERE 'filiere' = '$filiere' ";
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

$query = "SELECT * FROM documents, filieres WHERE filiere = abrev_fil AND abrev_fil LIKE '$filiere' LIMIT $paginationStart, $limit ";
$documents = mysqli_query($connection, $query);
$count = mysqli_num_rows($documents);

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
    <link rel="stylesheet" href="css/documents.css" />
    <script src="js/ajax.js" defer></script>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <?php require 'includes/header.php'; ?>
        <!-- ./Header -->

        <!-- Main -->
        <div class="search ml-auto mr-auto mt-5 " style="width: fit-content">
            <form>
                <div class="form-inline">
                    <input style="margin-left:8px;" type="text" name="search-box" placeholder="Taper pour rechercher ..." class="form-control">
                    <select name="doc-filter" class="form-control ml-2">
                        <option value="titre">Titre</option>
                        <option value="module">Module</option>
                    </select>
                    <select name="doc-type" class="form-control ml-2">
                        <option value="" selected>Tout</option>
                        <option value="cours">Cours</option>
                        <option value="td">TD</option>
                        <option value="tp">TP</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="documents">
            <div class="row">
                <?php if (!$count) : ?>
                    <div class="row flex-column align-items-center not-found">
                        <h3 class="mb-3">Pas de résultat trouvé !</h3>
                        <img class="mx-auto my-3 w-50" style="border-radius: 30px ;" src="images/assets/NoData.png" alt="">
                    </div>
                <?php else : ?>
                    <?php while ($document = mysqli_fetch_array($documents)) : ?>
                        <div class='col-sm-6 mb-3'>
                            <div class='card card-primary'>
                                <h5 class='card-header'><?php echo $document['titre']; ?></h5>
                                <div class='card-body p-4 position-relative'>
                                    <div class="d-flex mb-4 ml-1 align-items-center">
                                        <i class="fa fa-info mr-3"></i>
                                        <span class="mr-2">Module :</span>
                                        <span style=""><?php echo $document['module']; ?></span>
                                    </div>
                                    <div class="d-flex mb-4 align-items-center">
                                        <i class="fa fa-book mr-2"></i>
                                        <span class="mr-2">Type :</span>
                                        <span class=""><?php echo $document['type']; ?></span>
                                    </div>
                                    <div class="d-flex mb-4 align-items-center">
                                        <i class="fa fa-graduation-cap mr-2"></i>
                                        <span class="mr-2">Filière :</span>
                                        <span style=""><?php echo $document['intitule_fil']; ?></span>
                                    </div>
                                    <div class="description position-absolute d-flex align-items-center justify-content-center text-center text-white">
                                        <p><?php echo $document['description']; ?></p>
                                    </div>
                                </div>
                                <div class='card-footer'>
                                    <a class='btn btn-primary' href='documents/<?php echo $document['lien'] ?>' download>télécharger</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <!-- Pagination -->
                    <div class="col-12 d-flex flex-column align-items-center mt-2">
                        <?php include 'includes/pagination.php' ?>
                    </div>
                    <!-- ./Pagination -->
                <?php endif ?>
            </div>
        </div>
        <!-- ./Main -->

        <!-- Footer -->
        <?php require 'includes/footer.php'; ?>
        <!-- ./Footer -->
    </div>
</body>

</html>