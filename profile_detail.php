<?php

require "config/config.php";
require "config/common.php";

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
  }  
        $user = $_SESSION['user_id'];
        $sql = $pdo->prepare("SELECT * FROM users WHERE id = $user ");
        $sql->execute();
        $rawResult = $sql->fetchAll();
        
?>
    
  
    
<html style="height: auto;">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
</head>
<body>
<div class="card">
  
  <div class="card-body">
    <div class="card card-primaryc card-body card-outline">
            <div class="card-body box-profile">
            <div class="text-center">
                <img src="images/<?php echo escape($rawResult[0]['profile']) ?>" class="profile-user-img img-fluid img-circle" alt="User profile picture" width="400" height="300"><br><br>
            </div>

            <h3 class="profile-username text-center"><?php echo escape($rawResult[0]['name']) ?></h3>

            <p class="text-muted text-center"><?php echo escape($rawResult[0]['description']) ?></p>

            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                <b>Email</b> <a class="float-right"><?php echo escape($rawResult[0]['email']) ?></a>
                </li>
                <li class="list-group-item">
                <b>Gender</b> <a class="float-right"><?php echo escape($rawResult[0]['gender']) ?></a>
                </li>
                <li class="list-group-item">
                <b>Hobby</b> <a class="float-right"><?php echo escape($rawResult[0]['hobby']) ?></a>
                </li>
            </ul>

            <a href="edit.php?id=<?php echo $user ?>" class="btn btn-primary btn-block"><b>Edit</b></a>
            <a href="delete.php?id=<?php echo $user ?>" class="btn btn-warning btn-block"
                onclick="return confirm('Are you sure want to delete this profile');window.location.href='index.php';"
                type="button" class="btn btn-outline-danger" >Delete</a>
            </div>
            <!-- /.card-body -->
        </div>  
  </div>
</div>
</body>
</html>

    