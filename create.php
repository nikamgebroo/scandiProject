
<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=scandiwebsql', 'root', '');
$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];
$title = '';
$description = '';
$price = '';
if($_SERVER['REQUEST_METHOD'] ==='POST'){
    $title =$_POST['title'];
    $description =$_POST['description'];
    $price =$_POST['price'];

    if(!$title ){
$errors[]='product title is required';
    }
    if(!$price ){
        $errors[]='product price is required';
    }
    if(empty(($errors))){
        $statement = $pdo->prepare("INSERT INTO products(titlle,image, description , price,create_date)
                    VALUES(:title, :image, :description, :price, :date)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', '');
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));
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
<h1>Create new product</h1>
<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $error): ?>
<div><?php echo $error ?></div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
<form method="post" enctype="multipart/form-data" >
    <div class="form-group">
        <label>Product Image</label><br>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label>Product Title</label>
        <input type="text" class="form-control" value="<?php echo $title ?>">
    </div>
    <div class="form-group">
        <label>Product description</label>
        <textarea class="form-control" <?php echo $description ?>></textarea>
    </div>
    <div class="form-group">
        <label>Product price</label>
        <input type="number" class="form-control" <?php echo $price ?> >
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


  </body>
</html>