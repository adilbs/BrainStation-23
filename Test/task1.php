<?php
 include_once 'database.php';
 include_once 'category.php';

 // get database connection
 $database = new Database();
 $db = $database->getConnection();
 $category = new Category($db);

$categories = $category->getCategoryItems();

$rows =$categories->fetchAll(PDO::FETCH_ASSOC);

// var_dump($rows);

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div class="container">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Category Name</th>
      <th scope="col">Total Items</th>
    </tr>
  </thead>
  <tbody>

    <?php foreach($rows as $key=>$row): ?>
    <tr>
        <td><?php echo $row['catname']; ?></td>
        <td><?php echo $row['total']; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>

  </tbody>
</table> 
</div>
</body>
</html>