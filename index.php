<?php

require "config/config.php";
require "config/common.php";


if(!empty($_POST)){
  
    
    if(empty($_POST['name']) || empty($_POST['password']) || empty($_POST['gender']) || empty($_POST['description']) ||  strlen($_POST['password'])<4 || empty($_POST['hobby']) || empty($_FILES['image']['name'])){
        if(empty($_POST['name'])){
          $nameError = ' * Fill Your name';
        }
        
        if (empty($_POST['password'])) {
            $passwordError = 'Fill in password';
          }elseif (strlen($_POST['password']) < 4) {
            $passwordError = 'Password must be at least 4 characters';
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
       

    }  // if empty data
    else{
       
        $file = 'images/'.($_FILES['image']['name']);
      $path = pathinfo($file,PATHINFO_EXTENSION);
          
        if($path != "jpg" && $path != "jpeg" && $path != "png"){
            echo "<script>alert('Images must be jpg or png or jpeg')</script>";
        }else{

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password =password_hash( $_POST['password'],PASSWORD_DEFAULT);
        $gender = $_POST['gender'];
        $hobby = $_POST['hobby'];
        $image = $_FILES['image']['name'];
        $description = $_POST['description'];
        
        
    
          move_uploaded_file($_FILES['image']['tmp_name'],$file);
    
          $stmt = $pdo->prepare("INSERT INTO users (name, email, password, gender, hobby, profile, description ) VALUES(:name, :email, :password, :gender, :hobby, :profile, :description) ");
          $result = $stmt->execute(
              array(':name'=>$name, ':email'=>$email, ':password'=>$password, ':gender'=>$gender, ':hobby'=>$hobby, ':profile'=>$image, ':description'=>$description )
          );
          
            $selectUser = $pdo->prepare("SELECT * FROM users WHERE email=:email");
            $selectUser->bindValue(':email',$email);
            $selectUser->execute();
            $user = $selectUser->fetch(PDO::FETCH_ASSOC);
           
          if($result){
            
               $_SESSION['user_id'] = $user['id'];

            
              echo "<script>alert('Successfully Created Profile!');window.location.href='profile_detail.php'; </script>";
          }
 
        }// data exists
    } // else 
}
   

?>

<html style="height: auto;">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
</head>
<body>
<div class="card">
  
  <div class="card-body">
    <h5 class="card-title"><h3>Create New Profile</h3></h5>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>"> 
    
        <div class="card-body">
            <div class="form-group">
            <label for="name">User Name</label>
            <p style="color:red;"><?php echo empty($nameError) ? '' : $nameError; ?></p>
            <input type="name" class="form-control" name="name" placeholder="Enter Name">
            </div>

            <div class="form-group">
            <label for="email">Email address</label>
            <p style="color:red;"><?php echo empty($emailError) ? '' : $emailError; ?></p>
            <input type="email" class="form-control" name="email" placeholder="Enter email">
            </div>

            <div class="form-group">
            <label for="password">Password</label>
            <p style="color:red;"><?php echo empty($passwordError) ? '' : $passwordError; ?></p>
            <input type="password" class="form-control" name="password" placeholder="Password">
            </div>

            <div class="form-group">
            <label for="gender">Gender</label>
            <p style="color:red;"><?php echo empty($genderError) ? '' : $genderError; ?></p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" value="male" checked>
                    <label class="form-check-label">Male</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="female" name="gender">
                    <label class="form-check-label">Female</label>
                </div>
            </div>

            <div class="form-group">
            <label for="hobby">Hobby</label>
            <p style="color:red;"><?php echo empty($hobbyError) ? '' : $hobbyError; ?></p>
            <input type="hobby" class="form-control" name="hobby" placeholder="Enter your enjoy Hobby">
            </div>

            <div class="form-group">
            <label for="file">Profile</label>
            <p style="color:red;"><?php echo empty($fileError) ? '' : $fileError; ?></p>
                <input type="file"  name="image">
            </div>

            <div class="form-group">
            <label for="description">About Your Bio</label>
            <p style="color:red;"><?php echo empty($descriptionError) ? '' : $descriptionError; ?></p>
            <textarea rows="4"  name="description" cols="20" class="form-control"></textarea>
            </div>
            
            
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="Create Profile">
        </div>
    </form>
  </div>
</div>
</body>
</html>

