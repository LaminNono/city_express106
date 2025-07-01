<?php
require_once "dbconn.php";
if (!isset($_SESSION)) {
    session_start();
}


try {
    $sql = "select c.cid,c.cname from category c";
    $stmt = $conn->query($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if (isset($_GET['catego'])) {
    $cat_id = $_GET['category'];
    try {
        $sql = "SELECT i.item_id, i.item_name, i.price, 
            c.cname as category,
            i.description, i.quantity, i.img_path
            from item i, category c
            where i.category = c.cid and c.cid=?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$cat_id]);
        $items = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
if(isset($_GET['radioAction'])){
    $priceRange = $_GET['priceRange'];//value attribute 1,2,3
    $sql = "SELECT i.item_id, i.item_name, i.price, 
            c.cname as category,
            i.description, i.quantity, i.img_path
            from item i, category c
            where i.category = c.cid and i.price between ? and ?";
            $lower =0;
            $upper =0;
            if($priceRange == 1){
                $lower = 1;
                $upper =100;
            }
            else if($priceRange ==2){
                $lower = 101;
                $upper =200;

            }
            else if($priceRange ==3){
                $lower = 201;
                $upper = 300;
            }
            $stmt=$conn->prepare($sql);
            $stmt->execute([$lower, $upper]);
            $items = $stmt->fetchAll();
}
try {
    $sql = "SELECT i.item_id, i.item_name, i.price, 
            c.cname as category,
            i.description, i.quantity, i.img_path
            from item i, category c
            where i.category = c.cid;";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $items = $stmt->fetchAll();
    // print_r($items);



} catch (PDOException $e) {
    echo $e->getMessage();
} //radio filter end
if(isset($_GET['bSearch']))
{
    $keyword = $_GET['kSearch'];
    $sql = "select * from item where item_name like?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["%".$keyword."%"]);
    $items = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer>
    </script>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            require_once "navbarbar.php";
            ?>
        </div>
        <div class="row">
            <div class="col-md-2 py-5">
                <div class="nav-item mb-3">
                    <a href="view_item.php" class="nav-link">View All Items</a>
                </div>
                <form action="view_item.php" method="get" class="form border border-primary border-1 rounded">
                    <select name="" class="form-select">
                        <option value="">Choose category</option>

                        <?php
                        foreach ($categories as $category) {
                            echo "<option value=$category[cid]>$category[cname]</option>";
                        }

                        ?>
                    </select>
                    <button type="submit" name="catego" class="btn btn-sm btn-outline-primary rounded-pill mt-2">Submit</button>
                </form>
                <form action="view_item.php" class="form mt-3 border border-primary border-1 rounded"method="get">
                    <fieldset> <legend><h6>Choose Price Range</h6></legend>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="priceRange" value="1">
                        <label class="form-check-label" for="priceRange">
                            $1-$100
                        </label>
                        <br>
                        <input class="form-check-input" type="radio" name="priceRange" value="2">
                        <label class="form-check-label" for="priceRange">
                            $101-$200
                        </label>
                        <br>
                        <input class="form-check-input" type="radio" name="priceRange" value="3">
                        <label class="form-check-label" for="priceRange">
                            $201-$300
                        </label>
                        <br>
                        <button type="submit"name = "radioAction"class="btn-sm btn-outline-primary rounded-pill mt-2">Submit</button>
                    </div>
                </fieldset>
                </form>


            </div>

            <div class="col-md-10 my-5 mx-auto">
                <?php

                if (isset($_SESSION['insertSuccess'])) {
                    echo "<p class='alert alert-success'>$_SESSION[insertSuccess]</p>";
                    unset($_SESSION['insertSuccess']);
                }

                ?>
                <p class="text-start"><a class="btn btn-outline-primary mx-auto" href="./insert_item.php">Add New Item</a></p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Category</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($items)) {
                            foreach ($items as $item) {
                                echo "<tr>
                                        <td>$item[item_name]</td>
                                        <td>$item[price]</td>
                                        <td>$item[description]</td>
                                        <td>$item[quantity]</td>
                                        <td>$item[category]</td>
                                        <td><img style=width:80px; height:100px; src=$item[img_path]></td>
                                        <td><a class='btn btn-primary rounded-pill' href=editItem.php?id=$item[item_id]>Edit</a></td>
                                        <td><a class='btn btn-danger rounded-pill' href=editItem.php?did=$item[item_id]>Delete</a></td>
                                    </tr>";
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>