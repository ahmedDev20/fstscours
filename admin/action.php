<?php
session_start();
if (empty($_SESSION['id_admin']))
	header('Location: ../login.php');

require '../db/connection.php';
require 'includes/validation.php';

// Store the primary key of the table
$table = $_GET["table"];
$query = "SHOW COLUMNS FROM $table";
$result = mysqli_query($connection, $query);
$columns = mysqli_fetch_array($result);
$id_table = $columns[0];


if (isset($_POST['Add'])) {
	if ($_GET['table'] == 'documents') {
		$titre = validate($_POST['titre']);
		$module = validate($_POST['module']);
		$type = validate($_POST['type']);
		$description = validate($_POST['description']);
		$filiere = validate($_POST['filiere']);
		$fichier = $_FILES['file']['name'];
		require 'includes/upload.php';
		$query = "INSERT INTO `documents` (`filiere`,`titre`,`module`,`type`,`description`,`fichier`) VALUES ('$filiere','$titre', '$module', '$type', '$description', '$fichier')";

		if (mysqli_query($connection, $query))
			header("location:index.php?table=$table&page=1&addsucess");
	}
	if ($_GET['table'] == 'articles') {
		$titre = validate($_POST['titre']);
		$lien = validate($_POST['lien']);
		$image = $_FILES['file']['name'];
		require 'includes/upload.php';
		$query = "INSERT INTO `articles` (`titre`,`lien`, `image`) VALUES ('$titre', '$lien', '$image')";

		if (mysqli_query($connection, $query))
			header("location:index.php?table=$table&page=1&addsucess");
	}
	if ($_GET['table'] == 'filieres') {
		$abrev_fil = validate($_POST['abrev_fil']);
		$intitule_fil = validate($_POST['intitule_fil']);
		$image = $_FILES['file']['name'];
		require 'includes/upload.php';
		$query = "INSERT INTO `filieres` (`abrev_fil`,`intitule_fil`,`image`) VALUES ('$abrev_fil', '$intitule_fil', '$image')";

		if (mysqli_query($connection, $query))
			header("location:index.php?table=$table&page=1&addsucess");
	}
}

if (isset($_POST['Edit'])) {
	if ($_GET['table'] == 'articles') {
		$id = $_POST['id'];
		$titre = validate($_POST['titre']);
		$image = validate($_POST['image']);
		$lien = validate($_POST['lien']);
		$query = "UPDATE articles SET titre='$titre', lien='$lien', image='$image' WHERE id_article=$id";

		if (mysqli_query($connection, $query))
			header("location:index.php?table=$table&page=1&editsucess");
	}
	if ($_GET['table'] == 'filieres') {
		$id = $_POST['id'];
		$abrev_fil = validate($_POST['abrev_fil']);
		$intitule_fil = validate($_POST['intitule_fil']);
		$image = validate($_POST['image']);
		$query = "UPDATE filieres SET abrev_fil='$abrev_fil', intitule_fil='$intitule_fil', image='$image' where id_filiere=$id";
		if (mysqli_query($connection, $query))
			header("location:index.php?table=$table&page=1&editsucess");
	}
	if ($_GET['table'] == 'documents') {
		$id = $_POST['id'];
		$filiere = validate($_POST['filiere']);
		$titre = validate($_POST['titre']);
		$module = validate($_POST['module']);
		$type = validate($_POST['type']);
		$description = validate($_POST['description']);
		$fichier = validate($_POST['fichier']);
		$query = "UPDATE documents SET titre='$titre', module='$module', type='$type', description='$description', fichier='$fichier', filiere='$filiere' where id_document=$id";
		if (mysqli_query($connection, $query))
			header("location:index.php?table=$table&page=1&editsucess");
	}
}

if (isset($_POST['Delete'])) {
	$id = $_POST['id'];
	if ($_GET['table'] == 'filieres') {
		$query = "DELETE FROM filieres WHERE id_filiere = $id";
		$q = "SELECT `image` from filieres WHERE id_filiere = $id";
		$result = mysqli_query($connection, $q);
		$record = mysqli_fetch_array($result);
		$image = $record['image'];
		if (!unlink("../images/filieres/$image")) {
			echo ("Fichier ne peut pas étre supprimé.");
		} else {
			echo ("Fichier supprimé.");
		}
	}
	if ($_GET['table'] == 'articles') {
		$query = "DELETE FROM articles WHERE id_article = $id";
		$q = "SELECT `image` from articles WHERE id_article = $id";
		$result = mysqli_query($connection, $q);
		$record = mysqli_fetch_array($result);
		$image = $record['image'];
		if (!unlink("../images/articles/$image")) {
			echo ("Fichier ne peut pas étre supprimé.");
		} else {
			echo ("Fichier supprimé.");
		}
	}
	if ($_GET['table'] == 'documents') {
		$query = "DELETE FROM documents WHERE id_document = $id";
		$q = "SELECT `fichier` from documents WHERE id_document = $id";
		$result = mysqli_query($connection, $q);
		$record = mysqli_fetch_array($result);
		$fichier = $record['fichier'];
		if (!unlink("../documents/$fichier")) {
			echo ("Fichier ne peut pas étre supprimé.");
		} else {
			echo ("Fichier supprimé.");
		}
	}
	if (mysqli_query($connection, $query))
		header("location:index.php?table=$table&page=1&deletesucess");
}

if (isset($_POST['Delete-all'])) {
	foreach ($_POST['options'] as $option) {

		if ($table == "documents") {
			$q = "SELECT `fichier` from documents WHERE id_document = $option";
			$result = mysqli_query($connection, $q);
			$record = mysqli_fetch_array($result);
			$fichier = $record['fichier'];
			$target_file = "../documents/$fichier";
		} else {
			$q = "SELECT `image` from $table WHERE $id_table = $option";
			$result = mysqli_query($connection, $q);
			$record = mysqli_fetch_array($result);
			$image = $record['image'];
			$target_file = "../images/$table/$image";
		}

		$query = "DELETE FROM $table WHERE $id_table = $option";
		if (mysqli_query($connection, $query)) {
			if (!unlink($target_file)) {
				echo ("Le fichier ne peut pas étre supprimé.");
			} else {
				header("location:index.php?table=$table&page=1&deleteallsucess");
			}
		}
	}
}
