<?php

require_once "functions.php";

$id = $_GET['id']?? null;
if(!$id){
    header('Location: index.php');
    exit();
}

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=scandiwebsql', 'root', '');
$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id' );
$statement->bindValue(':id', $id);
$statement->execute();
$product =$statement->fetch(PDO::FETCH_ASSOC);
$errors = [];
$title = $product['titlle'];
$description = $product['description'];
$price = $product['price'];


if($_SERVER['REQUEST_METHOD'] ==='POST'){

    $title =$_POST['titlle'];
    $description =$_POST['description'];
    $price =$_POST['price'];
    $image=$_FILES['image'] ?? null;
    $imagepath =  '';
    if(!is_dir('images')){
        mkdir('images');
    }

    if($image){
        if($product['image']){
            unlink($product['image']);
        }
        $imagepath =  'images/' .randomString(8).'/'.$image['name'];
        mkdir(dirname($imagepath));
        move_uploaded_file($image['tmp_name'], $imagepath);
    }

    if(!$title ){
        $errors[]='product title is required';
    }
    if(!$price ){
        $errors[]='product price is required';
    }
    if(empty(($errors))){
        $statement = $pdo->prepare("UPDATE products SET title = :titlle,image= :image, 
                    description= :description, price= :price WHERE id = :id");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagepath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':id', $id);
        $statement->execute();
        header('location: index.php');
    }
}


?>

<!doctype html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
</head>
<body>
<p>
<a href="index.php">Back to main</a>
</p>

<h1> Update product <b><?php echo $product['titlle']?></b></h1>
<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $error): ?>
        <div><?php echo $error ?></div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<form method="post" enctype="multipart/form-data" >
   <?php if($product['image']): ?>
   <img src="<?php echo $product['image']?>" class="product-img-view" >
    <?php endif; ?>
    <div class="form-group">
        <label>Product Image</label><br>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label>Product Title</label>
        <input type="text" name="titlle" class="form-control" value="<?php echo $title ?>">
    </div>
    <div class="form-group">
        <label>Product description</label>
        <textarea class="form-control" name="description"><?php echo $description ?></textarea>
    </div>
    <div class="form-group">
        <label>Product price</label>
        <input type="number" step=".01" name="price" class="form-control" value="<?php echo $price ?>" >
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>



<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


</body>
</html>