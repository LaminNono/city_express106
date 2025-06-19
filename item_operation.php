<?php
  require_once "dbconn.php";
  
  if(!isset($_SESSION))
  {
    session_start();
  }
  
  if(isset($_POST['insert_item']))
  {
    $iName=$_POST['iName'];
    $iPrice=$_POST['iPrice'];
    $iQuantity=$_POST['iQuantity'];
    $fileimage=$_FILES['image'];
    $filename=$_FILES['image']['name'];
    $filepath = "item_img/".$filename;
    $iCategory=$_POST['iCategory'];
    $iDescription=$_POST['iDescription'];
  if(!is_uploaded_file($_FILES['image']['tmp_name']))
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
        echo "movie record has been inseted successfully";
        header("Location: view_item.php");
      }
    } catch (PDOException $e)
    {
      echo $e -> getMessage();
    }
  }

  }
?>