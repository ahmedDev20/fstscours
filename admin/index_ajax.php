<?php
session_start();
if (empty($_SESSION['id_admin']))
  header('Location: ../login.php');

$table = (isset($_GET['table'])) ? $_GET['table'] : "documents";

/* Pagination handling */
require '../db/connection.php';

// Dynamic limit
$limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 6;

// Get total records
$query = "SELECT * FROM $table";
$sql = mysqli_query($connection, $query);
$allRecrods = mysqli_num_rows($sql);

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

$query = "SELECT * FROM $table LIMIT $paginationStart, $limit ";
$result = mysqli_query($connection, $query);
$currentRecords = mysqli_num_rows($result);
$fields = mysqli_fetch_fields($result);
array_shift($fields); //remove the id property

//include 'includes/pagination.php';
?>
<div class="table-responsive">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6">
          <h2>Gérer les <b><?= $table ?></b></h2>
        </div>
        <div class="col-sm-6">
          <a href="#addModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i><span>Ajouter</span></a>
          <a href="#" id="deleteAll" class="btn btn-danger" data-toggle="modal"><i class="material-icons" id="deleteAll">&#xE15C;</i> <span id="deleteAll">Supprimer</span></a>
        </div>
      </div>
    </div>
    <table class="table table-striped table-hover animate__animated animate__fadeIn">
      <thead>
        <tr>
          <th>
            <span class="custom-checkbox">
              <input type="checkbox" id="selectAll">
              <label for="selectAll"></label>
            </span>
          </th>
          <?php foreach ($fields as $field) : ?>
            <th>
              <?= $field->name ?>
            </th>
          <?php endforeach ?>
        </tr>
      </thead>
      <tbody>
        <?php while ($element = mysqli_fetch_array($result)) : ?>
          <tr>
            <td>
              <span class="custom-checkbox">
                <input type="checkbox" form="delete-all-form" name="options[]" value="<?= $element[0] ?>">
                <label for="checkbox1"></label>
              </span>
            </td>
            <?php foreach ($fields as $field) : ?>
              <td><?= $element["$field->name"] ?></td>
            <?php endforeach ?>
            <td>
              <a href="#edit<?= $table ?>Modal-<?= $element[0] ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Modifier">&#xE254;</i></a>
              <a href="#delete<?= $table ?>Modal-<?= $element[0] ?>" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Supprimer">&#xE872;</i></a>
            </td>
          </tr>
        <?php endwhile ?>
      </tbody>
    </table>

    <!-- Pagination -->
    <?php include 'includes/pagination.php' ?>
    <!-- ./Pagination -->

  </div>
</div>

<!-- Add Modal HTML -->
<div id="addModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="action.php?table=<?= $table ?>&page=<?= $page ?>" enctype="multipart/form-data">
        <div class="modal-header">
          <h4 class="modal-title">Ajouter <?= $table ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <?php foreach ($fields as $field) : ?>
            <div class="form-group">
              <label> <?= $field->name ?></label>
              <?php if ($field->name == "filiere") : ?>
                <select name="filiere" class="form-control">
                  <option value="GI" selected="">GI</option>
                  <option value="MECA">MECA</option>
                  <option value="GM">GM</option>
                  <option value="GESA">GESA</option>
                  <option value="EEA">EEA</option>
                </select>
              <?php elseif ($field->name == "type") : ?>
                <select name="type" class="form-control">
                  <option value="TD" selected="">TD</option>
                  <option value="TP">TP</option>
                  <option value="Cours">Cours</option>
                </select>
              <?php elseif ($field->name == "image" || $field->name == "fichier") : ?>
                <input type="file" class="form-control-file" name="file" required>
              <?php else : ?>
                <input type="text" class="form-control" name="<?= $field->name; ?>" required>
              <?php endif; ?>
            </div>
          <?php endforeach ?>
        </div>

        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
          <input type="submit" class="btn btn-success" value="Ajouter" name="Add">
        </div>
      </form>
    </div>
  </div>
</div>

<?php $query = "SELECT * FROM $table LIMIT $paginationStart, $limit" ?>
<?php $result = mysqli_query($connection, $query) ?>
<?php while ($element = mysqli_fetch_array($result)) : ?>
  <!-- Edit Modal HTML -->
  <div id="edit<?= $table ?>Modal-<?= $element[0] ?>" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="action.php?table=<?= $table  ?>&page=<?= $page ?>">
          <div class="modal-header">
            <h4 class="modal-title">Editer les <?= $table ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" value="<?= $element[0] ?>">
            <?php foreach ($fields as $field) : ?>
              <div class="form-group">
                <label> <?= $field->name ?></label>
                <?php if ($field->name == "filiere") : ?>
                  <select name="filiere" class="form-control">
                    <option value="GI" <?php if ($element["filiere"] === "GI") echo "selected";
                                        else echo ""; ?>>GI</option>
                    <option value="MECA" <?php if ($element["filiere"] === "MECA") echo "selected";
                                          else echo ""; ?>>MECA</option>
                    <option value="GM" <?php if ($element["filiere"] === "GM") echo "selected";
                                        else echo ""; ?>>GM</option>
                    <option value="GESA" <?php if ($element["filiere"] === "GESA") echo "selected";
                                          else echo ""; ?>>GESA</option>
                    <option value="EEA" <?php if ($element["filiere"] === "EEA") echo "selected";
                                        else echo ""; ?>>EEA</option>
                  </select>
                <?php elseif ($field->name == "type") : ?>
                  <select name="type" class="form-control">
                    <option value="Cours" <?php if ($element["type"] === "Cours") echo "selected";
                                          else echo ""; ?>>Cours</option>
                    <option value="TD" <?php if ($element["type"] === "TD") echo "selected";
                                        else echo ""; ?>>TD</option>
                    <option value="TP" <?php if ($element["type"] === "TP") echo "selected";
                                        else echo ""; ?>>TP</option>
                  </select>
                <?php else : ?>
                  <input type="text" class="form-control" value="<?= $element["$field->name"] ?>" name="<?= $field->name; ?>" required>
                <?php endif; ?>
              </div>
            <?php endforeach ?>

          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
            <input type="submit" class="btn btn-info" value="Enregistrer" name="Edit">
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Delete Modal HTML -->
  <div id="delete<?= $table ?>Modal-<?= $element[0] ?>" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="action.php?table=<?= $table  ?>&page=<?= $page ?>">
          <div class="modal-header">
            <h4 class="modal-title">Supprimer les <?= $table ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <p>Voulez-vous vraiment supprimer cet enregistrement?</p>
            <p class="text-warning"><small>Cette action ne peut pas être annulée.</small></p>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id" value="<?= $element[0] ?>">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
            <input type="submit" class="btn btn-danger" value="Supprimer" name="Delete">
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endwhile ?>

<!-- Delete All Modal HTML -->
<div id="deleteModalall" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="action.php?table=<?= $table ?>&page=<?= $page ?>" id="delete-all-form">
        <div class="modal-header">
          <h4 class="modal-title">Supprimer les <?= $table ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <p>Voulez-vous vraiment supprimer ces enregistrements ?</p>
          <p class="text-warning"><small>Cette action ne peut pas être annulée.</small></p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
          <input type="submit" class="btn btn-danger" value="Supprimer" name="Delete-all">
        </div>
      </form>
    </div>
  </div>
</div>