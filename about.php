<?php
session_start();
require 'db/connection.php';
$query = "SELECT * FROM `team`";
$team = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>A propos de nous</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/gif/png" href="images/assets/favicon.ico">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" defer></script>

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/about.css" />
</head>

<body>
  <div class="container">
    <!-- Header -->
    <?php require 'includes/header.php'; ?>
    <!-- ./Header -->

    <!-- Main -->
    <div class="team-section">
      <div class="row">
        <?php while ($member = mysqli_fetch_array($team)) :
          $social_media = explode(",", $member['social_media']);
          $facebook = $social_media[0];
          $instagram = $social_media[1];
          $github = $social_media[2]; ?>
          <!-- Team member -->
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="image-flip">
              <div class="mainflip flip-0">
                <div class="frontside">
                  <div class="card">
                    <div class="card-body text-center">
                      <p>
                        <img class="img-fluid" src="images/team/<?php echo $member['avatar'] ?>" alt="card image" />
                      </p>
                      <h4 class="card-title"><?php echo $member['full_name'] ?></h4>
                      <p class="card-text"><?php echo $member['occupation'] ?></p>
                    </div>
                  </div>
                </div>
                <div class="backside">
                  <div class="card">
                    <div class="card-body text-center mt-4">
                      <h4 class="card-title"><?php echo $member['full_name'] ?></h4>
                      <p class="card-text"><?php echo $member['description'] ?></p>
                      <ul class="list-inline">
                        <li class="list-inline-item">
                          <a class="social-icon text-xs-center" target="_blank" href="<?php echo $facebook ?>">
                            <i class="fa fa-facebook"></i>
                          </a>
                        </li>
                        <li class="list-inline-item">
                          <a class="social-icon text-xs-center" target="_blank" href="<?php echo $instagram ?>">
                            <i class="fa fa-instagram"></i>
                          </a>
                        </li>
                        <li class="list-inline-item">
                          <a class="social-icon text-xs-center" target="_blank" href="<?php echo $github ?>'">
                            <i class="fa fa-github"></i>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./Team member -->
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