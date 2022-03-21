<?php
if (empty($_SESSION['id_admin']))
    header('Location: ../login.php');

if ($table == "documents") {
    $target_dir = "../documents";
    $target_file = "$target_dir/$fichier";
} else {
    $target_dir = "../images/$table";
    $target_file = "$target_dir/$image";
}

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


// Check file size
if ($_FILES["file"]["size"] > 20000000) {
    echo "Désolé, la taille du fichier ne doit pas depassée 20MB." . "<br>";
    die;
    $uploadOk = 0;
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "docx"
) {
    echo "Désolé, sauf JPG, JPEG, PNG, GIF, PDF & DOCX fichiers sont autorisés." . "<br>";
    die;
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Désolé, votre fichier n'a pas été chargé.";
    die;
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "Le fichier " . basename($_FILES["file"]["name"]) . " a été chargé." . "<br>";
    } else {
        echo "Désolé, une erreur a été survenue.";
        die;
    }
}
