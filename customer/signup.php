<?php
require_once "../dbconn.php";
if(!isset($_SESSION)){
    session_start();
}
if(isset($_POST['signUp'])){
    $username =$_POST['username'];
    $password =$_POST['password'];
    $cpassword =$_POST['cpassword'];
    $email =$_POST['email'];
    $phone =$_POST['phone'];
    $city =$_POST['city'];
    $gender =$_POST['gender'];
    $profile =$_FILES['profile'];
    $img_path = "profile/".$_FILES['profile']['name'];

    if($password === $cpassword)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        //to check strong password 
        //save file into a specified directory in a server
        $status = move_uploaded_file($_FILES['profile']['tmp_name'],$img_path);
        if($status){
            try{
                $sql = "insert into users values (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([null, $username, $email, $phone, $img_path, $hash, $city, $gender]);
                if($status){
                    header("Location:clogin.php");
                }

            }catch(PDOException $e){
                echo $e->getMessage();
                
            }
        }

    }
    else{
        $errMessage = "Password and confirm passoword must be same.";
    }
}






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer>
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "../navbarbar.php"  ?>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 mx-auto py-3">
                <p>Signup Here</p>
                <form action="signup.php" method="post" enctype="multipart/form-data">
                    <div class="mb-1">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="mb-1">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="mb-1">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" class="form-control" name="cpassword">
                    </div>
                    <div class="mb-1">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <p>Choose Gender</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="male">
                        <label class="form-check-label" for="gender">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="female">
                        <label class="form-check-label" for="gender">
                            Female
                        </label>
                    </div>
                     <div class="mb-1">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone">
                    </div>

                     <div class="mb-1">
                        <label for="profile">Choose profile picture</label>
                        <input type="file" class="form-control" name="profile">
                    </div>

                    <select name="city" class="form-select">
                        <option value="">Choose city</option>
                        <?php 
                        $cities = array("Yangon","Mandalay","NayPyiTaw","Taunggyi","Magway");
                        foreach($cities as $city){
                                echo "<option value=$city>$city</option>";
                        }
                        
                        ?>

                    </select>
                    <button class="btn btn-outline-primary" name="signUp">Signup</button>

                </form>
            </div>
        </div>


    </div>

</body>

</html>