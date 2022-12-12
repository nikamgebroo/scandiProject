<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=scandiwebsql', 'root', '');
$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC' );
$statement->execute();
$products =$statement->fetchALL(PDO::FETCH_ASSOC);


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
    <title>products</title>
  </head>
  <body>
<h1>Products crud</h1>
<a href="create.php" type="button" class="btn btn-sn btn-outline-primary">Add product</a>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Title</th>
        <th scope="col">Price</th>
        <th scope="col">description</th>
        <th scope="col">Create date</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $i=> $product) { ?>
        <tr>
            <th scope="row"><?php echo $i++?> </th>
            <td>
           <?php if($product['image']): ?>
        <img src = <?php echo $product['image']?> alt="<?php echo $product['titlle']?>" class="product-img">
        <?php endif; ?>
            </td>
            <td><?php echo $product['titlle'] ?></td>
            <td><?php echo $product['price'] ?></td>
            <td><?php echo $product['description'] ?></td>
            <td><?php echo $product['create_date'] ?></td>
            <td>
                <a href="update.php?id=<?php echo $product['id']?>"  class="btn btn-sn btn-outline-primary">Edit</a>
               <form method="post" action="delete.php" style="display:inline-block">
                   <input type="hidden" name="id" value="<?php echo $product['id']?>">
                <button type="submit" class="btn btn-sn btn-outline-danger">Delete</button>
               </form>
            </td>
        </tr>
    <?php } ?>


    </tbody>
</table>



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


  </body>
</html>