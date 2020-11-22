<?php

require "config/config.php";
require "config/common.php";

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
  }       

  
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id =".$_GET['id']);
    $stmt->execute();
    $res = $stmt->fetchAll();

    if(!empty($_POST)){


        if(empty($_POST['name']) || empty($_POST['password']) || empty($_POST['gender']) || empty($_POST['description']) ||   empty($_POST['hobby']) || empty($_FILES['image']['name'])){
            if(empty($_POST['name'])){
              $nameError = ' * Fill Your name';
            }
            
                       
    
            if(empty($_FILES['image']['name'])){
              $fileError = ' * Fill images';
            }
        
            if(empty($_POST['hobby'])){
                $hobbyError = ' * Fill Your Hobby';
              }
    
              if(empty($_POST['description'])){
                $descriptionError = ' * Fill Your Bio';
              }
           
    
        }  // if empty dataelse{

        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $hobby = $_POST['hobby'];
        $image = $_FILES['image']['name'];
        $description = $_POST['description'];

        if($_FILES['image']['name'] != null ){

            $file = 'images/'.($_FILES['image']['name']);
            $path = pathinfo($file,PATHINFO_EXTENSION);
        
            if($path != "jpg" && $path != "jpeg" && $path != "png"){
                echo "<script>alert('Images must be jpg or png or jpeg')</script>";
            }else{
               
                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],$file);
        
                $sql = $pdo->prepare("UPDATE users SET name='$name',email='$email',gender='$gender' , profile='$image', hobby='$hobby', description='$description'  WHERE id = '$id' ");
                
                $result = $sql->execute();

                if($result){
                    echo "<script>alert('Successfully Updated!');window.location.href='profile_detail.php'; </script>";
                }
            }

        }else{
            $sql = $pdo->prepare("UPDATE users SET name='$name',email='$email',gender='$gender' ,hobby='$hobby', description='$description' WHERE id = '$id'");
            $result = $sql->execute();

            if($result){
                echo "<script>alert('Successfully Updated!');window.location.href='profile_detail.php'; </script>";
            }

        }

   
        
    }

?>



<html style="height: auto;">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
</head>
<body>
<div class="card">
  
  <div class="card-body">
    <h5 class="card-title"><h3>Edit New Profile</h3></h5>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
        <input type="hidden" name="id" value="<?php echo escape($res[0]['id'])?>">
    
        <div class="card-body">
            <div class="form-group">
            <label for="name">User Name</label>
            <p style="color:red;"><?php echo empty($nameError) ? '' : $nameError; ?></p>
            <input type="name" class="form-control" name="name" placeholder="Enter Name" value="<?php echo escape($res[0]['name'])?>">
            </div>

            <div class="form-group">
            <label for="email">Email address</label>
            <p style="color:red;"><?php echo empty($emailError) ? '' : $emailError; ?></p>
            <input type="email" class="form-control" name="email" placeholder="Enter email" value="<?php echo escape($res[0]['email'])?>">
            </div>

            

            <div class="form-group">
            <label for="gender">Gender</label>
            <p style="color:red;"><?php echo empty($genderError) ? '' : $genderError; ?></p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" value="male" <?php echo (isset($res[0]['gender']) == 'male') ? 'checked' : '' ?>>
                    <label class="form-check-label">Male</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="female" name="gender" <?php echo (isset($res[0]['gender']) == 'female') ? 'checked' : '' ?>>
                    <label class="form-check-label">Female</label>
                </div>
            </div>

            <div class="form-group">
            <label for="hobby">Hobby</label>
            <p style="color:red;"><?php echo empty($hobbyError) ? '' : $hobbyError; ?></p>
            <input type="hobby" class="form-control" name="hobby" placeholder="Enter your enjoy Hobby" value="<?php echo escape($res[0]['hobby'])?>">
            </div>

            <div class="form-group">
            <label for="file">Profile</label>
            <p style="color:red;"><?php echo empty($fileError) ? '' : $fileError; ?></p>
                <img src="images/<?php echo escape($res[0]['profile']) ?>" width="150" height="150" alt=""><br><br>
                <input type="file"  name="image">
            </div>

            <div class="form-group">
            <label for="description">About Your Bio</label>
            <p style="color:red;"><?php echo empty($descriptionError) ? '' : $descriptionError; ?></p>
            <textarea rows="4"  name="description" cols="20" class="form-control"><?php echo escape($res[0]['description'])?></textarea>
            </div>
            
            
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="Edit Profile">
        </div>
    </form>  
  </div>
</div>
</body>
</html>