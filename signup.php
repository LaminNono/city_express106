<?php
require_once "dbconn.php";

$sql = "select c.cid,c.cname from category c";
$stmt = $conn -> query($sql);
$stmt -> execute();
$categories = $stmt->fetchAll();

// Creating cities array
$cities = ['Yangon', 'Mandaly', 'Pyinoolwin', 'Magway', 'Taungoo', 'Taungyi', 'Kalaw'];

function checkPwd($pwd, $cpwd):bool
{
    return $pwd === $cpwd;
}

function isStrong($password):string
{
    $message ="";
    if(strlen($password)<8)
    {
        $message = "Password length must be at least 8 characters including at least one number,
                     one capital letter and one special character.";
    }
    else{
            $noCapital = 0;
            $special = 0;
            $number = 0;

            for($i=0; $i<strlen($password); $i++){


            }
    }
    return $message;
}

if(isset($_POST['signup']))
{
  $username=$_POST['username'];
  $fullname=$_POST['fullname'];
  $password=$_POST['password'];
  $cpassword=$_POST['cpassword'];
  $email=$_POST['email'];
  $phone=$_POST['phone'];
  $filename=$_FILES['user_img']['name'];
  $filepath="item_img/".$filename;
  $city = $_POST['city'];
  $message = "";
  if (checkPwd($password, $cpassword)) // true
     {
        $message = isStrong($password);

     }
     else{
        $message = "Password and Confirm Password are not the same.";
     }



 /* if(!is_uploaded_file($_FILES['image']['tmp_name']))
  {
    echo "file is not uploaded";
  }
  else
  {
    move_uploaded_file($_FILES['image']['tmp_name'], $filepath);
    try {

      $sql = "insert into item values (?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn -> prepare($sql);
      $status = $stmt -> execute([null,$iName,$iPrice,$iCategory,$iDescription,$filepath,$iQuantity]);
      $lastId= $conn->lastInsertId();
      if($status)
      {
        $_SESSION['insertSuccess'] = "One item $lastId record has been inserted successfully!";
        header("Location: view_item.php");
      }
    } catch (PDOException $e)
    {
      echo $e -> getMessage();
    }
  } */
} 

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer>
  </script>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <?php require_once "navbarbar.php"; ?>
    </div>
    <div class="row my-5">
      <div class="col-md-4 mx-auto">
        <h4 class="text-center">Sign Up Here</h4>
        <form class="border border-primary p-3" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
            <div class="mb-1">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="mb-1">
            <label for="fullname" class="form-label">Fullname</label>
            <input type="text" class="form-control" name="fullname">
          </div>
         <div class="mb-1">
            <label for="fullname" class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
          </div>
          <div class="mb-1">
            <?php 
            if(isset($message) && $message!="")
            echo "<p class = 'alert alert-warning'>$message</p>";
            ?>
            <label for="cpassword" class="form-label">Confirm password</label>
            <input type="password" class="form-control" name="cpassword">
          </div>
          <div class="mb-1">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email">
          </div>

          <div class="mb-1">
            <label for="phone" class="form-label">Ph number</label>
            <input type="number" class="form-control" name="phone">
          </div>
          <div class="mb-1">
            <select class="form-select" name="city">
              <option selected>Choose City</option>
              <?php 
              if(isset($cities))
              { for($i=0; $i<count($cities); $i++)
               {
                  ?>
              <option value="<?php echo $cities[$i]?>"><?php echo $cities[$i]; ?></option>

              <?php }} ?>
              ?>

            </select>
          </div>


          <div class="mb-1">
            <input class="form-control" name="user_img" type="file"></textarea>
            <label for="user_img">User Profile</label>
          </div>



          <button type="submit" class="btn btn-primary" style="margin-top: 15px;" name="signup">Submit</button>

        </form>

      </div>
    </div>
  </div>
</body>

</html>