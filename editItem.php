<?php
    require_once "dbconn.php";
    if(!isset($_SESSION))
    {
        session_start();
    }

    $sql = "select c.cid,c.cname from category c";
    $stmt = $conn -> query($sql);
    $stmt -> execute();
    $categories = $stmt->fetchAll();

    if(isset($_GET['id']))
    {
        $sql = "SELECT i.item_id, i.item_name, i.price, 
            c.cname as cname, c.cid as cid,
            i.description, i.quantity, i.img_path
            from item i, category c
            where i.category = c.cid AND
            i.item_id =?" ;

            $stmt = $conn->prepare($sql);
            $stmt->execute([$_GET['id']]);
            $item = $stmt->fetch();
            //print_r($item);


    }

    if(isset($_POST['updateItem'])){
    $iName=$_POST['iName'];
    $iPrice=$_POST['iPrice'];
    $iQuantity=$_POST['iQuantity'];
    $fileimage=$_FILES['image'];
    $filename=$_FILES['image']['name'];
    $filepath = "item_img/".$filename;
    $iCategory=$_POST['iCategory'];
    $iDescription=$_POST['iDescription'];
    $id=$_POST['id'];
  if(!is_uploaded_file($_FILES['image']['tmp_name']))
  {
    echo "file is not uploaded";
  }
  else
  {
    move_uploaded_file($_FILES['image']['tmp_name'], $filepath);
    try {

      $sql = "update item set item_name=?, price=?, 
              description=?, quantity=?, category=?, img_path=? 
              where item_id=?";
      $stmt = $conn -> prepare($sql);
      $status = $stmt -> execute([$iName,$iPrice,$iDescription,$iQuantity,$iCategory,$filepath, $id]);
      $lastId= $id;
      if($status)
      {
        $_SESSION['updateSuccess'] = "Item with $lastId record has been updated successfully!";
        echo "movie record has been inseted successfully";
        header("Location: view_item.php");
      }
    } catch (PDOException $e)
    {
      echo $e -> getMessage();
    }
  }
    }
    if(isset($_GET['did']))
    {
       try{
         $sql ="delete from item where item_id=?";
        $stmt = $conn->prepare($sql);
        $status= $stmt->execute([$_GET['did']]);

        if($status)
        {
            $_SESSION['deleteSuccess']="Item with $_GET[did] has been deleted successfully!";
            header("Location:viewitem.php");
        }

       }catch(PDOException $e){
        echo $e->getMessage();
       }
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
      <?php require_once "navbarbar.php" ?>
    </div>
    <div class="row my-4">
      <div class="col-md-5 mx-auto">
        <h4 class="text-center"> Update Item Information </h4>
        <form class="border border-primary p-3" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $item['item_id'] ?>">
          <div class="mb-3">
            <label for="itemName" class="form-label">Name</label>
            <input type="text" class="form-control" name="iName" id="iName" value="<?php echo $item['item_name'] ?>">
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" name="iPrice" id="iPrice" value="<?php echo $item['price'] ?>">
          </div>

          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" name="iQuantity" id="iQuantity" value="<?php echo $item['quantity'] ?>">
          </div>

          <div class="mb-3">
            <img src="<?php echo $item['img_path'] ?>" style="width: 120px; height: 120px;" alt="">
            <label for="formFileSm" class="form-label">Item image</label>
            <input class="form-control form-control-sm" name="image" type="file" id="image_path">
          </div>
          <div class="mb-3">
            <p><?php echo $item['cname']; ?></p>
            <select class="form-select" aria-label="Default select example" name="iCategory" id="iCategory">
              <option selected>Open this select menu</option>
              <?php 
              if(isset($categories))
              { foreach($categories as $category)
               {
                  ?>
              <option value="<?php echo $category['cid']?>"><?php echo $category['cname']?></option>

              <?php }} ?>
              ?>

            </select>
          </div>


          <div class="form-floating">
            <textarea class="form-control" value="<?php echo $item['description']; ?>" name="iDescription" placeholder="write description here"
              id="iDescription"></textarea>
            <label for="floatingTextarea">Description</label>
          </div>



          <button type="submit" class="btn btn-primary" style="margin-top: 15px;" name="updateItem">Update</button>

        </form>

      </div>
    </div>
  </div>
</body>

</html>