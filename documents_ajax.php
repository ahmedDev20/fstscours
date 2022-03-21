<?php
session_start();
if (!isset($_SESSION['id_user']))
    header('Location: login.php');

/* Pagination handling */
require 'db/connection.php';

// Dynamic limit
$limit = 6;

// Get total records
$query = "SELECT count(*) AS total FROM documents WHERE 'filiere' = ' " . $_GET['fil'] . " ' ";
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

// AJAX handling
$filter = $_GET['filter'];
$type = $_GET['type'];
$value = $_GET['value'];
$filiere = $_GET['fil'];


require 'db/connection.php';
$query = "SELECT * FROM documents, filieres WHERE filiere = abrev_fil AND abrev_fil LIKE '$filiere' AND  $filter LIKE '%$value%' AND type LIKE '%$type%' LIMIT $paginationStart, $limit";
$documents = mysqli_query($connection, $query);
$count = mysqli_num_rows($documents);


if (!$count) : ?>
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