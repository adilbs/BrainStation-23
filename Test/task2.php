<?php
 include_once 'database.php';
 include_once 'item.php';

 // get database connection
 $database = new Database();
 $db = $database->getConnection();




$query = "
SELECT CONCAT( REPEAT(' -', COUNT(parent.Name) - 1), node.Name) AS nameId
FROM (SELECT category.Name, nested_category.* FROM category JOIN nested_category WHERE category.Id = nested_category.catId) AS node,
        (SELECT category.Name, nested_category.* FROM category JOIN nested_category WHERE category.Id = nested_category.catId) AS parent
WHERE node.left_l BETWEEN parent.left_l AND parent.right_r
GROUP BY node.catId
ORDER BY node.left_l
";

$stmt = $db->prepare( $query );
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($data);


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
<?php foreach($data as $d): ?>
   <?php echo $d['nameId'];echo "<br>";?>
    <?php endforeach; ?>
</div>
</body>
</html>