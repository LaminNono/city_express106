<?php
require_once "dbconn.php";

$sql = "select c.cid,c.cname from category c";
$stmt = $conn -> query($sql);
$stmt -> execute();
$categories = $stmt->fetchAll();



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
        <h4 class="text-center">Insert Item</h4>
        <form class="border border-primary p-3" method="post" action="<?php echo "item_operation.php";?>" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="itemName" class="form-label">Name</label>
            <input type="text" class="form-control" name="iName" id="iName">
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" name="iPrice" id="iPrice">
          </div>

          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" name="iQuantity" id="iQuantity">
          </div>

          <div class="mb-3">
            <label for="formFileSm" class="form-label">Item image</label>
            <input class="form-control form-control-sm" name="image" type="file" id="image_path">
          </div>


          <div class="mb-3">
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
            <textarea class="form-control" name="iDescription" placeholder="write description here"
              id="iDescription"></textarea>
            <label for="floatingTextarea">Description</label>
          </div>



          <button type="submit" class="btn btn-primary" style="margin-top: 15px;" name="insert_item">Insert
            Item</button>

        </form>

      </div>
    </div>
  </div>
</body>

</html>